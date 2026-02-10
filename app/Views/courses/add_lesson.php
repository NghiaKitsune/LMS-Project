<?php require_once '../app/Views/inc/header.php'; ?>

<div class="row justify-content-center mt-4">
    <div class="col-md-5">
        <div class="card shadow border-0 mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-plus-circle me-2"></i>Add New Lesson</h5>
                <small class="text-muted">For course: <strong><?= htmlspecialchars($data['course']['title']) ?></strong></small>
            </div>
            <div class="card-body p-4">
                
                <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                    <div class="alert alert-success d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i> Lesson added successfully!
                    </div>
                <?php endif; ?>

                <form action="/LMS_Project/public/course/store_lesson/<?= $data['course']['id'] ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Lesson Title</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. Introduction to PHP">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Youtube URL</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fab fa-youtube text-danger"></i></span>
                            <input type="url" name="video_url" class="form-control" required placeholder="https://www.youtube.com/watch?v=...">
                        </div>
                        <div class="form-text">Paste the full Youtube link here.</div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success fw-bold">
                            <i class="fas fa-save me-1"></i> Save Lesson
                        </button>
                        <a href="/LMS_Project/public/course/my_courses" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Done / Back to Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-bold">
                <i class="fas fa-list-ol me-2"></i> Existing Lessons
            </div>
            <ul class="list-group list-group-flush">
                <?php if (empty($data['lessons'])): ?>
                    <li class="list-group-item text-center text-muted py-5">
                        <i class="fas fa-box-open fa-3x mb-3 text-secondary"></i><br>
                        No lessons added yet. Start adding one!
                    </li>
                <?php else: ?>
                    <?php foreach($data['lessons'] as $index => $lesson): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div>
                                <span class="badge bg-secondary me-2">Lesson <?= $index + 1 ?></span>
                                <span class="fw-semibold"><?= htmlspecialchars($lesson['title']) ?></span>
                            </div>
                            <a href="<?= htmlspecialchars($lesson['video_url']) ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                <i class="fas fa-external-link-alt me-1"></i> Check Link
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>