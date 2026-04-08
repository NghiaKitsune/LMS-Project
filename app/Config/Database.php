<?php
class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = ''; // XAMPP default is empty, set your password here if needed
    private $dbname = 'lms_db';

    public function connect() {
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8";
            $pdo = new PDO($dsn, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Database Connection Error: " . $e->getMessage());
        }
    }
}