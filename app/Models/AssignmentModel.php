<?php
require_once '../app/Config/Database.php';

class AssignmentModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // 1. Tạo bài tập mới (Giảng viên)
    public function createAssignment($course_id, $title, $description, $deadline) {
        $sql = "INSERT INTO assignments (course_id, title, description, deadline) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$course_id, $title, $description, $deadline]);
    }

    // 2. Lấy danh sách bài tập của 1 khóa học
    public function getAssignmentsByCourse($course_id) {
        $sql = "SELECT * FROM assignments WHERE course_id = ? ORDER BY deadline ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Lấy chi tiết 1 bài tập
    public function getAssignmentById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM assignments WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 4. Sinh viên nộp bài
    public function submitWork($assignment_id, $student_id, $file_path) {
        $sql = "INSERT INTO submissions (assignment_id, student_id, file_path) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$assignment_id, $student_id, $file_path]);
    }

    // 5. Lấy bài nộp của sinh viên (Để check xem nộp chưa)
    public function getMySubmission($assignment_id, $student_id) {
        $sql = "SELECT * FROM submissions WHERE assignment_id = ? AND student_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$assignment_id, $student_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 6. Lấy tất cả bài nộp của 1 bài tập (Để GV chấm)
    public function getAllSubmissions($assignment_id) {
        $sql = "SELECT s.*, u.fullname, u.email 
                FROM submissions s 
                JOIN users u ON s.student_id = u.id 
                WHERE s.assignment_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$assignment_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 7. Chấm điểm (Giảng viên)
    public function gradeSubmission($submission_id, $grade, $feedback) {
        $sql = "UPDATE submissions SET grade = ?, feedback = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$grade, $feedback, $submission_id]);
    }
}