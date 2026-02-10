<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?? 'Login' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h4>Login to LMS</h4>
                    </div>
                    <div class="card-body">
                        
                        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                            <div class="alert alert-success">
                                Registration successful! Please login.
                            </div>
                        <?php endif; ?>

                        <?php if (isset($data['error'])): ?>
                            <div class="alert alert-danger">
                                <?= $data['error'] ?>
                            </div>
                        <?php endif; ?>

                        <form action="/LMS_Project/public/auth/authenticate" method="POST">
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">Login</button>
                                <a href="/LMS_Project/public/auth/register" class="btn btn-outline-secondary">Create new account</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>