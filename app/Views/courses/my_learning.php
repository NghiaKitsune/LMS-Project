<?php require_once '../app/Views/inc/header.php'; ?>

<div class="mt-4 mb-4">
    <h2 class="fw-bold text-primary"><i class="fas fa-graduation-cap me-2"></i>My Learning Dashboard</h2>
    <p class="text-muted">Track your progress and continue learning.</p>
</div>

<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <strong><i class="fas fa-party-horn"></i> Welcome!</strong> You have successfully enrolled. Happy learning!
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (empty($data['courses'])): ?>
    <div class="text-center py-5 border rounded bg-white shadow-sm">
        <i class="fas fa-book-reader fa-4x text-muted mb-3 opacity-25"></i>
        <h4 class="text-muted">You haven't enrolled in any courses yet.</h4>
        <p>Explore our catalog to find your next skill.</p>
        <a href="/LMS_Project/public/home/index" class="btn btn-primary fw-bold px-4">Browse Courses</a>
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach($data['courses'] as $course): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm border-0 hover-effect">
                    <?php 
                        $img = $course['thumbnail'] ? '/LMS_Project/public/assets/uploads/'.$course['thumbnail'] : 'https://via.placeholder.com/300x200';
                    ?>
                    <div class="position-relative">
                        <img src="<?= $img ?>" class="card-img-top" style="height: 160px; object-fit: cover;">
                        <span class="badge bg-dark bg-opacity-75 position-absolute bottom-0 end-0 m-2">Enrolled</span>
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title fw-bold text-dark line-clamp-2" style="min-height: 40px;">
                            <?= htmlspecialchars($course['title']) ?>
                        </h6>
                        <p class="small text-muted mb-2">
                            <i class="fas fa-user-tie me-1"></i> <?= htmlspecialchars($course['instructor_name']) ?>
                        </p>
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span>Progress</span>
                                <span>10%</span>
                            </div>
                            <div class="progress mb-3" style="height: 6px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 10%"></div>
                            </div>
                            
                            <a href="/LMS_Project/public/course/learn/<?= $course['id'] ?>" class="btn btn-primary btn-sm w-100 fw-bold">
                                <i class="fas fa-play me-1"></i> Continue Learning
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once '../app/Views/inc/footer.php'; ?>