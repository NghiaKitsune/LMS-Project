<?php
class MessageController extends Controller {

    // 1. Xem danh sách tin nhắn (Inbox)
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /LMS_Project/public/auth/login');
            exit;
        }

        require_once '../app/Config/Database.php';
        $db = new Database();
        $conn = $db->connect();

        // Lấy tin nhắn kèm tên người gửi
        $sql = "SELECT m.*, u.fullname as sender_name 
                FROM messages m 
                JOIN users u ON m.sender_id = u.id 
                WHERE m.receiver_id = ? 
                ORDER BY m.created_at DESC";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([$_SESSION['user_id']]);
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // [SỬA LẠI ĐƯỜNG DẪN Ở ĐÂY]: Thêm chữ 's' vào tên thư mục
        $this->view('messages/index', [
            'title' => 'My Inbox',
            'messages' => $messages
        ]);
    }

    // 2. Xem chi tiết & Đánh dấu đã đọc
    public function detail($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /LMS_Project/public/auth/login');
            exit;
        }

        require_once '../app/Config/Database.php';
        $db = new Database();
        $conn = $db->connect();

        // Lấy chi tiết tin nhắn
        $sql = "SELECT m.*, u.fullname as sender_name 
                FROM messages m 
                JOIN users u ON m.sender_id = u.id 
                WHERE m.id = ? AND m.receiver_id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id, $_SESSION['user_id']]);
        $message = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$message) {
            die("Message not found or access denied.");
        }

        // Cập nhật trạng thái đã đọc (is_read = 1)
        if ($message['is_read'] == 0) {
            $updateSql = "UPDATE messages SET is_read = 1 WHERE id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->execute([$id]);
        }

        // [SỬA LẠI ĐƯỜNG DẪN Ở ĐÂY LUÔN]
        $this->view('messages/detail', [
            'title' => $message['subject'],
            'message' => $message
        ]);
    }
    
    // 3. Xóa tin nhắn
    public function delete($id) {
        if (!isset($_SESSION['user_id'])) header('Location: /LMS_Project/public/auth/login');

        require_once '../app/Config/Database.php';
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("DELETE FROM messages WHERE id = ? AND receiver_id = ?");
        $stmt->execute([$id, $_SESSION['user_id']]);

        header('Location: /LMS_Project/public/message/index');
    }
}