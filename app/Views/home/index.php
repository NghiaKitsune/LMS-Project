<?php require_once '../app/Views/inc/header.php'; ?>

<header class="bg-white py-5 mb-5 border-bottom">
    <div class="container text-center my-5">
        <h1 class="fw-bolder display-5 text-primary">Welcome to LMS Platform</h1>
        <p class="lead mb-4 text-muted">Master PHP, IoT, C++ and more with our expert-led courses.</p>
        
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="/LMS_Project/public/auth/register" class="btn btn-primary btn-lg px-5 shadow-sm">Start Learning Today</a>
            <a href="/LMS_Project/public/auth/login" class="btn btn-outline-secondary btn-lg px-4 ms-2">Login</a>
            
        <?php else: ?>
            <?php if($_SESSION['user_role'] === 'student'): ?>
                <a href="/LMS_Project/public/course/my_learning" class="btn btn-success btn-lg px-5 shadow-sm">
                    <i class="fas fa-book-reader me-2"></i> Go to My Learning
                </a>
            
            <?php elseif($_SESSION['user_role'] === 'instructor'): ?>
                <a href="/LMS_Project/public/course/my_courses" class="btn btn-warning btn-lg px-5 shadow-sm text-dark fw-bold">
                    <i class="fas fa-chalkboard-teacher me-2"></i> Go to Instructor Panel
                </a>
            
            <?php elseif($_SESSION['user_role'] === 'admin'): ?>
                <a href="/LMS_Project/public/admin/dashboard" class="btn btn-danger btn-lg px-5 shadow-sm">
                    <i class="fas fa-user-shield me-2"></i> Go to Admin Dashboard
                </a>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</header>

<div class="container mb-5">
    <h2 class="mb-4 border-start border-5 border-primary ps-3 fw-bold">Featured Courses</h2>
    
    <div class="row">
        <?php if (empty($data['courses'])): ?>
            <div class="col-12 text-center py-5 bg-light rounded">
                <i class="fas fa-box-open fa-3x text-muted mb-3 opacity-50"></i>
                <p class="text-muted fs-5">No courses available at the moment. Please check back later.</p>
            </div>
        <?php else: ?>
            
            <?php foreach($data['courses'] as $course): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm course-card border-0">
                        <?php 
                            $img = $course['thumbnail'] ? '/LMS_Project/public/assets/uploads/'.$course['thumbnail'] : 'https://via.placeholder.com/300x200?text=No+Image';
                        ?>
                        
                        <div class="position-relative">
                            <img src="<?= $img ?>" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>">
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-primary shadow-sm">
                                    <?= htmlspecialchars($course['category_name'] ?? 'General') ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-truncate" title="<?= htmlspecialchars($course['title']) ?>">
                                <?= htmlspecialchars($course['title']) ?>
                            </h5>
                            <p class="card-text text-muted small mb-2">
                                <i class="fas fa-user-tie me-1"></i> <?= htmlspecialchars($course['instructor_name']) ?>
                            </p>
                            <p class="card-text text-secondary small">
                                <?= substr(strip_tags($course['description']), 0, 80) ?>...
                            </p>
                        </div>
                        
                        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center pb-3">
                            <span class="fw-bold text-success fs-5">
                                <?= ($course['price'] == 0) ? 'Free' : '$' . number_format($course['price']) ?>
                            </span>
                            <a href="/LMS_Project/public/course/detail/<?= $course['id'] ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>