<?php
class App {
    protected $controller = 'HomeController'; // Mặc định vào trang chủ
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // 1. Kiểm tra file Controller có tồn tại không
        if (isset($url[0])) {
            if (file_exists('../app/Controllers/' . ucfirst($url[0]) . 'Controller.php')) {
                $this->controller = ucfirst($url[0]) . 'Controller';
                unset($url[0]);
            }
        }

        require_once '../app/Controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 2. Kiểm tra Method (Hàm) có tồn tại không
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // 3. Lấy tham số còn lại
        $this->params = $url ? array_values($url) : [];

        // 4. Kiểm tra trước khi gọi để tránh Fatal Error (gãy layout)
        if (is_callable([$this->controller, $this->method])) {
            call_user_func_array([$this->controller, $this->method], $this->params);
        } else {
            // Proper 404 handling
            http_response_code(404);
            die("404 Not Found - Controller or Method does not exist.");
        }
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}