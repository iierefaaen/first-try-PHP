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


if ( $_SERVER["REQUEST_METHOD"] == "GET")
{
    if ( !isset($_GET['id']) || empty($_GET['id']) ) {
        page_not_found("recover.php", "Menu Admin");
        exit;
    }
    
    $id = $_GET['id'];
    $result = get_data_by_id($id, true);
    
    // Jika data tidak ditemukan
    if (!$result) {
        data_not_found("recover.php", "Menu Admin");
        exit;
    }
    
    // Jika user menekan tombol recover
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        $recover = recover_data( $id );
        if ($recover === 1) {
            alert_popup('Berhasil','Data berhasil dipulihkan','success', "success", "recover.php");
            exit;
        } else {
            alert_popup("Gagal","Data gagal dipulihkan","danger", "danger","recover.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recover Data Mahasiswa</title>
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
<?php include_once("helper/admin-navbar.php"); ?>
<div class="container">
    <div class="card">
        <div class="card-header text-center bg-warning text-white">
            <h3>Konfirmasi Pemulihan Data</h3>
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
                <a href="recover.php" class="btn btn-secondary">🔙 Batal</a>
                <a href="recoverdata.php?id=<?= $result['id']; ?>&confirm=yes" class="btn btn-warning">♻️ Ya, Pulihkan Data</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
