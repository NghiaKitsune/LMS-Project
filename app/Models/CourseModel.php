<?php
require_once '../app/Config/Database.php';

class CourseModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // 1. Lấy danh sách tất cả danh mục (Để hiện vào Dropdown khi tạo khóa học)
    public function getCategories() {
        $stmt = $this->conn->prepare("SELECT * FROM categories");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 2. Tạo khóa học mới
    public function createCourse($title, $slug, $description, $price, $thumbnail, $instructor_id, $category_id) {
        $sql = "INSERT INTO courses (title, slug, description, price, thumbnail, instructor_id, category_id, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'published')";
        
        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                $title, $slug, $description, $price, $thumbnail, $instructor_id, $category_id
            ]);
        } catch (PDOException $e) {
            // Log lỗi ra file nếu cần (ở môi trường Production)
            return false;
        }
    }

    // 3. Lấy tất cả khóa học (Hiển thị trang chủ - Public)
    // Kỹ thuật: JOIN bảng users để lấy tên giảng viên, JOIN bảng categories để lấy tên danh mục
    public function getAllCourses() {
        $sql = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                FROM courses c 
                JOIN users u ON c.instructor_id = u.id 
                JOIN categories cat ON c.category_id = cat.id 
                WHERE c.status = 'published' 
                ORDER BY c.created_at DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // 4. Lấy khóa học của riêng Giảng viên đó (Trang My Courses)
    public function getCoursesByInstructor($instructor_id) {
        $sql = "SELECT * FROM courses WHERE instructor_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$instructor_id]);
        return $stmt->fetchAll();
    }

    // 5. Helper: Tạo Slug từ Title (VD: "Lập trình PHP" -> "lap-trinh-php")
    // Hàm này giúp URL thân thiện SEO
    public function createSlug($string) {
        $search = array(' ', 'đ', 'Đ');
        $replace = array('-', 'd', 'D');
        $string = str_replace($search, $replace, $string);
        // Xóa dấu tiếng Việt (Đơn giản hóa cho dự án sinh viên, dùng thư viện thì tốt hơn)
        // Ở đây dùng basic regex để giữ lại ký tự a-z, 0-9 và dấu gạch ngang
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', strtolower($string));
        return $string . '-' . time(); // Thêm time() để tránh trùng lặp tuyệt đối
    }
    // 6. Lấy chi tiết 1 khóa học theo ID (Kèm tên giảng viên và danh mục)
    public function getCourseById($id) {
        $sql = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                FROM courses c 
                JOIN users u ON c.instructor_id = u.id 
                JOIN categories cat ON c.category_id = cat.id 
                WHERE c.id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // 7. Kiểm tra sinh viên đã đăng ký khóa học chưa (Dùng cho nút Enroll)
    public function isEnrolled($student_id, $course_id) {
        $sql = "SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$student_id, $course_id]);
        return $stmt->rowCount() > 0;
    }
    // 8. Ghi danh sinh viên vào khóa học (Insert vào bảng enrollments)
    public function enrollStudent($student_id, $course_id) {
        $sql = "INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)";
        
        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$student_id, $course_id]);
        } catch (PDOException $e) {
            // Trường hợp lỗi trùng lặp (Duplicate entry) do user cố tình refresh trang
            return false;
        }
    }

    // 9. Lấy danh sách khóa học mà sinh viên đã mua (Để làm trang My Learning sau này)
    public function getEnrolledCourses($student_id) {
        $sql = "SELECT c.*, u.fullname as instructor_name, e.enrolled_date 
                FROM enrollments e
                JOIN courses c ON e.course_id = c.id
                JOIN users u ON c.instructor_id = u.id
                WHERE e.student_id = ?
                ORDER BY e.enrolled_date DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$student_id]);
        return $stmt->fetchAll();
    }
// ... (Giữ nguyên các hàm cũ bên trên) ...

    // [NEW] Cập nhật thông tin khóa học
    public function updateCourse($id, $title, $slug, $description, $price, $thumbnail, $category_id) {
        // Logic: Nếu người dùng KHÔNG up ảnh mới ($thumbnail = null), ta giữ nguyên ảnh cũ
        if ($thumbnail) {
            $sql = "UPDATE courses SET title=?, slug=?, description=?, price=?, thumbnail=?, category_id=? WHERE id=?";
            $params = [$title, $slug, $description, $price, $thumbnail, $category_id, $id];
        } else {
            // Không cập nhật cột thumbnail
            $sql = "UPDATE courses SET title=?, slug=?, description=?, price=?, category_id=? WHERE id=?";
            $params = [$title, $slug, $description, $price, $category_id, $id];
        }

        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }

    // [NEW] Xóa khóa học vĩnh viễn
    public function deleteCourse($id) {
        $sql = "DELETE FROM courses WHERE id = ?";
        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }
// [NEW] Lấy danh sách bài học của một khóa học
    public function getLessonsByCourse($course_id) {
        // Giả sử bảng tên là 'lessons'
        $sql = "SELECT * FROM lessons WHERE course_id = ? ORDER BY id ASC"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
