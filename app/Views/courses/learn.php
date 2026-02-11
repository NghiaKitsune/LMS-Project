<?php require_once '../app/Views/inc/header.php'; ?>

<?php
    // HÀM HỖ TRỢ: Lấy ID video từ link Youtube bất kỳ
    // Input: https://www.youtube.com/watch?v=dQw4w9WgXcQ hoặc https://youtu.be/dQw4w9WgXcQ
    function getYoutubeId($url) {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
        return null;
    }

    $currentLesson = $data['current_lesson'];
    $videoId = $currentLesson ? getYoutubeId($currentLesson['video_url']) : null;
?>

<style>
    .learn-sidebar .card { border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 0.125rem 0.5rem rgba(0,0,0,0.08); }
    .learn-sidebar .card-header { background: var(--lms-gradient) !important; border: none; padding: 1rem 1.25rem; }
    .learn-sidebar .card-header-title { font-size: 1rem; font-weight: 700; margin: 0; display: flex; align-items: center; }
    .learn-sidebar .card-header-title i { opacity: 0.95; }
    .learn-back-btn { display: inline-flex; align-items: center; margin-top: 0.75rem; padding: 0.35rem 0.85rem; font-size: 0.8125rem; font-weight: 600; border-radius: 50px; border: 1px solid rgba(255,255,255,0.7); color: #fff; background: rgba(255,255,255,0.1); text-decoration: none; transition: background 0.2s, border-color 0.2s; }
    .learn-back-btn:hover { background: rgba(255,255,255,0.25); border-color: #fff; color: #fff; }
    .sidebar-content { max-height: 70vh; overflow-y: auto; }
    .sidebar-content .list-group-item { border-left: 0; border-right: 0; padding: 0.75rem 1.25rem; }
    .sidebar-content .list-group-item.active { background: var(--lms-gradient); border-color: transparent; color: #fff; font-weight: 600; }
    .sidebar-content .list-group-item-action:hover { background: rgba(102, 126, 234, 0.08); }
    .learn-empty-sidebar { padding: 2.25rem 1.25rem; text-align: center; color: #6c757d; }
    .learn-empty-sidebar i { font-size: 2.5rem; opacity: 0.45; margin-bottom: 0.75rem; display: block; }
    .learn-empty-sidebar span { font-size: 0.9rem; }
    .video-wrap { border-radius: 12px; overflow: hidden; box-shadow: 0 0.25rem 1rem rgba(0,0,0,0.1); }
    .video-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000; }
    .video-container iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
    .learn-no-content { background: linear-gradient(135deg, #f8f4f0 0%, #f0ebe3 100%); border: none; border-radius: 16px; padding: 3rem 2rem; text-align: center; box-shadow: 0 0.125rem 0.5rem rgba(0,0,0,0.06); }
    .learn-no-content i { color: #8b7355; font-size: 3.5rem; margin-bottom: 1rem; }
    .learn-no-content h4 { color: #5c4d3a; font-weight: 700; }
    .learn-no-content p { color: #7a6f5c; margin-bottom: 0; }
</style>

<div class="container-fluid mt-3 mb-5 px-3 px-md-4">
    <div class="row g-4">
        
        <div class="col-lg-3 mb-4 learn-sidebar">
            <div class="card shadow-sm h-100">
                <div class="card-header text-white">
                    <h2 class="h6 card-header-title mb-0">
                        <i class="fas fa-list-ul me-2"></i>Course Content
                    </h2>
                    <a href="/LMS_Project/public/course/my_learning" class="learn-back-btn">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
                
                <div class="list-group list-group-flush sidebar-content">
                    <?php if (empty($data['lessons'])): ?>
                        <div class="learn-empty-sidebar">
                            <i class="fas fa-folder-open"></i>
                            <span>No lessons uploaded yet.</span>
                        </div>
                    <?php else: ?>
                        <?php foreach($data['lessons'] as $index => $lesson): ?>
                            <?php 
                                // Kiểm tra xem bài này có đang được chọn không
                                $isActive = ($currentLesson && $currentLesson['id'] == $lesson['id']) ? 'active' : '';
                                
                                // Tạo link: Reload trang với tham số lesson_id
                                $link = "/LMS_Project/public/course/learn/" . $data['course']['id'] . "?lesson_id=" . $lesson['id'];
                            ?>
                            <a href="<?= $link ?>" class="list-group-item list-group-item-action <?= $isActive ?> d-flex align-items-center">
                                <span class="me-2">
                                    <?php if($isActive): ?>
                                        <i class="fas fa-play-circle"></i>
                                    <?php else: ?>
                                        <i class="far fa-circle text-muted"></i>
                                    <?php endif; ?>
                                </span>
                                <span class="text-truncate">
                                    Lesson <?= $index + 1 ?>: <?= htmlspecialchars($lesson['title']) ?>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <h2 class="fw-bold mb-4 text-primary">
                <?= htmlspecialchars($data['course']['title']) ?>
            </h2>

            <?php if ($currentLesson): ?>
                <div class="card shadow-sm mb-4 border-0 video-wrap">
                    <div class="card-body p-0 bg-dark">
                        <div class="video-container">
                            <?php if ($videoId): ?>
                                <iframe src="https://www.youtube.com/embed/<?= $videoId ?>?rel=0&autoplay=1&modestbranding=1" 
                                        frameborder="0" allowfullscreen allow="autoplay">
                                </iframe>
                            <?php else: ?>
                                <div class="d-flex justify-content-center align-items-center h-100 text-white">
                                    <div class="text-center">
                                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                        <h5>Video Unavailable</h5>
                                        <p>Invalid URL or video removed.</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 pt-3 pb-3">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="fas fa-play-circle me-2 text-primary"></i>
                            <?= htmlspecialchars($currentLesson['title']) ?>
                        </h5>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white border-bottom">
                        <ul class="nav nav-tabs card-header-tabs" id="learnTab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#overview">
                                    Course Overview
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#resources">
                                    Resources
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="overview">
                                <h5 class="fw-bold text-dark">About this course</h5>
                                <div class="text-muted" style="line-height: 1.6;">
                                    <?= nl2br(htmlspecialchars($data['course']['description'])) ?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="resources">
                                <p class="text-muted">
                                    <i class="fas fa-download me-2"></i> No downloadable resources available for this lesson.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <div class="card learn-no-content">
                    <div class="card-body">
                        <i class="fas fa-video-slash d-block"></i>
                        <h4 class="mb-2">Course Content Not Available</h4>
                        <p>The instructor hasn't uploaded any lessons yet.</p>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>