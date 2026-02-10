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
    /* Chỉnh lại chiều cao sidebar cho vừa màn hình */
    .sidebar-content { max-height: 75vh; overflow-y: auto; }
    .video-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000; border-radius: 8px; }
    .video-container iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
    /* Style cho bài đang chọn */
    .list-group-item.active {
        background-color: #0d6efd;
        border-color: #0d6efd;
        font-weight: 600;
    }
</style>

<div class="container-fluid mt-3 mb-5">
    <div class="row">
        
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white p-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-list-ul me-2"></i>Course Content</h6>
                    <a href="/LMS_Project/public/course/my_learning" class="text-white small text-decoration-none opacity-75 hover-opacity-100">
                        &larr; Back to Dashboard
                    </a>
                </div>
                
                <div class="list-group list-group-flush sidebar-content">
                    <?php if (empty($data['lessons'])): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-box-open fa-2x mb-2"></i><br>
                            No lessons uploaded yet.
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

        <div class="col-md-9">
            <h2 class="fw-bold mb-3 text-primary">
                <?= htmlspecialchars($data['course']['title']) ?>
            </h2>

            <?php if ($currentLesson): ?>
                <div class="card shadow mb-4 border-0">
                    <div class="card-body p-1 bg-dark rounded">
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
                    <div class="card-footer bg-white">
                        <h4 class="fw-bold mt-2">
                            <i class="fas fa-video me-2 text-primary"></i>
                            <?= htmlspecialchars($currentLesson['title']) ?>
                        </h4>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom-0">
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
                <div class="alert alert-warning text-center py-5 shadow-sm">
                    <i class="fas fa-chalkboard-teacher fa-4x mb-3"></i>
                    <h4>Course Content Not Available</h4>
                    <p>The instructor hasn't uploaded any lessons yet.</p>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>