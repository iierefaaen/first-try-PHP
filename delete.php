<?php

session_start();

// jika tidak ada session == belum login
if ( !isset($_SESSION["login"]) ){
    // WARNING : don't add white space after Location, or will be error
    header('Location: login.php');
    exit;
}


require_once("helper/helper.php");


// TODO

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$result = detail($id);

// Jika data tidak ditemukan
if (!$result) {
    echo '
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Data Tidak Ditemukan</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="d-flex justify-content-center align-items-center vh-100 bg-light" style="font-family: Poppins, sans-serif;">
        <div class="container text-center">
            <div class="p-4 bg-white shadow-lg rounded mx-auto" style="max-width: 450px;">
                <div class="text-danger mb-3 display-1">🚫</div>
                <h2 class="text-dark fw-bold">DATA TIDAK DITEMUKAN</h2>
                <p class="text-secondary">Oops! Data yang Anda cari tidak tersedia atau mungkin telah dihapus.</p>
                <a href="index.php" class="btn btn-primary fw-bold">🔙 Kembali ke Beranda</a>
            </div>
        </div>
    </body>
    </html>';
    exit();
}

// Jika user sudah konfirmasi hapus
if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    $del = delete($id);
    if ($del > 0) {
        echo "<script>alert('Sukses menghapus data!'); window.location.href ='index.php';</script>";
        // header("Location: index.php?msg=deleted");
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location='index.php';</script>";
    }
    exit();
}
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

<div class="container">
    <div class="card">
        <div class="card-header text-center bg-danger text-white">
            <h3>Konfirmasi Hapus Data</h3>
        </div>
        <div class="card-body text-center">
            <img src="uploads/img/<?php echo htmlspecialchars($result["foto"]); ?>" alt="Foto Mahasiswa" class="profile-pic">
            <h4><?= htmlspecialchars($result['nama']); ?></h4>
            <p><?= htmlspecialchars($result['nim']); ?> - <?= htmlspecialchars($result['jurusan']); ?></p>
        </div>
        <div class="card-body">
            <table class="table">
                <tr><th>Jenis Kelamin</th><td><?php echo ($result["jenis_kelamin"] === "P") ? "Perempuan" : "Laki-laki"; ?></td></tr>
                <tr><th>Tanggal Lahir</th><td><?= htmlspecialchars($result['tanggal_lahir']); ?></td></tr>
                <tr><th>Alamat</th><td><?= htmlspecialchars($result['alamat']); ?></td></tr>
                <tr><th>Kota</th><td><?= htmlspecialchars($result['kota']); ?></td></tr>
                <tr><th>Provinsi</th><td><?= htmlspecialchars($result['provinsi']); ?></td></tr>
                <tr><th>Angkatan</th><td><?= htmlspecialchars($result['angkatan']); ?></td></tr>
                <tr><th>Jenjang</th><td><?= htmlspecialchars($result['jenjang']); ?></td></tr>
                <tr><th>Status</th><td><?= strtoupper(htmlspecialchars($result['status'])); ?></td></tr>
                <tr><th>Email</th><td><?= htmlspecialchars($result['email']); ?></td></tr>
                <tr><th>No HP</th><td><?= htmlspecialchars($result['telepon']); ?></td></tr>
            </table>

            <div class="btn-group-custom">
                <a href="index.php" class="btn btn-secondary">🔙 Batal</a>
                <a href="delete.php?id=<?= $result['id']; ?>&confirm=yes" class="btn btn-danger">🗑️ Ya, Hapus Sekarang</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
