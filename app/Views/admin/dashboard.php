<?php require_once '../app/Views/inc/header.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .stat-card { border-left: 5px solid; transition: transform 0.2s; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    .border-blue { border-color: #0d6efd !important; }
    .border-green { border-color: #198754 !important; }
    .border-orange { border-color: #fd7e14 !important; }
</style>

<div class="container-fluid px-4">
    
    <div class="d-flex justify-content-between align-items-center my-4 p-3 bg-white rounded shadow-sm border-start border-5 border-primary">
        <div>
            <h2 class="fw-bold text-primary mb-0">🛡️ Admin Command Center</h2>
            <p class="text-muted mb-0 small">Welcome back, Administrator</p>
        </div>
        <div>
            <a href="/LMS_Project/public/home/index" class="btn btn-outline-primary fw-bold rounded-pill px-3 shadow-sm">
                <i class="fas fa-eye"></i> Switch to Student View
            </a>
        </div>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success shadow-sm mb-4">
            <i class="fas fa-check-circle"></i> Action completed successfully!
        </div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card stat-card border-blue shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase small fw-bold">Total Users</h6>
                            <h2 class="display-6 fw-bold text-primary"><?= htmlspecialchars($data['stats']['users']) ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card border-green shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase small fw-bold">Total Courses</h6>
                            <h2 class="display-6 fw-bold text-success"><?= htmlspecialchars($data['stats']['courses']) ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card border-orange shadow-sm h-100">
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase small fw-bold">Enrollments</h6>
                            <h2 class="display-6 fw-bold text-warning"><?= htmlspecialchars($data['stats']['enrollments']) ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white fw-bold border-bottom-0">📊 Course Distribution</div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <canvas id="courseChart" style="max-height: 200px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-5">
        <div class="card-header bg-white p-0">
            <ul class="nav nav-tabs card-header-tabs m-0" id="adminTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active fw-bold py-3" data-bs-toggle="tab" data-bs-target="#students" type="button">👨‍🎓 Students</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold py-3" data-bs-toggle="tab" data-bs-target="#instructors" type="button">👨‍🏫 Instructors</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold py-3" data-bs-toggle="tab" data-bs-target="#courses" type="button">📚 Courses</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-bold py-3 text-danger" data-bs-toggle="tab" data-bs-target="#support" type="button">📩 Support Tickets</button>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content">
                
                <div class="tab-pane fade show active" id="students">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light"><tr><th>ID</th><th>Full Name</th><th>Email</th><th>Actions</th></tr></thead>
                            <tbody>
                                <?php foreach($data['students'] as $s): ?>
                                <tr>
                                    <td>#<?= $s['id'] ?></td>
                                    <td><?= htmlspecialchars($s['fullname']) ?></td>
                                    <td><?= htmlspecialchars($s['email']) ?></td>
                                    <td>
                                        <a href="/LMS_Project/public/admin/edit_user/<?= $s['id'] ?>" class="btn btn-sm btn-outline-primary">✏️ Edit</a>
                                        <a href="/LMS_Project/public/admin/delete_user/<?= $s['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Ban this student?')">🚫 Ban</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="instructors">
                        <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light"><tr><th>ID</th><th>Full Name</th><th>Email</th><th>Actions</th></tr></thead>
                            <tbody>
                                <?php foreach($data['instructors'] as $i): ?>
                                <tr>
                                    <td>#<?= $i['id'] ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($i['fullname']) ?></strong>
                                        <span class="badge bg-info text-dark ms-2">Instructor</span>
                                    </td>
                                    <td><?= htmlspecialchars($i['email']) ?></td>
                                    <td>
                                        <a href="/LMS_Project/public/admin/edit_user/<?= $i['id'] ?>" class="btn btn-sm btn-outline-primary">✏️ Edit</a>
                                        <a href="/LMS_Project/public/admin/delete_user/<?= $i['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Ban this instructor?')">🚫 Ban</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="courses">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light"><tr><th>ID</th><th>Course</th><th>Instructor</th><th>Price</th><th>Actions</th></tr></thead>
                            <tbody>
                                <?php foreach($data['courses'] as $c): ?>
                                <tr>
                                    <td><?= $c['id'] ?></td>
                                    <td>
                                        <img src="/LMS_Project/public/assets/uploads/<?= $c['thumbnail'] ?>" width="40" class="rounded me-2">
                                        <?= htmlspecialchars($c['title']) ?>
                                    </td>
                                    <td><?= htmlspecialchars($c['instructor_name']) ?></td>
                                    <td>$<?= $c['price'] ?></td>
                                    <td>
                                        <a href="/LMS_Project/public/course/edit/<?= $c['id'] ?>" class="btn btn-sm btn-outline-warning">✏️ Force Edit</a>
                                        <a href="/LMS_Project/public/admin/delete_course/<?= $c['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete course?')">🗑️ Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane fade" id="support">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Status</th>
                                    <th>User</th>
                                    <th>Issue</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($data['tickets'])): ?>
                                    <tr><td colspan="5" class="text-center text-muted py-4">No support requests yet.</td></tr>
                                <?php else: ?>
                                    <?php foreach($data['tickets'] as $t): ?>
                                    <tr class="<?= $t['status'] == 'resolved' ? 'table-light text-muted' : '' ?>">
                                        <td>
                                            <?php if($t['status'] == 'pending'): ?>
                                                <span class="badge bg-warning text-dark">⏳ Pending</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">✅ Resolved</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($t['fullname']) ?></strong><br>
                                            <small class="text-muted"><?= ucfirst($t['role']) ?></small>
                                        </td>
                                        <td>
                                            <strong><?= htmlspecialchars($t['subject']) ?></strong><br>
                                            <small><?= htmlspecialchars($t['message']) ?></small>
                                        </td>
                                        <td><?= date('d/m/Y', strtotime($t['created_at'])) ?></td>
                                        <td>
                                            <?php if($t['status'] == 'pending'): ?>
                                                <a href="/LMS_Project/public/admin/resolve_ticket/<?= $t['id'] ?>" 
                                                    class="btn btn-sm btn-outline-success fw-bold">
                                                    Mark Done
                                                </a>
                                            <?php else: ?>
                                                <span class="text-success small">Completed</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    // Lấy dữ liệu từ PHP sang JS
    const chartData = <?= json_encode($data['chart_data']) ?>;
    const labels = chartData.map(item => item.name);
    const counts = chartData.map(item => item.count);

    const ctx = document.getElementById('courseChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: counts,
                backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6610f2'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'right' } }
        }
    });
</script>

<?php require_once '../app/Views/inc/footer.php'; ?>