<?php require_once '../app/Views/inc/header.php'; ?>

<header class="bg-white py-4 mb-4 border-bottom">
    <div class="text-center">
        <h1 class="fw-bolder display-6 text-primary mb-2">
            <i class="fas fa-graduation-cap me-2"></i>Welcome back
        </h1>
        <p class="lead text-muted mb-0">Log in to continue learning on LMS Platform.</p>
    </div>
</header>

<div class="row justify-content-center mb-5">
    <div class="col-md-5 col-lg-4">
        <div class="card border-0 shadow-sm border-start border-5 border-primary">
            <div class="card-body p-4">
                <h2 class="h5 fw-bold text-primary mb-4">
                    <i class="fas fa-sign-in-alt me-2"></i>Log in to LMS
                </h2>

                <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                    <div class="alert alert-success alert-dismissible fade show py-2 small" role="alert">
                        <i class="fas fa-check-circle me-2"></i>Registration successful! Please log in.
                        <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($data['error'])): ?>
                    <div class="alert alert-danger py-2 small" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($data['error']) ?>
                    </div>
                <?php endif; ?>

                <form action="/LMS_Project/public/auth/authenticate" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label small text-muted fw-semibold text-uppercase">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" name="email" id="email" class="form-control border-start-0" placeholder="you@example.com" required autofocus>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label small text-muted fw-semibold text-uppercase">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" name="password" id="password" class="form-control border-start-0" placeholder="••••••••" required>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary fw-bold shadow-sm">
                            <i class="fas fa-sign-in-alt me-2"></i>Log in
                        </button>
                        <a href="/LMS_Project/public/auth/register" class="btn btn-outline-primary">
                            <i class="fas fa-user-plus me-2"></i>Create new account
                        </a>
                    </div>
                </form>
                <hr class="my-3">
                <p class="small text-center text-muted mb-0">
                    <a href="/LMS_Project/public/home/index" class="text-primary text-decoration-none"><i class="fas fa-arrow-left me-1"></i>Back to home</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>
