<p align="center">
  <img src="assets/logo.png" width="250" alt="Mphisher Logo">
</p>

<h1 align="center">Mphisher</h1>

<p align="center">
  <img src="https://img.shields.io/badge/Version-2.3.5-00f2ff?style=for-the-badge">
  <img src="https://img.shields.io/badge/Author-Easir%20Iqbal%20Mahi-7000ff?style=for-the-badge">
  <img src="https://img.shields.io/badge/Platform-Linux%20|%20Termux-ff3366?style=for-the-badge">
  <img src="https://img.shields.io/badge/License-GPLv3-00ff88?style=for-the-badge">
</p>

<p align="center">
  <b>A professional-grade, automated phishing tool with 30+ high-fidelity templates and a premium management dashboard.</b>
</p>

---

### ⚠️ Disclaimer

> [!CAUTION]
> **Educational Purpose Only**: This tool is developed strictly for educational and ethical security testing purposes. Unauthorized use of this tool for malicious activities is illegal and strictly prohibited. The author (Easir Iqbal Mahi) and contributors assume no liability for any misuse or damage caused by this program.

---

### 🚀 Features

Mphisher is designed to be the most comprehensive and user-friendly phishing toolkit available.

- **🎨 30+ Premium Templates**: High-fidelity login pages for Facebook, Google, Instagram, Microsoft, Netflix, and more.
- **⚡ One-Click Deployment**: Fully automated server setup and tunnel initialization.
- **🛠️ Multiple Tunneling Engines**:
  - **Localhost**: For internal network testing.
  - **Cloudflared**: Secure tunnels without port forwarding.
  - **LocalXpose**: Powerful alternative for remote access.
- **🖥️ Premium Admin Panel**: A beautiful, glassmorphism-themed web interface to manage your hits in real-time.
- **🔗 Custom Domain Support**: Easily connect your own domain via the admin panel.
- **📱 Termux Optimized**: Native support for Android via Termux with full functionality.

---

### 🛠️ Installation

#### **Standard Linux**
```bash
# Clone the repository
git clone --depth=1 https://github.com/sosuke-d-mahi/mphisher.git

# Navigate to the directory
cd mphisher

# Launch Mphisher
bash mphisher.sh
```

#### **Termux (Android)**
```bash
# Install dependencies
pkg install git php curl -y

# Clone and run
git clone --depth=1 https://github.com/sosuke-d-mahi/mphisher.git
cd mphisher
bash mphisher.sh
```

---

### 💎 Premium Admin Panel

Mphisher now includes a state-of-the-art **Web Dashboard** to monitor your campaigns.

- **Real-time Monitoring**: View credentials and visitor IPs as they arrive.
- **Domain Configuration**: Set up your custom phishing domains with a single click.
- **Responsive Design**: Manage your tool from your phone or desktop.

**To start the panel:**
```bash
bash run-admin.sh
```
Access at: `http://localhost:8888`

---

### 🤝 Contributing

Contributions are what make the open-source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

### 👨‍💻 Author

**Easir Iqbal Mahi**
- GitHub: [@sosuke-d-mahi](https://github.com/sosuke-d-mahi)
- Tool Version: 2.3.5

---

<p align="center">
  Made with ❤️ by Easir Iqbal Mahi
</p>
