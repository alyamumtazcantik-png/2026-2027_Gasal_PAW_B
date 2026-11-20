<?php
require_once '../koneksi.php';
require_once '../cek_owner.php';

$query = mysqli_query($koneksi, "
    SELECT 
        barang.kode_barang,
        barang.nama_barang,
        barang.harga,
        barang.stok,
        supplier.nama_supplier
    FROM barang
    LEFT JOIN supplier
    ON barang.id_supplier = supplier.id_supplier
    ORDER BY barang.id_barang ASC
");

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
</head>
<body>

<h2>DATA BARANG</h2>

<a href="../home.php">Home</a> |
<a href="tambah.php">Tambah Barang</a>

<hr>

<h3>Daftar Data Barang</h3>

<table border="1" cellpadding="10" cellspacing="0">

    <tr>
        <th>No</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Supplier</th>
    </tr>

    <?php
    $no = 1;

    while ($data = mysqli_fetch_assoc($query)) {
    ?>

    <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($data['kode_barang']); ?></td>
        <td><?= htmlspecialchars($data['nama_barang']); ?></td>
        <td>Rp <?= number_format($data['harga'], 0, ',', '.'); ?></td>
        <td><?= $data['stok']; ?></td>
        <td>
            <?= htmlspecialchars($data['nama_supplier'] ?? '-'); ?>
        </td>
    </tr>

    <?php } ?>

</table>

</body>
</html>
