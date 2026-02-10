<?php
require_once '../app/Config/Database.php';

class AdminModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // 1. Lấy thống kê tổng quan (Dashboard Stats)
    public function getStats() {
        // Đếm tổng User
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total_users FROM users WHERE role != 'admin'");
        $stmt->execute();
        $users = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];

        // Đếm tổng Khóa học
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total_courses FROM courses");
        $stmt->execute();
        $courses = $stmt->fetch(PDO::FETCH_ASSOC)['total_courses'];

        // Đếm tổng Đăng ký (Enrollments)
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total_enrollments FROM enrollments");
        $stmt->execute();
        $enrollments = $stmt->fetch(PDO::FETCH_ASSOC)['total_enrollments'];

        return [
            'users' => $users,
            'courses' => $courses,
            'enrollments' => $enrollments
        ];
    }

    // 2. Lấy danh sách tất cả người dùng (để quản lý)
    public function getAllUsers() {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE role != 'admin' ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Xóa người dùng (Ban User)
    public function deleteUser($id) {
        // Xóa user thì phải xóa cả khóa học và enrollments liên quan (Logic DB phức tạp, ở đây làm đơn giản)
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
    // [NEW] Lấy dữ liệu cho biểu đồ: Số khóa học theo Danh mục
    public function getCourseDistribution() {
        $sql = "SELECT cat.name, COUNT(c.id) as count 
                FROM categories cat 
                LEFT JOIN courses c ON cat.id = c.category_id 
                GROUP BY cat.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // [NEW] Lấy danh sách User theo Vai trò (để chia bảng Student/Instructor)
    public function getUsersByRole($role) {
        $sql = "SELECT * FROM users WHERE role = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$role]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // [NEW] Lấy chi tiết 1 user để sửa
    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   // [UPDATED] Cập nhật thông tin User (Bao gồm cả đổi mật khẩu)
    public function updateUser($id, $fullname, $email, $role, $password = null) {
        
        // 1. Nếu Admin nhập mật khẩu mới -> Hash và cập nhật tất cả
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET fullname = ?, email = ?, role = ?, password = ? WHERE id = ?";
            $params = [$fullname, $email, $role, $hashedPassword, $id];
        } 
        // 2. Nếu bỏ trống mật khẩu -> Chỉ cập nhật thông tin, giữ nguyên pass cũ
        else {
            $sql = "UPDATE users SET fullname = ?, email = ?, role = ? WHERE id = ?";
            $params = [$fullname, $email, $role, $id];
        }

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }
}