<?php
include 'koneksi.php';

$data = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY id_transaksi DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master Detail Transaksi</title>
    <style>
        body { font-family: Arial; margin: 30px; background: #f5f5f5; }
        table { border-collapse: collapse; width: 100%; background: white; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background: #ddd; }
        a, button { padding: 8px 12px; background: #198754; color: white; text-decoration: none; border: none; }
    </style>
</head>
<body>

<h2>Data Master Transaksi</h2>

<a href="transaksi.php">Tambah Transaksi</a>
<a href="barang.php">Data Barang</a>

<br><br>

<table>
<tr>
    <th>ID</th>
    <th>Tanggal</th>
    <th>Pelanggan</th>
    <th>Total</th>
    <th>Detail</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($data)) { ?>
<tr>
    <td><?= $row['id_transaksi'] ?></td>
    <td><?= $row['tanggal'] ?></td>
    <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
    <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
    <td>
        <a href="detail.php?id=<?= $row['id_transaksi'] ?>">
            Lihat Detail
        </a>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>

