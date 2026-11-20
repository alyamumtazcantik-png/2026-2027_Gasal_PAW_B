<?php
require_once '../cek_login.php';
require_once '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama = trim($_POST['nama_supplier']);
    $telepon = trim($_POST['telepon']);
    $alamat = trim($_POST['alamat']);

    if ($nama == '') {
        die("Nama supplier wajib diisi.");
    }

    $stmt = mysqli_prepare($koneksi,
        "INSERT INTO supplier
        (nama_supplier, telepon, alamat)
        VALUES (?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $nama,
        $telepon,
        $alamat
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menambahkan supplier: " .
             mysqli_stmt_error($stmt);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Supplier</title>
</head>
<body>

<h2>Tambah Data Supplier</h2>

<form method="POST">

    <label>Nama Supplier:</label><br>
    <input type="text" name="nama_supplier" required>

    <br><br>

    <label>Telepon:</label><br>
    <input type="text" name="telepon">

    <br><br>

    <label>Alamat:</label><br>
    <textarea name="alamat"></textarea>

    <br><br>

    <button type="submit" name="simpan">Simpan</button>
    <a href="index.php">Kembali</a>

</form>

</body>
</html>
