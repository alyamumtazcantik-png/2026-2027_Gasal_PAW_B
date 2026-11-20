<?php
require_once '../cek_owner.php';

if(isset($_POST['simpan'])) {
    $nama = trim($_POST['nama_pelanggan']);
    $alamat = trim($_POST['alamat']);
    $telepon = trim($_POST['telepon']);

    $stmt = mysqli_prepare($koneksi,
        "INSERT INTO pelanggan (nama_pelanggan,alamat,telepon)
         VALUES (?,?,?)"
    );
    mysqli_stmt_bind_param($stmt,"sss",$nama,$alamat,$telepon);

    if(mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    }
    echo "Gagal menambah pelanggan.";
}
?>

<h2>Tambah Pelanggan</h2>
<form method="POST">
    Nama Pelanggan<br>
    <input type="text" name="nama_spelanggan" required><br><br>

    Alamat<br>
    <textarea name="alamat"></textarea><br><br>

    Telepon<br>
    <input type="text" name="telepon"><br><br>

    <button name="simpan">Simpan</button>
</form>
<a href="index.php">Kembali</a>