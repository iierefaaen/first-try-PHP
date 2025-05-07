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

if ( $_SERVER["REQUEST_METHOD"] === "POST") {

    if ( isset( $_POST["submit"]) ){

        $username                   = trim($_POST["username"]);
        $email                      = trim($_POST["email"]);
        $password                   = trim($_POST["password"]);
        $confirm_password           = trim($_POST["confirm-password"]);

        $errors = 0 ;

        if (empty($username)) {
            $errors++;
            print_error("username wajib diisi.", "error-username");
        }
        if (empty($password)) {
            $errors++;
            print_error("password wajib diisi.", "error-password");
        }
        if (empty($confirm_password) || $password !== $confirm_password ) {
            $errors++;
            print_error("confirm password wajib diisi / salah.", "error-confirm-password");
        }
        if (empty($email)) {
            $errors++;
            print_error("Email wajib diisi.", "error-email");
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors++;
            print_error("Format email tidak valid.", "error-email");
        }

        if ( $errors === 0 ) {
            $result = registration($_POST, true);
            if ( $result === 1 ) {
                // alert when success
                alert_popup("Registrasi Berhasil","Registrasi admin berhasil","success", "success", "admin-menu.php");
                exit;
            } else {
            alert_popup("Registrasi Gagal","Registrasi admin gagal","danger", "danger", "admin-registration.php");
                exit;
            }
        }
    }

    // if ( isset( $_POST["submit"]) ){
    //     $result = registration($_POST, true);
    //     if ( $result === 1){
    //         alert_popup("Registrasi Berhasil","Registrasi admin berhasil","success", "success", "admin-menu.php");
    //         exit;
    //     } else {
    //         alert_popup("Registrasi Gagal","Registrasi admin gagal","danger", "danger", "admin-registration.php");
    //         exit;
    //     }
    // }
}


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include_once("helper/admin-navbar.php"); ?>
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h4>Tambah User Admin</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                            <div class="error-username"></div>
                                <label for="username" class="form-label">Username</label>
                                <input name="username" type="text" class="form-control" id="username" placeholder="Masukkan username" required>
                            </div>
                            <div class="mb-3">
                            <div class="error-email"></div>
                                <label for="email" class="form-label">Email</label>
                                <input name="email" type="email" class="form-control" id="email" placeholder="Masukkan email" required>
                            </div>
                            <div class="mb-3">
                            <div class="error-password"></div>
                                <label for="password" class="form-label">Password</label>
                                <input name="password" type="password" class="form-control" id="password" placeholder="Masukkan password" required>
                            </div>
                            <div class="mb-3">
                            <div class="error-confirm-password"></div>
                                <label for="confirm-password" class="form-label">Konfirmasi Password</label>
                                <input name="confirm-password" type="password" class="form-control" id="confirm-password" placeholder="Konfirmasi password" required>
                            </div>
                            <div class="d-grid">
                                <button name="submit" type="submit" class="btn btn-primary">Buat User</button>
                            </div>
                        </form>
                        <div class="d-grid mt-3">
                            <a class="btn btn-danger" href="javascript:history.back()">
                                Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
