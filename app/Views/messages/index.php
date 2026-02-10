<?php require_once '../app/Views/inc/header.php'; ?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-primary fw-bold"><i class="fas fa-envelope me-2"></i>Inbox</h3>
                <a href="/LMS_Project/public/home/index" class="btn btn-outline-secondary btn-sm shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to Home
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="list-group list-group-flush">
                    
                    <?php if (empty($data['messages'])): ?>
                        <div class="text-center py-5">
                            <i class="far fa-envelope-open fa-3x text-muted mb-3 opacity-50"></i>
                            <h5 class="text-muted">Your inbox is empty.</h5>
                            <p class="text-muted small">No new messages at the moment.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($data['messages'] as $msg): ?>
                            <?php 
                                // Logic: Tin chưa đọc (is_read=0) thì tô đậm nền & chữ
                                $isUnread = ($msg['is_read'] == 0);
                                $bgClass = $isUnread ? 'bg-primary bg-opacity-10' : '';
                                $textClass = $isUnread ? 'fw-bold text-dark' : 'text-secondary';
                            ?>

                            <a href="/LMS_Project/public/message/detail/<?= $msg['id'] ?>" class="list-group-item list-group-item-action p-3 <?= $bgClass ?>">
                                <div class="d-flex w-100 justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px; font-size: 14px;">
                                            <?= strtoupper(substr($msg['sender_name'], 0, 1)) ?>
                                        </div>
                                        
                                        <div>
                                            <h6 class="mb-0 <?= $textClass ?>">
                                                <?= htmlspecialchars($msg['sender_name']) ?>
                                                <?php if($isUnread): ?>
                                                    <span class="badge bg-primary rounded-pill ms-2" style="font-size: 0.6em;">NEW</span>
                                                <?php endif; ?>
                                            </h6>
                                            <small class="text-muted"><?= htmlspecialchars($msg['subject']) ?></small>
                                        </div>
                                    </div>
                                    <small class="text-muted text-nowrap">
                                        <?= date('d M', strtotime($msg['created_at'])) ?>
                                    </small>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>