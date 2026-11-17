<?php
// Cek status autentikasi login
require_once("auth_check.php");

// include database connection file
include_once("config.php");

// Check if form is submitted for user update, then redirect to homepage after update
if(isset($_POST['update']))
{   
    $id        = intval($_POST['id']);
    $nama_alat = mysqli_real_escape_string($mysqli, $_POST['nama_alat']);
    $tahun     = mysqli_real_escape_string($mysqli, $_POST['tahun']);
    $merek     = mysqli_real_escape_string($mysqli, $_POST['merek']);
    $lokasi    = mysqli_real_escape_string($mysqli, $_POST['lokasi']);

    // update user data
    $result = mysqli_query($mysqli, "UPDATE alat SET nama_alat='$nama_alat', tahun='$tahun', merek='$merek', lokasi='$lokasi' WHERE id=$id");

    // Redirect to homepage to display updated user in list
    header("Location: index.php");
    exit();
}
?>
<?php
// Display selected user data based on id
// Getting id from url
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch user data based on id
$result = mysqli_query($mysqli, "SELECT * FROM alat WHERE id=$id");

$nama_alat = "";
$tahun     = "";
$merek     = "";
$lokasi    = "";

if($result && $user_data = mysqli_fetch_array($result))
{
    $nama_alat = $user_data['nama_alat'];
    $tahun     = $user_data['tahun'];
    $merek     = $user_data['merek'];
    $lokasi    = $user_data['lokasi'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Alat - SIM RS Elektromedis</title>
    
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
            background-color: var(--bg-color);
            color: var(--text-dark);
            min-height: 100vh;
        }

        .navbar {
            background-color: var(--primary-color) !important;
            box-shadow: 0 4px 15px rgba(40, 135, 255, 0.2);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: -0.3px;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background: var(--card-bg);
            overflow: hidden;
        }

        .card-header {
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.25rem 1.5rem;
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
            padding: 0.65rem 1.5rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-secondary, .btn-light {
            border-radius: 10px;
            padding: 0.65rem 1.25rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
                <i class="ri-heart-pulse-fill fs-4"></i>
                <span>SIM-RS Elektromedis</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="ri-dashboard-line me-1"></i> Data Alat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add.php">
                            <i class="ri-add-circle-line me-1"></i> Tambah Alat
                        </a>
                    </li>
                </ul>
                <!-- User Profile & Logout -->
                <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0 text-white">
                    <span class="small d-flex align-items-center bg-white bg-opacity-10 px-3 py-1 rounded-pill">
                        <i class="ri-user-smile-line me-1"></i> Halo, <b class="ms-1"><?= htmlspecialchars($_SESSION['nama'] ?? 'User') ?></b>
                    </span>
                    <a href="logout.php" class="btn btn-sm btn-outline-light rounded-pill px-3" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                        <i class="ri-logout-box-r-line me-1"></i> Keluar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">

                <!-- Navigation link -->
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <a href="index.php" class="btn btn-sm btn-light border text-secondary shadow-sm">
                        <i class="ri-arrow-left-line me-1"></i> Kembali ke Data Alat
                    </a>
                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2 rounded-pill">
                        Mode Edit Data
                    </span>
                </div>

                <!-- Form Card -->
                <div class="card">
                    <div class="card-header d-flex align-items-center gap-2">
                        <i class="ri-edit-2-fill text-warning fs-4"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">Edit Data Alat</h5>
                            <small class="text-muted">Perbarui informasi alat elektromedis</small>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form name="update_user" method="post" action="edit.php">
                            <!-- Hidden ID -->
                            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

                            <!-- Nama Alat -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Alat</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-stethoscope-line"></i></span>
                                    <input type="text" name="nama_alat" class="form-control" value="<?= htmlspecialchars($nama_alat) ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Tahun -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Tahun Pengadaan</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ri-calendar-line"></i></span>
                                        <input type="number" name="tahun" class="form-control" value="<?= htmlspecialchars($tahun) ?>" min="1990" max="2099" required>
                                    </div>
                                </div>

                                <!-- Merek -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Merek / Pabrikan</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ri-building-line"></i></span>
                                        <input type="text" name="merek" class="form-control" value="<?= htmlspecialchars($merek) ?>" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Lokasi -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Lokasi Ruangan</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-map-pin-line"></i></span>
                                    <input type="text" name="lokasi" class="form-control" value="<?= htmlspecialchars($lokasi) ?>" required>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2 pt-2">
                                <button type="submit" name="update" value="Update" class="btn btn-primary d-flex align-items-center gap-1">
                                    <i class="ri-save-line"></i>
                                    <span>Simpan Perubahan</span>
                                </button>
                                <a href="index.php" class="btn btn-light border d-flex align-items-center gap-1">
                                    <i class="ri-close-line"></i>
                                    <span>Batal</span>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
