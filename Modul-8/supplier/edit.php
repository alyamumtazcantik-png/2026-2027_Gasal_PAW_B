<?php
require_once '../cek_owner.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = mysqli_prepare($koneksi,
    "SELECT * FROM supplier WHERE id_supplier=?"
);
mysqli_stmt_bind_param($stmt,"i",$id);
mysqli_stmt_execute($stmt);
$d = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if(!$d) die("Supplier tidak ditemukan.");

if(isset($_POST['update'])) {
    $nama = trim($_POST['nama_supplier']);
    $alamat = trim($_POST['alamat']);
    $telepon = trim($_POST['telepon']);

    $stmt = mysqli_prepare($koneksi,
        "UPDATE supplier SET nama_supplier=?, alamat=?, telepon=?
         WHERE id_supplier=?"
    );
    mysqli_stmt_bind_param($stmt,"sssi",$nama,$alamat,$telepon,$id);

    if(mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    }
    echo "Gagal mengubah supplier.";
}
?>

<h2>Edit Supplier</h2>
<form method="POST">
    Nama Supplier<br>
    <input type="text" name="nama_supplier"
    value="<?php echo htmlspecialchars($d['nama_supplier']); ?>" required><br><br>

    Alamat<br>
    <textarea name="alamat"><?php echo htmlspecialchars($d['alamat']); ?></textarea><br><br>

    Telepon<br>
    <input type="text" name="telepon"
    value="<?php echo htmlspecialchars($d['telepon']); ?>"><br><br>

    <button name="update">Update</button>
</form>
<a href="index.php">Kembali</a>