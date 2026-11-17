<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include_once("config.php");

$error = "";

if (isset($_POST['register'])) {
    $nama             = trim($_POST['nama']);
    $username         = trim($_POST['username']);
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi form
    if (empty($nama) || empty($username) || empty($password) || empty($confirm_password)) {
        $error = "Semua kolom wajib diisi!";
    } elseif (strlen($username) < 3) {
        $error = "Username minimal harus 3 karakter!";
    } elseif (preg_match('/[^a-zA-Z0-9_]/', $username)) {
        $error = "Username hanya boleh huruf, angka, dan underscore (_)!";
    } elseif (strlen($password) < 5) {
        $error = "Password minimal harus 5 karakter!";
    } elseif ($password !== $confirm_password) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        $username_clean = mysqli_real_escape_string($mysqli, $username);
        $nama_clean     = mysqli_real_escape_string($mysqli, $nama);

        // Cek apakah username sudah dipakai
        $check_query = "SELECT id FROM users WHERE username = '$username_clean' LIMIT 1";
        $check_result = mysqli_query($mysqli, $check_query);

        if ($check_result && mysqli_num_rows($check_result) > 0) {
            $error = "Username '<strong>" . htmlspecialchars($username) . "</strong>' sudah terdaftar. Silakan gunakan username lain!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Simpan ke database
            $insert_query = "INSERT INTO users (nama, username, password) VALUES ('$nama_clean', '$username_clean', '$hashed_password')";
            $insert_result = mysqli_query($mysqli, $insert_query);

            if ($insert_result) {
                header("Location: login.php?status=registered");
                exit();
            } else {
                $error = "Gagal mendaftar: " . mysqli_error($mysqli);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SIM-RS Elektromedis</title>

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

        .register-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(40, 135, 255, 0.08), 0 5px 15px rgba(0, 0, 0, 0.04);
            background: var(--card-bg);
            overflow: hidden;
            width: 100%;
            max-width: 480px;
        }

        .brand-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #2887ff 0%, #1a73e8 100%);
            color: #ffffff;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            box-shadow: 0 8px 20px rgba(40, 135, 255, 0.3);
            margin-bottom: 0.75rem;
        }

        .form-control, .input-group-text {
            border-radius: 10px;
            padding: 0.65rem 1rem;
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
    </style>
</head>
<body>

    <div class="register-card p-4 p-md-5">
        <div class="text-center mb-4">
            <div class="brand-icon">
                <i class="ri-user-add-fill"></i>
            </div>
            <h4 class="fw-bold mb-1">Daftar Akun Baru</h4>
            <p class="text-muted small mb-0">Registrasi akun untuk akses SIM-RS Elektromedis</p>
        </div>

        <!-- Alert Error -->
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center py-2 px-3 mb-3 border-0 rounded-3 shadow-sm" role="alert">
                <i class="ri-error-warning-fill fs-5 me-2"></i>
                <div class="small"><?= $error ?></div>
                <button type="button" class="btn-close ms-auto p-2" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form action="register.php" method="post">
            <!-- Nama Lengkap -->
            <div class="mb-3">
                <label class="form-label fw-semibold small text-secondary">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ri-user-heart-line"></i></span>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Dr. Budi Santoso" value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '' ?>" required autofocus>
                </div>
            </div>

            <!-- Username -->
            <div class="mb-3">
                <label class="form-label fw-semibold small text-secondary">Username</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ri-user-line"></i></span>
                    <input type="text" name="username" class="form-control" placeholder="Hanya huruf/angka tanpa spasi" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" required>
                </div>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label fw-semibold small text-secondary">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ri-lock-line"></i></span>
                    <input type="password" name="password" id="passInput" class="form-control" placeholder="Minimal 5 karakter" required>
                    <button class="btn btn-outline-secondary border" type="button" id="togglePass">
                        <i class="ri-eye-line" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-4">
                <label class="form-label fw-semibold small text-secondary">Konfirmasi Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="ri-lock-check-line"></i></span>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password di atas" required>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="register" class="btn btn-primary w-100 mb-3 shadow-sm">
                <i class="ri-check-line me-1"></i> Buat Akun Sekarang
            </button>
        </form>

        <!-- Link to Login -->
        <div class="text-center pt-2 border-top">
            <span class="small text-muted">Sudah punya akun?</span>
            <a href="login.php" class="small fw-bold text-decoration-none text-primary ms-1">
                Masuk di sini
            </a>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePass = document.getElementById('togglePass');
        const passInput = document.getElementById('passInput');
        const toggleIcon = document.getElementById('toggleIcon');

        togglePass.addEventListener('click', function () {
            const type = passInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passInput.setAttribute('type', type);
            toggleIcon.classList.toggle('ri-eye-line');
            toggleIcon.classList.toggle('ri-eye-off-line');
        });
    </script>
</body>
</html>
