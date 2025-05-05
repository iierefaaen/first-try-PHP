<?php

session_start();

require_once("helper/functions.php");

// jika tidak ada session == belum login
if ( !isset($_SESSION["login"]) ){
    // WARNING : don't add white space after Location, or will be error
    header('Location: login.php');
    exit;
}


$result = show_data();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container-fluid min-vh-100 py-5">
        <div class="w-100 px-3">
            <h2 class="text-center mb-4">📋 Data Mahasiswa</h2>
            <div class="mb-1 p-1 bg-info mb-3">
                    <input type="text" class="ps-4 border-2 border-bottom border-info form-control" id="keyword" placeholder="🔍 Cari mahasiswa berdasarkan Nama | NIM | Jurusan" autofocus>
            </div>

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
                        <?php $counter = 1; foreach ($result as $value): ?>
                        <tr>
                            <td><?= $counter++; ?></td>
                            <td><?= htmlspecialchars($value["nim"]); ?></td>
                            <td><?= htmlspecialchars($value["nama"]); ?></td>
                            <td><?= htmlspecialchars($value["jurusan"]); ?></td>
                            <td class="text-center">
                                <a href="students-detail.php?id=<?= $value["id"]; ?>" class="btn btn-info btn-sm">🔍 Detail</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script src="js/script2.js"></script>
</body>
</html>
