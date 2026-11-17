<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include_once("config.php");

$error = "";
$success = "";
$info = "";

if (isset($_GET['status'])) {
    if ($_GET['status'] === 'logout') {
        $info = "Anda telah berhasil keluar (logout).";
    } elseif ($_GET['status'] === 'registered') {
        $success = "Pendaftaran berhasil! Silakan masuk menggunakan akun baru Anda.";
    }
}

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Silakan isi username dan password!";
    } else {
        $username_clean = mysqli_real_escape_string($mysqli, $username);
        $query = "SELECT * FROM users WHERE username = '$username_clean' LIMIT 1";
        $result = mysqli_query($mysqli, $query);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['nama']     = $user['nama'];
                $_SESSION['username'] = $user['username'];

                header("Location: index.php");
                exit();
            } else {
                $error = "Password yang Anda masukkan salah!";
            }
        } else {
            $error = "Username tidak terdaftar!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SIM-RS Elektromedis</title>

    <!-- Google Fonts: DM Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Remixicon Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2887ff;
            --primary-dark: #2476da;
            --bg-color: #f4f7fb;
            --card-bg: #ffffff;
            --text-dark: #1e293b;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(135deg, #eef4ff 0%, #f4f7fb 100%);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(40, 135, 255, 0.08), 0 5px 15px rgba(0, 0, 0, 0.04);
            background: var(--card-bg);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
        }

        .brand-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #2887ff 0%, #1a73e8 100%);
            color: #ffffff;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            box-shadow: 0 8px 20px rgba(40, 135, 255, 0.3);
            margin-bottom: 1rem;
        }

        .form-control, .input-group-text {
            border-radius: 10px;
            padding: 0.7rem 1rem;
            border: 1px solid #e2e8f0;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(40, 135, 255, 0.15);
        }

        .input-group-text {
            background-color: #f8fafc;
            color: #64748b;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(40, 135, 255, 0.25);
        }

        .demo-box {
            background-color: #eff6ff;
            border: 1px dashed #bfdbfe;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

    <div class="login-card p-4 p-md-5">
        <div class="text-center mb-4">
            <div class="brand-icon">
                <i class="ri-heart-pulse-fill"></i>
            </div>
            <h4 class="fw-bold mb-1">Selamat Datang</h4>
            <p class="text-muted small mb-0">Masuk ke Sistem Informasi Manajemen RS</p>
        </div>

        <!-- Alert messages -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center py-2 px-3 mb-3 border-0 rounded-3 shadow-sm" role="alert">
                <i class="ri-error-warning-fill fs-5 me-2"></i>
                <div class="small"><?= htmlspecialchars($error) ?></div>
                <button type="button" class="btn-close ms-auto p-2" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center py-2 px-3 mb-3 border-0 rounded-3 shadow-sm" role="alert">
                <i class="ri-checkbox-circle-fill fs-5 me-2"></i>
                <div class="small"><?= htmlspecialchars($success) ?></div>
                <button type="button" class="btn-close ms-auto p-2" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($info)): ?>
            <div class="alert alert-info alert-dismissible fade show d-flex align-items-center py-2 px-3 mb-3 border-0 rounded-3 shadow-sm" role="alert">
                <i class="ri-information-fill fs-5 me-2"></i>
                <div class="small"><?= htmlspecialchars($info) ?></div>
                <button type="button" class="btn-close ms-auto p-2" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form action="login.php" method="post">
            <!-- Username -->
            <div class="mb-3">
                <label class="form-label fw-semibold small text-secondary">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ri-user-line"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" required autofocus>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label fw-semibold small text-secondary">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ri-lock-line"></i></span>
                    <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Masukkan password" required>
                    <button class="btn btn-outline-secondary border" type="button" id="togglePassword">
                        <i class="ri-eye-line" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="login" class="btn btn-primary w-100 mb-3 shadow-sm">
                <i class="ri-login-box-line me-1"></i> Masuk Sekarang
            </button>
        </form>

        <!-- Link to Register -->
        <div class="text-center pt-2 border-top">
            <span class="small text-muted">Belum memiliki akun?</span>
            <a href="register.php" class="small fw-bold text-decoration-none text-primary ms-1">
                Daftar Akun Baru
            </a>
        </div>

        <!-- Demo Credentials -->
        <div class="demo-box mt-3 text-center text-muted">
            <i class="ri-key-2-line me-1 text-primary"></i>
            <span>Akun Default: <strong>admin</strong> | Password: <strong>admin123</strong></span>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');
        const toggleIcon = document.getElementById('toggleIcon');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            toggleIcon.classList.toggle('ri-eye-line');
            toggleIcon.classList.toggle('ri-eye-off-line');
        });
    </script>
</body>
</html>
