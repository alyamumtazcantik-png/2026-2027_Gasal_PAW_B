<?php
require 'koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {

    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM supplier WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {

        header("Location: index.php?pesan=hapus");
        exit;

    } else {

        echo "Data gagal dihapus!";

    }

} else {

    header("Location: index.php");
    exit;

}
?>