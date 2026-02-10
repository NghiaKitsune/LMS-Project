<?php
require_once '../app/Core/Controller.php';

class AssignmentController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /LMS_Project/public/auth/login');
            exit;
        }
    }

    // 1. Hiển thị Form tạo bài tập (Chỉ GV)
    public function create($course_id) {
        // Check quyền GV (hoặc Admin)
        if ($_SESSION['user_role'] == 'student') die("Access Denied");
        
        $this->view('assignments/create', ['course_id' => $course_id]);
    }

    // 2. Xử lý lưu bài tập mới
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $course_id = $_POST['course_id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $deadline = $_POST['deadline'];

            $this->model('AssignmentModel')->createAssignment($course_id, $title, $description, $deadline);
            header("Location: /LMS_Project/public/course/detail/$course_id");
        }
    }

    // 3. Xem chi tiết bài tập (Quan trọng: Xử lý Dual View cho GV và SV)
    public function detail($id) {
        $assignModel = $this->model('AssignmentModel');
        $assignment = $assignModel->getAssignmentById($id);

        if (!$assignment) die("Assignment not found");

        // Dữ liệu gửi sang View
        $data = [
            'assignment' => $assignment,
            'my_submission' => null,     // Cho Sinh viên
            'all_submissions' => []      // Cho Giảng viên
        ];

        // Nếu là Sinh viên -> Lấy bài đã nộp của mình
        if ($_SESSION['user_role'] == 'student') {
            $data['my_submission'] = $assignModel->getMySubmission($id, $_SESSION['user_id']);
        }
        // Nếu là GV/Admin -> Lấy danh sách tất cả bài nộp để chấm
        else {
            $data['all_submissions'] = $assignModel->getAllSubmissions($id);
        }

        $this->view('assignments/detail', $data);
    }

    // 4. Sinh viên nộp bài (Upload file)
    public function upload($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] == 0) {
                
                // Tạo folder nếu chưa có
                $targetDir = "../public/assets/assignments/";
                if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);

                // Đổi tên file để tránh trùng
                $fileName = time() . "_" . basename($_FILES["file_upload"]["name"]);
                $targetFilePath = $targetDir . $fileName;

                if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $targetFilePath)) {
                    $this->model('AssignmentModel')->submitWork($id, $_SESSION['user_id'], $fileName);
                    header("Location: /LMS_Project/public/assignment/detail/$id?status=success");
                } else {
                    echo "File upload failed.";
                }
            }
        }
    }

    // 5. Giảng viên chấm điểm
    public function grade() {
        if ($_SESSION['user_role'] == 'student') die("Access Denied");

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $submission_id = $_POST['submission_id'];
            $assignment_id = $_POST['assignment_id'];
            $grade = $_POST['grade'];
            $feedback = $_POST['feedback'];

           // [NEW] Gửi thông báo cho sinh viên
    // Cần lấy ID sinh viên từ submission_id trước nhé (bạn tự viết query lấy student_id nếu chưa có)
    // Giả sử $student_id đã lấy được từ submission
    
    $notiModel = $this->model('NotificationModel');
    $notiModel->createNotification(
        $student_id, 
        "Your assignment has been graded: " . $grade . "/100", 
        "/LMS_Project/public/assignment/detail/" . $assignment_id
    );
            header("Location: /LMS_Project/public/assignment/detail/$assignment_id?status=graded");
        }
    }
}