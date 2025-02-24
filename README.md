# PediaTopup - Digital Product Top-up Platform

A web-based platform for digital product top-ups including mobile credit, data packages, e-money, and bill payments.


## Features

- User Authentication System
- Digital Product Top-up
- E-wallet/Balance System
- Transaction History
- Admin Dashboard
- Product Management
- Responsive Mobile-First Design

## Tech Stack

- PHP 8.1+
- CodeIgniter 4
- MySQL/MariaDB
- Bootstrap 4.6
- jQuery 3.7.1
- SweetAlert2
- Font Awesome 5.5.0
- Material Design Iconic Font

## Prerequisites

- XAMPP/WAMP with PHP 8.1 or higher
- Composer
- Web Browser (Chrome/Firefox recommended)
- Required PHP Extensions:
  - intl
  - mbstring
  - json
  - mysqlnd
  - libcurl

## Installation

1. Clone this repository to your xampp/htdocs directory:
```bash
git clone https://github.com/yourusername/PediaTopUp.git
```
2. Install dependencies:
```bash
composer install
```

3. Create database and import SQL file : 
 -> Create a new database named ```db_pediatopup```
 -> Import ```public/db_pediatopup.sql```

4. Configure database connection:
-> Copy ```env``` to ```.env```
-> Update database configuration in ```.env```:
```.env
database.default.hostname = localhost
database.default.database = db_pediatopup
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```
5. Set write permission for writable directory:
```bash
chmod -R 777 writable
```

## Usage
1. Start Apache and MySQL services from XAMPP control panel.
2. Open your web browser and go to ```http://localhost/PediaTopUp```
3. Set your admin account in database

## Contact
Email : bimaj0206@gmail.com

Whatsapp : +6282254044783

Instagram : @biimaa_jo
