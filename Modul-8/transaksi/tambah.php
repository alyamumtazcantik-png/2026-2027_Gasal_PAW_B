<?php
require_once '../cek_login.php';
include '../koneksi.php';

$barang = mysqli_query($koneksi, "SELECT * FROM barang");
$pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Transaksi</title>
</head>
<body>

<h2>Tambah Transaksi Penjualan</h2>

<form action="simpan.php" method="POST">

    <label>Barang:</label><br>
    <select name="id_barang" required>
        <option value="">-- Pilih Barang --</option>
        <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
            <option value="<?= $b['id_barang']; ?>">
                <?= htmlspecialchars($b['nama_barang']); ?>
                - Stok: <?= $b['stok']; ?>
            </option>
        <?php } ?>
    </select>

    <br><br>

    <label>Pelanggan:</label><br>
    <select name="id_pelanggan">
        <option value="">-- Tanpa Pelanggan --</option>
        <?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>
            <option value="<?= $p['id_pelanggan']; ?>">
                <?= htmlspecialchars($p['nama_pelanggan']); ?>
            </option>
        <?php } ?>
    </select>

    <br><br>

    <label>Tanggal Transaksi:</label><br>
    <input type="date" name="tanggal"
           value="<?= date('Y-m-d'); ?>" required>

    <br><br>

    <label>Jumlah:</label><br>
    <input type="number" name="jumlah" min="1" required>

    <br><br>

    <button type="submit">Simpan Transaksi</button>
    <a href="index.php">Kembali</a>

</form>

</body>
</html>
