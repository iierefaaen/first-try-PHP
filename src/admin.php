<?php
session_start();
// jika tidak ada session == belum login
if ( !isset($_SESSION["login"]) ){
    // WARNING : don't add white space after Location, or will be error
    header('Location: login.php');
    exit;
}

require_once("helper/functions.php");

// !check_role => user
// used for admin page
if ( !check_role() ) {
    header("Location: students.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Halaman Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    .card:hover {
        transform: translateY(-5px);
        transition: 0.2s ease-in-out;
        box-shadow: 0 0 15px rgba(0,0,0,0.15);
    }
</style>
</head>
<body>
<?php include_once("helper/admin-navbar.php"); ?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Panel Admin</h2>
    <div class="row justify-content-center g-4">
        
        <!-- Card Menu Admin -->
        <div class="col-md-5">
            <a href="admin-menu.php" class="text-decoration-none">
                <div class="card text-center shadow-sm border-0 rounded-4 h-100 hover-shadow">
                    <div class="card-body py-5">
                        <i class="bi bi-speedometer2 display-4 text-primary mb-3"></i>
                        <h5 class="card-title">Kelola Admin</h5>
                        <p class="card-text">Kelola admin, pengguna, dan fitur admin lainnya.</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card Pulihkan Data -->
        <div class="col-md-5">
            <a href="recover.php" class="text-decoration-none">
                <div class="card text-center shadow-sm border-0 rounded-4 h-100 hover-shadow">
                    <div class="card-body py-5">
                        <i class="bi bi-arrow-clockwise display-4 text-success mb-3"></i>
                        <h5 class="card-title">Kelola Data</h5>
                        <p class="card-text">Lihat, hapus, dan pulihkan data mahasiswa.</p>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-12 d-flex justify-content-center">
            <a href="index.php" class="btn btn-info d-inline-flex align-items-center gap-2 shadow-sm px-4 py-2 rounded-pill fw-semibold">
            <i class="bi bi-arrow-left-circle-fill fs-5 text-dark"></i>
            <span>Kembali</span>
            </a>
        </div>


    </div>
</div>


</body>
</html>
