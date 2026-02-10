<?php require_once '../app/Views/inc/header.php'; ?>

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-md-8">
        
        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary"><i class="fas fa-headset me-2"></i>Support Center</h2>
            <p class="text-muted">We are here to help. Please fill out the form below.</p>
        </div>

        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white p-4 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold"><i class="fas fa-paper-plane me-2"></i>Submit a Request</h4>
                <a href="/LMS_Project/public/support/history" class="btn btn-sm btn-outline-light fw-bold">
                    <i class="fas fa-history me-1"></i> View My History
                </a>
            </div>
            
            <div class="card-body p-5">

                <?php if (isset($_GET['status']) && $_GET['status'] == 'sent'): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fa-2x me-3"></i>
                            <div>
                                <strong>Request Sent Successfully!</strong><br>
                                Your ticket has been sent to the Administrator. We will contact you shortly via email.
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="/LMS_Project/public/support/send" method="POST">
                    <div class="mb-3">
                        <label class="fw-bold form-label">Subject <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-tag text-muted"></i></span>
                            <input type="text" name="subject" class="form-control form-control-lg" placeholder="E.g., Cannot access course, Forgot password..." required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold form-label">Message Details <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control" rows="6" placeholder="Describe your issue in detail so we can assist you better..." required></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm hover-effect">
                            Submit Request 🚀
                        </button>
                        <a href="/LMS_Project/public/home/index" class="btn btn-outline-secondary">
                            Cancel & Return Home
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-4 text-center">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i> Common issues: 
                <a href="#" class="text-decoration-none">Reset Password</a> &bull; 
                <a href="#" class="text-decoration-none">Payment Issues</a> &bull; 
                <a href="#" class="text-decoration-none">Course Access</a>
            </small>
        </div>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>