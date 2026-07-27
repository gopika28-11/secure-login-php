# Secure Login System with Brute-Force Protection
A PHP-based login system built to defend against brute-force and credential-stuffing attacks — 
built as part of my cybersecurity portfolio while completing my B.Sc. Computer Science.
## What It Does
This isn't just a login form — it actively detects and blocks repeated password-guessing attempts.
- Passwords are never stored in plain text — they're hashed using PHP's `password_hash()`
- Every login attempt (success or failure) is logged with a timestamp
- If an account has 5+ failed attempts within 15 minutes, it's automatically locked out — 
  even if the correct password is entered on the 6th try
- Login errors are intentionally generic ("Invalid username or password") so attackers can't 
  tell whether the username or password was wrong
## Why This Matters
Brute-force and credential-stuffing attacks work by rapidly guessing passwords until one succeeds. 
Rate-limiting and lockouts are a standard real-world defense against this — many basic login 
systems skip this step entirely.
## Tech Used
- PHP
- MySQL (via phpMyAdmin/XAMPP for local development)
- Prepared statements throughout, to prevent SQL injection
## Database Structure
**users** — stores username + hashed password  
**login_attempts** — logs every login attempt with username, timestamp, and success/failure
## Note on Credentials
Database credentials in `db.php` are hardcoded for local demo purposes only. In a production 
environment, these would be stored as environment variables rather than in source code.
## Demo
*(Add your screenshot here showing the "Account locked" message after 5 failed attempts, 
and the login_attempts table showing the logged attack)*
