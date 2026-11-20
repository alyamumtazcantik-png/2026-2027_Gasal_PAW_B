<?php
require_once '../cek_owner.php';

$id = $_GET['id'];

$query = mysqli_prepare($koneksi,
    "SELECT * FROM barang WHERE kode_barang = ?"
);
mysqli_stmt_bind_param($query, "s", $id);
mysqli_stmt_execute($query);

$data = mysqli_fetch_assoc(mysqli_stmt_get_result($query));

if (!$data) {
    die("Data barang tidak ditemukan");
}

if (isset($_POST['update'])) {
    $nama = $_POST['nama_barang'];
    $harga = $_POST['harga'];

    $stmt = mysqli_prepare($koneksi,
        "UPDATE barang SET nama_barang=?, harga=?
         WHERE kode_barang=?"
    );

    mysqli_stmt_bind_param($stmt, "sis", $nama, $harga, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    }

    echo "Gagal mengedit data barang.";
}
?>

<h2>Edit Data Barang</h2>

<form method="POST">
    Kode Barang<br>
    <input type="text"
           value="<?php echo htmlspecialchars($data['kode_barang']); ?>"
           disabled>
    <br><br>

    Nama Barang<br>
    <input type="text" name="nama_barang"
           value="<?php echo htmlspecialchars($data['nama_barang']); ?>"
           required>
    <br><br>

    Harga<br>
    <input type="number" name="harga"
           value="<?php echo htmlspecialchars($data['harga']); ?>"
           required>
    <br><br>

    <button type="submit" name="update">Update</button>
</form>

<a href="index.php">Kembali</a>
