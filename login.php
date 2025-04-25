<?php
// start session
session_start();
require_once("helper/functions.php");
// cek cookie
cek_cookie($_POST);



// jika user sudah login
// tidak perlu menampilkan login kembali
// redirect ke index/php
if ( isset($_SESSION["login"]) ){
    echo "
    <script>
    window.location.href = 'index.php';
    </script>
    ";
    exit;
}

if ( isset($_POST["login"])) {
    if ( !login($_POST) ) {
        // echo"fepflp";
        // echo "<script>console.log('HALO')</script>";
        // echo '
        // <script>
        // console.log("TES")
        // document.addEventListener("DOMContentLoaded", function() {
        // console.log("EFEFEFEFEF")
        //     let alert = `<div class="alert alert-danger">
        //         <p>Username atau Password SALAH</p>
        //     </div>`;
        //     let div = document.querySelector("alert-div");
        //     if (div) {
        //         div.innerHTML = alert;
        //     }
        // });
        // </script>
        // ';
        echo '
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
        window.onload = function () {
            document.querySelector(".alert-div").innerHTML = `<div class = "alert alert-danger">Username atau Password Salah</div>`;
            let modal = new bootstrap.Modal(document.querySelector("#warningModal"));
        };
        </script>
        ';
    } else {
        // set session bernama login
        $_SESSION["login"] = true;

        // TODO
        // // cek remember me
        // if ( isset($_POST["remember"])) {
        //     // // set cookie
        //     setcookie("login", "true", time()+60);
        // }

        // echo "
        // <script>
        // window.location.href = 'index.php';
        // </script>
        // ";
        header("Location: index.php");
        exit;
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h3 class="text-center mb-4">Login</h3>
            <div class="alert-div">
            </div>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Enter your password" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                    <label class="form-check-label" for="rememberMe">Remember Me</label>
                </div>
                <button name="login" type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <p class="text-center mt-3">Don't have an account? <a href="registration.php">Register</a></p>
        </div>
    </div>
</body>
</html>
