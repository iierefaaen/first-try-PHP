<?php


session_start();
// jika tidak ada session == belum login
if ( !isset($_SESSION["login"]) ){
    // WARNING : don't add white space after Location, or will be error
    header('Location: login.php');
    exit;
}


require_once("helper/functions.php");


if ( $_SERVER["REQUEST_METHOD"] == "POST")
{
    if ( isset($_POST["tambah"]) ) {
    
        // $foto = foto_handlefunc($_FILES);
        // $foto = upload_photo($_FILES, $_FILES["foto"]["name"], 4);
        // TODO : commented
        // $foto = upload_image($_FILES,); 

    
        // TODO : commented
        // if ( !$foto ) {
        //     // alert when  no photo
        //     echo '
        //     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        //     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            
            
        //     <div class="modal fade" id="failedModal" tabindex="-1" aria-labelledby="failedModalLabel" aria-hidden="true">
        //     <div class="modal-dialog modal-dialog-centered">
        //     <div class="modal-content">
        //     <div class="modal-header bg-danger">
        //     <h5 class="modal-title" id="failedModalLabel">GAGAL</h5>
        //     </div>
        //     <div class="modal-body">
        //     <p>Tambahkan Foto</p>
        //     </div>
        //     <div class="modal-footer">
        //     <button type="button" class="btn btn-danger" id="closeButton">CLOSE</button>
        //     </div>
        //     </div>
        //     </div>
        //     </div>
            
        //     <script>
        //     window.onload = function () {
        //     let modal = new bootstrap.Modal(document.getElementById("failedModal"));
        //     modal.show();
        //     };
    
    
        //     document.addEventListener("DOMContentLoaded", function () {
        //     document.getElementById("closeButton").addEventListener("click", function () {
        //         location.href = window.location.href;
        //     });
        //     });
        //     </script>
        //     ';
        //     exit;
        // }
    
        $result = add_data($_POST, $foto);
        if ( $result > 0 ) {
            // alert when success
            echo '
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    
            <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h5 class="modal-title" id="successModalLabel">Berhasil</h5>
                        </div>
                        <div class="modal-body">
                        <p>Data berhasil ditambahkan!</p>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="okButton">OK</button>
                        </div>
                    </div>
                </div>
            </div>
    
            <script>
            window.onload = function () {
            let modal = new bootstrap.Modal(document.getElementById("successModal"));
            modal.show();
            };
    
    
            document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("okButton").addEventListener("click", function () {
                window.location.href = "index.php";
            });
            });
            </script>
            ';
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
                <label class="form-label">NIM</label>
                <input type="text" name="nim" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Kota</label>
                <input type="text" name="kota" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Provinsi</label>
                <input type="text" name="provinsi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Telepon</label>
                <input type="text" name="telepon" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jurusan</label>
                <input type="text" name="jurusan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Angkatan</label>
                <input type="number" name="angkatan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select" required>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Jenjang</label>
                <select name="jenjang" class="form-select" required>
                    <option value="D3">D3</option>
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Foto</label>
                <input type="file" name="foto" class="form-control" required>
            </div>

            <div class="mb-3">
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