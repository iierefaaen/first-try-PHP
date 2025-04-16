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


$keyword = $_GET["keyword"];

$result = ajax_search($keyword);

?>

<table class="table table-bordered table-striped">
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
            <td data-label="No"><?php echo $counter; $counter++; ?></td>
            <td data-label="NIM"><?php echo $value["nim"]; ?></td>
            <td data-label="Nama"><?php echo $value["nama"]; ?></td>
            <td data-label="Jurusan"><?php echo $value["jurusan"]; ?></td>
            <td data-label="Aksi">
            <div class="action-buttons">
                <a href='detail.php?id=<?php echo $value["id"]; ?>' class='btn btn-info btn-sm'>🔍 Detail</a>
                <a href='edit.php?id=<?php echo $value["id"]; ?>' class='btn btn-warning btn-sm'>✏️ Edit</a>
                <a href='delete.php?id=<?php echo $value["id"]; ?>' class='btn btn-danger btn-sm'>🗑️ Hapus</a>
            </div>
            </td>
        </tr>
        <?php
        }
        ?>
        <!--  -->
    </tbody>
</table>
