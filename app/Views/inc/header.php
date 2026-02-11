<?php
// --- [BACKEND LOGIC] ĐẾM THÔNG BÁO & TIN NHẮN ---
$msgCount = 0;
$notiCount = 0;

if (isset($_SESSION['user_id'])) {
    require_once '../app/Config/Database.php';
    $dbNav = new Database();
    $connNav = $dbNav->connect();

    // 1. Đếm tin nhắn chưa đọc
    $stmtMsg = $connNav->prepare("SELECT COUNT(*) FROM messages WHERE receiver_id = ? AND is_read = 0");
    $stmtMsg->execute([$_SESSION['user_id']]);
    $msgCount = $stmtMsg->fetchColumn();

    // 2. Đếm thông báo chưa đọc
    $stmtNoti = $connNav->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
    $stmtNoti->execute([$_SESSION['user_id']]);
    $notiCount = $stmtNoti->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($data['title']) ? htmlspecialchars($data['title']) : 'LMS Platform' ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/LMS_Project/public/css/style.css">
    
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }
        .navbar-brand { font-weight: 800; letter-spacing: 1px; }
        footer { margin-top: auto; }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); }

        /* --- CSS TINH CHỈNH BADGE (SỐ ĐỎ) --- */
        .nav-link { position: relative; } 
        
        .notification-badge {
            font-size: 0.65rem;      
            padding: 0.25em 0.5em;   
            position: absolute;      
            top: 2px;                
            right: 0px;              
            transform: translate(30%, -20%);
            min-width: 1.2rem;       
            text-align: center;
            border: 2px solid #0d6efd; /* Viền trùng màu nền xanh */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/LMS_Project/public/home/index">
            <i class="fas fa-graduation-cap"></i> LMS PLATFORM
        </a>
        
        <button class="navbar-toggler hamburger-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="hamburger-inner">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                
                <?php if (isset($_SESSION['user_id'])): ?>

                    <?php if($_SESSION['user_role'] === 'student'): ?>
                        <li class="nav-item me-3 nav-role-item">
                            <a class="nav-link text-white fw-bold" href="/LMS_Project/public/course/my_learning">
                                <i class="fas fa-book-reader me-1"></i> My Learning
                            </a>
                        </li>

                    <?php elseif($_SESSION['user_role'] === 'instructor'): ?>
                        <li class="nav-item me-3 nav-role-item">
                            <a class="nav-link text-warning fw-bold" href="/LMS_Project/public/course/my_courses">
                                <i class="fas fa-chalkboard-teacher me-1"></i> Instructor Panel
                            </a>
                        </li>

                    <?php elseif($_SESSION['user_role'] === 'admin'): ?>
                        <li class="nav-item me-3 nav-role-item">
                            <a class="nav-link text-danger fw-bold bg-white bg-opacity-10 rounded px-3" href="/LMS_Project/public/admin/dashboard">
                                <i class="fas fa-user-shield me-1"></i> ADMIN PORTAL
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item nav-icon-item d-none d-lg-block">
                        <a class="nav-link text-white d-flex align-items-center justify-content-center" href="/LMS_Project/public/message/index" title="Messages">
                            <i class="fas fa-envelope fa-lg"></i>
                            <?php if ($msgCount > 0): ?>
                                <span class="badge rounded-pill bg-danger notification-badge">
                                    <?= $msgCount > 99 ? '99+' : $msgCount ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item nav-icon-item me-3 d-none d-lg-block">
                        <a class="nav-link text-white d-flex align-items-center justify-content-center" href="/LMS_Project/public/profile/notifications" title="Notifications">
                            <i class="fas fa-bell fa-lg"></i>
                            <?php if ($notiCount > 0): ?>
                                <span class="badge rounded-pill bg-danger notification-badge">
                                    <?= $notiCount > 99 ? '99+' : $notiCount ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item d-lg-none nav-icons-mobile">
                        <div class="d-flex align-items-center gap-2 py-2">
                            <a class="nav-link nav-icon-link-mobile text-white flex-fill d-flex align-items-center justify-content-center py-3 rounded-2" href="/LMS_Project/public/message/index" title="Messages">
                                <i class="fas fa-envelope fa-lg me-1"></i>
                                <?php if ($msgCount > 0): ?>
                                    <span class="badge rounded-pill bg-danger notification-badge"><?= $msgCount > 99 ? '99+' : $msgCount ?></span>
                                <?php endif; ?>
                            </a>
                            <a class="nav-link nav-icon-link-mobile text-white flex-fill d-flex align-items-center justify-content-center py-3 rounded-2" href="/LMS_Project/public/profile/notifications" title="Notifications">
                                <i class="fas fa-bell fa-lg me-1"></i>
                                <?php if ($notiCount > 0): ?>
                                    <span class="badge rounded-pill bg-danger notification-badge"><?= $notiCount > 99 ? '99+' : $notiCount ?></span>
                                <?php endif; ?>
                            </a>
                        </div>
                    </li>

                    <li class="nav-item dropdown nav-user-dropdown">
                        <a class="nav-link dropdown-toggle text-warning fw-bold bg-white bg-opacity-10 rounded px-3" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> <?= htmlspecialchars($_SESSION['user_name']) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow animate__animated animate__fadeIn">
                            <li><h6 class="dropdown-header text-uppercase text-muted small">Account</h6></li>
                            <li><a class="dropdown-item" href="/LMS_Project/public/profile/index"><i class="fas fa-id-card me-2 text-primary"></i> My Profile</a></li>
                            
                            <?php if($_SESSION['user_role'] === 'student'): ?>
                                <li><a class="dropdown-item" href="/LMS_Project/public/profile/grades"><i class="fas fa-chart-line me-2 text-success"></i> Gradebook</a></li>
                            
                            <?php elseif($_SESSION['user_role'] === 'instructor'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header text-uppercase text-muted small">Management</h6></li>
                                <li><a class="dropdown-item" href="/LMS_Project/public/course/my_courses"><i class="fas fa-chalkboard-teacher me-2 text-warning"></i> Manage Courses</a></li>
                            
                            <?php elseif($_SESSION['user_role'] === 'admin'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header text-uppercase text-muted small">System</h6></li>
                                <li><a class="dropdown-item" href="/LMS_Project/public/admin/dashboard"><i class="fas fa-tools me-2 text-danger"></i> System Dashboard</a></li>
                                <li><a class="dropdown-item" href="/LMS_Project/public/course/my_courses"><i class="fas fa-list me-2"></i> All Courses List</a></li>
                            <?php endif; ?>
                            
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger fw-bold" href="/LMS_Project/public/auth/logout"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </li>

                <?php else: ?>
                    <li class="nav-item"><a class="nav-link text-white fw-semibold" href="/LMS_Project/public/auth/login">Log In</a></li>
                    <li class="nav-item ms-2"><a class="btn btn-warning fw-bold shadow-sm" href="/LMS_Project/public/auth/register">Sign Up Free</a></li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

<div class="container mb-5">
    
    <?php if(isset($_GET['msg'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <strong>System Notification:</strong> 
            <?php 
                if($_GET['msg'] == 'created') echo "Created successfully!";
                elseif($_GET['msg'] == 'updated') echo "Updated successfully!";
                elseif($_GET['msg'] == 'deleted') echo "Deleted successfully!";
                elseif($_GET['msg'] == 'sent') echo "Message sent!";
                else echo htmlspecialchars($_GET['msg']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <strong>Error:</strong> <?= htmlspecialchars($_GET['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>