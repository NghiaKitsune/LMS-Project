<?php require_once '../app/Views/inc/header.php'; ?>
<?php
    $progressList = $data['progress'] ?? [];
    $gradesList  = $data['grades'] ?? [];
?>

<header class="d-flex flex-wrap justify-content-between align-items-center mb-4 mt-3 gap-2">
    <div>
        <h1 class="h3 text-primary fw-bold mb-1"><i class="fas fa-chart-line me-2"></i>Gradebook</h1>
        <p class="text-muted mb-0 small">Track your learning progress and achievements.</p>
    </div>
    <a href="/LMS_Project/public/profile/index" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Back to Profile
    </a>
</header>

<!-- Learning Progress -->
<section class="mb-5">
    <h2 class="h5 fw-bold text-dark mb-3 border-start border-4 border-success ps-3">
        <i class="fas fa-rocket me-2 text-success"></i>Learning Progress
    </h2>

    <?php if (empty($progressList)): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-graduation-cap fa-3x text-muted mb-3 opacity-25"></i>
                <p class="text-muted mb-3">You haven't enrolled in any courses yet.</p>
                <a href="/LMS_Project/public/home/index" class="btn btn-primary btn-sm">Browse Courses</a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($progressList as $p): ?>
                <?php
                    $pct = min(100, max(0, (int) ($p['progress'] ?? 0)));
                ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 card-hover grades-progress-card">
                        <div class="card-body">
                            <h6 class="fw-bold text-dark mb-3 text-truncate" title="<?= htmlspecialchars($p['title'] ?? '') ?>">
                                <?= htmlspecialchars($p['title'] ?? 'Course') ?>
                            </h6>
                            <div class="d-flex justify-content-between align-items-center small mb-2">
                                <span class="text-muted fw-semibold">Completion</span>
                                <span class="fw-bold text-primary"><?= $pct ?>%</span>
                            </div>
                            <div class="progress grades-progress-bar" role="progressbar" aria-valuenow="<?= $pct ?>" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: <?= $pct ?>%;"></div>
                            </div>
                            <a href="/LMS_Project/public/course/learn/<?= (int) ($p['id'] ?? 0) ?>" class="btn btn-outline-primary btn-sm w-100 mt-3">
                                <i class="fas fa-play me-1"></i>Continue
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- Detailed Grades -->
<section class="mb-5">
    <h2 class="h5 fw-bold text-dark mb-3 border-start border-4 border-primary ps-3">
        <i class="fas fa-clipboard-list me-2 text-primary"></i>Detailed Grades
    </h2>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <?php if (empty($gradesList)): ?>
                <div class="text-center py-5 px-3">
                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3 opacity-25"></i>
                    <p class="text-muted mb-0">No grades recorded yet. Complete quizzes or assignments to see results here.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 grades-table">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 text-nowrap">Date</th>
                                <th>Course</th>
                                <th>Activity</th>
                                <th class="text-nowrap">Type</th>
                                <th class="text-nowrap">Score</th>
                                <th class="text-end pe-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($gradesList as $g): ?>
                                <tr>
                                    <td class="ps-4 small text-muted">
                                        <i class="far fa-calendar-alt me-1"></i><?= date('d M Y', strtotime($g['date'] ?? 'now')) ?>
                                    </td>
                                    <td class="fw-semibold text-dark"><?= htmlspecialchars($g['course_name'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($g['item_name'] ?? '') ?></td>
                                    <td>
                                        <?php if (($g['type'] ?? '') === 'Quiz'): ?>
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info">Quiz</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">Assignment</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (isset($g['score']) && $g['score'] !== null): ?>
                                            <span class="fw-bold text-dark"><?= (int) $g['score'] ?></span><span class="text-muted small">/100</span>
                                        <?php else: ?>
                                            <span class="text-muted fst-italic">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <?php
                                        $score = $g['score'] ?? null;
                                        if ($score === null) echo '<span class="badge bg-secondary">Waiting</span>';
                                        elseif ($score >= 80) echo '<span class="badge bg-success">Distinction</span>';
                                        elseif ($score >= 50) echo '<span class="badge bg-primary">Pass</span>';
                                        else echo '<span class="badge bg-danger">Fail</span>';
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
.grades-progress-bar {
    height: 10px;
    border-radius: 50px;
    background-color: #e9ecef;
}
.grades-progress-bar .progress-bar {
    background: var(--lms-gradient);
    border-radius: 50px;
    transition: width 0.4s ease;
}
.grades-table thead th {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    color: #6c757d;
}
.grades-table tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.04);
}
</style>

<?php require_once '../app/Views/inc/footer.php'; ?>
