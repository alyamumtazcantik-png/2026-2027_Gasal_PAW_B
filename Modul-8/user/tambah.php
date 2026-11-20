<?php
require_once '../cek_owner.php';

if(isset($_POST['simpan'])) {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = trim($_POST['nama']);
    $level = (int)$_POST['level'];

    $stmt = mysqli_prepare($koneksi,
        "INSERT INTO user (username,password,nama,level)
         VALUES (?,?,?,?)"
    );
    mysqli_stmt_bind_param($stmt,"sssi",$username,$password,$nama,$level);

    if(mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    }
    echo "Gagal menambah user. Username mungkin sudah digunakan.";
}
?>

<h2>Tambah User</h2>
<form method="POST">
    Username<br>
    <input type="text" name="username" required><br><br>

    Password<br>
    <input type="password" name="password" required><br><br>

    Nama<br>
    <input type="text" name="nama" required><br><br>

    Level<br>
    <select name="level">
        <option value="1">Owner</option>
        <option value="2">Kasir</option>
    </select><br><br>

    <button name="simpan">Simpan</button>
</form>
<a href="index.php">Kembali</a>