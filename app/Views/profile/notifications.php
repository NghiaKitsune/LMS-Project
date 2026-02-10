<?php require_once '../app/Views/inc/header.php'; ?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="text-primary fw-bold"><i class="fas fa-bell me-2"></i>My Notifications</h3>
                <a href="/LMS_Project/public/home/index" class="btn btn-outline-secondary btn-sm shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to Home
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="list-group list-group-flush">
                    
                    <?php if (empty($data['notifications'])): ?>
                        <div class="text-center py-5">
                            <i class="far fa-bell-slash fa-3x text-muted mb-3 opacity-50"></i>
                            <h5 class="text-muted">You have no new notifications.</h5>
                            <p class="text-muted small">We'll let you know when something important happens.</p>
                            <a href="/LMS_Project/public/course/my_learning" class="btn btn-sm btn-primary mt-2">
                                Go to My Courses
                            </a>
                        </div>
                    
                    <?php else: ?>
                        <?php foreach($data['notifications'] as $noti): ?>
                            <?php 
                                // Logic: Kiểm tra trạng thái đã đọc chưa?
                                // Nếu is_read = 0 (Chưa đọc) -> Thêm class nền xanh nhạt (bg-primary bg-opacity-10)
                                $activeClass = ($noti['is_read'] == 0) ? 'bg-primary bg-opacity-10' : '';
                                
                                // Logic: Kiểm tra link liên kết (nếu null thì để dấu #)
                                $link = !empty($noti['link']) ? $noti['link'] : '#';
                            ?>

                            <a href="<?= htmlspecialchars($link) ?>" class="list-group-item list-group-item-action p-4 <?= $activeClass ?>">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1 text-dark fw-bold">
                                        <?php if($noti['is_read'] == 0): ?>
                                            <i class="fas fa-circle text-primary fs-6 me-2 small" title="Unread"></i>
                                        <?php endif; ?>
                                        
                                        <?= htmlspecialchars($noti['message']) ?>
                                    </h5>
                                    
                                    <small class="text-muted text-nowrap ms-3">
                                        <i class="far fa-clock me-1"></i> 
                                        <?= date('d M, H:i', strtotime($noti['created_at'])) ?>
                                    </small>
                                </div>
                                <small class="text-secondary">Click to view details &rarr;</small>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>