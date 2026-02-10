<?php require_once '../app/Views/inc/header.php'; ?>

<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card shadow border-0 mb-5">
            <div class="card-header bg-warning bg-opacity-25 border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-edit me-2"></i>Edit Course
                    </h4>
                    <a href="/LMS_Project/public/course/my_courses" class="btn btn-sm btn-outline-dark">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                
                <form action="/LMS_Project/public/course/update/<?= $data['course']['id'] ?>" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Course Title</label>
                        <input type="text" name="title" class="form-control form-control-lg" required 
                               value="<?= htmlspecialchars($data['course']['title']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Category</label>
                        <select name="category_id" class="form-select">
                            <?php foreach($data['categories'] as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $data['course']['category_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="5"><?= htmlspecialchars($data['course']['description']) ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Price ($)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="price" class="form-control" required min="0" step="0.01"
                                       value="<?= $data['course']['price'] ?>">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Current Thumbnail</label>
                            <div class="d-flex align-items-center">
                                <img src="/LMS_Project/public/assets/uploads/<?= $data['course']['thumbnail'] ?>" 
                                     width="80" height="50" class="rounded border me-3" style="object-fit: cover;">
                                <input type="file" name="thumbnail" class="form-control" accept="image/*">
                            </div>
                            <div class="form-text text-muted">Leave empty to keep current image.</div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="/LMS_Project/public/course/delete/<?= $data['course']['id'] ?>" 
                           class="btn btn-outline-danger"
                           onclick="return confirm('WARNING: Are you sure you want to delete this course? This action cannot be undone!');">
                            <i class="fas fa-trash-alt me-1"></i> Delete Course
                        </a>

                        <button type="submit" class="btn btn-warning fw-bold px-4 shadow-sm">
                            <i class="fas fa-save me-1"></i> Save Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/Views/inc/footer.php'; ?>