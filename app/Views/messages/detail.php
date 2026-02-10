<?php require_once '../app/Views/inc/header.php'; ?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <a href="/LMS_Project/public/message/index" class="btn btn-outline-secondary btn-sm mb-3">
                <i class="fas fa-arrow-left me-1"></i> Back to Inbox
            </a>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-1 text-primary fw-bold"><?= htmlspecialchars($data['message']['subject']) ?></h4>
                    <div class="d-flex justify-content-between align-items-center text-muted small">
                        <span>
                            <i class="fas fa-user-circle me-1"></i> From: <strong><?= htmlspecialchars($data['message']['sender_name']) ?></strong>
                        </span>
                        <span>
                            <i class="far fa-clock me-1"></i> <?= date('d M Y, H:i', strtotime($data['message']['created_at'])) ?>
                        </span>
                    </div>
                </div>
                <div class="card-body p-4" style="min-height: 200px; line-height: 1.6;">
                    <?= nl2br(htmlspecialchars($data['message']['message'])) ?>
                </div>
                <div class="card-footer bg-light text-end">
                    <button class="btn btn-primary btn-sm" onclick="alert('Reply feature coming soon!')">
                        <i class="fas fa-reply me-1"></i> Reply
                    </button>
                    <a href="/LMS_Project/public/message/delete/<?= $data['message']['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this message?');">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>