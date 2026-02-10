<?php require_once '../app/Views/inc/header.php'; ?>

<div class="mt-4">
    <a href="/LMS_Project/public/course/detail/<?= $data['assignment']['course_id'] ?>" class="btn btn-outline-secondary mb-4 shadow-sm">
        <i class="fas fa-arrow-left me-2"></i> Back to Course
    </a>

    <div class="card shadow-sm mb-4 border-start border-5 border-primary">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="text-primary fw-bold mb-1"><?= htmlspecialchars($data['assignment']['title']) ?></h2>
                    <p class="text-muted mb-0">
                        <i class="far fa-clock me-1"></i> Deadline: 
                        <span class="fw-bold text-danger">
                            <?= date('d M Y, H:i', strtotime($data['assignment']['deadline'])) ?>
                        </span>
                    </p>
                </div>
                <?php if($_SESSION['user_role'] == 'instructor' || $_SESSION['user_role'] == 'admin'): ?>
                    <button class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i> Edit</button>
                <?php endif; ?>
            </div>
            
            <hr class="my-4">
            
            <h5 class="fw-bold text-secondary"><i class="fas fa-align-left me-2"></i>Instructions:</h5>
            <div class="bg-light p-3 rounded text-dark">
                <?= nl2br(htmlspecialchars($data['assignment']['description'])) ?>
            </div>
        </div>
    </div>

    <?php if($_SESSION['user_role'] == 'student'): ?>
        <div class="card shadow border-0 mb-5">
            <div class="card-header bg-primary text-white fw-bold d-flex align-items-center">
                <i class="fas fa-upload me-2"></i> Your Submission
            </div>
            <div class="card-body p-4">
                
                <?php if($data['my_submission']): ?>
                    <div class="alert alert-success d-flex align-items-center shadow-sm">
                        <i class="fas fa-check-circle fa-2x me-3"></i>
                        <div>
                            <strong>Submitted successfully!</strong><br>
                            <small>On <?= date('d M Y, H:i', strtotime($data['my_submission']['submitted_at'])) ?></small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="mb-1 fw-bold">Submitted File:</p>
                        <a href="/LMS_Project/public/assets/assignments/<?= $data['my_submission']['file_path'] ?>" class="btn btn-outline-dark btn-sm" download>
                            <i class="fas fa-file-download me-2"></i> Download File
                        </a>
                    </div>
                    
                    <?php if($data['my_submission']['grade'] !== null): ?>
                        <div class="card bg-light border-success">
                            <div class="card-body">
                                <h4 class="text-success fw-bold mb-3">
                                    <i class="fas fa-star me-2"></i>Grade: <?= $data['my_submission']['grade'] ?>/100
                                </h4>
                                <div>
                                    <strong><i class="fas fa-comment-dots me-1"></i> Teacher's Feedback:</strong>
                                    <p class="mt-1 mb-0 fst-italic text-muted">"<?= htmlspecialchars($data['my_submission']['feedback']) ?>"</p>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning border-warning">
                            <i class="fas fa-hourglass-half me-2"></i> Your assignment is waiting for grading.
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <form action="/LMS_Project/public/assignment/upload/<?= $data['assignment']['id'] ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Upload your work (PDF, Zip, Docx)</label>
                            <input type="file" name="file_upload" class="form-control form-control-lg" required>
                            <div class="form-text">Max file size: 10MB. Allowed formats: .pdf, .zip, .doc, .docx</div>
                        </div>
                        <button type="submit" class="btn btn-primary fw-bold btn-lg w-100">
                            <i class="fas fa-paper-plane me-2"></i> Submit Assignment
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if($_SESSION['user_role'] == 'instructor' || $_SESSION['user_role'] == 'admin'): ?>
        <div class="card shadow border-0 mb-5">
            <div class="card-header bg-danger text-white fw-bold d-flex justify-content-between align-items-center">
                <span><i class="fas fa-graduation-cap me-2"></i> Grading Area</span>
                <span class="badge bg-white text-danger"><?= count($data['all_submissions']) ?> Submissions</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Student</th>
                                <th>File</th>
                                <th>Submitted At</th>
                                <th>Grade</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($data['all_submissions'])): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No submissions yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($data['all_submissions'] as $sub): ?>
                                <tr>
                                    <td class="ps-4 fw-bold"><?= htmlspecialchars($sub['fullname']) ?></td>
                                    <td>
                                        <a href="/LMS_Project/public/assets/assignments/<?= $sub['file_path'] ?>" class="btn btn-sm btn-outline-dark" download>
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </td>
                                    <td><?= date('d M, H:i', strtotime($sub['submitted_at'])) ?></td>
                                    <td>
                                        <?php if($sub['grade'] !== null): ?>
                                            <span class="badge bg-success fs-6"><?= $sub['grade'] ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Not Graded</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#gradeModal<?= $sub['id'] ?>">
                                            <i class="fas fa-pen-nib me-1"></i> Grade
                                        </button>

                                        <div class="modal fade text-start" id="gradeModal<?= $sub['id'] ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="/LMS_Project/public/assignment/grade" method="POST">
                                                        <div class="modal-header bg-light">
                                                            <h5 class="modal-title fw-bold">Grade for <?= htmlspecialchars($sub['fullname']) ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="submission_id" value="<?= $sub['id'] ?>">
                                                            <input type="hidden" name="assignment_id" value="<?= $data['assignment']['id'] ?>">
                                                            
                                                            <div class="mb-3">
                                                                <label class="fw-bold">Score (0-100)</label>
                                                                <input type="number" name="grade" class="form-control form-control-lg" min="0" max="100" value="<?= $sub['grade'] ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="fw-bold">Feedback</label>
                                                                <textarea name="feedback" class="form-control" rows="3" placeholder="Good job, but..."><?= htmlspecialchars($sub['feedback'] ?? '') ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary fw-bold">Save Grade</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php require_once '../app/Views/inc/footer.php'; ?>