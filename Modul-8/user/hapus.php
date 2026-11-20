<?php
require_once '../cek_owner.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = mysqli_prepare($koneksi,
    "SELECT * FROM user WHERE id_user=?"
);
mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);
$d = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if(!$d) die("User tidak ditemukan.");

if(isset($_POST['update'])) {
    $username = trim($_POST['username']);
    $nama = trim($_POST['nama']);
    $level = (int)$_POST['level'];

    if($_POST['password'] != '') {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($koneksi,
            "UPDATE user SET username=?, password=?, nama=?, level=?
             WHERE id_user=?"
        );
        mysqli_stmt_bind_param($stmt,"sssii",
            $username,$password,$nama,$level,$id
        );
    } else {
        $stmt = mysqli_prepare($koneksi,
            "UPDATE user SET username=?, nama=?, level=?
             WHERE id_user=?"
        );
        mysqli_stmt_bind_param($stmt,"ssii",
            $username,$nama,$level,$id
        );
    }

    if(mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    }
    echo "Gagal mengubah user.";
}
?>

<h2>Edit User</h2>
<form method="POST">
    Username<br>
    <input type="text" name="username"
    value="<?php echo htmlspecialchars($d['username']); ?>" required><br><br>

    Nama<br>
    <input type="text" name="nama"
    value="<?php echo htmlspecialchars($d['nama']); ?>" required><br><br>

    Password Baru<br>
    <input type="password" name="password"><br>
    <small>Kosongkan jika tidak ingin mengganti password.</small>
    <br><br>

    Level<br>
    <select name="level">
        <option value="1" <?php if($d['level']==1) echo 'selected'; ?>>Owner</option>
        <option value="2" <?php if($d['level']==2) echo 'selected'; ?>>Kasir</option>
    </select><br><br>

    <button name="update">Update</button>
</form>
<a href="index.php">Kembali</a>