<?php require_once '../app/Views/inc/header.php'; ?>

<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Create New Assignment</h4>
            </div>
            <div class="card-body p-4">
                <form action="/LMS_Project/public/assignment/store" method="POST">
                    <input type="hidden" name="course_id" value="<?= $data['course_id'] ?>">
                    
                    <div class="mb-3">
                        <label class="fw-bold form-label">Assignment Title</label>
                        <input type="text" name="title" class="form-control form-control-lg" placeholder="e.g. Lab 1: PHP Basics" required>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold form-label">Instructions / Description</label>
                        <textarea name="description" class="form-control" rows="5" placeholder="Describe the requirements for this assignment..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold form-label text-danger">Deadline</label>
                        <input type="datetime-local" name="deadline" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/LMS_Project/public/course/detail/<?= $data['course_id'] ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success fw-bold px-4">
                            <i class="fas fa-save me-1"></i> Publish Assignment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>