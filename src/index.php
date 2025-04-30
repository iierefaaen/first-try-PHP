<?php

session_start();

require_once("helper/functions.php");

// jika tidak ada session == belum login
if ( !isset($_SESSION["login"]) ){
    // WARNING : don't add white space after Location, or will be error
    header('Location: login.php');
    exit;
}


// insert_data_dummy();


$total = hitung_jumlah_siswa();
$jurusan_result = hitung_jumlah_siswa_per_jurusan();
$gender_result = hitung_jumlah_siswa_per_gender();
$jenjang_result = hitung_jumlah_mahasiswa_berdasar_jenjang();
$status_result = hitung_jumlah_mahasiswa_berdasar_status();
$angkatan_result = hitung_jumlah_mahasiswa_berdasar_angkatan();

// TODO :
// // cek cookie
// if ( isset($_COOKIE["login"]) ) {
//     if ($_COOKIE["login"] === "true") {
//         $_SESSION["logim"] = true;
//     }
// }

$result = show_data();

?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #212529;
            color: white;
            position: fixed;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            padding: 12px;
            display: block;
            text-decoration: none;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: #343a40;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .content {
                margin-left: 0;
                padding: 10px;
            }
            .table-responsive {
                width: 100%;
                overflow-x: auto;
            }
            .table thead {
                display: none;
            }
            .table tbody, .table tr, .table td {
                display: block;
                width: 100%;
            }
            .table tr {
                margin-bottom: 15px;
                border-bottom: 2px solid #ddd;
                padding-bottom: 10px;
            }
            .table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }
            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                font-weight: bold;
                text-align: left;
            }
            .action-buttons {
                display: flex;
                justify-content: center;
                gap: 5px;
            }
        }
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center">📌 Manajemen Mahasiswa</h4>
        <a href="#">🏠 Dashboard</a>
        <a href="#">📋 Data Mahasiswa</a>
        <a href="#">⚙️ Pengaturan</a>
        <a href="logout.php">🚪 Logout</a>
    </div>
    
    
    
    <div class="content">
        <div class="container mt-3 mb-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body text-center py-5">
                            <h4 class="card-title mb-4 text-primary">Panel Admin</h4>
                            <p class="card-text mb-4">Akses pengelolaan data, manajemen user, dan fitur admin lainnya.</p>
                            <a href="admin.php" class="btn btn-primary px-4 py-2">
                                <i class="bi bi-speedometer2 me-2"></i> Menu Admin
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STATISTIK -->
        <div class="row">
            <!-- Total Mahasiswa -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg border-0 rounded-4 text-white" style="background: linear-gradient(135deg, #42a5f5, #1e88e5);">
                    <div class="card-body d-flex flex-column justify-content-center text-center">
                        <h6 class="card-title fs-5 mb-3">👨‍🎓 Total Mahasiswa</h6>
                        <p class="fs-1 fw-bold mb-0"><?= $total ?></p>
                    </div>
                </div>
            </div>

            <!-- Mahasiswa per Jenis Kelamin -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg border-0 rounded-4" style="background-color: #fce4ec;">
                    <div class="card-body">
                        <h6 class="card-title fs-5 mb-3 text-danger-emphasis">🚻 Mahasiswa per Jenis Kelamin</h6>
                        <ul class="list-group list-group-flush fs-6">
                        <?php foreach ($gender_result as $g): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0"
                                style="background-color: transparent;">
                                <strong><?= $g['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></strong>
                                <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill px-3 py-2"><?= $g['total'] ?></span>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Mahasiswa per Jurusan -->
            <div class="col-md-12 mb-4">
                <div class="card shadow-lg border-0 rounded-4" style="background-color: #e8f5e9;">
                    <div class="card-body">
                        <h6 class="card-title fs-5 mb-3 text-success-emphasis">📚 Mahasiswa per Jurusan</h6>
                        <ul class="list-group list-group-flush fs-6">
                        <?php foreach ($jurusan_result as $j): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0"
                                style="background-color: transparent;">
                                <strong><?= htmlspecialchars($j['jurusan']) ?></strong>
                                <span class="badge bg-success-subtle text-success-emphasis rounded-pill px-3 py-2"><?= $j['total'] ?></span>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            
            <!-- BERDASAR JENJANG -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg border-0 rounded-4" style="background-color: #f1f8e9;">
                    <div class="card-body">
                        <h6 class="card-title fs-5 mb-3 text-success-emphasis">🎓 Mahasiswa per Jenjang</h6>
                        <ul class="list-group list-group-flush fs-6">
                        <?php foreach ($jenjang_result as $jr): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0"
                                style="background-color: transparent;">
                                <strong><?= htmlspecialchars($jr['jenjang']) ?></strong>
                                <span class="badge bg-success-subtle text-success-emphasis rounded-pill px-3 py-2"><?= $jr['total'] ?></span>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- BERDASAR KEAKTIFAN -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg border-0 rounded-4" style="background-color: #fff3e0;">
                    <div class="card-body">
                        <h6 class="card-title fs-5 mb-3 text-warning-emphasis">📊 Mahasiswa berdasarkan Status Keaktifan</h6>
                        <ul class="list-group list-group-flush fs-6">
                        <?php foreach ($status_result as $sr): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0"
                                style="background-color: transparent;">
                                <strong><?= ucfirst(htmlspecialchars($sr['status'])) ?></strong>
                                <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-2"><?= $sr['total'] ?></span>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- BERDASAR ANGKATAN -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg border-0 rounded-4" style="background-color: #e3f2fd;">
                    <div class="card-body">
                        <h6 class="card-title fs-5 mb-3 text-primary-emphasis">📅 Mahasiswa berdasarkan Angkatan</h6>
                        <ul class="list-group list-group-flush fs-6">
                        <?php foreach ($angkatan_result as $ar): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0"
                                style="background-color: transparent;">
                                <strong>Angkatan <?= htmlspecialchars($ar['angkatan']) ?></strong>
                                <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill px-3 py-2"><?= $ar['total'] ?></span>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

        

        </div> <!-- END STATISTIK -->


        <div class="container mt-5">
            <h2 class="mb-4">📋 Data Mahasiswa</h2>
            <a href="add.php" class="btn btn-primary mb-3">➕ Tambah Mahasiswa</a>
            <a href="cari.php" class="btn btn-outline-secondary mb-3 ms-2">🔍 Cari Mahasiswa</a>
            
            <div class="table-responsive" id="table-container">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1;
                        foreach( $result as $key => $value ) {
                        ?>
                        <tr>
                            <td data-label="No"><?php echo $counter; $counter++; ?></td>
                            <td data-label="NIM"><?php echo $value["nim"]; ?></td>
                            <td data-label="Nama"><?php echo $value["nama"]; ?></td>
                            <td data-label="Jurusan"><?php echo $value["jurusan"]; ?></td>
                            <td data-label="Aksi">
                            <div class="action-buttons">
                                <a href='detail.php?id=<?php echo $value["id"]; ?>' class='btn btn-info btn-sm'>🔍 Detail</a>
                                <a href='edit.php?id=<?php echo $value["id"]; ?>' class='btn btn-warning btn-sm'>✏️ Edit</a>
                                <a href='delete.php?id=<?php echo $value["id"]; ?>' class='btn btn-danger btn-sm'>🗑️ Hapus</a>
                            </div>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <!--  -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
