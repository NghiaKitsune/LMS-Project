<?php require_once '../app/Views/inc/header.php'; ?>

<div class="row justify-content-center mt-4 mb-5">
    <div class="col-md-8">
        <form action="/LMS_Project/public/quiz/store" method="POST" id="quizForm">
            <input type="hidden" name="course_id" value="<?= $data['course_id'] ?>">

            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0 fw-bold"><i class="fas fa-edit me-2"></i>Setup New Quiz</h4>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="fw-bold form-label">Quiz Title</label>
                        <input type="text" name="title" class="form-control form-control-lg" placeholder="E.g. Final Exam PHP" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Instructions for students..."></textarea>
                    </div>
                </div>
            </div>

            <div id="questions-container"></div>

            <div class="d-grid gap-2 mb-5">
                <button type="button" class="btn btn-outline-primary border-2 fw-bold py-2 dashed-border" onclick="addQuestion()">
                    <i class="fas fa-plus-circle me-1"></i> Add New Question
                </button>
                
                <div class="d-flex gap-2 mt-3">
                    <a href="/LMS_Project/public/course/detail/<?= $data['course_id'] ?>" class="btn btn-secondary w-50">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-success fw-bold w-50 shadow-sm">
                        <i class="fas fa-save me-1"></i> Save & Publish Quiz
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let qIndex = 0; // Biến đếm số câu hỏi

    function addQuestion() {
        const container = document.getElementById('questions-container');
        
        // Tạo HTML cho câu hỏi mới
        // Lưu ý: Dùng backtick (`) để viết chuỗi nhiều dòng
        const html = `
        <div class="card shadow-sm border-0 mb-4 question-block animate__animated animate__fadeIn" id="q_${qIndex}">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <span class="fw-bold text-primary">Question ${qIndex + 1}</span>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeQuestion('q_${qIndex}')" title="Remove Question">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <input type="text" name="questions[${qIndex}][text]" class="form-control fw-bold" placeholder="Enter question text here..." required>
                </div>

                <div class="row">
                    ${[0, 1, 2, 3].map(i => {
                        const optionLabel = String.fromCharCode(65+i); // A, B, C, D
                        return `
                        <div class="col-md-6 mb-2">
                            <div class="input-group">
                                <div class="input-group-text bg-white">
                                    <input class="form-check-input mt-0" type="radio" name="questions[${qIndex}][correctIdx]" value="${i}" required title="Select as correct answer">
                                </div>
                                <input type="text" name="questions[${qIndex}][options][]" class="form-control" placeholder="Option ${optionLabel}" required>
                            </div>
                        </div>
                        `;
                    }).join('')}
                </div>
                <div class="form-text text-muted fst-italic mt-2">
                    <i class="fas fa-info-circle me-1"></i> Select the radio button corresponding to the correct answer.
                </div>
            </div>
        </div>
        `;

        // Chèn vào cuối danh sách
        container.insertAdjacentHTML('beforeend', html);
        qIndex++;
    }

    // Hàm xóa câu hỏi
    function removeQuestion(id) {
        const element = document.getElementById(id);
        if (confirm('Are you sure you want to remove this question?')) {
            element.remove();
        }
    }

    // Tự động thêm 1 câu hỏi đầu tiên khi tải trang
    // Sử dụng DOMContentLoaded để đảm bảo HTML đã load xong
    document.addEventListener('DOMContentLoaded', function() {
        addQuestion();
    });
</script>

<?php require_once '../app/Views/inc/footer.php'; ?>