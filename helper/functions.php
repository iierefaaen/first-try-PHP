<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "pabd";
$conn = mysqli_connect($hostname, $username, $password, $database);
if ( !$conn ){
    die( "Failed to connect DB " + mysqli_connect_error() );
}


function registration($data){
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $email = $data["email"];
    $password = $data["password"];
    $confirm_password = $data["confirm-password"];

    // CEK APAKAH PASSWORD DAN CONFIRM PASSWORD SAMA
    if ( $password !== $confirm_password ) {
        echo "<script>alert('Password dan konfirmasi password tidak cocok!');</script>";
        return -1;
    }


    //
    $checkSameUser = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
    if ( mysqli_fetch_assoc($checkSameUser) ) {
        echo "
        <script>alert('Username sudah ada, gunakan username lain');</script>
        ";
        return -1;
    }
    // ENKRIPSI PASSWORD
    $encrypted_password = password_hash($password, PASSWORD_DEFAULT);


    mysqli_query($conn, "INSERT INTO user (username, email, password) VALUES ( '$username', '$email', '$encrypted_password' )");

    // return 1;
    // return mysqli_affected_rows($conn);
    var_dump(mysqli_affected_rows($conn));
    $result = mysqli_affected_rows($conn);
    if ($result > 0) {
        return $result;
    }

}


function login($data) {
    global $conn;

    $email = $_POST["email"];
    $password = $_POST["password"];

    $email_result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
    // cek username
    // mysqli_num_rows -> mengembalikan jumlah berapa hasil dari query
    if ( mysqli_num_rows($email_result) === 1 ){
        // data dari db
        $result = mysqli_fetch_assoc($email_result);
        // check password
        $login_cek = password_verify($password, $result["password"] );
        if ( !$login_cek ){
            return false;
        } else {
            // cek remember me ditekan
            // set cookie
            if ( isset($data["remember"])) {
            $cookie_id = $result["id"] + 8908 / 786 * 34;
            $cookie_key = hash("sha256", $result["username"] . (string) pi());
            setcookie("id", $cookie_id, time() + 60, secure: true);
            setcookie("key", $cookie_key, time() + 60, secure: true);
            }
        // return $_SESSION["login] -=>> true;
        return true;

        }
    }
}

function cek_cookie($data) {
    global $conn;
    if (isset($_COOKIE["id"]) && isset($_COOKIE["key"])){
        $id = $_COOKIE["id"];
        $key = $_COOKIE["key"];

        $email = $data["email"];
        $result = mysqli_query($conn, "SELECT id, username FROM user WHERE email = '$email'");
        $row = mysqli_fetch_assoc($result);

        if ( $key = hash("sha256", $row["username"] . (string) pi() )) {
            $_SESSION["login"] = true;
        }
    }
}

function show_data() {
    global $conn;


    $ret = array();
    $result = mysqli_query($conn, "SELECT * FROM students WHERE deleted_at IS NULL LIMIT 15");
    

    foreach ( $result as $key => $value) {
        $ret[$key] = $value;
    }
    return $ret;
}

function get_all_data( $is_deleted = false ) {
    global $conn;

    $ret = array();
    if ( $is_deleted == false) {
        $result = mysqli_query($conn, "SELECT * FROM students WHERE deleted_at IS NULL");
        foreach ( $result as $key => $value) {
            $ret[$key] = $value;
        }
    } else {
        $result = mysqli_query($conn, "SELECT * FROM students WHERE deleted_at IS NOT NULL");
        foreach ( $result as $key => $value) {
            $ret[$key] = $value;
        }

    }
    return $ret;
}

