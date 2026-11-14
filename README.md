# Saniya's Kitchen — Restaurant Website

A PHP + MySQL restaurant website starter project by **Saniya Islam**. Includes a customer-facing website, menu, session cart, customer accounts, table reservation requests, admin dashboard, order management and a demo UPI QR payment flow.

## Tech stack
- PHP 8.1+
- MySQL 5.7+ / MariaDB
- HTML, CSS, JavaScript
- PDO prepared statements

## Requirements
Install XAMPP (Apache + PHP + MySQL) or an equivalent PHP/MySQL environment.

## Local setup (XAMPP)
1. Copy the `SANIYAS-KITCHEN` folder into `C:\xampp\htdocs\`.
2. Start **Apache** and **MySQL** in XAMPP Control Panel.
3. Open `http://localhost/phpmyadmin`.
4. Import `database/restaurant.sql`.
5. Open `config/config.php` and check `BASE_URL`. For the folder above, `/SANIYAS-KITCHEN` is correct.
6. Open `config/database.php` and set your MySQL username/password.
7. Edit `database/create_admin.php`: choose a private admin email and a strong password.
8. Visit `http://localhost/SANIYAS-KITCHEN/database/create_admin.php` once.
9. **Immediately delete `database/create_admin.php`** after the admin is created.
10. Visit `http://localhost/SANIYAS-KITCHEN/`.

## Demo UPI QR
1. Edit `UPI_ID` in `config/config.php` to your own UPI ID.
2. Place an order while logged in. The site creates a UPI intent QR with the order amount.
3. This is a **demo/manual verification flow**, not a payment gateway. The QR scan does not send a payment confirmation to the website.
4. The customer can submit a UTR/reference. An admin must compare it with the actual bank/UPI transaction and then mark it paid under Admin → Verify payments.
5. Do not use this demo flow to accept real payments without proper payment-provider integration and server-side verification.

## Main routes
- `/index.php` — Home
- `/menu.php` — Menu
- `/cart.php` — Cart
- `/booking.php` — Table booking request
- `/auth/register.php` — Customer registration
- `/auth/login.php` — Customer login
- `/admin/login.php` — Admin login
- `/admin/dashboard.php` — Admin dashboard

## GitHub upload
From the project folder:
```bash
git init
git add .
git commit -m "Initial Saniya's Kitchen restaurant website"
git branch -M main
git remote add origin https://github.com/YOUR-USERNAME/SANIYAS-KITCHEN.git
git push -u origin main
```
Create an empty repository on GitHub first and replace `YOUR-USERNAME` with your GitHub username.

## Before publishing
- Change the UPI ID, contact information and restaurant address.
- Use HTTPS and production database credentials.
- Remove the admin setup script after use.
- Add rate limiting, email verification, password reset, audit logs and stronger production deployment controls.
- Never commit passwords, API keys, database credentials or real customer data.
- Add a real payment gateway only with its official server-side signature/webhook verification.

## Notes
This is a learning/portfolio project. Images are loaded from Unsplash URLs and the QR library is loaded from a CDN, so internet access is required for those assets.
