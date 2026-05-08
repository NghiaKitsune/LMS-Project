<?php
$_navCounts = get_nav_counts();
$msgCount   = $_navCounts['msg'];
$notiCount  = $_navCounts['noti'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($data['title']) ? htmlspecialchars($data['title']) : 'LMS Platform' ?></title>
    
    <link rel="icon" type="image/avif" href="<?= BASE_URL ?>/assets/uploads/logo.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?= BASE_URL ?>/home/index">
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
                            <a class="nav-link text-white fw-bold" href="<?= BASE_URL ?>/course/my_learning">
                                <i class="fas fa-book-reader me-1"></i> My Learning
                            </a>
                        </li>

                    <?php elseif($_SESSION['user_role'] === 'instructor'): ?>
                        <li class="nav-item me-3 nav-role-item">
                            <a class="nav-link text-warning fw-bold" href="<?= BASE_URL ?>/course/my_courses">
                                <i class="fas fa-chalkboard-teacher me-1"></i> Instructor Panel
                            </a>
                        </li>

                    <?php elseif($_SESSION['user_role'] === 'admin'): ?>
                        <li class="nav-item me-3 nav-role-item">
                            <a class="nav-link text-danger fw-bold bg-white bg-opacity-10 rounded px-3" href="<?= BASE_URL ?>/admin/dashboard">
                                <i class="fas fa-user-shield me-1"></i> ADMIN PORTAL
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item nav-icon-item d-none d-lg-block">
                        <a class="nav-link text-white d-flex align-items-center justify-content-center" href="<?= BASE_URL ?>/message/index" title="Messages">
                            <i class="fas fa-envelope fa-lg"></i>
                            <?php if ($msgCount > 0): ?>
                                <span class="badge rounded-pill bg-danger notification-badge">
                                    <?= $msgCount > 99 ? '99+' : $msgCount ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item nav-icon-item me-3 d-none d-lg-block">
                        <a class="nav-link text-white d-flex align-items-center justify-content-center" href="<?= BASE_URL ?>/profile/notifications" title="Notifications">
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
                            <a class="nav-link nav-icon-link-mobile text-white flex-fill d-flex align-items-center justify-content-center py-3 rounded-2" href="<?= BASE_URL ?>/message/index" title="Messages">
                                <i class="fas fa-envelope fa-lg me-1"></i>
                                <?php if ($msgCount > 0): ?>
                                    <span class="badge rounded-pill bg-danger notification-badge"><?= $msgCount > 99 ? '99+' : $msgCount ?></span>
                                <?php endif; ?>
                            </a>
                            <a class="nav-link nav-icon-link-mobile text-white flex-fill d-flex align-items-center justify-content-center py-3 rounded-2" href="<?= BASE_URL ?>/profile/notifications" title="Notifications">
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
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>/profile/index"><i class="fas fa-id-card me-2 text-primary"></i> My Profile</a></li>
                            
                            <?php if($_SESSION['user_role'] === 'student'): ?>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/profile/grades"><i class="fas fa-chart-line me-2 text-success"></i> Gradebook</a></li>
                            
                            <?php elseif($_SESSION['user_role'] === 'instructor'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header text-uppercase text-muted small">Management</h6></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/course/my_courses"><i class="fas fa-chalkboard-teacher me-2 text-warning"></i> Manage Courses</a></li>
                            
                            <?php elseif($_SESSION['user_role'] === 'admin'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header text-uppercase text-muted small">System</h6></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/admin/dashboard"><i class="fas fa-tools me-2 text-danger"></i> System Dashboard</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/course/my_courses"><i class="fas fa-list me-2"></i> All Courses List</a></li>
                            <?php endif; ?>
                            
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger fw-bold" href="<?= BASE_URL ?>/auth/logout"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </li>

                <?php else: ?>
                    <li class="nav-item"><a class="nav-link text-white fw-semibold" href="<?= BASE_URL ?>/auth/login">Log In</a></li>
                    <li class="nav-item ms-2"><a class="btn btn-warning fw-bold shadow-sm" href="<?= BASE_URL ?>/auth/register">Sign Up Free</a></li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

<div class="container mb-5">
    
    <?php $__flash = flash_get(); if ($__flash): ?>
        <div class="alert alert-<?= $__flash['type'] === 'error' ? 'danger' : e($__flash['type']) ?> alert-dismissible fade show shadow-sm" role="alert">
            <?= e($__flash['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>