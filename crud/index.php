<?php
// Cek status autentikasi login
require_once("auth_check.php");

// include database connection file
include_once("config.php");

// Fetch all alat data from database
$result = mysqli_query($mysqli, "SELECT * FROM alat ORDER BY id DESC");
$total_alat = ($result) ? mysqli_num_rows($result) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Alat Elektromedis - SIM RS</title>

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

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 10px;
            padding: 0.6rem 1.25rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .table th {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            font-weight: 700;
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            padding: 1rem;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-hover tbody tr:hover {
            background-color: #f8faff;
        }

        .badge-year {
            background-color: #eff6ff;
            color: var(--primary-color);
            border: 1px solid #bfdbfe;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.35rem 0.65rem;
            display: inline-block;
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
                        <a class="nav-link active" href="index.php">
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
        <!-- Header Banner -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h4 class="fw-bold mb-1">Data Alat Elektromedis</h4>
                <p class="text-muted mb-0">Kelola inventaris dan pemantauan alat medis rumah sakit</p>
            </div>
            <a href="add.php" class="btn btn-primary d-flex align-items-center gap-1 shadow-sm">
                <i class="ri-add-line fs-5"></i>
                <span>Tambah Alat Baru</span>
            </a>
        </div>

        <!-- Table Card -->
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="ri-list-settings-line text-primary fs-5"></i>
                    <span class="fw-bold">Daftar Inventaris Alat</span>
                </div>
                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">
                    Total: <?= $total_alat ?> Alat
                </span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 70px;">No</th>
                            <th>Nama Alat</th>
                            <th>Tahun</th>
                            <th>Merek</th>
                            <th>Lokasi</th>
                            <th class="text-center" style="width: 190px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                        if($result && mysqli_num_rows($result) > 0) {
                            $i = 1;
                            while($user_data = mysqli_fetch_array($result)) {         
                                echo "<tr>";
                                echo "<td class='text-center fw-bold text-muted'>".$i."</td>";
                                echo "<td><div class='fw-semibold text-dark'><i class='ri-stethoscope-line text-primary me-2'></i>".htmlspecialchars($user_data['nama_alat'])."</div></td>";
                                echo "<td><span class='badge-year'>".htmlspecialchars($user_data['tahun'])."</span></td>";
                                echo "<td><span class='text-secondary'><i class='ri-building-line me-1'></i>".htmlspecialchars($user_data['merek'])."</span></td>";    
                                echo "<td><span class='text-secondary'><i class='ri-map-pin-line text-danger me-1'></i>".htmlspecialchars($user_data['lokasi'])."</span></td>";    
                                echo "<td class='text-center'>";
                                echo "<div class='btn-group btn-group-sm' role='group'>";
                                echo "<a href='edit.php?id=".$user_data['id']."' class='btn btn-outline-primary' title='Edit Data'><i class='ri-edit-line me-1'></i>Edit</a>";
                                echo "<a href='delete.php?id=".$user_data['id']."' class='btn btn-outline-danger' onclick=\"return confirm('Yakin ingin menghapus data alat ".htmlspecialchars(addslashes($user_data['nama_alat']))."?')\" title='Hapus Data'><i class='ri-delete-bin-line me-1'></i>Hapus</a>";
                                echo "</div>";
                                echo "</td>";
                                echo "</tr>"; 
                                $i++;       
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center py-5 text-muted'>";
                            echo "<i class='ri-inbox-line fs-1 d-block mb-2 text-secondary opacity-50'></i>";
                            echo "<p class='mb-2'>Belum ada data alat yang tersimpan.</p>";
                            echo "<a href='add.php' class='btn btn-sm btn-primary rounded-pill px-3'><i class='ri-add-line me-1'></i>Tambah Sekarang</a>";
                            echo "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
