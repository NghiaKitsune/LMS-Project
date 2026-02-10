<?php
require_once '../app/Config/Database.php';

class MessageModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Gửi tin nhắn
    public function sendMessage($sender_id, $receiver_id, $subject, $message) {
        $sql = "INSERT INTO messages (sender_id, receiver_id, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$sender_id, $receiver_id, $subject, $message]);
    }

    // Lấy hộp thư đến (Inbox)
    public function getInbox($user_id) {
        $sql = "SELECT m.*, u.fullname as sender_name 
                FROM messages m 
                JOIN users u ON m.sender_id = u.id 
                WHERE m.receiver_id = ? 
                ORDER BY m.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Đếm tin nhắn chưa đọc
    public function countUnreadMessages($user_id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM messages WHERE receiver_id = ? AND is_read = 0");
        $stmt->execute([$user_id]);
        return $stmt->fetchColumn();
    }
}