<?php
require_once '../app/Config/Database.php';

class LessonModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // 1. Lấy danh sách bài học của 1 khóa (Sắp xếp theo thứ tự)
    public function getLessonsByCourse($course_id) {
        $sql = "SELECT * FROM lessons WHERE course_id = ? ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$course_id]);
        return $stmt->fetchAll();
    }

    // 2. Thêm bài học mới
    public function addLesson($course_id, $title, $video_url) {
        $sql = "INSERT INTO lessons (course_id, title, video_url) VALUES (?, ?, ?)";
        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$course_id, $title, $video_url]);
        } catch (PDOException $e) {
            return false;
        }
    }
}