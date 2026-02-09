<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - HNU Security</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-primary: #f5f5f5;
            --bg-secondary: #ffffff;
            --text-primary: #333333;
            --text-secondary: #666666;
            --text-light: #999999;
            --border-color: #f0f0f0;
            --hover-bg: #f8f8f8;
            --shadow: 0 2px 8px rgba(0,0,0,0.05);
            --shadow-hover: 0 4px 12px rgba(0,0,0,0.1);
            --blue-link: #0066cc;
        }

        [data-theme="dark"] {
            --bg-primary: #1a1a1a;
            --bg-secondary: #2d2d2d;
            --text-primary: #e0e0e0;
            --text-secondary: #b0b0b0;
            --text-light: #808080;
            --border-color: #404040;
            --hover-bg: #3a3a3a;
            --shadow: 0 2px 8px rgba(0,0,0,0.3);
            --shadow-hover: 0 4px 12px rgba(0,0,0,0.5);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* Dark Mode Toggle */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1001;
            background: var(--bg-secondary);
            border-radius: 30px;
            padding: 4px;
            box-shadow: var(--shadow);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            box-shadow: var(--shadow-hover);
            transform: scale(1.05);
        }

        .toggle-track {
            width: 70px;
            height: 32px;
            background: var(--border-color);
            border-radius: 30px;
            position: relative;
            transition: background 0.3s ease;
        }

        .toggle-thumb {
            position: absolute;
            top: 4px;
            left: 4px;
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, #ffd700, #ffa500);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        }

        [data-theme="dark"] .toggle-thumb {
            transform: translateX(38px);
            background: linear-gradient(135deg, #4a5568, #2d3748);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
            }
        }

        .animate-on-scroll {
            opacity: 0;
        }

        .animate-on-scroll.animated {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* Sigma Header */
        .top-nav {
            background: white;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            animation: fadeInUp 0.5s ease;
            transition: background 0.3s ease;
        }

        [data-theme="dark"] .top-nav {
            background: var(--bg-secondary);
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logo-img {
            width: 30px;
            height: 30px;
            object-fit: contain;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            list-style: none;
        }

        .nav-links a {
            color: var(--text-primary);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
        }

        .nav-links a:hover {
            color: var(--blue-link);
        }

        .user-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .user-icon:hover {
            transform: scale(1.1);
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 80px 20px 40px;
        }

        /* Header Section */
        .header-section {
            background: var(--bg-secondary);
            border-radius: 12px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            display: flex;
            gap: 40px;
            align-items: flex-start;
            animation: fadeInUp 0.6s ease;
            transition: all 0.3s ease;
        }

        .header-section:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
        }

        .profile-photo {
            width: 200px;
            height: 240px;
            background: #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            animation: slideInLeft 0.8s ease;
        }

        .profile-photo:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-hover);
        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-info {
            flex: 1;
            animation: slideInRight 0.8s ease;
        }

        .profile-name {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-primary);
        }

        .verified-badge {
            width: 24px;
            height: 24px;
            background: #1DA1F2;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            animation: bounceIn 1s ease 0.3s both;
        }

        .profile-location {
            color: var(--text-secondary);
            font-size: 14px;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .profile-title {
            font-size: 16px;
            color: var(--text-primary);
            margin-bottom: 20px;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #2c2c2c;
            color: white;
        }

        [data-theme="dark"] .btn-primary {
            background: #e0e0e0;
            color: #1a1a1a;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        .btn-secondary {
            background: var(--hover-bg);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--border-color);
            transform: translateY(-2px);
        }

        /* Two Column Layout */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        /* Section Cards */
        .section-card {
            background: var(--bg-secondary);
            border-radius: 12px;
            padding: 30px;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .section-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-3px);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .section-icon {
            width: 24px;
            height: 24px;
            object-fit: contain;
        }

        .section-content {
            color: var(--text-secondary);
            font-size: 14px;
            line-height: 1.8;
        }

        /* About Profile with Map */
        .about-content {
            margin-bottom: 20px;
        }

        .map-container {
            margin-top: 20px;
        }

        .map-label {
            font-size: 12px;
            color: var(--text-light);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .map-placeholder {
            width: 100%;
            height: 200px;
            background: var(--hover-bg);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .map-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Security Features */
        .feature-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .feature-item:hover {
            transform: translateX(5px);
            background: var(--hover-bg);
            padding: 10px;
            margin: -10px;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        .feature-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background: var(--hover-bg);
            border-radius: 50%;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .feature-icon img {
            width: 24px;
            height: 24px;
            object-fit: contain;
        }

        .feature-item:hover .feature-icon {
            transform: scale(1.1);
        }

        .feature-content {
            flex: 1;
        }

        .feature-title {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 4px;
            color: var(--text-primary);
        }

        .feature-subtitle {
            font-size: 13px;
            color: var(--text-light);
        }

        .feature-status {
            font-size: 13px;
            color: var(--text-light);
            margin-left: auto;
            flex-shrink: 0;
        }

        /* Projects Grid */
        .projects-grid {
            background: var(--bg-secondary);
            border-radius: 12px;
            padding: 30px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .projects-grid:hover {
            box-shadow: var(--shadow-hover);
        }

        .grid-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .grid-icon {
            width: 24px;
            height: 24px;
            object-fit: contain;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .project-card {
            background: var(--hover-bg);
            border-radius: 8px;
            padding: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .project-card:hover {
            background: var(--bg-secondary);
            transform: translateY(-5px);
            box-shadow: var(--shadow);
            border-color: #2c2c2c;
        }

        [data-theme="dark"] .project-card:hover {
            border-color: #e0e0e0;
        }

        .project-icon {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
        }

        .project-icon img {
            width: 24px;
            height: 24px;
            object-fit: contain;
        }

        .project-details {
            flex: 1;
        }

        .project-title {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-primary);
        }

        .project-desc {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        .project-link {
            font-size: 12px;
            color: var(--text-light);
        }

        /* Bottom Section */
        .bottom-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .info-list {
            list-style: none;
        }

        .info-list li {
            margin-bottom: 16px;
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.8;
            transition: all 0.3s ease;
        }

        .info-list li:hover {
            color: var(--text-primary);
            transform: translateX(5px);
        }

        .social-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            color: var(--text-primary);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            border-radius: 6px;
        }

        .social-link:hover {
            background: var(--hover-bg);
            padding-left: 10px;
        }

        .social-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .social-icon img {
            width: 20px;
            height: 20px;
            object-fit: contain;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .contact-item:hover {
            transform: scale(1.02);
        }

        .contact-icon {
            width: 40px;
            height: 40px;
            background: var(--hover-bg);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .contact-icon img {
            width: 20px;
            height: 20px;
            object-fit: contain;
        }

        .contact-item:hover .contact-icon {
            transform: scale(1.1);
        }

        .contact-content {
            flex: 1;
        }

        .contact-label {
            font-size: 12px;
            color: var(--text-light);
            margin-bottom: 4px;
        }

        .contact-value {
            font-size: 14px;
            color: var(--text-primary);
            font-weight: 500;
        }

        /* Footer */
        .footer {
            margin-top: 60px;
            padding: 30px 0;
            border-top: 1px solid var(--border-color);
            text-align: center;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .footer-link {
            color: var(--blue-link);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        .footer-copyright {
            color: var(--text-secondary);
            font-size: 13px;
        }

        /* Loading & Scroll Top */
        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
            transform: scaleX(0);
            transform-origin: left;
            z-index: 9999;
        }

        .loading.active {
            animation: loading 1.5s ease-in-out;
        }

        @keyframes loading {
            0% { transform: scaleX(0); }
            50% { transform: scaleX(0.7); }
            100% { transform: scaleX(1); }
        }

        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--bg-secondary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            cursor: pointer;
            box-shadow: var(--shadow);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
        }

        .scroll-top.visible {
            opacity: 1;
            visibility: visible;
        }

        .scroll-top:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        @media (max-width: 768px) {
            .header-section {
                flex-direction: column;
            }

            .content-grid,
            .cards-grid,
            .bottom-grid {
                grid-template-columns: 1fr;
            }

            .nav-links {
                display: none;
            }

            .theme-toggle {
                top: 10px;
                right: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Bar -->
    <div class="loading"></div>

    <!-- Dark Mode Toggle -->
    <div class="theme-toggle" onclick="toggleTheme()">
        <div class="toggle-track">
            <div class="toggle-thumb">
                <span id="themeIcon">☀️</span>
            </div>
        </div>
    </div>

    <!-- Scroll to Top -->
    <div class="scroll-top" onclick="scrollToTop()">
        ↑
    </div>

    <!-- Sigma Header -->
    <nav class="top-nav">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img" onerror="this.style.display='none'">
            <span>HNU Security</span>
        </div>

        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#security">Security</a></li>
            <li><a href="#activity">My Activity</a></li>
            <li><a href="#profile">Profile</a></li>
        </ul>

        <div class="user-icon" onclick="toggleUserMenu()">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
    </nav>

    <div class="container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="profile-photo">
                <img src="{{ asset('images/user-profile.png') }}" alt="Profile" onerror="this.style.display='none'; this.parentElement.innerHTML='<div style=\'width:100%;height:100%;background:linear-gradient(135deg,#667eea,#764ba2);display:flex;align-items:center;justify-content:center;color:white;font-size:72px;font-weight:700;\'>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>'">
            </div>
            <div class="profile-info">
                <h1 class="profile-name">
                    {{ Auth::user()->name }}
                    <span class="verified-badge">✓</span>
                </h1>
                <p class="profile-location">📍 Tagbilaran City, Bohol, Philippines</p>
                <p class="profile-title">HNU Student / Security System User</p>
                <div class="action-buttons">
                    <button class="btn btn-primary" onclick="viewProfile()">
                        📄 View Profile
                    </button>
                    <button class="btn btn-secondary" onclick="settings()">
                        ✉️ Settings
                    </button>
                </div>
            </div>
        </div>

        <!-- About and Security Features -->
        <div class="content-grid">
            <div class="section-card animate-on-scroll">
                <div class="section-header">
                    <img src="{{ asset('images/icon-about.png') }}" alt="About" class="section-icon" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E📋%3C/text%3E%3C/svg%3E'">
                    <span>About</span>
                </div>
                <div class="about-content section-content">
                    <p>I am a student at Holy Name University, Tagbilaran City, Bohol, Philippines. My account is secured with advanced security features including password hashing, role-based access control, and two-factor authentication.</p>
                    <br>
                    <p>Member since {{ Auth::user()->created_at->format('F Y') }}, with a strong commitment to maintaining account security and following best practices for digital safety.</p>
                </div>
                <div class="map-container">
                    <div class="map-label">
                        📍 Institution Location
                    </div>
                    <div class="map-placeholder">
                        <img src="{{ asset('images/map-location.png') }}" alt="Map" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 300 200\'%3E%3Crect fill=\'%23e0e0e0\' width=\'300\' height=\'200\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%23999\' font-size=\'14\'%3ETagbilaran City, Bohol%3C/text%3E%3C/svg%3E'">
                    </div>
                </div>
            </div>

            <div class="section-card animate-on-scroll">
                <div class="section-header">
                    <img src="{{ asset('images/icon-security.png') }}" alt="Security" class="section-icon" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E🛡️%3C/text%3E%3C/svg%3E'">
                    <span>Security Features</span>
                </div>
                <div>
                    <div class="feature-item" onclick="showFeatureDetail('password')">
                        <div class="feature-icon">
                            <img src="{{ asset('images/feature-password.png') }}" alt="Password" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E🔒%3C/text%3E%3C/svg%3E'">
                        </div>
                        <div class="feature-content">
                            <div class="feature-title">Password Encryption - Bcrypt</div>
                            <div class="feature-subtitle">Industry-Standard Hashing Algorithm</div>
                        </div>
                        <div class="feature-status">Active</div>
                    </div>

                    <div class="feature-item" onclick="showFeatureDetail('2fa')">
                        <div class="feature-icon">
                            <img src="{{ asset('images/feature-2fa.png') }}" alt="2FA" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E🔐%3C/text%3E%3C/svg%3E'">
                        </div>
                        <div class="feature-content">
                            <div class="feature-title">2FA / OTP Authentication</div>
                            <div class="feature-subtitle">Email-based Two-Factor Security</div>
                        </div>
                        <div class="feature-status">Enabled</div>
                    </div>

                    <div class="feature-item" onclick="showFeatureDetail('rbac')">
                        <div class="feature-icon">
                            <img src="{{ asset('images/feature-rbac.png') }}" alt="RBAC" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E🎭%3C/text%3E%3C/svg%3E'">
                        </div>
                        <div class="feature-content">
                            <div class="feature-title">Role-Based Access Control</div>
                            <div class="feature-subtitle">User Privilege Management</div>
                        </div>
                        <div class="feature-status">Active</div>
                    </div>

                    <div class="feature-item" onclick="showFeatureDetail('validation')">
                        <div class="feature-icon">
                            <img src="{{ asset('images/feature-validation.png') }}" alt="Validation" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E✅%3C/text%3E%3C/svg%3E'">
                        </div>
                        <div class="feature-content">
                            <div class="feature-title">Input Validation & Protection</div>
                            <div class="feature-subtitle">SQL Injection & XSS Prevention</div>
                        </div>
                        <div class="feature-status">Active</div>
                    </div>

                    <div class="feature-item" onclick="showFeatureDetail('session')">
                        <div class="feature-icon">
                            <img src="{{ asset('images/feature-session.png') }}" alt="Session" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E🔑%3C/text%3E%3C/svg%3E'">
                        </div>
                        <div class="feature-content">
                            <div class="feature-title">Session Security</div>
                            <div class="feature-subtitle">Protected Session Management</div>
                        </div>
                        <div class="feature-status">Active</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="projects-grid animate-on-scroll">
            <div class="grid-header">
                <img src="{{ asset('images/icon-activity.png') }}" alt="Activity" class="grid-icon" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E📊%3C/text%3E%3C/svg%3E'">
                <span>Recent Activity</span>
            </div>
            <div class="cards-grid">
                <div class="project-card" onclick="viewActivity(1)">
                    <div class="project-icon">
                        <img src="{{ asset('images/activity-login.png') }}" alt="Login" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E🔓%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="project-details">
                        <div class="project-title">Successful Login</div>
                        <div class="project-desc">Logged in via web browser with OTP verification</div>
                        <div class="project-link">Today at {{ now()->format('h:i A') }}</div>
                    </div>
                </div>

                <div class="project-card" onclick="viewActivity(2)">
                    <div class="project-icon">
                        <img src="{{ asset('images/activity-update.png') }}" alt="Update" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E✏️%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="project-details">
                        <div class="project-title">Profile Updated</div>
                        <div class="project-desc">Personal information successfully updated</div>
                        <div class="project-link">{{ now()->subDays(1)->format('M d, Y') }}</div>
                    </div>
                </div>

                <div class="project-card" onclick="viewActivity(3)">
                    <div class="project-icon">
                        <img src="{{ asset('images/activity-security.png') }}" alt="Security" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E🛡️%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="project-details">
                        <div class="project-title">Security Check Passed</div>
                        <div class="project-desc">System security validation completed</div>
                        <div class="project-link">{{ now()->subDays(2)->format('M d, Y') }}</div>
                    </div>
                </div>

                <div class="project-card" onclick="viewActivity(4)">
                    <div class="project-icon">
                        <img src="{{ asset('images/activity-2fa.png') }}" alt="2FA" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E🔐%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="project-details">
                        <div class="project-title">2FA Enabled</div>
                        <div class="project-desc">Two-factor authentication activated</div>
                        <div class="project-link">{{ now()->subDays(5)->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Verification -->
        <div class="projects-grid animate-on-scroll">
            <div class="grid-header">
                <img src="{{ asset('images/icon-verification.png') }}" alt="Verification" class="grid-icon" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E✓%3C/text%3E%3C/svg%3E'">
                <span>Account Verification</span>
            </div>
            <div class="cards-grid">
                <div class="project-card">
                    <div class="project-icon">
                        <img src="{{ asset('images/verify-email.png') }}" alt="Email" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E📧%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="project-details">
                        <div class="project-title">Email Verified</div>
                        <div class="project-desc">{{ Auth::user()->email }}</div>
                        <div class="project-link">Verified Account</div>
                    </div>
                </div>

                <div class="project-card">
                    <div class="project-icon">
                        <img src="{{ asset('images/verify-active.png') }}" alt="Active" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E✅%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="project-details">
                        <div class="project-title">Account Active</div>
                        <div class="project-desc">All security features enabled</div>
                        <div class="project-link">Status: Active</div>
                    </div>
                </div>

                <div class="project-card">
                    <div class="project-icon">
                        <img src="{{ asset('images/verify-security.png') }}" alt="Security Level" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E🔒%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="project-details">
                        <div class="project-title">Security Level: High</div>
                        <div class="project-desc">Maximum protection enabled</div>
                        <div class="project-link">Updated Today</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Grid -->
        <div class="bottom-grid">
            <!-- Account Info -->
            <div class="section-card animate-on-scroll">
                <div class="section-header">
                    <img src="{{ asset('images/icon-info.png') }}" alt="Info" class="section-icon" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E🎯%3C/text%3E%3C/svg%3E'">
                    <span>Account Info</span>
                </div>
                <ul class="info-list">
                    <li>Member since {{ Auth::user()->created_at->format('F Y') }} with verified email and active security features.</li>
                    <li>Maintain account security through regular password updates and 2FA verification.</li>
                </ul>
            </div>

            <!-- Quick Links -->
            <div class="section-card animate-on-scroll">
                <div class="section-header">
                    <img src="{{ asset('images/icon-links.png') }}" alt="Links" class="section-icon" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E🔗%3C/text%3E%3C/svg%3E'">
                    <span>Quick Links</span>
                </div>
                <div>
                    <a href="#" class="social-link" onclick="editProfile(); return false;">
                        <span class="social-icon">
                            <img src="{{ asset('images/link-profile.png') }}" alt="Profile" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'14\'%3E👤%3C/text%3E%3C/svg%3E'">
                        </span>
                        Edit Profile
                    </a>
                    <a href="#" class="social-link" onclick="changePassword(); return false;">
                        <span class="social-icon">
                            <img src="{{ asset('images/link-password.png') }}" alt="Password" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'14\'%3E🔒%3C/text%3E%3C/svg%3E'">
                        </span>
                        Change Password
                    </a>
                    <a href="#" class="social-link" onclick="manage2FA(); return false;">
                        <span class="social-icon">
                            <img src="{{ asset('images/link-2fa.png') }}" alt="2FA" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'14\'%3E🔐%3C/text%3E%3C/svg%3E'">
                        </span>
                        Manage 2FA
                    </a>
                </div>
            </div>

            <!-- Contact -->
            <div class="section-card animate-on-scroll">
                <div class="section-header">
                    <img src="{{ asset('images/icon-contact.png') }}" alt="Contact" class="section-icon" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E📧%3C/text%3E%3C/svg%3E'">
                    <span>Contact</span>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <img src="{{ asset('images/contact-email.png') }}" alt="Email" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'14\'%3E✉️%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="contact-content">
                        <div class="contact-label">Email</div>
                        <div class="contact-value">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <img src="{{ asset('images/contact-institution.png') }}" alt="Institution" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'14\'%3E🏛️%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="contact-content">
                        <div class="contact-label">Institution</div>
                        <div class="contact-value">Holy Name University</div>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <img src="{{ asset('images/contact-facebook.png') }}" alt="Facebook" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'14\'%3E📘%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="contact-content">
                        <div class="contact-label">Facebook</div>
                        <div class="contact-value">HNU Security</div>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <img src="{{ asset('images/contact-twitter.png') }}" alt="Twitter" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'14\'%3E🐦%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="contact-content">
                        <div class="contact-label">Twitter</div>
                        <div class="contact-value">@HNUSecurity</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-links">
                <a href="#" class="footer-link">Privacy Policy</a>
                <a href="#" class="footer-link">Terms of Service</a>
                <a href="#" class="footer-link">Security</a>
                <a href="#" class="footer-link">Contact</a>
                <a href="#" class="footer-link">Help Center</a>
            </div>
            <div class="footer-copyright">
                © {{ now()->year }} Holy Name University Security System. All rights reserved.
            </div>
        </footer>
    </div>

    <script>
        // Theme Toggle
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            const icon = document.getElementById('themeIcon');
            
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            icon.textContent = newTheme === 'dark' ? '🌙' : '☀️';
            
            showLoading();
        }

        // Load saved theme
        window.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme') || 'light';
            const icon = document.getElementById('themeIcon');
            document.documentElement.setAttribute('data-theme', savedTheme);
            icon.textContent = savedTheme === 'dark' ? '🌙' : '☀️';
            
            observeElements();
        });

        // Loading Bar
        function showLoading() {
            const loading = document.querySelector('.loading');
            loading.classList.add('active');
            setTimeout(() => loading.classList.remove('active'), 1500);
        }

        // Scroll to Top
        window.addEventListener('scroll', () => {
            const scrollTop = document.querySelector('.scroll-top');
            if (window.pageYOffset > 300) {
                scrollTop.classList.add('visible');
            } else {
                scrollTop.classList.remove('visible');
            }
        });

        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Animate on Scroll
        function observeElements() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.add('animated');
                        }, index * 100);
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                observer.observe(el);
            });
        }

        // Interactive Functions
        function toggleUserMenu() {
            alert('User menu - Profile, Settings, Logout options');
        }

        function viewProfile() {
            showLoading();
            alert('Opening your profile...');
        }

        function settings() {
            showLoading();
            alert('Opening settings...');
        }

        function showFeatureDetail(feature) {
            const features = {
                'password': 'Password Encryption: Your password is secured using Bcrypt, a strong one-way hashing algorithm.',
                '2fa': '2FA Authentication: Two-factor authentication adds an extra layer of security via email OTP.',
                'rbac': 'Role-Based Access: Your permissions are managed based on your user role.',
                'validation': 'Input Validation: All inputs are validated to prevent SQL injection and XSS attacks.',
                'session': 'Session Security: Your sessions are protected with encrypted tokens and timeout mechanisms.'
            };
            alert(features[feature]);
        }

        function viewActivity(id) {
            showLoading();
            alert('Viewing activity details #' + id);
        }

        function editProfile() {
            showLoading();
            alert('Edit Profile - Update your personal information');
        }

        function changePassword() {
            showLoading();
            alert('Change Password - Update your account password');
        }

        function manage2FA() {
            showLoading();
            alert('Manage 2FA - Configure two-factor authentication');
        }
    </script>
</body>
</html>