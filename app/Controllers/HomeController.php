<?php
class HomeController extends Controller {
    
    public function index() {
        // 1. Gọi CourseModel
        $courseModel = $this->model('CourseModel');

        // 2. Lấy danh sách tất cả khóa học (đã publish)
        // Hàm getAllCourses() này chúng ta đã viết ở Sprint 2 rồi, giờ chỉ việc dùng lại.
        $courses = $courseModel->getAllCourses();

        // 3. Đổ dữ liệu ra View
        $this->view('home/index', [
            'title' => 'Home - LMS Learning Platform',
            'courses' => $courses // Truyền biến $courses sang view
        ]);
    }
}