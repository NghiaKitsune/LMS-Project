<?php require_once '../app/Views/inc/header.php'; ?>

<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card shadow border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0 fw-bold text-primary">
                        <i class="fas fa-magic me-2"></i>Create New Course
                    </h4>
                    <a href="/LMS_Project/public/course/my_courses" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                
                <form action="/LMS_Project/public/course/store" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Course Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg" required 
                               placeholder="e.g., Advanced PHP Programming">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select">
                            <?php foreach($data['categories'] as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="5" 
                                  placeholder="What will students learn in this course? Describe the outcomes..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Price ($) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="price" class="form-control" required min="0" step="0.01" placeholder="0.00">
                            </div>
                            <div class="form-text">Set 0 for Free courses.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Thumbnail Image</label>
                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                            <div class="form-text text-muted">Supported: JPG, PNG, WEBP (Max 2MB)</div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                            <i class="fas fa-check me-2"></i> Create Course
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>