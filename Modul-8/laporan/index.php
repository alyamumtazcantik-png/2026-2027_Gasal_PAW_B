
<?php
include '../cek_login.php';
include '../koneksi.php';

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
    die("Error: " . mysqli_error($koneksi));
}

$laporan = [];
$grand_total = 0;
$grafik = [];

while ($data = mysqli_fetch_assoc($query)) {
    $laporan[] = $data;
    $grand_total += $data['total'];

    $tanggal = date('Y-m-d', strtotime($data['tanggal']));

    if (!isset($grafik[$tanggal])) {
        $grafik[$tanggal] = 0;
    }

    $grafik[$tanggal] += $data['total'];
}

ksort($grafik);

$labels = array_keys($grafik);
$values = array_values($grafik);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2>LAPORAN PENJUALAN</h2>

<a href="../home.php">Kembali ke Home</a> |
<a href="export_excel.php">Export Excel</a> |
<button onclick="window.print()">Cetak Laporan</button>

<hr>

<h3>Grafik Penjualan</h3>

<canvas id="grafikPenjualan" width="800" height="350"></canvas>

<script>
const labels = <?= json_encode($labels); ?>;
const values = <?= json_encode($values); ?>;

const ctx = document.getElementById('grafikPenjualan');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Total Penjualan (Rp)',
            data: values,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'blue',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<hr>

<h3>Data Laporan Penjualan</h3>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>ID Transaksi</th>
        <th>Tanggal</th>
        <th>Kasir</th>
        <th>Pelanggan</th>
        <th>Total</th>
    </tr>

    <?php $no = 1; ?>

    <?php foreach ($laporan as $data) { ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($data['id_transaksi']); ?></td>
        <td><?= htmlspecialchars($data['tanggal']); ?></td>
        <td><?= htmlspecialchars($data['nama_kasir'] ?? '-'); ?></td>
        <td><?= htmlspecialchars($data['nama_pelanggan'] ?? '-'); ?></td>
        <td>Rp <?= number_format($data['total'], 0, ',', '.'); ?></td>
    </tr>
    <?php } ?>

    <tr>
        <th colspan="5">TOTAL PENJUALAN</th>
        <th>Rp <?= number_format($grand_total, 0, ',', '.'); ?></th>
    </tr>
</table>

</body>
</html>
