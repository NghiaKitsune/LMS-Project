<?php
class AuthController extends Controller {
    
    // Display Registration Form
    public function register() {
        // Check if already logged in -> redirect to dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/home/index');
            exit;
        }

        $this->view('auth/register', [
            'title' => 'Student Registration'
        ]);
    }

    // Handle Registration Logic (POST request)
    public function store() {
        // 1. Get data from form (sanitize input)
        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // 2. Validate Empty Fields
        if (empty($fullname) || empty($email) || empty($password)) {
            $this->view('auth/register', [
                'title' => 'Student Registration',
                'error' => 'Please fill in all fields!'
            ]);
            return;
        }

        // 3. Call Model
        $userModel = $this->model('UserModel');

        // 4. Check if email exists
        if ($userModel->emailExists($email)) {
            $this->view('auth/register', [
                'title' => 'Student Registration',
                'error' => 'Email is already taken. Please try another one.'
            ]);
            return;
        }

        // 5. Hash Password (SECURITY CRITICAL)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // 6. Create User
        if ($userModel->register($fullname, $email, $hashedPassword)) {
            // Success -> Redirect to Login
            header('Location: ' . BASE_URL . '/auth/login?status=success');
        } else {
            // Failed
            $this->view('auth/register', [
                'title' => 'Student Registration',
                'error' => 'System error. Please try again later.'
            ]);
        }
    }
    // --- PHẦN LOGIN ---

    // 1. Hiển thị Form Đăng nhập
    public function login() {
        // Nếu đang đăng nhập rồi thì đá về trang chủ, không cho vào trang login nữa
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/home/index');
            exit;
        }

        $this->view('auth/login', [
            'title' => 'Login System'
        ]);
    }

    // 2. Xử lý Đăng nhập (POST request)
    public function authenticate() {
        // Lấy dữ liệu từ form
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validate cơ bản
        if (empty($email) || empty($password)) {
            $this->view('auth/login', [
                'title' => 'Login System',
                'error' => 'Please enter both email and password.'
            ]);
            return;
        }

        // Gọi Model để lấy thông tin user theo email
        $userModel = $this->model('UserModel');
        $user = $userModel->login($email);

        // Kịch bản kiểm tra:
        // 1. User phải tồn tại
        // 2. Mật khẩu phải khớp (dùng password_verify để so sánh với hash trong DB)
        if ($user && password_verify($password, $user['password'])) {
            
            // ĐĂNG NHẬP THÀNH CÔNG -> LƯU SESSION
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_avatar'] = $user['avatar'];

            // Chuyển hướng về trang chủ (Dashboard)
            header('Location: ' . BASE_URL . '/home/index');
            exit;

        } else {
            // Đăng nhập thất bại
            $this->view('auth/login', [
                'title' => 'Login System',
                'error' => 'Invalid email or password.' // Thông báo chung chung để bảo mật (tránh lộ là sai email hay sai pass)
            ]);
        }
    }

    // 3. Xử lý Đăng xuất
    public function logout() {
        // Xóa toàn bộ Session
        session_unset();
        session_destroy();

        // Quay về trang Login
        header('Location: ' . BASE_URL . '/auth/login');
        exit;
    }
    
}