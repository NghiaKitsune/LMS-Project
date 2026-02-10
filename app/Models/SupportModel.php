<?php
require_once '../app/Config/Database.php';

class SupportModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // 1. Gửi yêu cầu hỗ trợ (User)
    public function createTicket($user_id, $subject, $message) {
        $sql = "INSERT INTO support_tickets (user_id, subject, message) VALUES (?, ?, ?)";
        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$user_id, $subject, $message]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // 2. Lấy tất cả yêu cầu (Dành cho Admin)
    public function getAllTickets() {
        // Join với bảng Users để biết ai gửi
        $sql = "SELECT st.*, u.fullname, u.email, u.role 
                FROM support_tickets st 
                JOIN users u ON st.user_id = u.id 
                ORDER BY st.status ASC, st.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Đổi trạng thái thành Đã xử lý (Admin)
    public function markAsResolved($id) {
        $sql = "UPDATE support_tickets SET status = 'resolved' WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
    // [NEW] Lấy danh sách phiếu của 1 user cụ thể
    public function getTicketsByUserId($user_id) {
        $sql = "SELECT * FROM support_tickets WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}