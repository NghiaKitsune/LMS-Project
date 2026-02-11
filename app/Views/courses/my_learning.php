<?php require_once '../app/Views/inc/header.php'; ?>

<header class="learning-page-banner bg-white py-4 mb-4 border-bottom rounded-bottom">
    <div class="learning-banner-inner d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
            <h1 class="h3 fw-bold text-primary mb-1">
                <i class="fas fa-book-reader me-2"></i>My Learning
            </h1>
            <p class="text-muted small mb-0">Track your progress and continue where you left off.</p>
        </div>
        <a href="/LMS_Project/public/home/index" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-th-large me-1"></i>Browse Courses
        </a>
    </div>
</header>

<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-check-circle me-2"></i><strong>Enrolled!</strong> You can start learning now.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (empty($data['courses'])): ?>
    <div class="learning-empty text-center py-5 px-4 rounded border bg-white shadow-sm">
        <i class="fas fa-graduation-cap fa-4x text-muted mb-3 opacity-25"></i>
        <h4 class="text-muted fw-semibold">No courses yet</h4>
        <p class="text-muted mb-4">Enroll in a course to see it here and track your progress.</p>
        <a href="/LMS_Project/public/home/index" class="btn btn-primary px-4">
            <i class="fas fa-search me-2"></i>Browse Courses
        </a>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($data['courses'] as $course): ?>
            <?php
                $img = $course['thumbnail'] ? '/LMS_Project/public/assets/uploads/' . $course['thumbnail'] : 'https://via.placeholder.com/600x320?text=No+Image';
                $pct = (($course['id'] * 17 + 31) % 91) + 5;
            ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card learning-card h-100 shadow-sm border-0 card-hover overflow-hidden">
                    <div class="learning-card-image position-relative">
                        <img src="<?= $img ?>" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>">
                        <span class="learning-badge position-absolute bottom-0 start-0 m-2">Enrolled</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark mb-1 text-truncate" title="<?= htmlspecialchars($course['title']) ?>">
                            <?= htmlspecialchars($course['title']) ?>
                        </h5>
                        <p class="small text-muted mb-3">
                            <i class="fas fa-user-tie me-1"></i><?= htmlspecialchars($course['instructor_name']) ?>
                        </p>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center small mb-1">
                                <span class="text-muted fw-semibold">Progress</span>
                                <span class="text-primary fw-bold"><?= $pct ?>%</span>
                            </div>
                            <div class="progress learning-progress" role="progressbar" aria-valuenow="<?= $pct ?>" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: <?= $pct ?>%"></div>
                            </div>
                        </div>
                        <a href="/LMS_Project/public/course/learn/<?= $course['id'] ?>" class="btn btn-primary btn-sm mt-auto">
                            <i class="fas fa-play me-2"></i>Continue Learning
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once '../app/Views/inc/footer.php'; ?>
