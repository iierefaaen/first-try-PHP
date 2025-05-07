<?php

session_start();
// jika tidak ada session == belum login
if ( !isset($_SESSION["login"]) ){
    // WARNING : don't add white space after Location, or will be error
    header("Location: login.php");
    exit;
}

require_once("helper/functions.php");

// !check_role => user
// used for admin page
if ( !check_role() ) {
    header("Location: students.php");
    exit;
}


$keyword = $_GET["keyword"];

$result = ajax_search($keyword);


?>

<div class="table-responsive" id="table-container">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            foreach( $result as $key => $value ) {
            ?>
            <tr>
                <td><?= $counter++; ?></td>
                <td><?= $value["nim"]; ?></td>
                <td><?= $value["nama"]; ?></td>
                <td><?= $value["jurusan"]; ?></td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <a href='detail.php?id=<?= $value["id"]; ?>' class='btn btn-info btn-sm'>🔍 Detail</a>
                        <a href='edit.php?id=<?= $value["id"]; ?>' class='btn btn-warning btn-sm'>✏️ Edit</a>
                        <a href='delete.php?id=<?= $value["id"]; ?>' class='btn btn-danger btn-sm'>🗑️ Hapus</a>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>