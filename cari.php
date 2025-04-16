<?php

session_start();

require_once("helper/helper.php");

// jika tidak ada session == belum login
if ( !isset($_SESSION["login"]) ){
    echo "
    <script>
    window.location.href = 'login.php';
    </script>
    ";
    exit;
}

$result = tampilkan();
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Mahasiswa</title>
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
        <a href="index.php">🏠 Dashboard</a>
        <a href="#">📋 Data Mahasiswa</a>
        <a href="#">⚙️ Pengaturan</a>
        <a href="logout.php">🚪 Logout</a>
    </div>

    <div class="content">
        <div class="container">
            <h2 class="mb-4">📋 Data Mahasiswa</h2>
            <a href="index.php" class="mb-4">
                <button type="button" class="btn btn-info mb-2">← Kembali Ke Dashboard</button>
            </a>
            
            <div class="card p-3 mb-4">
                <input id="keyword" type="text" name="keyword" class="form-control" placeholder="🔍 Cari mahasiswa berdasarkan Nama | NIM | Jurusan">
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
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>



<script src="js/script.js"></script>
</body>
</html>
