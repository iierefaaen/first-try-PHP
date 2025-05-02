<?php


session_start();
// jika tidak ada session == belum login
if ( !isset($_SESSION["login"]) ){
    // WARNING : don't add white space after Location, or will be error
    header('Location: login.php');
    exit;
}


function print_error($msg, $dom_element) {
    echo "
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const el = document.querySelector('.$dom_element');
            if (el) {
                el.innerHTML = `<div class='alert alert-danger fw-bold text-primary'>$msg</div>`;
            }
        });
        </script>
    ";
}



require_once("helper/functions.php");


if ( $_SERVER["REQUEST_METHOD"] == "POST")
{
    if ( isset($_POST["tambah"]) ) {

        $nim            = trim($_POST["nim"]);
        $nama           = trim($_POST["nama"]);
        $alamat         = trim($_POST["alamat"]);
        $kota           = trim($_POST["kota"]);
        $provinsi       = trim($_POST["provinsi"]);
        $telepon        = trim($_POST["telepon"]);
        $email          = trim($_POST["email"]);
        $jurusan        = trim($_POST["jurusan"]);
        $angkatan       = trim($_POST["angkatan"]);
        $jenis_kelamin  = trim($_POST["jenis_kelamin"]);
        $tanggal_lahir  = trim($_POST["tanggal_lahir"]);
        $jenjang        = trim($_POST["jenjang"]);
        $status         = trim($_POST["status"]);
        $foto         = $_FILES["foto"];

        $errors = [];

        if (empty($nim)) {
            $errors[] = "NIM wajib diisi.";
            print_error("NIM wajib diisi.", "error-nim");
        }
        if (empty($nama)) {
            $errors[] = "Nama wajib diisi.";
            print_error("Nama wajib diisi.", "error-nama");
        }
        if (empty($alamat)) {
            $errors[] = "Alamat wajib diisi.";
            print_error("Alamat wajib diisi.", "error-alamat");
        }
        if (empty($kota)) {
            $errors[] = "Kota wajib diisi.";
            print_error("Kota wajib diisi.", "error-kota");
        }
        if (empty($provinsi)) {
            $errors[] = "Provinsi wajib diisi.";
            print_error("Provinsi wajib diisi.", "error-provinsi");
        }
        if (empty($telepon)) {
            $errors[] = "Telepon wajib diisi.";
            print_error("Telepon wajib diisi.", "error-telepon");
        } elseif (!preg_match('/^[0-9+\-() ]+$/', $telepon)) {
            $errors[] = "Format telepon tidak valid.";
            print_error("Format telepon tidak valid.", "error-telepon");
        }
        if (empty($email)) {
            $errors[] = "Email wajib diisi.";
            print_error("Email wajib diisi.", "error-email");
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Format email tidak valid.";
            print_error("Format email tidak valid.", "error-email");
        }
        if (empty($jurusan)) {
            $errors[] = "Jurusan wajib diisi.";
            print_error("Jurusan wajib diisi.", "error-jurusan");
        }
        if (empty($angkatan)) {
            $errors[] = "Angkatan wajib diisi.";
            print_error("Angkatan wajib diisi.", "error-angkatan");
        } elseif (!is_numeric($angkatan) || strlen($angkatan) != 4) {
            $errors[] = "Angkatan harus berupa tahun (4 digit).";
            print_error("Angkatan harus berupa tahun (4 digit).", "error-angkatan");
        }
        if (empty($jenis_kelamin)) {
            $errors[] = "Jenis kelamin wajib dipilih.";
            print_error("Jenis kelamin wajib dipilih.", "error-kelamin");
        }
        if (empty($tanggal_lahir)) {
            $errors[] = "Tanggal lahir wajib diisi.";
            print_error("Tanggal lahir wajib diisi.", "error-ttl");
        } elseif (!DateTime::createFromFormat('Y-m-d', $tanggal_lahir)) {
            $errors[] = "Format tanggal lahir tidak valid.";
            print_error("Format tanggal lahir tidak valid (gunakan YYYY-MM-DD).", "error-ttl");
        }
        if (empty($jenjang)) {
            $errors[] = "Jenjang wajib diisi.";
            print_error("Jenjang wajib diisi.", "error-jenjang");
        }
        if (empty($status)) {
            $errors[] = "Status wajib diisi.";
            print_error("Status wajib diisi.", "error-status");
        }
        if ( $foto["error"] === 4 ) {
            $errors[] = "Foto wajib diunggah.";
            print_error("Foto wajib diunggah.", "error-foto");
        }
        


        if (empty($errors)) {
            $result = add_data($_POST, $foto);
            if ( $result > 0 ) {
                // alert when success
                alert_popup("Berhasil","Data berhasil ditambahkan","success", "success", "index.php");
                exit;
            }
        } else {
            alert_popup("Gagal","Data gagal ditambahkan","danger","danger","add.php");
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
    <title>Tambah Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-primary {
            width: 100%;
        }
        .btn-secondary {
            width: 100%;
            margin-top: 10px;
        }
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Mahasiswa</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <div class="error-nim"></div>
                <label class="form-label">NIM</label>
                <input type="text" name="nim" class="form-control" required>
            </div>
            <div class="mb-3">
            <div class="error-nama"></div>
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
            <div class="error-alamat"></div>
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control"></textarea required>
            </div>
            <div class="mb-3">
            <div class="error-kota"></div>
                <label class="form-label">Kota</label>
                <input type="text" name="kota" class="form-control" required>
            </div>
            <div class="mb-3">
            <div class="error-provinsi"></div>
                <label class="form-label">Provinsi</label>
                <input type="text" name="provinsi" class="form-control" required>
            </div>
            <div class="mb-3">
            <div class="error-telepon"></div>
                <label class="form-label">Telepon</label>
                <input type="text" name="telepon" class="form-control" required>
            </div>
            <div class="mb-3">
            <div class="error-email"></div>
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
            <div class="error-jurusan"></div>
                <label class="form-label">Jurusan</label>
                <input type="text" name="jurusan" class="form-control" required>
            </div>
            <div class="mb-3">
            <div class="error-angkatan"></div>
                <label class="form-label">Angkatan</label>
                <input type="number" name="angkatan" class="form-control" required>
            </div>
            <div class="mb-3">
            <div class="error-kelamin"></div>
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
            <div class="error-ttl"></div>
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" required>
            </div>
            <div class="mb-3">
            <div class="error-jenjang"></div>
                <label class="form-label">Jenjang</label>
                <select name="jenjang" class="form-select" required>
                    <option value="D1">D1</option>
                    <option value="D3">D3</option>
                    <option value="D4">D4</option>
                    <option value="S1">S1</option>
                </select>
            </div>
            <div class="mb-3">
            <div class="error-foto"></div>
                <label class="form-label">Foto</label>
                <input type="file" name="foto" class="form-control" required>
            </div>

            <div class="mb-3">
            <div class="error-status"></div>
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="aktif">Aktif</option>
                <option value="cuti">Cuti</option>
                <option value="lulus">Lulus</option>
                <option value="drop-out">Drop Out</option>
            </select>
            </div>

            <button name="tambah" type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>