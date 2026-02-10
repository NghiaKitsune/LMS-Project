<?php
require_once '../app/Core/Controller.php';

class SupportController extends Controller {

    public function __construct() {
        // Phải đăng nhập mới được gửi hỗ trợ
        if (!isset($_SESSION['user_id'])) {
            header('Location: /LMS_Project/public/auth/login');
            exit;
        }
    }

    // 1. Hiển thị Form
    public function index() {
        $this->view('support/index');
    }

    // 2. Xử lý gửi Form
    public function send() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $subject = trim($_POST['subject']);
            $message = trim($_POST['message']);
            $user_id = $_SESSION['user_id'];

            $supportModel = $this->model('SupportModel');
            
            if ($supportModel->createTicket($user_id, $subject, $message)) {
                // Gửi xong thì báo thành công
                header('Location: /LMS_Project/public/support/index?status=sent');
            } else {
                echo "Error sending request.";
            }
        }
    }
    // [NEW] Trang lịch sử hỗ trợ
    public function history() {
        $user_id = $_SESSION['user_id'];
        $supportModel = $this->model('SupportModel');
        
        $tickets = $supportModel->getTicketsByUserId($user_id);

        $this->view('support/history', [
            'tickets' => $tickets
        ]);
    }
}