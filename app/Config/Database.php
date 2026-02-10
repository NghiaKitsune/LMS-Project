<?php
class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = ''; // XAMPP mặc định pass rỗng, nếu bạn có set pass thì điền vào
    private $dbname = 'lms_db';

    public function connect() {
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8";
            $pdo = new PDO($dsn, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Lỗi kết nối Database: " . $e->getMessage());
        }
    }
}