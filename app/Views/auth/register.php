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

        <h2 class="panel-headline">Bắt đầu hành trình<br><span>học tập của bạn.</span></h2>
        <p class="panel-sub">Tham gia cùng hàng nghìn học viên đang học tập mỗi ngày trên nền tảng của chúng tôi.</p>

        <ul class="feature-list">
            <li>
                <div class="feat-icon"><i class="fas fa-user-graduate"></i></div>
                Đăng ký hoàn toàn miễn phí
            </li>
            <li>
                <div class="feat-icon"><i class="fas fa-infinity"></i></div>
                Truy cập không giới hạn sau khi đăng ký khoá học
            </li>
            <li>
                <div class="feat-icon"><i class="fas fa-mobile-alt"></i></div>
                Học mọi lúc, mọi nơi trên mọi thiết bị
            </li>
            <li>
                <div class="feat-icon"><i class="fas fa-shield-halved"></i></div>
                Bảo mật tài khoản tuyệt đối
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
            <p class="form-eyebrow">Get started</p>
            <h1 class="form-title">Tạo tài khoản</h1>
            <p class="form-subtitle">
                Đã có tài khoản?
                <a href="<?= BASE_URL ?>/auth/login">Đăng nhập ngay</a>
            </p>

            <?php if (isset($data['error'])): ?>
                <div class="auth-alert danger">
                    <i class="fas fa-circle-exclamation"></i>
                    <?= htmlspecialchars($data['error']) ?>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/auth/store" method="POST">
                <div class="field-group">
                    <label class="field-label" for="fullname">Họ và tên</label>
                    <div class="field-wrap">
                        <i class="fas fa-user field-icon"></i>
                        <input
                            type="text"
                            name="fullname"
                            id="fullname"
                            placeholder="Nguyễn Văn A"
                            value="<?= isset($data['fullname']) ? htmlspecialchars($data['fullname']) : '' ?>"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label" for="email">Email</label>
                    <div class="field-wrap">
                        <i class="fas fa-envelope field-icon"></i>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="you@example.com"
                            value="<?= isset($data['email']) ? htmlspecialchars($data['email']) : '' ?>"
                            required
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
                            placeholder="Tối thiểu 6 ký tự"
                            required
                            autocomplete="new-password"
                        >
                        <button type="button" class="toggle-pw" onclick="togglePassword('password', this)" tabindex="-1" aria-label="Show/hide password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <p class="password-hint"><i class="fas fa-circle-info me-1"></i>Tối thiểu 6 ký tự</p>
                </div>

                <button type="submit" class="btn-auth" style="margin-top: 8px;">
                    <i class="fas fa-user-plus"></i>Tạo tài khoản
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
