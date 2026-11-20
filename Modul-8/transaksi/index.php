<?php
include '../koneksi.php';

$sql = "SELECT 
            transaksi.*,
            user.nama AS nama_user,
            pelanggan.nama_pelanggan
        FROM transaksi
        LEFT JOIN user 
            ON transaksi.id_user = user.id_user
        LEFT JOIN pelanggan 
            ON transaksi.id_pelanggan = pelanggan.id_pelanggan
        ORDER BY transaksi.id_transaksi DESC";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi</title>
</head>
<body>

<h2>Data Transaksi Penjualan</h2>

<a href="tambah.php">Tambah Transaksi</a>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>ID Transaksi</th>
        <th>Tanggal</th>
        <th>Kasir</th>
        <th>Pelanggan</th>
        <th>Total</th>
    </tr>

    <?php
    $no = 1;
    while ($data = mysqli_fetch_assoc($query)) {
    ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $data['id_transaksi']; ?></td>
        <td><?= $data['tanggal']; ?></td>
        <td><?= htmlspecialchars($data['nama_user']); ?></td>
        <td><?= htmlspecialchars($data['nama_pelanggan'] ?? '-'); ?></td>
        <td>Rp <?= number_format($data['total'], 0, ',', '.'); ?></td>
    </tr>
    <?php } ?>

</table>

</body>
</html>
