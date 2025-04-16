<?php

session_start();

// jika tidak ada session == belum login
if ( !isset($_SESSION["login"]) ){
    echo "
    <script>
    window.location.href = 'login.php';
    </script>
    ";
    exit;
}

require_once("helper/helper.php");

$id = $_GET["id"];

// if ( !$id ) {
//     echo 'TIDAK ADA USER DENGAN ID:' . $id;
//     return false;
// }


$result = edit($id);
 if ( !$result) {
    echo '
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Data Tidak Ditemukan</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <style>
            body {
                background-color: #f8f9fa;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .error-container {
                text-align: center;
                padding: 40px;
                background: white;
                border-radius: 12px;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                animation: fadeIn 0.5s ease-in-out;
                max-width: 500px;
            }
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: scale(0.9);
                }
                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }
            .error-icon {
                font-size: 80px;
                color: #dc3545;
                margin-bottom: 10px;
            }
            .error-container h1 {
                font-size: 50px;
                font-weight: bold;
                color: #dc3545;
            }
            .error-container p {
                font-size: 18px;
                color: #6c757d;
                margin-bottom: 20px;
            }
            .btn-home {
                background-color: #007bff;
                color: white;
                padding: 10px 20px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
                transition: 0.3s;
            }
            .btn-home:hover {
                background-color: #0056b3;
                transform: scale(1.05);
            }
        </style>
    </head>
    <body>

    <div class="error-container">
        <i class="fas fa-exclamation-triangle error-icon"></i>
        <h1>404</h1>
        <p>Oops! Data mahasiswa tidak ditemukan.</p>
        <a href="index.php" class="btn-home">🔙 Kembali ke Beranda</a>
    </div>

    </body>
    </html>
    ';

    exit;
 }


if (isset($_POST["update"])) {
    $foto;
    // jika ada foto diupload
    if ( isset($_FILES["foto"]) ) {
        $foto = foto_handlefunc($_FILES["foto"]);
    } else {
        $foto = $result["foto"];
    }

    $ret = update($_POST, $foto, $result["id"]);
    if ( $ret > 0 ) {
        echo '
        <script>
        alert("Edit data berhasil");
        document.location.href = "index.php";
        </script>
        ';
        // header("Location: index.php");
        exit;
    } else {
        echo '
        <script>
        alert("Edit data GAGAL");
        </script>
        ';
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

<div class="container mt-5">
    <div class="card">
        <h3 class="text-center">Edit Data Mahasiswa</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $result["id"] ?>">

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
                    <option value="L" <?= $result['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="P" <?= $result['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $result["tanggal_lahir"] ?>" required>
            </div>

            <div class="mb-3">
                <label for="jenjang" class="form-label">Jenjang</label>
                <select name="jenjang" class="form-select" required>
                <option value="D3" <?= $result['jenjang'] == 'D3' ? 'selected' : '' ?>>D3</option>
                    <option value="S1" <?= $result['jenjang'] == 'S1' ? 'selected' : '' ?>>S1</option>
                    <option value="S2" <?= $result['jenjang'] == 'S2' ? 'selected' : '' ?>>S2</option>
                    <option value="S3" <?= $result['jenjang'] == 'S3' ? 'selected' : '' ?>>S3</option>
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

            <!-- Upload Foto -->
            <div class="mb-3">
                <label class="form-label">Foto Profil</label>
                <input type="file" class="form-control" name="foto" id="fotoInput" accept="image/*">
            </div>

            <!-- Tombol -->
            <button name="update" type="submit" class="btn btn-primary w-100">Update Data</button>
            <a href="index.php" class="btn btn-secondary w-100 mt-2">Batal</a>
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
