<?php require_once '../app/Views/inc/header.php'; ?>

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 text-center">
            <div class="card-body p-5">
                
                <?php if($data['score'] >= 80): ?>
                    <div class="mb-3 text-success animate__animated animate__bounceIn">
                        <i class="fas fa-trophy fa-5x"></i>
                    </div>
                    <h2 class="text-success fw-bold mb-3">Excellent Job!</h2>
                    <p class="text-muted">You have mastered this topic.</p>
                
                <?php elseif($data['score'] >= 50): ?>
                    <div class="mb-3 text-primary animate__animated animate__fadeIn">
                        <i class="fas fa-thumbs-up fa-5x"></i>
                    </div>
                    <h2 class="text-primary fw-bold mb-3">Good Job!</h2>
                    <p class="text-muted">You passed the quiz successfully.</p>
                
                <?php else: ?>
                    <div class="mb-3 text-danger animate__animated animate__shakeX">
                        <i class="fas fa-times-circle fa-5x"></i>
                    </div>
                    <h2 class="text-danger fw-bold mb-3">Don't Give Up!</h2>
                    <p class="text-muted">Review the course material and try again.</p>
                <?php endif; ?>

                <div class="display-1 fw-bold my-4 text-dark">
                    <?= $data['score'] ?><span class="fs-4 text-muted">/100</span>
                </div>
                
                <div class="alert alert-light border d-inline-block px-4 py-2 rounded-pill mb-4">
                    <i class="fas fa-book me-2"></i> Quiz: <strong><?= htmlspecialchars($data['quiz']['title']) ?></strong>
                </div>

                <div class="d-grid gap-2 col-8 mx-auto">
                    <a href="/LMS_Project/public/course/detail/<?= $data['quiz']['course_id'] ?>" class="btn btn-outline-secondary fw-bold">
                        <i class="fas fa-arrow-left me-2"></i> Back to Course
                    </a>
                    <a href="/LMS_Project/public/profile/grades" class="btn btn-primary fw-bold shadow-sm">
                        <i class="fas fa-chart-line me-2"></i> View Gradebook
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>