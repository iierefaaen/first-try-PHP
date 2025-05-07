<?php

session_start();
// jika tidak ada session == belum login
if ( !isset($_SESSION["login"]) ){
    // WARNING : don't add white space after Location, or will be error
    header('Location: login.php');
    exit;
}


require_once("helper/functions.php");

// check_role === true => role === admin
// redirect to admin page : index.php
// use this for user page only
if ( check_role() ) {
    header("Location: index.php");
    exit;
}



if ( $_SERVER["REQUEST_METHOD"] === "GET")
{
    if ( !isset($_GET["id"]) || empty($_GET['id']) ) {
        page_not_found("index.php", "Beranda");
        exit;
    }
    $id = $_GET["id"];
    $result = get_data_by_id($id);

    if ( !$result ) {
        data_not_found("index.php","Beranda");
        exit();
    }
    
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">
<?php include_once("helper/user-navbar.php"); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h3 class="mb-0">Detail Mahasiswa</h3>
                </div>
                <div class="card-body text-center">
                    <img src="uploads/img/<?php echo $result["foto"]; ?>" alt="Foto Mahasiswa" 
                         class="rounded-circle border border-primary border-3 shadow mb-3" 
                         style="width: 120px; height: 120px; object-fit: cover;">
                    <h4><?= htmlspecialchars($result['nama']); ?></h4>
                    <p class="mb-4"><?= htmlspecialchars($result['nim']); ?> - <?= htmlspecialchars($result['jurusan']); ?></p>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td><?= ($result["jenis_kelamin"] === "P") ? "Perempuan" : "Laki-laki"; ?></td>
                        </tr>
                        <tr>
                            <th>Angkatan</th>
                            <td><?= htmlspecialchars($result['angkatan']); ?></td>
                        </tr>
                        <tr>
                            <th>Jenjang</th>
                            <td><?= htmlspecialchars($result['jenjang']); ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><?= strtoupper($result['status']); ?></td>
                        </tr>
                    </table>

                    <div class="mb-4 col-12 d-flex justify-content-center">
                        <a href="students.php" class="btn btn-info d-inline-flex align-items-center gap-2 shadow-sm px-4 py-2 rounded-pill fw-semibold">
                        <i class="bi bi-arrow-left-circle-fill fs-5 text-dark"></i>
                        <span>Kembali</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
