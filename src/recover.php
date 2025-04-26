<?php

session_start();

// jika tidak ada session == belum login
if ( !isset($_SESSION["login"]) ){
    // WARNING : don't add white space after Location, or will be error
    header('Location: login.php');
    exit;
}


require_once("helper/helper.php");

$result = get_all_data(true);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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

<div class="container content">
<div class="container mt-5">
            <!-- TODO : -->
            <?php // TODO : ?>
            <a href="cari.php" class="btn btn-outline-secondary mb-3 ms-2">🔍 Cari Mahasiswa</a>
            <?php // TODO ?>
            
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
                                <a href='recoverdata.php?id=<?php echo $value["id"]; ?>' class='btn btn-success btn-sm'>♻️ Pulihkan Data</a>
                                <a href='permanentdelete.php?id=<?php echo $value["id"]; ?>&confirm=yes' class='btn btn-danger btn-sm'>🗑️ Hapus Permanen</a>
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

</body>
</html>
