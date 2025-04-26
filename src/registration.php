<?php

require_once("helper/helper.php");

// CEK APAKAH TOMBOL SUDAH DITEKAN
if (isset($_POST["register"])) {
    // CEK APAKAH INSERT BERHASIL
    $result = registration($_POST);
    if ( $result > 0) {
        echo "<script>
                alert('REGISTRASI BERHASIL');
                window.location.href = 'login.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('Registrasi gagal, coba lagi!');</script>";
        echo mysqli_error($conn);
    }
}


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100 px-4">
    <div class="w-full max-w-md p-8 space-y-6 bg-white shadow-lg rounded-2xl">
        <h2 class="text-2xl font-bold text-center text-gray-700">Buat Akun Baru</h2>
        <form action="" method="POST" id="registerForm" class="space-y-4">
            <div>
                <label for="username" class="block mb-1 text-gray-600">Username</label>
                <input name="username" type="text" id="username" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
            </div>
            <div>
                <label for="email" class="block mb-1 text-gray-600">Email</label>
                <input name="email" type="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
            </div>
            <div>
                <label for="password" class="block mb-1 text-gray-600">Password</label>
                <input name="password" type="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
            </div>
            <div>
                <label for="confirm-password" class="block mb-1 text-gray-600">Konfirmasi Password</label>
                <input name="confirm-password" type="password" id="confirmPassword" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
            </div>
            <button id="register" name="register" type="submit" class="w-full py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">Daftar</button>
        </form>
        <p class="text-sm text-center text-gray-500">Sudah punya akun? <a href="login.php" class="text-blue-500">Masuk</a></p>
    </div>
    <!-- <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (password !== confirmPassword) {
                alert('Password dan konfirmasi password tidak cocok!');
                return;
            }
            
            alert('Registrasi berhasil!');
        });
    </script> -->
</body>
</html>