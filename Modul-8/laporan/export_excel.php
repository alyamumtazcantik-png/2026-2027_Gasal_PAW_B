<?php
include '../koneksi.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");

$sql = "SELECT
            transaksi.id_transaksi,
            transaksi.tanggal,
            user.nama AS nama_kasir,
            pelanggan.nama_pelanggan,
            transaksi.total
        FROM transaksi
        LEFT JOIN user
            ON transaksi.id_user = user.id_user
        LEFT JOIN pelanggan
            ON transaksi.id_pelanggan = pelanggan.id_pelanggan
        ORDER BY transaksi.tanggal DESC";

$query = mysqli_query($koneksi, $sql);

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<table border="1">
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
    $grand_total = 0;

    while ($data = mysqli_fetch_assoc($query)) {
        $grand_total += $data['total'];
    ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $data['id_transaksi']; ?></td>
        <td><?= $data['tanggal']; ?></td>
        <td><?= htmlspecialchars($data['nama_kasir'] ?? '-'); ?></td>
        <td><?= htmlspecialchars($data['nama_pelanggan'] ?? '-'); ?></td>
        <td><?= $data['total']; ?></td>
    </tr>
    <?php } ?>

    <tr>
        <th colspan="5">TOTAL PENJUALAN</th>
        <th><?= $grand_total; ?></th>
    </tr>
</table>
