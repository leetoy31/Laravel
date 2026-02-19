# HNU Security System

![image alt](https://github.com/leetoy31/Laravel/blob/main/Screenshot%202026-02-04%20212357.png?raw=true)
![image alt](https://github.com/leetoy31/Laravel/blob/main/Screenshot%202026-02-04%20212406.png?raw=true)
![image alt](https://github.com/leetoy31/Laravel/blob/main/Screenshot%202026-02-04%20212406.png?raw=true)
![image alt](https://github.com/leetoy31/Laravel/blob/main/Screenshot%202026-02-04%20212406.png?raw=true)

A secure authentication system built with Laravel.

---

##  Features Already Working

### Authentication
- User registration with email validation
- User login with email and password
- Secure logout functionality
- Password hashing using bcrypt
- Session management with "Remember Me" option

### Security
- Role-Based Access Control (Admin & User roles)
- Protected routes with middleware
- Input validation (SQL Injection & XSS prevention)
- CSRF protection on all forms
- OTP/2FA via email (bypassed for test accounts)

### User Interface
- Responsive login page with two-column design
- Registration page
- Admin dashboard (purple theme)
- User dashboard (green theme)
- Modern UI with gradient backgrounds

### Database
- Users table with role management
- OTP codes table for 2FA
- Sessions table for authentication
- Database migrations
- Seeder with test accounts

---

##  What Still Needs to Be Done

### High Priority
- Add official HNU logo to login page
- Configure and test email SMTP for OTP delivery
- Style the registration page to match login design
- Create OTP verification page design

### Medium Priority
- Password reset functionality
- Email verification on registration
- User profile page
- Admin panel for user management
- Activity logging system

### Low Priority
- Enhanced password strength meter
- Account lockout after failed attempts
- Dark mode toggle
- Extended session options

---

##  Test Accounts

**Admin Account:**
- Email: admin@test.com
- Password: password123

**User Account:**
- Email: user@test.com
- Password: password123

> Note: Test accounts bypass OTP verification

---

##  Tech Stack

- **Framework:** Laravel 12.49.0
- **Language:** PHP 8.2.12
- **Database:** MySQL
- **Server:** XAMPP
- **Frontend:** HTML5, CSS3, Blade Templates

---

##  Project Requirements Met

| Requirement | Status |
|------------|--------|
| Laravel Framework | ✅ |
| Login & Registration | ✅ |
| Password Hashing (bcrypt) | ✅ |
| Role-Based Access (Admin/User) | ✅ |
| Protected Routes | ✅ |
| Input Validation | ✅ |
| OTP/2FA Feature | ✅ |

---

##  Project Status

**Completion:** 85%  
**Status:** In Development  
**Last Updated:** February 4, 2026

---

**Holy Name University - Tagbilaran City, Bohol**
