<?php require_once '../app/Views/inc/header.php'; ?>

<nav aria-label="breadcrumb" class="mt-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/LMS_Project/public/home/index" class="text-decoration-none">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Course Details</li>
    </ol>
</nav>

<div class="row mb-5">
    <div class="col-md-8">
        <?php 
            $img = $data['course']['thumbnail'] ? '/LMS_Project/public/assets/uploads/'.$data['course']['thumbnail'] : 'https://via.placeholder.com/800x400';
        ?>
        <div class="position-relative">
            <img src="<?= $img ?>" class="img-fluid rounded mb-4 shadow w-100" alt="Course Thumbnail" style="max-height: 400px; object-fit: cover;">
            <span class="badge bg-primary position-absolute top-0 start-0 m-3 fs-6 shadow-sm">
                <?= htmlspecialchars($data['course']['category_name']) ?>
            </span>
        </div>
        
        <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($data['course']['title']) ?></h1>
        
        <div class="d-flex align-items-center mb-4 text-muted">
            <div class="me-4">
                <i class="fas fa-chalkboard-teacher me-2 text-primary"></i>
                Instructor: <strong><?= htmlspecialchars($data['course']['instructor_name']) ?></strong>
            </div>
            <div>
                <i class="far fa-clock me-2 text-primary"></i> Last updated: <?= date('M Y') ?>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h4 class="card-title fw-bold text-dark border-bottom pb-2 mb-3">About this course</h4>
                <p class="card-text text-secondary" style="white-space: pre-line; line-height: 1.6;">
                    <?= htmlspecialchars($data['course']['description']) ?>
                </p>
            </div>
        </div>

        <?php if(isset($data['assignments']) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'instructor')): ?>
        <div class="card shadow-sm border-start border-5 border-warning mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-tasks me-2 text-warning"></i>Assignments & Quizzes</h5>
                
                <?php if(isset($_SESSION['user_role']) && ($_SESSION['user_role'] == 'instructor' || $_SESSION['user_role'] == 'admin')): ?>
                    <div>
                        <a href="/LMS_Project/public/assignment/create/<?= $data['course']['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="fas fa-plus"></i> Assign
                        </a>
                        <a href="/LMS_Project/public/quiz/create/<?= $data['course']['id'] ?>" class="btn btn-sm btn-outline-success">
                            <i class="fas fa-plus"></i> Quiz
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="card-body">
                <?php if(!empty($data['assignments'])): ?>
                    <h6 class="text-primary fw-bold mb-2 small text-uppercase">Homework</h6>
                    <div class="list-group mb-4">
                        <?php foreach($data['assignments'] as $ass): ?>
                            <a href="/LMS_Project/public/assignment/detail/<?= $ass['id'] ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-file-alt me-2 text-secondary"></i>
                                    <strong><?= htmlspecialchars($ass['title']) ?></strong>
                                    <div class="small text-muted ms-4">Due: <?= date('d M, H:i', strtotime($ass['deadline'])) ?></div>
                                </div>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if(isset($data['quizzes']) && !empty($data['quizzes'])): ?>
                    <h6 class="text-success fw-bold mb-2 small text-uppercase">Quizzes</h6>
                    <div class="list-group">
                        <?php foreach($data['quizzes'] as $qz): ?>
                            <a href="/LMS_Project/public/quiz/take/<?= $qz['id'] ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-question-circle me-2 text-success"></i>
                                    <strong><?= htmlspecialchars($qz['title']) ?></strong>
                                </div>
                                <span class="badge bg-success rounded-pill">Start</span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if(empty($data['assignments']) && (empty($data['quizzes']) || !isset($data['quizzes']))): ?>
                    <div class="text-center py-4 text-muted border rounded border-dashed">
                        <i class="fas fa-wind fa-2x mb-2"></i><br>
                        No assignments or quizzes yet.
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4">
        <div class="card shadow border-0 sticky-top" style="top: 100px; z-index: 10;">
            <div class="card-body p-4">
                <h2 class="fw-bold mb-3 text-success display-6">
                    <?= ($data['course']['price'] == 0) ? 'Free' : '$' . number_format($data['course']['price'], 2) ?>
                </h2>

                <div class="d-grid gap-2 mb-3">
                    <?php if ($data['isOwner']): ?>
                        <a href="/LMS_Project/public/course/my_courses" class="btn btn-secondary fw-bold py-2">
                            <i class="fas fa-cog me-2"></i>Manage Course
                        </a>
                        <a href="/LMS_Project/public/course/add_lesson/<?= $data['course']['id'] ?>" class="btn btn-outline-primary py-2">
                            <i class="fas fa-video me-2"></i>Add Lesson
                        </a>

                    <?php elseif ($data['isEnrolled']): ?>
                        <a href="/LMS_Project/public/course/learn/<?= $data['course']['id'] ?>" class="btn btn-success btn-lg fw-bold py-3 shadow-sm">
                            <i class="fas fa-play-circle me-2"></i>Continue Learning
                        </a>

                    <?php else: ?>
                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'instructor'): ?>
                            <button class="btn btn-secondary btn-lg" disabled>Instructor View Only</button>
                        <?php else: ?>
                            <form action="/LMS_Project/public/course/enroll/<?= $data['course']['id'] ?>" method="POST">
                                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold py-3 shadow-sm pulse-button">
                                    Enroll Now
                                </button>
                            </form>
                            <div class="text-center mt-2 small text-muted">30-day money-back guarantee</div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <div class="border-top pt-3">
                    <h6 class="fw-bold text-dark">This course includes:</h6>
                    <ul class="list-unstyled text-secondary small mb-0">
                        <li class="mb-2"><i class="fas fa-video me-2 w-20 text-center"></i> On-demand video</li>
                        <li class="mb-2"><i class="fas fa-file-download me-2 w-20 text-center"></i> Downloadable resources</li>
                        <li class="mb-2"><i class="fas fa-infinity me-2 w-20 text-center"></i> Full lifetime access</li>
                        <li class="mb-2"><i class="fas fa-mobile-alt me-2 w-20 text-center"></i> Access on mobile and TV</li>
                        <li><i class="fas fa-certificate me-2 w-20 text-center"></i> Certificate of completion</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>