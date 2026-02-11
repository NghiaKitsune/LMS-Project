<?php
require_once '../app/Config/Database.php';

class GradeModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // 1. Lấy tất cả điểm Trắc nghiệm của sinh viên
    public function getQuizGrades($student_id) {
        $sql = "SELECT q.title as item_name, c.title as course_name, qa.score, qa.completed_at as date, 'Quiz' as type 
                FROM quiz_attempts qa 
                JOIN quizzes q ON qa.quiz_id = q.id 
                JOIN courses c ON q.course_id = c.id 
                WHERE qa.user_id = ? 
                ORDER BY qa.completed_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Lấy tất cả điểm Bài tập của sinh viên
    public function getAssignmentGrades($student_id) {
        $sql = "SELECT a.title as item_name, c.title as course_name, s.grade as score, s.submitted_at as date, 'Assignment' as type 
                FROM submissions s 
                JOIN assignments a ON s.assignment_id = a.id 
                JOIN courses c ON a.course_id = c.id 
                WHERE s.student_id = ? 
                ORDER BY s.submitted_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$student_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Tính tiến độ học tập (Progress) của từng khóa học
    // Logic: (Số bài đã làm / Tổng số bài tập & quiz) * 100
    public function getCourseProgress($student_id) {
        // Lấy danh sách khóa học sinh viên đã đăng ký
        $sql = "SELECT c.id, c.title, c.thumbnail FROM enrollments e 
                JOIN courses c ON e.course_id = c.id 
                WHERE e.student_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$student_id]);
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Tính % cho từng khóa
        foreach ($courses as &$course) {
            $cId = $course['id'];

            // Đếm tổng số bài cần làm (Total Items)
            $stmt1 = $this->conn->prepare("SELECT 
                (SELECT COUNT(*) FROM assignments WHERE course_id = ?) + 
                (SELECT COUNT(*) FROM quizzes WHERE course_id = ?) as total");
            $stmt1->execute([$cId, $cId]);
            $totalItems = $stmt1->fetchColumn();

            // Đếm số bài đã làm (Completed Items)
            $stmt2 = $this->conn->prepare("SELECT 
                (SELECT COUNT(*) FROM submissions s JOIN assignments a ON s.assignment_id = a.id WHERE a.course_id = ? AND s.student_id = ?) + 
                (SELECT COUNT(*) FROM quiz_attempts qa JOIN quizzes q ON qa.quiz_id = q.id WHERE q.course_id = ? AND qa.user_id = ?) as completed");
            $stmt2->execute([$cId, $student_id, $cId, $student_id]);
            $completedItems = $stmt2->fetchColumn();

            // Tính phần trăm (giới hạn 0–100)
            if ($totalItems > 0) {
                $raw = round(($completedItems / $totalItems) * 100);
                $course['progress'] = min(100, max(0, (int) $raw));
            } else {
                $course['progress'] = 0;
            }
        }
        return $courses;
    }
}