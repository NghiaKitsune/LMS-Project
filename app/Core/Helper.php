<?php
// Hàm chống XSS (In ra màn hình an toàn)
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

// Hàm format tiền tệ
function format_currency($n) {
    return '$' . number_format($n, 2);
}

// Đếm tin nhắn và thông báo chưa đọc cho navbar
function get_nav_counts() {
    if (!isset($_SESSION['user_id'])) {
        return ['msg' => 0, 'noti' => 0];
    }
    require_once '../app/Config/Database.php';
    $db = new Database();
    $conn = $db->connect();

    $stmtMsg = $conn->prepare("SELECT COUNT(*) FROM messages WHERE receiver_id = ? AND is_read = 0");
    $stmtMsg->execute([$_SESSION['user_id']]);

    $stmtNoti = $conn->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
    $stmtNoti->execute([$_SESSION['user_id']]);

    return [
        'msg'  => (int) $stmtMsg->fetchColumn(),
        'noti' => (int) $stmtNoti->fetchColumn(),
    ];
}

// Session-based flash message helpers
function flash_set($message, $type = 'success') {
    $_SESSION['_flash'] = ['message' => $message, 'type' => $type];
}

function flash_get() {
    if (!isset($_SESSION['_flash'])) return null;
    $flash = $_SESSION['_flash'];
    unset($_SESSION['_flash']);
    return $flash;
}
?>