<?php require_once '../app/Views/inc/auth_header.php'; ?>

<div class="auth-wrapper">

    <!-- ── Left: Branding panel ─────────────────────── -->
    <div class="auth-panel-left">
        <div class="brand-logo">
            <div class="icon-wrap"><i class="fas fa-graduation-cap"></i></div>
            <div class="brand-name">
                LMS PLATFORM
                <small>E-Learning System</small>
            </div>
        </div>

        <h2 class="panel-headline">Học không có<br><span>giới hạn.</span></h2>
        <p class="panel-sub">Nền tảng học tập trực tuyến toàn diện — khoá học, bài tập, quiz và hơn thế nữa.</p>

        <ul class="feature-list">
            <li>
                <div class="feat-icon"><i class="fas fa-book-open"></i></div>
                Truy cập hàng trăm khoá học chất lượng cao
            </li>
            <li>
                <div class="feat-icon"><i class="fas fa-tasks"></i></div>
                Theo dõi tiến độ học tập theo thời gian thực
            </li>
            <li>
                <div class="feat-icon"><i class="fas fa-comments"></i></div>
                Tương tác trực tiếp với giảng viên
            </li>
            <li>
                <div class="feat-icon"><i class="fas fa-certificate"></i></div>
                Nhận chứng chỉ sau khi hoàn thành khoá học
            </li>
        </ul>

        <p class="panel-copy">&copy; <?= date('Y') ?> LMS Platform. All rights reserved.</p>
    </div>

    <!-- ── Right: Form panel ─────────────────────────── -->
    <div class="auth-panel-right">

        <!-- Mobile only: compact brand header -->
        <div class="mobile-brand-header">
            <div class="mob-icon"><i class="fas fa-graduation-cap"></i></div>
            <div class="mob-name">LMS PLATFORM</div>
            <div class="mob-tagline">E-Learning System</div>
        </div>

        <div class="auth-form-box">
            <p class="form-eyebrow">Welcome back</p>
            <h1 class="form-title">Đăng nhập</h1>
            <p class="form-subtitle">
                Chưa có tài khoản?
                <a href="<?= BASE_URL ?>/auth/register">Đăng ký miễn phí</a>
            </p>

            <?php $__flash = flash_get(); if ($__flash && $__flash['type'] === 'success'): ?>
                <div class="auth-alert success">
                    <i class="fas fa-circle-check"></i>
                    <?= e($__flash['message']) ?>
                </div>
            <?php endif; ?>

            <?php if (isset($data['error'])): ?>
                <div class="auth-alert danger">
                    <i class="fas fa-circle-exclamation"></i>
                    <?= htmlspecialchars($data['error']) ?>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/auth/authenticate" method="POST">
                <div class="field-group">
                    <label class="field-label" for="email">Email</label>
                    <div class="field-wrap">
                        <i class="fas fa-envelope field-icon"></i>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="you@example.com"
                            value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                            class="<?= isset($data['error']) ? 'is-invalid' : '' ?>"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label" for="password">Mật khẩu</label>
                    <div class="field-wrap">
                        <i class="fas fa-lock field-icon"></i>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="••••••••"
                            class="<?= isset($data['error']) ? 'is-invalid' : '' ?>"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="toggle-pw" onclick="togglePassword('password', this)" tabindex="-1" aria-label="Show/hide password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-meta">
                    <label>
                        <input class="form-check-input me-1" type="checkbox" name="remember"> Ghi nhớ đăng nhập
                    </label>
                </div>

                <button type="submit" class="btn-auth">
                    <i class="fas fa-arrow-right-to-bracket"></i>Đăng nhập
                </button>
            </form>

            <div class="auth-divider">hoặc</div>

            <div class="back-home">
                <a href="<?= BASE_URL ?>/home/index">
                    <i class="fas fa-arrow-left"></i> Quay về trang chủ
                </a>
            </div>
        </div>
    </div>

</div>

<?php require_once '../app/Views/inc/auth_footer.php'; ?>
