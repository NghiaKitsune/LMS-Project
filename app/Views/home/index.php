<?php require_once '../app/Views/inc/header.php'; ?>

<section class="hero-section py-5 py-lg-6 mb-5">
    <div class="container hero-container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8 text-center">
                <h1 class="fw-bolder display-5 text-primary mb-3">Welcome to LMS Platform</h1>
                <p class="lead mb-4 text-muted">Master PHP, IoT, C++ and more with our expert-led courses. Start learning at your own pace, anytime.</p>
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="/LMS_Project/public/auth/register" class="btn btn-primary btn-lg px-4 shadow-sm">
                            <i class="fas fa-rocket me-2"></i>Start Learning Today
                        </a>
                        <a href="/LMS_Project/public/auth/login" class="btn btn-outline-primary btn-lg px-4">Login</a>
                    <?php else: ?>
                        <?php if($_SESSION['user_role'] === 'student'): ?>
                            <a href="/LMS_Project/public/course/my_learning" class="btn btn-success btn-lg px-4 shadow-sm">
                                <i class="fas fa-book-reader me-2"></i>Go to My Learning
                            </a>
                        <?php elseif($_SESSION['user_role'] === 'instructor'): ?>
                            <a href="/LMS_Project/public/course/my_courses" class="btn btn-warning btn-lg px-4 shadow-sm text-dark fw-bold">
                                <i class="fas fa-chalkboard-teacher me-2"></i>Go to Instructor Panel
                            </a>
                        <?php elseif($_SESSION['user_role'] === 'admin'): ?>
                            <a href="/LMS_Project/public/admin/dashboard" class="btn btn-danger btn-lg px-4 shadow-sm">
                                <i class="fas fa-user-shield me-2"></i>Go to Admin Dashboard
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

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
                    <div class="card h-100 shadow-sm course-card border-0 card-hover overflow-hidden">
                        <?php 
                            $img = $course['thumbnail'] ? '/LMS_Project/public/assets/uploads/'.$course['thumbnail'] : 'https://via.placeholder.com/600x320?text=No+Image';
                        ?>
                        <div class="course-card-image position-relative">
                            <img src="<?= $img ?>" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>">
                            <div class="course-card-badges">
                                <span class="course-category-badge"><?= htmlspecialchars($course['category_name'] ?? 'General') ?></span>
                                <span class="course-price-badge"><?= ($course['price'] == 0) ? 'Free' : '$' . number_format($course['price']) ?></span>
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
                        <div class="card-footer bg-white border-top-0 pt-0 pb-3">
                            <a href="/LMS_Project/public/course/detail/<?= $course['id'] ?>" class="btn btn-outline-primary btn-sm w-100">
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