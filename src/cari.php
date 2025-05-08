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


$result = get_all_data(false);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>Cari Data Mahasiswa</title>
    <style>
        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>
</head>
<body class="bg-light">
<?php include_once("helper/admin-navbar.php"); ?>
    <div class="container py-4">
        <div class="col-12 d-flex justify-content-center">
            <a href="index.php" class="btn btn-info d-inline-flex align-items-center gap-2 shadow-sm px-4 py-2 rounded-pill fw-semibold">
            <i class="bi bi-arrow-left-circle-fill fs-5 text-dark"></i>
            <span>Kembali</span>
            </a>
        </div>
        <h2 class="mb-4">📋 Data Mahasiswa</h2>

        <div class="card mb-4 p-3 border-primary" style="background: linear-gradient(to right,rgba(240, 251, 252, 0.99), rgba(15, 215, 255, 0.99));">
            <label for="keyword" class="form-label fw-semibold text-primary">Cari Mahasiswa</label>
            <div class="input-group">
                <span class="input-group-text bg-primary text-white" id="search-icon">🔍</span>
                <input type="text" class="form-control border-primary" id="keyword"
                    placeholder="Nama | NIM | Jurusan"
                    aria-label="Cari Mahasiswa"
                    aria-describedby="search-icon">
            </div>
        </div>



        <div class="table-responsive" id="table-container">
            <table class="table table-bordered table-striped align-middle">
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
                        <td><?= $counter++; ?></td>
                        <td><?= $value["nim"]; ?></td>
                        <td><?= $value["nama"]; ?></td>
                        <td><?= $value["jurusan"]; ?></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href='detail.php?id=<?= $value["id"]; ?>' class='btn btn-info btn-sm'>🔍 Detail</a>
                                <a href='edit.php?id=<?= $value["id"]; ?>' class='btn btn-warning btn-sm'>✏️ Edit</a>
                                <a href='delete.php?id=<?= $value["id"]; ?>' class='btn btn-danger btn-sm'>🗑️ Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

<script src="js/script.js"></script>
</body>
</html>
