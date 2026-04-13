<?php
session_start();

// Define Base URL for dynamic routing
define('BASE_URL', '/LMS_Project/public');

// Nạp các file Core
require_once '../app/Config/Database.php';
require_once '../app/Core/Controller.php';
require_once '../app/Core/App.php';
require_once '../app/Core/Helper.php';
// Khởi chạy App
$app = new App();