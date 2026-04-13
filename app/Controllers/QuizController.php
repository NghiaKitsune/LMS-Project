<?php
require_once '../app/Core/Controller.php';

class QuizController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }
    }

    // 1. Hiển thị form tạo Quiz (GV)
    public function create($course_id) {
        if ($_SESSION['user_role'] == 'student') die("<script>alert('Access Denied'); window.location.href='" . BASE_URL . "/home/index';</script>");
        $this->view('quiz/create', ['course_id' => $course_id]);
    }

    // 2. Xử lý lưu Quiz (Logic khó nhất: Lưu lồng nhau Quiz -> Question -> Options)
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $quizModel = $this->model('QuizModel');
            
            // a. Tạo bài thi
            $course_id = $_POST['course_id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $quiz_id = $quizModel->createQuiz($course_id, $title, $description);

            // b. Duyệt qua mảng câu hỏi từ Form gửi lên
            // Cấu trúc mong đợi từ Form: $_POST['questions'][0]['text'], $_POST['questions'][0]['options']...
            if (isset($_POST['questions']) && is_array($_POST['questions'])) {
                foreach ($_POST['questions'] as $qData) {
                    // Tạo câu hỏi
                    $question_id = $quizModel->addQuestion($quiz_id, $qData['text']);

                    // Tạo 4 đáp án cho câu hỏi đó
                    foreach ($qData['options'] as $key => $optText) {
                        // Kiểm tra xem đáp án này có phải là đáp án đúng không (radio button)
                        // Trong form, correctAnswer sẽ chứa index của đáp án đúng (0, 1, 2, hoặc 3)
                        $is_correct = ($key == $qData['correctIdx']) ? 1 : 0;
                        $quizModel->addOption($question_id, $optText, $is_correct);
                    }
                }
            }

            header("Location: /LMS_Project/public/course/detail/$course_id?msg=quiz_created");
        }
    }

    // 3. Sinh viên làm bài
    public function take($id) {
        $quizModel = $this->model('QuizModel');
        $quiz = $quizModel->getQuizById($id);
        $questions = $quizModel->getFullQuizData($id);

        if (!$quiz) die("<script>alert('Quiz not found'); history.back();</script>");

        $this->view('quiz/take', [
            'quiz' => $quiz,
            'questions' => $questions
        ]);
    }

    // 5. Xử lý nộp bài thi (Chấm điểm tự động)
    public function submit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $quizModel = $this->model('QuizModel');
            
            // Lấy đáp án đúng từ Database để so sánh
            $questions = $quizModel->getFullQuizData($id);
            
            $totalQuestions = count($questions);
            $correctCount = 0;
            $userAnswers = $_POST['answers'] ?? []; // Mảng đáp án user chọn: [question_id => option_id]

            // Thuật toán chấm điểm tự động
            foreach ($questions as $q) {
                // Tìm đáp án đúng trong Database
                $correctOptionId = null;
                foreach ($q['options'] as $opt) {
                    if ($opt['is_correct'] == 1) {
                        $correctOptionId = $opt['id'];
                        break;
                    }
                }

                // So sánh với đáp án User chọn
                if (isset($userAnswers[$q['id']]) && $userAnswers[$q['id']] == $correctOptionId) {
                    $correctCount++;
                }
            }

            // Tính điểm (Thang 100)
            $score = ($totalQuestions > 0) ? round(($correctCount / $totalQuestions) * 100) : 0;

            // Lưu vào Database
            $quizModel->saveAttempt($id, $_SESSION['user_id'], $score);

            // Chuyển hướng đến trang kết quả
            header("Location: /LMS_Project/public/quiz/result/$id?score=$score");
        }
    }

    // 6. Trang hiển thị kết quả vừa thi
    public function result($id) {
        $score = $_GET['score'] ?? 0;
        $quiz = $this->model('QuizModel')->getQuizById($id);
        
        $this->view('quiz/result', [
            'quiz' => $quiz,
            'score' => $score
        ]);
    }
}