function get_data_by_id($id, $is_deleted = false) {
    global $conn;

    // deleted_at = NULL
    // if user not soft deleted
    if ( $is_deleted == false) {
        return mysqli_fetch_assoc(mysqli_query($conn,"
        SELECT * FROM students WHERE id = '$id' AND deleted_at IS NULL
        "));
    } else { // value deleted_at is NOT NULL => user is soft deleted
        return mysqli_fetch_assoc(mysqli_query($conn,"
        SELECT * FROM students WHERE id = '$id' AND deleted_at IS NOT NULL
        "));
    }
}

// TODO :
function upload_image( $file, $old_image = null) {
    $allowed_ext = array("jpg","jpeg","png", );
    $max_file_size = 2 * 1024 * 1024; // 2 MB
    if ( isset($file["name"]) && $file["error"] === UPLOAD_ERR_OK) {
        $filename = $file["name"];
        $filesize = $file["size"];
        $file_temp = $file["temp_naem"];
        $file_ext = pathinfo($filename, PATHINFO_EXTENSION);

        // check file extension
        if ( !in_array($file_ext, $allowed_ext) ) {
            return "Extensi filke salah. extensi diterima: jpg, jpeg, png";
        }

        // check file size
        if ( $filesize > $max_file_size) {
            return "Ukuran file terlalu besar. Maksimla 2 MB.";
        }

        // generate unique file name
        $uploaded_filename = pathinfo($filename, PATHINFO_FILENAME) . "_" . uniqid() . "." . $file_ext;

        // UPLOAD FILE
        $upload_path = __DIR__ . "../uploads/img/";
        if ( move_uploaded_file($file_temp, $upload_path) ) {
            return $uploaded_filename;
        } else {
            return "Upload Gagal";
        }
    }


    // handle old file, if not upload new image on edit page
    if ( $old_image ) {
        return $old_image;
    }

    return "Tidak ada file yang diupload";
} // TODO


function add_data($data, $foto) {
    //            data $_POST,  image_file $_FILES
    global $conn;
 
    $id = bin2hex(random_bytes(16));
 
    $nim = htmlspecialchars($_POST['nim'], ENT_QUOTES, 'UTF-8');
    $nama = htmlspecialchars($_POST['nama'], ENT_QUOTES, 'UTF-8');
    $alamat = htmlspecialchars($_POST['alamat'], ENT_QUOTES, 'UTF-8');
    $kota = htmlspecialchars($_POST['kota'], ENT_QUOTES, 'UTF-8');
    $provinsi = htmlspecialchars($_POST['provinsi'], ENT_QUOTES, 'UTF-8');
    $telepon = htmlspecialchars($_POST['telepon'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $jurusan = htmlspecialchars($_POST['jurusan'], ENT_QUOTES, 'UTF-8');
    $angkatan = htmlspecialchars($_POST['angkatan'], ENT_QUOTES, 'UTF-8');
    $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin'], ENT_QUOTES, 'UTF-8');
    $tanggal_lahir = htmlspecialchars($_POST['tanggal_lahir'], ENT_QUOTES, 'UTF-8');
    $jenjang = htmlspecialchars($_POST['jenjang'], ENT_QUOTES, 'UTF-8');
    $status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');

    $image = upload_image($foto);

    $result = mysqli_query($conn, "INSERT INTO students
    (
    id,
    nim, nama,
    alamat, kota, provinsi,
    telepon, email,
    jurusan, angkatan,
    jenis_kelamin, tanggal_lahir,
    jenjang, foto, status
    )
    VALUES (
    '$id',
    '$nim', '$nama',
    '$alamat', '$kota', '$provinsi',
    '$telepon', '$email',
    '$jurusan', '$angkatan',
    '$jenis_kelamin', '$tanggal_lahir',
    '$jenjang', '$image', '$status'
    )"
    );

    if ( $result ){
        return mysqli_affected_rows($conn);
    } else {
        return 0;
    }
}

function update_data($id, $data, $foto) {
    //              $data = $_POST, $foto = $_FILES
    global $conn;

    $old_image = htmlspecialchars($data["old-foto"], ENT_QUOTES, "UTF-8");

    $nim = htmlspecialchars($data['nim'], ENT_QUOTES, 'UTF-8');
    $nama = htmlspecialchars($data['nama'], ENT_QUOTES, 'UTF-8');
    $alamat = htmlspecialchars($data['alamat'], ENT_QUOTES, 'UTF-8');
    $kota = htmlspecialchars($data['kota'], ENT_QUOTES, 'UTF-8');
    $provinsi = htmlspecialchars($data['provinsi'], ENT_QUOTES, 'UTF-8');
    $telepon = htmlspecialchars($data['telepon'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8');
    $jurusan = htmlspecialchars($data['jurusan'], ENT_QUOTES, 'UTF-8');
    $angkatan = htmlspecialchars($data['angkatan'], ENT_QUOTES, 'UTF-8');
    $jenis_kelamin = htmlspecialchars($data['jenis_kelamin'], ENT_QUOTES, 'UTF-8');
    $tanggal_lahir = htmlspecialchars($data['tanggal_lahir'], ENT_QUOTES, 'UTF-8');
    $jenjang = htmlspecialchars($data['jenjang'], ENT_QUOTES, 'UTF-8');
    $status = htmlspecialchars($data['status'], ENT_QUOTES, 'UTF-8');

    // ambil dan cek data lama
    $result = mysqli_query($conn, "SELECT * FROM students WHERE id = '$id'");
    $old = mysqli_fetch_assoc($result);

    
    // Cek apakah ada perubahan
    if (
        $old['nama'] == $nama &&
        $old['nim'] == $nim &&
        $old['alamat'] == $alamat &&
        $old['kota'] == $kota &&
        $old['provinsi'] == $provinsi &&
        $old['telepon'] == $telepon &&
        $old['email'] == $email &&
        $old['jurusan'] == $jurusan &&
        $old['angkatan'] == $angkatan &&
        $old['jenis_kelamin'] == $jenis_kelamin &&
        $old['tanggal_lahir'] == $tanggal_lahir &&
        $old['jenjang'] == $jenjang &&
        $old['status'] == $status &&
        ($foto === null || $old['foto'] == $old_image)
        ) {
            return 0; // Tidak ada perubahan
    }
        
        
    $foto = upload_image($foto);

    $query = "
        UPDATE students SET
        nama = '$nama',
        nim = '$nim',
        alamat = '$alamat',
        kota = '$kota',
        provinsi = '$provinsi',
        telepon = '$telepon',
        email = '$email',
        jurusan = '$jurusan',
        angkatan = '$angkatan',
        jenis_kelamin = '$jenis_kelamin',
        tanggal_lahir = '$tanggal_lahir',
        jenjang = '$jenjang',
        status = '$status',
        foto = '$foto'
        WHERE id = '$id'
    ";


    // hanya update kolom `foto` jika ada foto baru
    // if ($foto !== null) {
    //     $query .= ", foto = '$foto'";
    // }

    // $query .= " WHERE id = '$id'";

    $ret = mysqli_query($conn, $query);
    if ( $ret ) {
        return mysqli_affected_rows($conn); // 1 if success
    } else {
        return -1;
    }
}

function soft_delete_data($id) {
    global $conn;

    $now = new DateTime();
    $timestamp = $now->format("Y-m-d H:i:s");

    $ret = mysqli_query($conn, "
    UPDATE students SET
    deleted_at = '$timestamp'
    WHERE id = '$id'
    ");

    if ( $ret) {
        return mysqli_affected_rows($conn);
    } else {
        return 0;
    }
}

function ajax_search($keyword) {
    global $conn;


    $ret = array();
    $result = mysqli_query($conn, "
    SELECT * FROM students WHERE
    deleted_at IS NULL
    AND (
    nama LIKE '%$keyword%' OR nim LIKE '%$keyword%' OR jurusan LIKE '%$keyword%'
    )
    ");
    
    foreach ( $result as $key => $value) {
        $ret[$key] = $value;
    }
    return $ret;
}

function hitung_jumlah_siswa() {
    global $conn;

    return mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM students WHERE deleted_at IS NULL"))['total'];
}


function hitung_jumlah_siswa_per_jurusan() {
    global $conn;

    return mysqli_query($conn, "SELECT jurusan, COUNT(*) AS total FROM students WHERE deleted_at IS NULL GROUP BY jurusan");
}


function hitung_jumlah_siswa_per_gender() {
    global $conn;

    return mysqli_query($conn, "SELECT jenis_kelamin, COUNT(*) AS total FROM students WHERE deleted_at IS NULL GROUP BY jenis_kelamin");
}

function hitung_jumlah_mahasiswa_berdasar_angkatan() {
    global $conn;

    return mysqli_query($conn, 
    "
    SELECT angkatan, COUNT(*) AS total FROM students WHERE deleted_at IS NULL GROUP BY angkatan ORDER BY angkatan DESC
    ");
}

function hitung_jumlah_mahasiswa_berdasar_jenjang() {
    global $conn;

    return mysqli_query($conn, "
    SELECT jenjang, COUNT(*) AS total FROM students WHERE deleted_at IS NULL GROUP BY jenjang
    ");
}

function hitung_jumlah_mahasiswa_berdasar_status() {
    global $conn;

    return mysqli_query($conn, "
    SELECT status, COUNT(*) AS total FROM students WHERE deleted_at IS NULL GROUP BY status
    ");
}

function recoverdata( $id ) {
    global $conn;

    mysqli_query($conn, "
    UPDATE students SET
    deleted_at = NULL
    WHERE id = '$id'
    ");

    return mysqli_affected_rows($conn);
}

function permanent_delete_data( $id ){
    global $conn;

    mysqli_query($conn,"
    DELETE FROM students WHERE id = '$id'
    ");

    return mysqli_affected_rows($conn);
}

?>