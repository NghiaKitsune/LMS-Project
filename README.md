# LMS Project

An e-learning platform built with PHP using the MVC architecture. It includes full functionalities for Administrators, Instructors, and Students.

## 📂 Project Structure

This project relies on the following essential files and directories:

- `/app/` - The main application logic (Controllers, Models, Views, Core, and Config).
- `/public/` - Publicly accessible assets (CSS, JS, Images, Uploads) and the `index.php` entry point.
- `/vendor/` - Third-party dependencies and libraries.
- `.htaccess` - Apache configuration for seamless URL rewriting (routing).
- `lms_db.sql` - **[REQUIRED]** The main database schema structure, complete with initial system data and optional dummy data for testing.
- `README.md` - Documentation and setup guide.

## 🚀 Setup Instructions

### 1. File Placement
Place the `LMS_Project` directory into your server's root folder (`c:\xampp\htdocs\` for XAMPP or `www\` for WAMP).

### 2. Database Initialization
1. Open your MySQL manager (e.g., [phpMyAdmin](http://localhost/phpmyadmin)).
2. Create a new database named `lms_db` with `utf8mb4_general_ci` collation.
3. Import the single `lms_db.sql` file. This securely builds the required tables structure and safely pre-loads the database with test data (Quizzes, Submissions, Tickets).

### 3. Database Configuration
Open `app/Config/Database.php` and ensure the credentials match your local setup:
```php
private $host = 'localhost';
private $user = 'root';       // Update if not using root
private $pass = '';           // XAMPP default is empty
private $dbname = 'lms_db';
```

### 4. Application Access
Start your Apache and MySQL modules. Open your web browser and navigate to:
`http://localhost/LMS_Project/public/`

## 👥 Testing Accounts
If you imported the dummy data, you can authenticate using these basic profiles. The default password for all test accounts is **`123456`**.

- **Admin Role**: `admin@gmail.com`
- **Instructor Role**: `sarah@lms.com` or `dev@test.com`
- **Student Role**: `new@gmail.com` or `alice@lms.com`
