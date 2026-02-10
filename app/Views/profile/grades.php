<?php require_once '../app/Views/inc/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4 mt-3">
    <div>
        <h2 class="text-primary fw-bold mb-0"><i class="fas fa-star me-2"></i>My Gradebook</h2>
        <p class="text-muted mb-0">Track your learning progress and achievements.</p>
    </div>
    <a href="/LMS_Project/public/profile/index" class="btn btn-outline-secondary shadow-sm">
        <i class="fas fa-arrow-left me-2"></i> Back to Profile
    </a>
</div>

<h5 class="mb-3 text-dark fw-bold border-start border-5 border-success ps-3">🚀 Learning Progress</h5>

<div class="row mb-5">
    <?php if(empty($data['progress'])): ?>
        <div class="col-12">
            <div class="alert alert-light border text-center py-4">
                <i class="fas fa-graduation-cap fa-2x text-muted mb-2"></i>
                <p class="text-muted mb-0">You haven't enrolled in any courses yet.</p>
                <a href="/LMS_Project/public/home/index" class="btn btn-sm btn-primary mt-2">Browse Courses</a>
            </div>
        </div>
    <?php else: ?>
        <?php foreach($data['progress'] as $p): ?>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100 hover-effect">
                <div class="card-body">
                    <h6 class="fw-bold text-dark text-truncate" title="<?= htmlspecialchars($p['title']) ?>">
                        <?= htmlspecialchars($p['title']) ?>
                    </h6>
                    
                    <div class="d-flex justify-content-between small text-muted mt-3 mb-1">
                        <span>Completion</span>
                        <span class="fw-bold"><?= $p['progress'] ?>%</span>
                    </div>
                    <div class="progress" style="height: 10px; border-radius: 5px;">
                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                             role="progressbar" 
                             style="width: <?= $p['progress'] ?>%;">
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <a href="/LMS_Project/public/course/detail/<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary w-100 fw-bold">
                            <i class="fas fa-play me-1"></i> Continue
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<h5 class="mb-3 text-dark fw-bold border-start border-5 border-primary ps-3">📝 Detailed Grades</h5>

<div class="card shadow-sm border-0 mb-5">
    <div class="card-body p-0">
        <?php if(empty($data['grades'])): ?>
            <div class="text-center py-5 text-muted">
                <i class="fas fa-clipboard-list fa-3x mb-3 opacity-25"></i>
                <p>No grades recorded yet. Go complete some quizzes or assignments!</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Date</th>
                            <th>Course Name</th>
                            <th>Activity</th>
                            <th>Type</th>
                            <th>Score</th>
                            <th class="text-end pe-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['grades'] as $g): ?>
                        <tr>
                            <td class="ps-4 text-muted small">
                                <i class="far fa-calendar-alt me-1"></i> <?= date('d M Y', strtotime($g['date'])) ?>
                            </td>
                            <td class="fw-bold text-dark"><?= htmlspecialchars($g['course_name']) ?></td>
                            <td><?= htmlspecialchars($g['item_name']) ?></td>
                            <td>
                                <?php if($g['type'] == 'Quiz'): ?>
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info">Quiz</span>
                                <?php else: ?>
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">Assignment</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($g['score'] !== null): ?>
                                    <span class="fw-bold fs-5 text-dark"><?= $g['score'] ?></span><span class="text-muted small">/100</span>
                                <?php else: ?>
                                    <span class="text-muted fst-italic">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-4">
                                <?php 
                                    // Logic hiển thị trạng thái
                                    if ($g['score'] === null) {
                                        echo '<span class="badge bg-secondary">Waiting</span>';
                                    } elseif ($g['score'] >= 80) {
                                        echo '<span class="badge bg-success">Distinction</span>';
                                    } elseif ($g['score'] >= 50) {
                                        echo '<span class="badge bg-primary">Pass</span>';
                                    } else {
                                        echo '<span class="badge bg-danger">Fail</span>';
                                    }
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

<?php require_once '../app/Views/inc/footer.php'; ?>