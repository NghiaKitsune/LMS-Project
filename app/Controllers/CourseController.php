<?php
class CourseController extends Controller {

    // --- GROUP 1: INSTRUCTOR ---

    public function my_courses() {
        if (!isset($_SESSION['user_id'])) { header('Location: /LMS_Project/public/auth/login'); exit; }
        if ($_SESSION['user_role'] !== 'instructor' && $_SESSION['user_role'] !== 'admin') {
            header('Location: /LMS_Project/public/course/my_learning'); exit;
        }

        $courseModel = $this->model('CourseModel');
        $myCourses = $courseModel->getCoursesByInstructor($_SESSION['user_id']);

        $this->view('courses/my_courses', ['title' => 'Instructor Dashboard', 'courses' => $myCourses]);
    }

    public function create() {
        if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'instructor' && $_SESSION['user_role'] !== 'admin')) {
            header('Location: /LMS_Project/public/home/index'); exit;
        }
        $courseModel = $this->model('CourseModel');
        $this->view('courses/create', ['title' => 'Create New Course', 'categories' => $courseModel->getCategories()]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // 1. Kiểm tra quyền (Authentication Check)
            if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'instructor' && $_SESSION['user_role'] !== 'admin')) {
                die("Unauthorized Access");
            }
            
            // 2. Lấy và làm sạch dữ liệu
            $title = trim($_POST['title']);
            $price = $_POST['price'];

            // --- [FIX] VALIDATE DATA (Chặn giá âm) ---
            if ($price < 0) {
                die("Error: Price cannot be negative!");
            }
            // -----------------------------------------

            $slug = $this->model('CourseModel')->createSlug($title);
            $thumbnail = 'default.jpg';

            // 3. Xử lý Upload file (Secure File Upload)
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                $ext = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
                
                // Kiểm tra đuôi file có hợp lệ không
                if (in_array($ext, $allowed)) {
                    $fileName = time() . '_' . uniqid() . '.' . $ext;
                    move_uploaded_file($_FILES['thumbnail']['tmp_name'], '../public/assets/uploads/' . $fileName);
                    $thumbnail = $fileName;
                } else {
                    // Báo lỗi tiếng Anh nếu file sai định dạng
                    die("Error: Invalid file format! Only JPG, JPEG, PNG, WEBP allowed.");
                }
            }

            // 4. Lưu vào Database
            if ($this->model('CourseModel')->createCourse($title, $slug, $_POST['description'], $price, $thumbnail, $_SESSION['user_id'], $_POST['category_id'])) {
                header('Location: /LMS_Project/public/course/my_courses?status=created');
            } else {
                echo "Error creating course. Please try again.";
            }
        }
    }

    // --- QUẢN LÝ BÀI HỌC (LESSONS) - MỚI BỔ SUNG ---
    public function add_lesson($course_id) {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'instructor') die("Unauthorized");
        
        $course = $this->model('CourseModel')->getCourseById($course_id);
        // Load bài học cũ để hiển thị
        $lessons = $this->model('LessonModel')->getLessonsByCourse($course_id); 

        $this->view('courses/add_lesson', [
            'title' => 'Add Lesson', 
            'course' => $course,
            'lessons' => $lessons
        ]);
    }

    public function store_lesson($course_id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // 1. Kiểm tra quyền (Auth Check)
            if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'instructor') {
                die("Unauthorized Access");
            }

            // --- [FIX] ROBUST YOUTUBE URL HANDLING (Xử lý link Youtube thông minh) ---
            $url = $_POST['video_url'];
            
            // Regex này chấp nhận: youtube.com/watch?v=ID, youtu.be/ID, youtube.com/embed/ID...
            $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
            
            if (preg_match($pattern, $url, $matches)) {
                // Lấy ID video (nhóm thứ 1 trong regex)
                $video_id = $matches[1];
                $final_url = "https://www.youtube.com/embed/" . $video_id;
                
                // 2. Gọi Model để lưu
                $this->model('LessonModel')->addLesson($course_id, $_POST['title'], $final_url);
                
                // Chuyển hướng kèm thông báo thành công
                header('Location: /LMS_Project/public/course/add_lesson/' . $course_id . '?status=success');
            } else {
                // Báo lỗi tiếng Anh nếu link không hợp lệ
                die("Error: Invalid YouTube URL! Please use a valid link (e.g., https://youtu.be/...)");
            }
        }
    }

    // --- GROUP 2: STUDENT ---

    // 4. Hiển thị chi tiết khóa học (Ai cũng xem được)
    public function detail($id) {
        $courseModel = $this->model('CourseModel');
        $course = $courseModel->getCourseById($id);
// [NEW] Lấy danh sách bài tập
    $assignmentModel = $this->model('AssignmentModel');
    $assignments = $assignmentModel->getAssignmentsByCourse($id);
    $quizModel = $this->model('QuizModel');
        if (!$course) {
            header('Location: /LMS_Project/public/home/index');
            exit;
        }

        $isEnrolled = false;
        $isOwner = false;

        // Kiểm tra trạng thái người dùng hiện tại
        if (isset($_SESSION['user_id'])) {
            // Check 1: Đã mua chưa?
            $isEnrolled = $courseModel->isEnrolled($_SESSION['user_id'], $id);
            
            // Check 2: Có phải chủ khóa học không? (Fix logic cho Giảng viên)
            if ($_SESSION['user_id'] == $course['instructor_id']) {
                $isOwner = true;
            }
        }

        $this->view('courses/detail', [
            'title' => $course['title'],
            'course' => $course,
            'isEnrolled' => $isEnrolled,
            'isOwner' => $isOwner, // <-- Truyền thêm biến này sang View
        'course' => $course,
        'assignments' => $assignments,
        'quizzes' => $quizModel->getQuizzesByCourse($id)
            ]);
    }

    public function enroll($course_id) {
        if (!isset($_SESSION['user_id'])) { header('Location: /LMS_Project/public/auth/login'); exit; }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $courseModel = $this->model('CourseModel');
            if (!$courseModel->isEnrolled($_SESSION['user_id'], $course_id)) {
                $courseModel->enrollStudent($_SESSION['user_id'], $course_id);
            }
            header('Location: /LMS_Project/public/course/my_learning?status=success');
        }
    }

    public function my_learning() {
        if (!isset($_SESSION['user_id'])) { header('Location: /LMS_Project/public/auth/login'); exit; }
        $myCourses = $this->model('CourseModel')->getEnrolledCourses($_SESSION['user_id']);
        $this->view('courses/my_learning', ['title' => 'My Learning', 'courses' => $myCourses]);
    }

   public function learn($course_id) {
        // 1. Check đăng nhập
        if (!isset($_SESSION['user_id'])) { 
            header('Location: /LMS_Project/public/auth/login'); 
            exit; 
        }
        
        $courseModel = $this->model('CourseModel');
        
        // 2. Lấy thông tin khóa học
        $course = $courseModel->getCourseById($course_id);
        if (!$course) {
            die("Course not found");
        }

        // 3. Kiểm tra quyền (Đã mua hoặc là Chủ khóa học)
        $isEnrolled = $courseModel->isEnrolled($_SESSION['user_id'], $course_id);
        $isOwner = ($course['instructor_id'] == $_SESSION['user_id']);
        $isAdmin = ($_SESSION['user_role'] == 'admin');

        if (!$isEnrolled && !$isOwner && !$isAdmin) { 
            // Chưa mua -> Đá về trang chi tiết
            header('Location: /LMS_Project/public/course/detail/' . $course_id . '?error=enroll_required'); 
            exit; 
        }

        // 4. [LOGIC MỚI] Lấy danh sách bài học từ CourseModel
        // (Lưu ý: Chúng ta dùng luôn CourseModel thay vì LessonModel cho tiện)
        $lessons = $courseModel->getLessonsByCourse($course_id);
        
        // 5. Xác định bài học đang xem (Current Lesson)
        $current_lesson = null;
        
        if (!empty($lessons)) {
            // Mặc định lấy bài đầu tiên
            $current_lesson = $lessons[0]; 

            // Nếu trên URL có tham số ?lesson_id=... thì lấy bài đó
            if (isset($_GET['lesson_id'])) {
                foreach($lessons as $l) {
                    if ($l['id'] == $_GET['lesson_id']) { 
                        $current_lesson = $l; 
                        break; 
                    }
                }
            }
        }

        // 6. Gửi dữ liệu sang View
        $this->view('courses/learn', [
            'title' => 'Learning: ' . $course['title'],
            'course' => $course,
            'lessons' => $lessons,
            'current_lesson' => $current_lesson
        ]);
    }
    // --- GROUP: EDIT & DELETE (CHỨC NĂNG SỬA/XÓA) ---

    // 1. Hiển thị Form Sửa (GET)
    public function edit($id) {
        // a. Check đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header('Location: /LMS_Project/public/auth/login');
            exit;
        }

        $courseModel = $this->model('CourseModel');
        $course = $courseModel->getCourseById($id);

        if (!$course) {
            die("Error: Course not found!");
        }

        // b. [BẢO MẬT] Kiểm tra quyền sở hữu
        $isOwner = ($_SESSION['user_id'] == $course['instructor_id']);
        $isAdmin = ($_SESSION['user_role'] === 'admin');

        if (!$isOwner && !$isAdmin) {
            // Nếu không phải chủ -> Đá về dashboard kèm thông báo lỗi
            die("Unauthorized: You do not have permission to edit this course.");
        }

        // c. Nếu qua cửa -> Cho vào sửa
        $this->view('courses/edit', [
            'title' => 'Edit Course: ' . $course['title'],
            'course' => $course,
            'categories' => $courseModel->getCategories()
        ]);
    }

    // 2. Xử lý Cập nhật (POST)
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            if (!isset($_SESSION['user_id'])) die("Unauthorized Access");

            $courseModel = $this->model('CourseModel');
            $course = $courseModel->getCourseById($id);

            // a. [BẢO MẬT] Kiểm tra lại lần 2 (Backend Validation)
            $isOwner = ($_SESSION['user_id'] == $course['instructor_id']);
            $isAdmin = ($_SESSION['user_role'] === 'admin');

            if (!$isOwner && !$isAdmin) {
                die("Unauthorized: You cannot update this course.");
            }

            // b. Lấy dữ liệu từ Form
            $title = trim($_POST['title']);
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $description = $_POST['description'];
            $slug = $courseModel->createSlug($title); // Tạo lại slug mới theo tên mới

            // Validate giá tiền
            if ($price < 0) die("Error: Price cannot be negative!");

            // c. Xử lý Upload ảnh (Nếu có thay ảnh mới)
            $thumbnail = null; // Mặc định là null
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                $ext = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
                
                if (in_array($ext, $allowed)) {
                    $fileName = time() . '_' . uniqid() . '.' . $ext;
                    move_uploaded_file($_FILES['thumbnail']['tmp_name'], '../public/assets/uploads/' . $fileName);
                    $thumbnail = $fileName;
                }
            }

            // d. Gọi Model cập nhật
            if ($courseModel->updateCourse($id, $title, $slug, $description, $price, $thumbnail, $category_id)) {
                // Thành công -> Về trang danh sách
                header('Location: /LMS_Project/public/course/my_courses?status=updated');
            } else {
                echo "Error updating course.";
            }
        }
    }

    // 3. Xử lý Xóa (GET hoặc POST)
    public function delete($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /LMS_Project/public/auth/login');
            exit;
        }

        $courseModel = $this->model('CourseModel');
        $course = $courseModel->getCourseById($id);

        if (!$course) die("Course not found");

        // a. [BẢO MẬT] Kiểm tra quyền sở hữu
        $isOwner = ($_SESSION['user_id'] == $course['instructor_id']);
        $isAdmin = ($_SESSION['user_role'] === 'admin');

        if (!$isOwner && !$isAdmin) {
            die("Unauthorized: You cannot delete this course.");
        }

        // b. Xóa
        if ($courseModel->deleteCourse($id)) {
            header('Location: /LMS_Project/public/course/my_courses?status=deleted');
        } else {
            echo "Error deleting course.";
        }
    }
}