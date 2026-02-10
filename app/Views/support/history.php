<?php require_once '../app/Views/inc/header.php'; ?>

<div class="container mt-4 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary fw-bold mb-0"><i class="fas fa-history me-2"></i>My Support Tickets</h2>
            <p class="text-muted mb-0">Track the status of your support requests.</p>
        </div>
        <div>
            <a href="/LMS_Project/public/support/index" class="btn btn-success fw-bold shadow-sm">
                <i class="fas fa-plus me-1"></i> New Request
            </a>
            <a href="/LMS_Project/public/profile/index" class="btn btn-outline-secondary ms-2">
                <i class="fas fa-arrow-left me-1"></i> Profile
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            
            <?php if (empty($data['tickets'])): ?>
                <div class="text-center py-5">
                    <i class="far fa-folder-open fa-4x text-muted mb-3 opacity-50"></i>
                    <h5 class="text-muted">You haven't sent any support requests yet.</h5>
                    <p class="text-muted small">Need help? Create a new ticket now.</p>
                    <a href="/LMS_Project/public/support/index" class="btn btn-outline-primary btn-sm mt-2">Create Ticket</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-uppercase small fw-bold">
                            <tr>
                                <th class="ps-4">Status</th>
                                <th>Subject</th>
                                <th>Message Preview</th>
                                <th>Date Sent</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['tickets'] as $t): ?>
                            <tr>
                                <td class="ps-4">
                                    <?php if($t['status'] == 'pending'): ?>
                                        <span class="badge bg-warning text-dark border border-warning">
                                            <i class="fas fa-hourglass-half me-1"></i> Pending
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-success border border-success">
                                            <i class="fas fa-check-circle me-1"></i> Resolved
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark"><?= htmlspecialchars($t['subject']) ?></span>
                                </td>
                                <td style="max-width: 300px;">
                                    <div class="text-truncate text-muted" title="<?= htmlspecialchars($t['message']) ?>">
                                        <?= htmlspecialchars($t['message']) ?>
                                    </div>
                                </td>
                                <td class="text-muted small">
                                    <i class="far fa-calendar-alt me-1"></i> <?= date('d M Y, H:i', strtotime($t['created_at'])) ?>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-outline-secondary" disabled title="View Details (Coming Soon)">
                                        <i class="fas fa-eye"></i> Details
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>