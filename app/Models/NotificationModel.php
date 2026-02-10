<?php
require_once '../app/Config/Database.php';

class NotificationModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Tạo thông báo mới (Hệ thống tự gọi hàm này)
    public function createNotification($user_id, $message, $link = '#') {
        $sql = "INSERT INTO notifications (user_id, message, link) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$user_id, $message, $link]);
    }

    // Lấy thông báo của user
    public function getNotifications($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Đếm thông báo chưa đọc
    public function countUnread($user_id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
        $stmt->execute([$user_id]);
        return $stmt->fetchColumn();
    }
}