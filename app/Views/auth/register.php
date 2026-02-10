<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?? 'Register' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Student Registration</h4>
                    </div>
                    <div class="card-body">
                        
                        <?php if (isset($data['error'])): ?>
                            <div class="alert alert-danger">
                                <?= $data['error'] ?>
                            </div>
                        <?php endif; ?>

                        <form action="/LMS_Project/public/auth/store" method="POST">
                            
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Full Name</label>
                                <input type="text" name="fullname" id="fullname" class="form-control" placeholder="John Doe" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="john@example.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="********" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Register Now</button>
                            </div>

                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <small>Already have an account? <a href="/LMS_Project/public/auth/login">Login here</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>