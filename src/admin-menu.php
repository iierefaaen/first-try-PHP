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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Utama Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
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
    <div class="row g-4">

        <div class="col-md-5 mb-4">
            <a href="admin-registration.php" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body text-center">
                        <i class="bi bi-person-plus display-4 text-primary mb-3"></i>
                        <h5 class="card-title">Tambahkan Admin</h5>
                        <p class="card-text">Tambahkan user dengan role Admin.</p>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-12 d-flex justify-content-center">
            <a href="admin.php" class="btn btn-info d-inline-flex align-items-center gap-2 shadow-sm px-4 py-2 rounded-pill fw-semibold">
            <i class="bi bi-arrow-left-circle-fill fs-5 text-dark"></i>
            <span>Kembali</span>
            </a>
        </div>

        
        
    </div>
</div>


    
</body>
</html>