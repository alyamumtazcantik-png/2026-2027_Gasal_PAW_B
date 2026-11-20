
<?php
require_once '../cek_login.php';
include '../koneksi.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = mysqli_prepare($koneksi,
    "SELECT t.*, d.id_barang, d.jumlah
     FROM transaksi t
     JOIN transaksi_detail d
     ON t.id_transaksi = d.id_transaksi
     WHERE t.id_transaksi = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) {
    die("Transaksi tidak ditemukan.");
}

$barang = mysqli_query($koneksi, "SELECT * FROM barang");
$pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Transaksi</title>
</head>
<body>

<h2>Edit Transaksi</h2>

<form action="update.php" method="POST">

    <input type="hidden" name="id_transaksi"
           value="<?= $data['id_transaksi']; ?>">

    <label>Barang:</label><br>

    <select name="id_barang" required>
        <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
            <option value="<?= $b['id_barang']; ?>"
                <?= ($b['id_barang'] == $data['id_barang']) ? 'selected' : ''; ?>>

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
            <option value="<?= $p['id_pelanggan']; ?>"
                <?= ($p['id_pelanggan'] == $data['id_pelanggan']) ? 'selected' : ''; ?>>

                <?= htmlspecialchars($p['nama_pelanggan']); ?>

            </option>
        <?php } ?>
    </select>

    <br><br>

    <label>Jumlah:</label><br>

    <input type="number" name="jumlah"
           min="1" value="<?= $data['jumlah']; ?>" required>

    <br><br>

    <button type="submit">Update Transaksi</button>
    <a href="index.php">Kembali</a>

</form>

</body>
</html>
