<?php
require_once '../app/Config/Database.php';

class QuizModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // --- PHẦN 1: DÀNH CHO GIẢNG VIÊN (TẠO ĐỀ) ---

    // 1. Tạo bài thi mới
    public function createQuiz($course_id, $title, $description) {
        $sql = "INSERT INTO quizzes (course_id, title, description) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$course_id, $title, $description]);
        return $this->conn->lastInsertId(); // Trả về ID bài thi vừa tạo
    }

    // 2. Thêm câu hỏi
    public function addQuestion($quiz_id, $text) {
        $sql = "INSERT INTO questions (quiz_id, question_text) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$quiz_id, $text]);
        return $this->conn->lastInsertId();
    }

    // 3. Thêm đáp án
    public function addOption($question_id, $text, $is_correct) {
        $sql = "INSERT INTO options (question_id, option_text, is_correct) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$question_id, $text, $is_correct]);
    }

    // --- PHẦN 2: DÀNH CHO HIỂN THỊ ---

    // 4. Lấy danh sách bài thi của khóa học
    public function getQuizzesByCourse($course_id) {
        $stmt = $this->conn->prepare("SELECT * FROM quizzes WHERE course_id = ? ORDER BY created_at DESC");
        $stmt->execute([$course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 5. Lấy thông tin 1 bài thi
    public function getQuizById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM quizzes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 6. [QUAN TRỌNG] Lấy toàn bộ Đề thi (Câu hỏi + Đáp án) để sinh viên làm
    public function getFullQuizData($quiz_id) {
        // Lấy danh sách câu hỏi
        $stmt = $this->conn->prepare("SELECT * FROM questions WHERE quiz_id = ?");
        $stmt->execute([$quiz_id]);
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Với mỗi câu hỏi, lấy danh sách đáp án
        foreach ($questions as &$q) {
            $stmtOpt = $this->conn->prepare("SELECT id, option_text, is_correct FROM options WHERE question_id = ?");
            $stmtOpt->execute([$q['id']]);
            $q['options'] = $stmtOpt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $questions; // Trả về mảng câu hỏi kèm đáp án bên trong
    }

    // --- PHẦN 3: XỬ LÝ KẾT QUẢ ---

    // 7. Lưu điểm số
    public function saveAttempt($quiz_id, $user_id, $score) {
        $sql = "INSERT INTO quiz_attempts (quiz_id, user_id, score) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$quiz_id, $user_id, $score]);
    }

    // 8. Lấy kết quả tốt nhất của sinh viên ở bài thi này
    public function getBestScore($quiz_id, $user_id) {
        $sql = "SELECT MAX(score) as best_score FROM quiz_attempts WHERE quiz_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$quiz_id, $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['best_score'];
    }
}