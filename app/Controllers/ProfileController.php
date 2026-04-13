<?php
require_once '../app/Core/Controller.php';

class ProfileController extends Controller {

    public function __construct() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
    }

    // Hàm mặc định khi gọi /profile/index
    public function index() {
        // --- [BẪY KIỂM TRA] ---
        // Bỏ comment dòng dưới để test xem hệ thống có chạy vào đây không
        // die("TEST: Đã vào được ProfileController!"); 
        // ----------------------

        $userModel = $this->model('UserModel');
        $user = $userModel->getUserById($_SESSION['user_id']);

        if (!$user) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        // Gọi View
        $this->view('profile/index', [
            'user' => $user
        ]);
    }
    // [NEW] Sổ điểm điện tử & Tiến độ
    public function grades() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        $gradeModel = $this->model('GradeModel');
        $student_id = $_SESSION['user_id'];

        // Lấy dữ liệu
        $quizGrades = $gradeModel->getQuizGrades($student_id);
        $assignGrades = $gradeModel->getAssignmentGrades($student_id);
        $progressData = $gradeModel->getCourseProgress($student_id);

        // Gộp chung Quiz và Assignment thành 1 danh sách để hiển thị
        $allGrades = array_merge($quizGrades, $assignGrades);
        
        // Sắp xếp theo ngày mới nhất
        usort($allGrades, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        $this->view('profile/grades', [
            'grades' => $allGrades,
            'progress' => $progressData
        ]);
    }
    public function notifications() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        // 1. Kết nối Database trực tiếp (hoặc qua Model nếu bạn siêng)
        require_once '../app/Config/Database.php';
        $db = new Database();
        $conn = $db->connect();

        // 2. Lấy danh sách thông báo
        $stmt = $conn->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$_SESSION['user_id']]);
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 3. Đánh dấu tất cả là ĐÃ ĐỌC (Để mất số đỏ trên Header)
        $updateStmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?");
        $updateStmt->execute([$_SESSION['user_id']]);

        // 4. Gọi View
        $this->view('profile/notifications', [
            'title' => 'My Notifications',
            'notifications' => $notifications
        ]);
    }
}