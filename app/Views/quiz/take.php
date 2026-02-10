<?php require_once '../app/Views/inc/header.php'; ?>

<div class="row justify-content-center mt-4 mb-5">
    <div class="col-md-8">
        
        <div class="card shadow border-0 border-top border-5 border-primary mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h3 class="fw-bold text-primary mb-2">
                            <i class="fas fa-pencil-alt me-2"></i><?= htmlspecialchars($data['quiz']['title']) ?>
                        </h3>
                        <p class="text-muted mb-0"><?= nl2br(htmlspecialchars($data['quiz']['description'])) ?></p>
                    </div>
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                        <i class="far fa-clock me-1"></i> Exam Mode
                    </span>
                </div>
            </div>
        </div>

        <form action="/LMS_Project/public/quiz/submit/<?= $data['quiz']['id'] ?>" method="POST">
            
            <?php foreach($data['questions'] as $index => $q): ?>
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white fw-bold py-3">
                        <span class="badge bg-secondary me-2">Q<?= $index + 1 ?></span>
                        <?= htmlspecialchars($q['question_text']) ?>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <?php foreach($q['options'] as $opt): ?>
                                <label class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer">
                                    <input class="form-check-input me-3" type="radio" 
                                           name="answers[<?= $q['id'] ?>]" 
                                           value="<?= $opt['id'] ?>" 
                                           id="opt_<?= $opt['id'] ?>">
                                    <span class="form-check-label w-100" for="opt_<?= $opt['id'] ?>">
                                        <?= htmlspecialchars($opt['option_text']) ?>
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="card shadow-sm border-0 sticky-bottom bg-white p-3 border-top">
                <div class="d-grid">
                    <button type="submit" class="btn btn-success btn-lg fw-bold shadow" 
                            onclick="return confirm('Are you sure you want to submit your answers? This cannot be undone.');">
                        <i class="fas fa-paper-plane me-2"></i> Submit Quiz
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>