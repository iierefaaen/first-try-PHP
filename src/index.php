<?php

session_start();

require_once("helper/functions.php");

// jika tidak ada session == belum login
if ( !isset($_SESSION["login"]) ){
    // WARNING : don't add white space after Location, or will be error
    header('Location: login.php');
    exit;
}


// !check_role => user
// used for admin page
if ( !check_role() ) {
    header("Location: students.php");
    exit;
}


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
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .border-left-primary {
            border-left: .25rem solid #4e73df !important;
        }
        .border-left-success {
            border-left: .25rem solid #1cc88a !important;
        }
        .border-left-info {
            border-left: .25rem solid #36b9cc !important;
        }
        .border-left-warning {
            border-left: .25rem solid #f6c23e !important;
        }
        .text-gray-800 {
            color: #5a5c69 !important;
        }
        .text-gray-300 {
            color: #dddfeb !important;
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

    <?php include_once("helper/admin-navbar.php"); ?>

    <div class="content m-5">

        <!-- STATISTIK -->
         <!-- Start 3 row -->
        <div class="container mt-2">
            <div class="row g-3 mb-3">

                <div class="col-md-4">
                    <div class="card shadow-sm border-left-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="fs-5 fw-bold text-primary text-uppercase">Total Mahasiswa : <?= $total ?>
                                </div>
                                <i class="bi bi-mortarboard-fill fs-1 text-primary"></i>
                            </div>

                                <?php foreach ($gender_result as $g): ?>
                                <div class="d-flex justify-content-between align-items-center h6 fw-bold mb-1 text-gray-800">
                                    <div><?= $g["jenis_kelamin"] === 'Laki-laki' ? 'Laki-laki' : 'Perempuan'; ?>
                                    </div>
                                    <div class="badge rounded-pill bg-info text-white px-2 py-1"><?= $g['total'] ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>

                        </div>
                    </div>
                </div>
     
                <div class="col-md-4">
                    <div class="card shadow-sm border-left-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="fs-5 fw-bold text-success text-uppercase mb-1">Mahasiswa per Jenjang</div>
                                <i class="bi bi-award-fill fs-1 text-success"></i>
                            </div>

                            <?php foreach ($jenjang_result as $jr): ?>
                                <div class="d-flex justify-content-between align-items-center h6 fw-bold mb-0 text-gray-800">
                                    <span><?= htmlspecialchars($jr['jenjang']) ?></span>
                                    <span class="mb-1 badge rounded-pill bg-success text-white px-2 py-1">
                                        <?= $jr['total'] ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
     
                <div class="col-md-4">
                    <div class="card shadow-sm border-left-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="fs-5 fw-bold text-warning text-uppercase mb-1">Status Keaktifan</div>
                                <i class="bi bi-activity fs-1 text-warning"></i>
                            </div>

                            <?php foreach ($status_result as $sr): ?>
                                <div class="d-flex justify-content-between align-items-center h6 fw-bold mb-0 text-gray-800">
                                    <span><?= ucfirst(htmlspecialchars($sr['status'])) ?></span>
                                    <span class="mb-1 badge bg-warning rounded-pill text-dark px-2 py-1">
                                        <?= $sr['total'] ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- End 3 row -->

        <!-- Mahasiswa per Jurusan -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-lg border-0 rounded-4 " style="background: linear-gradient(to right, #e3f2fd,rgb(70, 221, 241));">
                <div class="card-body">
                    <h6 class="card-title fs-5 mb-3 text-primary-emphasis">📚 Mahasiswa per Jurusan</h6>
                    <ul class="list-group list-group-flush fs-6">
                        
                    <?php foreach ($jurusan_result as $j): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0"
                            style="background-color: rgba(255, 255, 255, 0.75); transition: background-color 0.3s;">
                            <div>
                                <i class="bi bi-journal-code me-2 text-secondary"></i>
                                <strong><?= htmlspecialchars($j['jurusan']) ?></strong>
                            </div>
                            <span class="badge bg-info text-white rounded-pill px-3 py-2"><?= $j['total'] ?></span>
                        </li>
                    <?php endforeach; ?>

                    </ul>
                </div>
            </div>
        </div>

        <!-- BERDASAR ANGKATAN -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-lg border-0 rounded-4" style="background: linear-gradient(to right, #f1f8e9, #dcedc8);">
                <div class="card-body">
                    <h6 class="card-title fs-5 mb-3 text-success-emphasis">📅 Mahasiswa berdasarkan Angkatan</h6>
                    <ul class="list-group list-group-flush fs-6">

                    <?php foreach ($angkatan_result as $ar): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0"
                            style="background-color: rgba(255, 255, 255, 0.75); transition: background-color 0.3s;">
                            <div>
                                <i class="bi bi-easel-fill me-2 text-success"></i>
                                <strong>Angkatan <?= htmlspecialchars($ar['angkatan']) ?></strong>
                            </div>
                            <span class="badge bg-success text-white rounded-pill px-3 py-2"><?= $ar['total'] ?></span>
                        </li>
                    <?php endforeach; ?>

                    </ul>
                </div>
            </div>
        </div>

        

    </div> <!-- END STATISTIK -->   
</body>
</html>