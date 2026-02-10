<?php
require_once '../app/Core/Controller.php';

class AdminController extends Controller {

    // [BẢO MẬT] Cổng gác của Tòa tháp
    public function __construct() {
        // Chỉ cho phép Admin truy cập
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /LMS_Project/public/home/index');
            exit;
        }
    }

    // 1. Dashboard Chính
    public function dashboard() {
        $adminModel = $this->model('AdminModel');
        $courseModel = $this->model('CourseModel');
        $supportModel = $this->model('SupportModel'); // [NEW] Gọi Support Model

        // Gọi View và truyền tất cả dữ liệu cần thiết
        $this->view('admin/dashboard', [
            'stats' => $adminModel->getStats(), // Số liệu thống kê
            'chart_data' => $adminModel->getCourseDistribution(), // Dữ liệu biểu đồ
            'students' => $adminModel->getUsersByRole('student'), // Danh sách học sinh
            'instructors' => $adminModel->getUsersByRole('instructor'), // Danh sách giảng viên
            'courses' => $courseModel->getAllCourses(), // Danh sách tất cả khóa học
            
            // [QUAN TRỌNG] Dòng này bị thiếu trong code cũ của bạn:
            'tickets' => $supportModel->getAllTickets() 
        ]);
    }

    // 2. Hiển thị form sửa User
    public function edit_user($id) {
        $user = $this->model('AdminModel')->getUserById($id);
        if (!$user) die("User not found");

        $this->view('admin/edit_user', [
            'user' => $user
        ]);
    }

    // 3. Xử lý update User (Admin quyền lực tối cao)
    public function update_user($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            
            // Lấy mật khẩu mới (nếu có)
            $password = !empty($_POST['password']) ? $_POST['password'] : null;

            // Gọi Model cập nhật
            if ($this->model('AdminModel')->updateUser($id, $fullname, $email, $role, $password)) {
                header('Location: /LMS_Project/public/admin/dashboard?msg=user_updated');
            } else {
                echo "Error updating user.";
            }
        }
    }

    // 4. Xóa User (Ban thành viên)
    public function delete_user($id) {
        if ($this->model('AdminModel')->deleteUser($id)) {
            header('Location: /LMS_Project/public/admin/dashboard?msg=user_deleted');
        } else {
            echo "Error deleting user.";
        }
    }

    // 5. Xóa Khóa học (Kiểm duyệt nội dung)
    public function delete_course($id) {
        if ($this->model('CourseModel')->deleteCourse($id)) {
            header('Location: /LMS_Project/public/admin/dashboard?msg=course_deleted');
        }
    }
  
    // [NEW] Hàm xử lý Ticket
    public function resolve_ticket($id) {
        $this->model('SupportModel')->markAsResolved($id);
        header('Location: /LMS_Project/public/admin/dashboard?msg=ticket_resolved');
    }
}