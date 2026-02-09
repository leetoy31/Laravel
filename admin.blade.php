<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - HNU Security</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            bottom: 30px;
            right: 30px;
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

        /* Top Navigation */
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

        .user-menu-container {
            position: relative;
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

        .user-dropdown {
            position: absolute;
            top: 50px;
            right: 0;
            background: var(--bg-secondary);
            border-radius: 12px;
            box-shadow: var(--shadow-hover);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .user-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .user-dropdown-item {
            padding: 12px 20px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .user-dropdown-item:last-child {
            border-bottom: none;
            border-radius: 0 0 12px 12px;
        }

        .user-dropdown-item:first-child {
            border-radius: 12px 12px 0 0;
        }

        .user-dropdown-item:hover {
            background: var(--hover-bg);
        }

        .user-dropdown-item.logout {
            color: #e74c3c;
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

        /* User Management - Replacing Security Features */
        .user-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background: var(--hover-bg);
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            align-items: center;
        }

        .user-item:hover {
            transform: translateX(5px);
            box-shadow: var(--shadow);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            overflow: hidden;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 2px;
            color: var(--text-primary);
        }

        .user-email {
            font-size: 12px;
            color: var(--text-light);
        }

        .user-actions {
            display: flex;
            gap: 8px;
        }

        .action-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: white;
            border: 1px solid var(--border-color);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            overflow: hidden;
        }

        .action-icon img {
            width: 16px;
            height: 16px;
            object-fit: contain;
        }

        .action-icon:hover {
            transform: scale(1.1);
            box-shadow: var(--shadow);
        }

        /* Dashboard Stats Grid */
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
            margin-bottom: 12px;
            overflow: hidden;
        }

        .project-icon img {
            width: 24px;
            height: 24px;
            object-fit: contain;
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

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: var(--bg-secondary);
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            width: 90%;
            max-height: 85vh;
            overflow-y: auto;
            animation: slideUp 0.3s ease;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .modal-header h2 {
            font-size: 24px;
            font-weight: 700;
        }

        .close-modal {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--hover-bg);
            border: none;
            cursor: pointer;
            font-size: 24px;
            color: var(--text-secondary);
            transition: all 0.3s;
        }

        .close-modal:hover {
            background: #e74c3c;
            color: white;
            transform: rotate(90deg);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            background: var(--bg-primary);
            color: var(--text-primary);
            transition: all 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-group input:disabled {
            background: var(--hover-bg);
            cursor: not-allowed;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn-success {
            flex: 1;
            padding: 12px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-success:hover {
            background: #229954;
            transform: translateY(-2px);
        }

        .btn-danger {
            flex: 1;
            padding: 12px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-danger:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        .btn-cancel {
            flex: 1;
            padding: 12px;
            background: var(--hover-bg);
            color: var(--text-primary);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background: var(--border-color);
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

        /* Loading */
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

        /* Scroll Top */
        .scroll-top {
            position: fixed;
            bottom: 100px;
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

    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img" onerror="this.style.display='none'">
            <span>HNU Security</span>
        </div>

        <ul class="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#users">Users</a></li>
            <li><a href="#security">Security</a></li>
            <li><a href="#settings">Settings</a></li>
        </ul>

        <div class="user-menu-container">
            <div class="user-icon" onclick="toggleUserMenu(event)">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="user-dropdown" id="userDropdown">
                <div class="user-dropdown-item">
                    <span>👤</span>
                    <span>Profile</span>
                </div>
                <div class="user-dropdown-item">
                    <span>⚙️</span>
                    <span>Settings</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <div class="user-dropdown-item logout" onclick="this.closest('form').submit()">
                        <span>🚪</span>
                        <span>Logout</span>
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="profile-photo">
                <img src="{{ asset('images/admin-profile.png') }}" alt="Admin Profile" onerror="this.style.display='none'; this.parentElement.innerHTML='<div style=\'width:100%;height:100%;background:linear-gradient(135deg,#667eea,#764ba2);display:flex;align-items:center;justify-content:center;color:white;font-size:72px;font-weight:700;\'>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>'">
            </div>
            <div class="profile-info">
                <h1 class="profile-name">
                    {{ Auth::user()->name }}
                    <span class="verified-badge">✓</span>
                </h1>
                <p class="profile-location">📍 Tagbilaran City, Bohol, Philippines</p>
                <p class="profile-title">System Administrator / HNU Security Manager</p>
                <div class="action-buttons">
                    <button class="btn btn-primary" onclick="viewDashboard()">
                        📊 Dashboard
                    </button>
                    <button class="btn btn-secondary" onclick="settings()">
                        ⚙️ Settings
                    </button>
                </div>
            </div>
        </div>

        <!-- About and Manage Users -->
        <div class="content-grid">
            <!-- About Profile -->
            <div class="section-card animate-on-scroll">
                <div class="section-header">
                    <img src="{{ asset('images/icon-about.png') }}" alt="About" class="section-icon" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E📋%3C/text%3E%3C/svg%3E'">
                    <span>About Profile</span>
                </div>
                <div class="about-content section-content">
                    <p>I am a system administrator for the Holy Name University Security System, responsible for managing user accounts, security protocols, and system configurations.</p>
                    <br>
                    <p>My role includes implementing advanced security features such as bcrypt password hashing, role-based access control (RBAC), input validation, and two-factor authentication to ensure the highest level of protection for all users.</p>
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

            <!-- Manage Users -->
            <div class="section-card animate-on-scroll">
                <div class="section-header">
                    <img src="{{ asset('images/icon-users.png') }}" alt="Users" class="section-icon" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E👥%3C/text%3E%3C/svg%3E'">
                    <span>Manage Users</span>
                </div>
                <div style="max-height: 400px; overflow-y: auto;">
                    @foreach(\App\Models\User::orderBy('created_at', 'desc')->take(5)->get() as $user)
                    <div class="user-item">
                        <div class="user-avatar">
                            <img src="{{ asset('images/user-icon-' . $user->id . '.png') }}" alt="{{ $user->name }}" onerror="this.style.display='none'; this.parentElement.textContent='{{ strtoupper(substr($user->name, 0, 1)) }}'">
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ $user->name }}</div>
                            <div class="user-email">{{ $user->email }}</div>
                        </div>
                        <div class="user-actions" onclick="event.stopPropagation()">
                            <div class="action-icon" onclick="viewUser({{ $user->id }})" title="View">
                                <img src="{{ asset('images/icon-view.png') }}" alt="View" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'12\'%3E👁️%3C/text%3E%3C/svg%3E'">
                            </div>
                            <div class="action-icon" onclick="editUser({{ $user->id }})" title="Edit">
                                <img src="{{ asset('images/icon-edit.png') }}" alt="Edit" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'12\'%3E✏️%3C/text%3E%3C/svg%3E'">
                            </div>
                            @if($user->id !== Auth::id())
                            <div class="action-icon" onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')" title="Delete">
                                <img src="{{ asset('images/icon-delete.png') }}" alt="Delete" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'12\'%3E🗑️%3C/text%3E%3C/svg%3E'">
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="btn btn-primary" style="width: 100%; margin-top: 15px;" onclick="showAllUsers()">View All Users</button>
            </div>
        </div>

        <!-- Dashboard Stats -->
        <div class="projects-grid animate-on-scroll">
            <div class="grid-header">
                <img src="{{ asset('images/icon-dashboard.png') }}" alt="Dashboard" class="grid-icon" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E📊%3C/text%3E%3C/svg%3E'">
                <span>Dashboard Statistics</span>
            </div>
            <div class="cards-grid">
                <div class="project-card" onclick="filterUsers('all')">
                    <div class="project-icon">
                        <img src="{{ asset('images/stat-total.png') }}" alt="Total Users" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E👥%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="project-title">Total Users</div>
                    <div class="project-desc" style="font-size: 32px; font-weight: 700; color: var(--text-primary);">{{ \App\Models\User::count() }}</div>
                    <div class="project-link">All registered users</div>
                </div>

                <div class="project-card" onclick="filterUsers('admin')">
                    <div class="project-icon">
                        <img src="{{ asset('images/stat-admin.png') }}" alt="Admin Users" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E⚡%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="project-title">Admin Users</div>
                    <div class="project-desc" style="font-size: 32px; font-weight: 700; color: var(--text-primary);">{{ \App\Models\User::where('role', 'admin')->count() }}</div>
                    <div class="project-link">System administrators</div>
                </div>

                <div class="project-card" onclick="filterUsers('user')">
                    <div class="project-icon">
                        <img src="{{ asset('images/stat-users.png') }}" alt="Regular Users" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E👤%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="project-title">Regular Users</div>
                    <div class="project-desc" style="font-size: 32px; font-weight: 700; color: var(--text-primary);">{{ \App\Models\User::where('role', 'user')->count() }}</div>
                    <div class="project-link">Standard accounts</div>
                </div>

                <div class="project-card" onclick="filterUsers('new')">
                    <div class="project-icon">
                        <img src="{{ asset('images/stat-new.png') }}" alt="New Users" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E🆕%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="project-title">New This Month</div>
                    <div class="project-desc" style="font-size: 32px; font-weight: 700; color: var(--text-primary);">{{ \App\Models\User::whereMonth('created_at', now()->month)->count() }}</div>
                    <div class="project-link">Recently registered</div>
                </div>
            </div>
        </div>

        <!-- Contact for Admin -->
        <div class="section-card animate-on-scroll">
            <div class="section-header">
                <img src="{{ asset('images/icon-contact.png') }}" alt="Contact" class="section-icon" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'16\'%3E📧%3C/text%3E%3C/svg%3E'">
                <span>Contact Information</span>
            </div>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
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
                        <img src="{{ asset('images/contact-role.png') }}" alt="Role" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'14\'%3E⚡%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="contact-content">
                        <div class="contact-label">Role</div>
                        <div class="contact-value">System Administrator</div>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <img src="{{ asset('images/contact-department.png') }}" alt="Department" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\'%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' font-size=\'14\'%3E🛡️%3C/text%3E%3C/svg%3E'">
                    </div>
                    <div class="contact-content">
                        <div class="contact-label">Department</div>
                        <div class="contact-value">Security Systems</div>
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

    <!-- View User Modal -->
    <div class="modal" id="viewModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>User Details</h2>
                <button class="close-modal" onclick="closeModal('viewModal')">×</button>
            </div>
            <div id="viewModalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Edit User</h2>
                <button class="close-modal" onclick="closeModal('editModal')">×</button>
            </div>
            <form id="editUserForm" onsubmit="return false;">
                <input type="hidden" id="editUserId">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" id="editName" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="editEmail" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select id="editRole" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>New Password (leave blank to keep current)</label>
                    <input type="password" id="editPassword" placeholder="Enter new password">
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-success" onclick="saveUser()">💾 Save Changes</button>
                    <button type="button" class="btn-cancel" onclick="closeModal('editModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Confirm Delete</h2>
                <button class="close-modal" onclick="closeModal('deleteModal')">×</button>
            </div>
            <div style="padding: 20px 0;">
                <p style="font-size: 16px; color: var(--text-secondary); margin-bottom: 20px;">
                    Are you sure you want to delete user "<strong id="deleteUserName"></strong>"?
                </p>
                <p style="font-size: 14px; color: #e74c3c;">
                    ⚠️ This action cannot be undone.
                </p>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-danger" onclick="confirmDelete()">🗑️ Delete User</button>
                <button type="button" class="btn-cancel" onclick="closeModal('deleteModal')">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        let currentDeleteUserId = null;

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

        // Toggle User Menu
        function toggleUserMenu(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('active');
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.remove('active');
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

        // Modal Functions
        function showModal(modalId) {
            document.getElementById(modalId).classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        // View User
        function viewUser(userId) {
            showLoading();
            const modalBody = document.getElementById('viewModalBody');
            
            // Simulate fetching user data
            const user = @json(\App\Models\User::all()->keyBy('id'));
            const userData = user[userId];
            
            modalBody.innerHTML = `
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" value="${userData.name}" disabled>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" value="${userData.email}" disabled>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <input type="text" value="${userData.role.charAt(0).toUpperCase() + userData.role.slice(1)}" disabled>
                </div>
                <div class="form-group">
                    <label>Joined Date</label>
                    <input type="text" value="${new Date(userData.created_at).toLocaleDateString()}" disabled>
                </div>
            `;
            showModal('viewModal');
        }

        // Edit User
        function editUser(userId) {
            showLoading();
            const user = @json(\App\Models\User::all()->keyBy('id'));
            const userData = user[userId];
            
            document.getElementById('editUserId').value = userData.id;
            document.getElementById('editName').value = userData.name;
            document.getElementById('editEmail').value = userData.email;
            document.getElementById('editRole').value = userData.role;
            document.getElementById('editPassword').value = '';
            
            showModal('editModal');
        }

        // Save User (Edit)
        function saveUser() {
            showLoading();
            alert('User updated successfully! (This would save to database)');
            closeModal('editModal');
            setTimeout(() => location.reload(), 1000);
        }

        // Delete User
        function deleteUser(userId, userName) {
            currentDeleteUserId = userId;
            document.getElementById('deleteUserName').textContent = userName;
            showModal('deleteModal');
        }

        // Confirm Delete
        function confirmDelete() {
            if (currentDeleteUserId) {
                showLoading();
                alert('User deleted successfully! (This would delete from database)');
                closeModal('deleteModal');
                setTimeout(() => location.reload(), 1000);
            }
        }

        // Other Functions
        function viewDashboard() {
            alert('Dashboard analytics view');
        }

        function settings() {
            alert('Admin settings panel');
        }

        function showAllUsers() {
            alert('Showing all users in full table view');
        }

        function filterUsers(type) {
            alert('Filtering users by: ' + type);
        }

        // Close modal on outside click
        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
            }
        });
    </script>
</body>
</html>