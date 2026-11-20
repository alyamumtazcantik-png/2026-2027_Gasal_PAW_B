<?php
require_once '../koneksi.php';
require_once '../cek_owner.php';

$supplier = mysqli_query($koneksi,
    "SELECT id_supplier, nama_supplier FROM supplier"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
</head>
<body>

<h2>Tambah Barang</h2>

<form method="POST" action="simpan.php">

    <label>Kode Barang</label><br>
    <input type="text" name="kode_barang" required>
    <br><br>

    <label>Nama Barang</label><br>
    <input type="text" name="nama_barang" required>
    <br><br>

    <label>Harga</label><br>
    <input type="number" name="harga" required>
    <br><br>

    <label>Stok</label><br>
    <input type="number" name="stok" required>
    <br><br>

    <label>Supplier</label><br>
    <select name="id_supplier" required>
        <option value="">Pilih Supplier</option>
        <?php while ($s = mysqli_fetch_assoc($supplier)) { ?>
            <option value="<?= $s['id_supplier']; ?>">
                <?= htmlspecialchars($s['nama_supplier']); ?>
            </option>
        <?php } ?>
    </select>

    <br><br>

    <button type="submit" name="simpan">Simpan</button>

</form>

<a href="index.php">Kembali</a>

</body>
</html>
