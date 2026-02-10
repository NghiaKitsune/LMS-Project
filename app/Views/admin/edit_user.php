<?php require_once '../app/Views/inc/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-danger"> 
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">🛡️ SUPREME EDIT</h4>
                    <span class="badge bg-white text-danger">Admin Mode</span>
                </div>
                <div class="card-body">
                    
                    <h5 class="card-title text-center mb-4">Editing User: <strong><?= htmlspecialchars($data['user']['fullname']) ?></strong></h5>

                    <form action="/LMS_Project/public/admin/update_user/<?= $data['user']['id'] ?>" method="POST">
                        
                        <div class="mb-3">
                            <label class="fw-bold">Full Name</label>
                            <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($data['user']['fullname']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data['user']['email']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold text-danger">Reset Password (Optional)</label>
                            <input type="text" name="password" class="form-control border-danger" placeholder="Leave empty to keep current password">
                            <small class="text-muted">Enter a new password here to force reset this user's password.</small>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Role (System Permission)</label>
                            <select name="role" class="form-select">
                                <option value="student" <?= $data['user']['role'] == 'student' ? 'selected' : '' ?>>Student (Learner)</option>
                                <option value="instructor" <?= $data['user']['role'] == 'instructor' ? 'selected' : '' ?>>Instructor (Teacher)</option>
                                <option value="admin" <?= $data['user']['role'] == 'admin' ? 'selected' : '' ?>>ADMIN </option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="/LMS_Project/public/admin/dashboard" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger fw-bold">Update User Info</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>