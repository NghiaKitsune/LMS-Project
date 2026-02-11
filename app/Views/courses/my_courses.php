<?php require_once '../app/Views/inc/header.php'; ?>
<?php
    $stats = $data['stats'] ?? ['total_courses' => 0, 'total_students' => 0, 'total_earnings' => 0];
    $courses = $data['courses'] ?? [];
?>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 mt-3 gap-2">
    <div>
        <h1 class="h3 text-primary fw-bold mb-1"><i class="fas fa-chalkboard-teacher me-2"></i>My Courses</h1>
        <p class="text-muted mb-0 small">Manage and track your courses.</p>
    </div>
    <a href="/LMS_Project/public/course/create" class="btn btn-primary shadow-sm">
        <i class="fas fa-plus me-2"></i>Create New Course
    </a>
</div>

<?php if (isset($_GET['status'])): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?php
            if ($_GET['status'] == 'created') echo 'Course created successfully!';
            if ($_GET['status'] == 'updated') echo 'Course updated successfully!';
            if ($_GET['status'] == 'deleted') echo 'Course deleted successfully!';
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 stats-card stats-card-courses">
            <div class="card-body d-flex align-items-center">
                <div class="stats-icon me-3">
                    <i class="fas fa-book-open fa-2x text-white"></i>
                </div>
                <div>
                    <p class="text-muted small text-uppercase fw-semibold mb-0">Total Courses</p>
                    <h4 class="fw-bold mb-0"><?= (int) $stats['total_courses'] ?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 stats-card stats-card-students">
            <div class="card-body d-flex align-items-center">
                <div class="stats-icon me-3">
                    <i class="fas fa-users fa-2x text-white"></i>
                </div>
                <div>
                    <p class="text-muted small text-uppercase fw-semibold mb-0">Total Students</p>
                    <h4 class="fw-bold mb-0"><?= (int) $stats['total_students'] ?></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 stats-card stats-card-earnings">
            <div class="card-body d-flex align-items-center">
                <div class="stats-icon me-3">
                    <i class="fas fa-coins fa-2x text-white"></i>
                </div>
                <div>
                    <p class="text-muted small text-uppercase fw-semibold mb-0">Total Earnings</p>
                    <h4 class="fw-bold mb-0">$<?= number_format((float) $stats['total_earnings'], 0) ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Courses Data Table -->
<div class="card border-0 shadow-sm mb-5 overflow-hidden">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2 text-primary"></i>Course List</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 instructor-courses-table">
                <thead class="table-light">
                    <tr>
                        <th class="text-nowrap ps-4" style="width: 60px;">ID</th>
                        <th class="text-nowrap" style="width: 100px;">Thumbnail</th>
                        <th>Title</th>
                        <th class="text-nowrap" style="width: 100px;">Price</th>
                        <th class="text-nowrap" style="width: 110px;">Status</th>
                        <th class="text-end pe-4" style="width: 160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($courses)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3 opacity-50 d-block"></i>
                                <h5 class="text-muted">No courses yet</h5>
                                <p class="text-muted small mb-2">Create your first course to get started.</p>
                                <a href="/LMS_Project/public/course/create" class="btn btn-outline-primary btn-sm">Create course</a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($courses as $course): ?>
                            <?php
                                $thumb = $course['thumbnail'] ?? '';
                                $imgSrc = $thumb ? '/LMS_Project/public/assets/uploads/' . $thumb : 'https://via.placeholder.com/80x50?text=No+Image';
                                $status = $course['status'] ?? 'published';
                            ?>
                            <tr>
                                <td class="ps-4 fw-semibold text-muted">#<?= (int) $course['id'] ?></td>
                                <td>
                                    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="" class="rounded" width="80" height="50" style="object-fit: cover;">
                                </td>
                                <td>
                                    <a href="/LMS_Project/public/course/detail/<?= (int) $course['id'] ?>" class="text-dark fw-semibold text-decoration-none">
                                        <?= htmlspecialchars($course['title']) ?>
                                    </a>
                                </td>
                                <td>
                                    <?= ($course['price'] == 0) ? '<span class="badge bg-success">Free</span>' : '<span class="fw-semibold">$' . number_format((float) $course['price'], 0) . '</span>' ?>
                                </td>
                                <td>
                                    <?php if ($status === 'published'): ?>
                                        <span class="badge bg-primary">Published</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?= htmlspecialchars($status) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="/LMS_Project/public/course/add_lesson/<?= (int) $course['id'] ?>" class="btn btn-sm btn-outline-info" title="Lessons">
                                            <i class="fas fa-video"></i>
                                        </a>
                                        <a href="/LMS_Project/public/course/edit/<?= (int) $course['id'] ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/LMS_Project/public/course/delete/<?= (int) $course['id'] ?>" class="btn btn-sm btn-outline-danger" title="Delete"
                                           onclick="return confirm('Delete this course? All lessons will be removed.');">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.stats-card { border-radius: 12px; transition: transform 0.2s ease, box-shadow 0.2s ease; }
.stats-card:hover { transform: translateY(-2px); box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important; }
.stats-icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.stats-card-courses .stats-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.stats-card-students .stats-icon { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
.stats-card-earnings .stats-icon { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
.instructor-courses-table thead th { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; color: #6c757d; }
.instructor-courses-table tbody tr:hover { background-color: rgba(102, 126, 234, 0.04); }
</style>

<script>
    if (window.history.replaceState && window.location.href.indexOf('?') > -1) {
        window.history.replaceState(null, null, window.location.href.split('?')[0]);
    }
</script>

<?php require_once '../app/Views/inc/footer.php'; ?>
