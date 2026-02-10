<?php require_once '../app/Views/inc/header.php'; ?>

<nav aria-label="breadcrumb" class="mt-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/LMS_Project/public/home/index" class="text-decoration-none">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">My Profile</li>
    </ol>
</nav>

<div class="row justify-content-center mt-4 mb-5">
    <div class="col-md-6">
        <div class="card shadow border-0 rounded-3">
            <div class="card-header bg-primary bg-gradient text-white p-4" style="border-bottom: 0;">
                <h4 class="mb-0 fw-bold"><i class="fas fa-id-card me-2"></i>User Profile</h4>
            </div>
            
            <div class="card-body p-5 text-center bg-white position-relative">
    
    <div class="mb-4 position-relative d-inline-block">
        <?php 
            $avatar = !empty($data['user']['avatar']) 
                ? '/LMS_Project/public/assets/uploads/' . $data['user']['avatar'] 
                : 'https://ui-avatars.com/api/?name=' . urlencode($data['user']['fullname']) . '&background=random&size=150';
        ?>
        <img src="<?= $avatar ?>" 
             class="rounded-circle shadow border border-4 border-white" 
             style="width: 140px; height: 140px; object-fit: cover; margin-top: -80px; background: #fff;">
    </div>

    <h2 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($data['user']['fullname']) ?></h2>
    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 mb-4 text-uppercase border border-primary fw-bold">
        <?= htmlspecialchars($data['user']['role']) ?>
    </span>

    <div class="list-group list-group-flush text-start mt-2 border rounded">
        <div class="list-group-item py-3 d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted fw-bold text-uppercase d-block mb-1">Email Address</small>
                <span class="fs-6 text-dark fw-semibold"><?= htmlspecialchars($data['user']['email']) ?></span>
            </div>
            <i class="fas fa-envelope text-muted opacity-25 fa-2x"></i>
        </div>
        <div class="list-group-item py-3 d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted fw-bold text-uppercase d-block mb-1">User ID</small>
                <span class="fs-6 text-dark font-monospace">#<?= $data['user']['id'] ?></span>
            </div>
            <i class="fas fa-fingerprint text-muted opacity-25 fa-2x"></i>
        </div>
        <div class="list-group-item py-3 d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted fw-bold text-uppercase d-block mb-1">Join Date</small>
                <span class="fs-6 text-dark">
                    <?= isset($data['user']['created_at']) ? date('d M, Y', strtotime($data['user']['created_at'])) : 'N/A' ?>
                </span>
            </div>
            <i class="fas fa-calendar-alt text-muted opacity-25 fa-2x"></i>
        </div>
    </div>

    <div class="mt-4">
        <div class="row g-2">
            
            <?php if($_SESSION['user_role'] === 'student'): ?>
                <div class="col-12">
                    <a href="/LMS_Project/public/profile/grades" class="btn btn-success fw-bold py-2 shadow-sm w-100">
                        <i class="fas fa-chart-line me-2"></i> View Gradebook & Progress
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="/LMS_Project/public/support/index" class="btn btn-warning fw-bold py-2 shadow-sm w-100 text-dark">
                        <i class="fas fa-life-ring me-2"></i> Need Help?
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="/LMS_Project/public/support/history" class="btn btn-outline-secondary fw-bold py-2 shadow-sm w-100">
                        <i class="fas fa-history me-2"></i> Ticket History
                    </a>
                </div>
            <?php endif; ?>

            <?php if($_SESSION['user_role'] === 'instructor'): ?>
                <div class="col-12">
                    <a href="/LMS_Project/public/course/my_courses" class="btn btn-primary fw-bold py-2 shadow-sm w-100">
                        <i class="fas fa-chalkboard-teacher me-2"></i> Go to Instructor Dashboard
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="/LMS_Project/public/support/index" class="btn btn-outline-warning fw-bold py-2 shadow-sm w-100 text-dark">
                        <i class="fas fa-bug me-2"></i> Report Issue
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="/LMS_Project/public/support/history" class="btn btn-outline-secondary fw-bold py-2 shadow-sm w-100">
                        <i class="fas fa-history me-2"></i> My Reports
                    </a>
                </div>
            <?php endif; ?>

            <?php if($_SESSION['user_role'] === 'admin'): ?>
                <div class="col-12">
                    <a href="/LMS_Project/public/admin/dashboard" class="btn btn-danger fw-bold py-3 shadow-sm w-100">
                        <i class="fas fa-cogs me-2"></i> Access System Administration
                    </a>
                </div>
                <div class="col-12">
                    <a href="#" class="btn btn-outline-dark fw-bold py-2 shadow-sm w-100 mt-2" onclick="alert('Module quản lý Support Ticket dành cho Admin đang phát triển!')">
                        <i class="fas fa-headset me-2"></i> Manage Support Tickets (Coming Soon)
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <?php if($_SESSION['user_role'] !== 'admin'): ?>
        <div class="alert alert-light border mt-4 mb-0 small text-muted">
            <i class="fas fa-info-circle me-1"></i> To update profile details, please contact Admin.
        </div>
    <?php endif; ?>

</div>
        </div>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>