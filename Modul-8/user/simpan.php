<?php
include '../koneksi.php';

if (isset($_POST['simpan'])) {

    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = trim($_POST['nama']);
    $level = (int) $_POST['level'];

    $stmt = mysqli_prepare($koneksi,
        "INSERT INTO user (username, password, nama, level)
         VALUES (?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt, "sssi",
        $username, $password, $nama, $level
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menyimpan user: " . mysqli_error($koneksi);
    }

} else {
    header("Location: tambah.php");
    exit;
}
?>
