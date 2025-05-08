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

$result = get_all_data(true);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            max-width: 600px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 20px auto;
            border: 3px solid #007bff;
        }
        .btn-group-custom {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<?php include_once("helper/admin-navbar.php"); ?>
    <div class="container-fluid content">
        <div class="mt-5">
            <div class="mb-4 col-12 d-flex justify-content-center">
                <a href="admin.php" class="btn btn-info d-inline-flex align-items-center gap-2 shadow-sm px-4 py-2 rounded-pill fw-semibold">
                <i class="bi bi-arrow-left-circle-fill fs-5 text-dark"></i>
                <span>Kembali</span>
                </a>
            </div>

            <div class="mb-4 p-3">
                <input type="text" class="border-success border-2 form-control w-100" id="keyword" placeholder="🔍 Cari mahasiswa berdasarkan Nama | NIM | Jurusan">
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
                            <div class="action-buttons d-flex justify-content-center gap-2">
                                <a href='recoverdetail.php?id=<?php echo $value["id"]; ?>' class='btn btn-info btn-sm'>🔍 Detail</a>
                                <a href='recoverdata.php?id=<?php echo $value["id"]; ?>' class='btn btn-warning btn-sm'>♻️ Pulihkan Data</a>
                                <a href='permanentdelete.php?id=<?php echo $value["id"]; ?>' class='btn btn-danger btn-sm'>🗑️ Hapus Permanen</a>
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
