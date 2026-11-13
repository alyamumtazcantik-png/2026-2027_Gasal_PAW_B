<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $tanggal = $_POST['tanggal'];
    $nama = trim($_POST['nama_pelanggan']);

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO transaksi (tanggal, nama_pelanggan, total)
         VALUES (?, ?, 0)"
    );

    mysqli_stmt_bind_param($stmt, "ss", $tanggal, $nama);
    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Transaksi</title>
</head>
<body>

<h2>Tambah Transaksi</h2>

<form method="POST">
    Tanggal:<br>
    <input type="date" name="tanggal" required><br><br>

    Nama Pelanggan:<br>
    <input type="text" name="nama_pelanggan" required><br><br>

    <button type="submit" name="simpan">Simpan</button>
</form>

<br>
<a href="index.php">Kembali</a>

</body>
</html>
