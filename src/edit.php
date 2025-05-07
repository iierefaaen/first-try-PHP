<?php

session_start();
require_once("helper/functions.php");

// jika tidak ada session == belum login
if ( !isset($_SESSION["login"]) ){
    // WARNING : don't add white space after Location, or will be error
    header('Location: login.php');
    exit;
}

// !check_role => user
// used for admin page
if ( !check_role() ) {
    header("Location: students.php");
    exit;
}


if ( $_SERVER["REQUEST_METHOD"] == "GET") {
    if ( !isset($_GET["id"] ) || empty($_GET['id']) ) {
        page_not_found("index.php", "Beranda");
        exit;
    }


    $id = $_GET["id"];
    $result = get_data_by_id($id);
    if ( !$result) {
        data_not_found("index.php", "Beranda");
        exit;
    }
}




if ( $_SERVER["REQUEST_METHOD"] === "POST") 
{
    if (isset($_POST["update"])) {
        $result = get_data_by_id($_GET["id"]);
        $foto = $result["foto"];

        // no photo uploaded
        // use existing
        if($_FILES["foto"]["error"] === 4)
        {
            $ret = update_data($_GET["id"],$_POST, null);
            if ($ret > 0) {
                alert_popup("Berhasil", "Data berhasil diperbarui", "success", "success", "index.php");
            } else if ($ret == 0) {
                alert_popup("Peringatan", "Data tidak ada yang diubah", "warning", "warning","index.php");
            } else {
                alert_popup("Gagal", "Data gagal diperbarui", "danger", "danger", "index.php");
            }
        }
        
        // new image uploaded
        // handle image
        if ($_FILES["foto"]["error"] === 0) {
            $photo = upload_image( $_FILES["foto"] );
            if ($photo) {
                $ret = update_data($_GET["id"], $_POST, $photo);
                if ($ret > 0) {
                    alert_popup("Berhasil", "Data berhasil diperbarui", "success", "success", "index.php");
                } else if ($ret == 0) {
                    alert_popup("Peringatan", "Data tidak ada yang diubah", "warning", "warning", "index.php");
                } else {
                    alert_popup("Gagal", "Data gagal diperbarui", "danger", "danger", "index.php");
                }
            }
        }
    }  
}

?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }
        .profile-img {
            display: block;
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin: auto;
            border: 3px solid #ddd;
        }
    </style>
</head>
<body>
<?php include_once("helper/admin-navbar.php"); ?>
<div class="container mt-5">
    <div class="card">
        <h3 class="text-center">Edit Data Mahasiswa</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $result["id"] ?>">
            <input type="hidden" name="old-foto" value="<?= $result["foto"] ?>">

            <!-- Foto Profil -->
            <div class="text-center">
                <img src="uploads/img/<?= $result["foto"]; ?>" class="profile-img mb-3" id="previewImg">
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $result["nama"] ?>" required>
            </div>
            <div class="mb-3">
                <label for="nim" class="form-label">Nim</label>
                <input type="text" class="form-control" id="nim" name="nim" value="<?= $result["nim"] ?>" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $result["alamat"] ?>" required>
            </div>

            <div class="mb-3">
                <label for="kota" class="form-label">Kota</label>
                <input type="text" class="form-control" id="kota" name="kota" value="<?= $result["kota"] ?>" required>
            </div>
            <div class="mb-3">
                <label for="provinsi" class="form-label">Provinsi</label>
                <input type="text" class="form-control" id="provinsi" name="provinsi" value="<?= $result["provinsi"] ?>" required>
            </div>

            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" value="<?= $result["telepon"] ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $result["email"] ?>" required>
            </div>

            <div class="mb-3">
                <label for="jurusan" class="form-label">Jurusan</label>
                <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?= $result["jurusan"] ?>" required>
            </div>

            <div class="mb-3">
                <label for="angkatan" class="form-label">Angkatan</label>
                <input type="number" class="form-control" id="angkatan" name="angkatan" value="<?= $result["angkatan"] ?>" required>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-laki" <?= $result['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="Perempuan" <?= $result['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $result["tanggal_lahir"] ?>" required>
            </div>

            <div class="mb-3">
                <label for="jenjang" class="form-label">Jenjang</label>
                <select name="jenjang" class="form-select" required>
                <option value="D1" <?= $result['jenjang'] == 'D1' ? 'selected' : '' ?>>D1</option>
                    <option value="D3" <?= $result['jenjang'] == 'D3' ? 'selected' : '' ?>>D3</option>
                    <option value="D4" <?= $result['jenjang'] == 'D4' ? 'selected' : '' ?>>D4</option>
                    <option value="S1" <?= $result['jenjang'] == 'S1' ? 'selected' : '' ?>>S1</option>
                </select>
            </div>
            <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="aktif" <?= $result['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="cuti" <?= $result['status'] == 'cuti' ? 'selected' : '' ?>>Cuti</option>
                <option value="lulus" <?= $result['status'] == 'lulus' ? 'selected' : '' ?>>Lulus</option>
                <option value="drop-out" <?= $result['status'] == 'drop-out' ? 'selected' : '' ?>>Drop Out</option>
            </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Profil</label>
                <input type="file" class="form-control" name="foto" id="fotoInput">
            </div>

            <button name="update" type="submit" class="btn btn-primary w-100">Update Data</button>
            <a href="javascript:history.back()" class="btn btn-secondary w-100 mt-2">Batal</a>
        </form>
    </div>
</div>

<script>
    document.getElementById('fotoInput').addEventListener('change', function(event) {
        let reader = new FileReader();
        reader.onload = function(){
            document.getElementById('previewImg').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    });
</script>

</body>
</html>
