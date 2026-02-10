<?php
// Gọi file Database config để dùng
require_once '../app/Config/Database.php';

class UserModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // 1. Đăng ký tài khoản mới
    public function register($fullname, $email, $password) {
        // Câu lệnh SQL dùng placeholder (?) để bảo mật
        $sql = "INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, 'student')";
        
        try {
            $stmt = $this->conn->prepare($sql);
            // Thực thi và truyền dữ liệu vào dấu ?
            if ($stmt->execute([$fullname, $email, $password])) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    // 2. Kiểm tra email đã tồn tại chưa (Tránh trùng lặp)
    public function emailExists($email) {
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        
        // Nếu đếm số dòng > 0 nghĩa là đã có email này
        return $stmt->rowCount() > 0;
    }

    // 3. Lấy thông tin user để đăng nhập
    public function login($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        
        // Trả về 1 dòng dữ liệu dạng mảng
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Lấy thông tin chi tiết user
    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}