<?php require_once '../app/Views/inc/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4 mt-3">
    <div>
        <h2 class="text-primary fw-bold mb-0"><i class="fas fa-chalkboard-teacher me-2"></i>My Created Courses</h2>
        <p class="text-muted mb-0">Manage courses you are teaching.</p>
    </div>
    <a href="/LMS_Project/public/course/create" class="btn btn-success fw-bold shadow-sm">
        <i class="fas fa-plus-circle me-2"></i>Create New Course
    </a>
</div>

<?php if (isset($_GET['status'])): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?php 
            if ($_GET['status'] == 'created') echo "Course created successfully!";
            if ($_GET['status'] == 'updated') echo "Course updated successfully!";
            if ($_GET['status'] == 'deleted') echo "Course deleted successfully!";
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 mb-5">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 120px;">Thumbnail</th>
                        <th>Course Details</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data['courses'])): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="mb-3 opacity-50">
                                <h5 class="text-muted">You haven't created any courses yet.</h5>
                                <a href="/LMS_Project/public/course/create" class="btn btn-outline-primary mt-2">Create your first course</a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($data['courses'] as $course): ?>
                            <tr>
                                <td class="ps-4">
                                    <img src="/LMS_Project/public/assets/uploads/<?= $course['thumbnail'] ?>" 
                                         class="rounded shadow-sm" width="80" height="50" style="object-fit: cover;">
                                </td>
                                <td>
                                    <h6 class="mb-0 fw-bold text-dark">
                                        <a href="/LMS_Project/public/course/detail/<?= $course['id'] ?>" class="text-decoration-none text-dark">
                                            <?= htmlspecialchars($course['title']) ?>
                                        </a>
                                    </h6>
                                    <small class="text-muted">Category ID: <?= $course['category_id'] ?></small>
                                </td>
                                <td>
                                    <?= ($course['price'] == 0) ? '<span class="badge bg-success">Free</span>' : '$' . number_format($course['price'], 2) ?>
                                </td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary">Published</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <a href="/LMS_Project/public/course/add_lesson/<?= $course['id'] ?>" 
                                           class="btn btn-sm btn-outline-info" title="Manage Lessons">
                                            <i class="fas fa-video"></i>
                                        </a>

                                        <a href="/LMS_Project/public/course/edit/<?= $course['id'] ?>" 
                                           class="btn btn-sm btn-outline-warning" title="Edit Course">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="/LMS_Project/public/course/delete/<?= $course['id'] ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('WARNING: Are you sure you want to delete this course? All lessons inside will be lost!');"
                                           title="Delete Course">
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

<script>
    if (window.history.replaceState && window.location.href.indexOf('?') > -1) {
        let newUrl = window.location.href.split('?')[0];
        window.history.replaceState(null, null, newUrl);
    }
</script>

<?php require_once '../app/Views/inc/footer.php'; ?>