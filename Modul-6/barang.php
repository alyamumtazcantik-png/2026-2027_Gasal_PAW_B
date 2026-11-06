<?php
include 'koneksi.php';

$pesan = "";

if (isset($_POST['simpan'])) {
    $kode = $_POST['kode_barang'];
    $nama = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $sql = "INSERT INTO barang
            (kode_barang, nama_barang, harga, stok)
            VALUES ('$kode', '$nama', '$harga', '$stok')";

    if (mysqli_query($conn, $sql)) {
        header("Location: barang.php");
        exit;
    } else {
        $pesan = mysqli_error($conn);
    }
}

$data = mysqli_query($conn, "SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
</head>
<body>

<h2>Data Barang</h2>

<a href="index.php">Kembali</a>

<p style="color:red;">
    <?= htmlspecialchars($pesan) ?>
</p>

<form method="POST">
    Kode Barang:<br>
    <input type="text" name="kode_barang" required><br><br>

    Nama Barang:<br>
    <input type="text" name="nama_barang" required><br><br>

    Harga:<br>
    <input type="number" name="harga" required><br><br>

    Stok:<br>
    <input type="number" name="stok" required><br><br>

    <button type="submit" name="simpan">Tambah Barang</button>
</form>

<br>

<table border="1" cellpadding="10">
<tr>
    <th>Kode Barang</th>
    <th>Nama Barang</th>
    <th>Harga</th>
    <th>Stok</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($data)) { ?>
<tr>
    <td><?= htmlspecialchars($row['kode_barang']) ?></td>
    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
    <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
    <td><?= $row['stok'] ?></td>
</tr>
<?php } ?>

</table>

</body>
</html>
