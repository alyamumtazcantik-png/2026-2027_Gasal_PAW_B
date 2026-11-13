<?php
require_once 'koneksi.php';

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

$labels = [];
$data_total = [];
$rekap = [];

$total_pendapatan = 0;
$total_pelanggan = 0;

$valid = (
    $mulai != '' &&
    $selesai != '' &&
    preg_match('/^\d{4}-\d{2}-\d{2}$/', $mulai) &&
    preg_match('/^\d{4}-\d{2}-\d{2}$/', $selesai) &&
    $mulai <= $selesai
);

if ($valid) {

    // Mengambil total penjualan harian
    $sql = "SELECT
                DATE(waktu_transaksi) AS tgl,
                SUM(total) AS total_harian
            FROM transaksi
            WHERE waktu_transaksi >= ?
            AND waktu_transaksi < DATE_ADD(?, INTERVAL 1 DAY)
            GROUP BY DATE(waktu_transaksi)
            ORDER BY tgl ASC";

    $stmt = mysqli_prepare($koneksi, $sql);

    if (!$stmt) {
        die("Query gagal: " . mysqli_error($koneksi));
    }

    mysqli_stmt_bind_param($stmt, "ss", $mulai, $selesai);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $tgl, $total_harian);

    while (mysqli_stmt_fetch($stmt)) {

        $labels[] = $tgl;
        $data_total[] = (float)$total_harian;

        $rekap[] = [
            'tgl' => $tgl,
            'total_harian' => $total_harian
        ];

        $total_pendapatan += (float)$total_harian;
    }

    mysqli_stmt_close($stmt);

    // Menghitung jumlah pelanggan unik
    $sqlPelanggan = "SELECT COUNT(DISTINCT pelanggan_id)
                     FROM transaksi
                     WHERE waktu_transaksi >= ?
                     AND waktu_transaksi < DATE_ADD(?, INTERVAL 1 DAY)";

    $stmtPelanggan = mysqli_prepare($koneksi, $sqlPelanggan);

    mysqli_stmt_bind_param($stmtPelanggan, "ss", $mulai, $selesai);
    mysqli_stmt_execute($stmtPelanggan);

    mysqli_stmt_bind_result($stmtPelanggan, $total_pelanggan);
    mysqli_stmt_fetch($stmtPelanggan);

    mysqli_stmt_close($stmtPelanggan);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>

    <!-- Library Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <h1>Laporan Penjualan</h1>
    <p>Grafik dan Rekapitulasi Data Penjualan</p>

    <hr>

    <!-- FILTER TANGGAL -->
    <h2>Filter Laporan</h2>

    <form method="GET">

        <label>Dari Tanggal:</label>
        <input
            type="date"
            name="mulai"
            value="<?= htmlspecialchars($mulai) ?>"
            required
        >

        <label>Sampai Tanggal:</label>
        <input
            type="date"
            name="selesai"
            value="<?= htmlspecialchars($selesai) ?>"
            required
        >

        <button type="submit">Tampilkan</button>

    </form>

    <br>

    <button onclick="window.print()">Cetak Laporan</button>

    <a href="export_excel.php?mulai=<?= urlencode($mulai) ?>&selesai=<?= urlencode($selesai) ?>">
        <button type="button">Export Excel</button>
    </a>

    <hr>

    <?php if ($valid): ?>

        <h2>Periode Laporan</h2>

        <p>
            <?= htmlspecialchars($mulai) ?>
            sampai
            <?= htmlspecialchars($selesai) ?>
        </p>

        <!-- RINGKASAN -->
        <h2>Ringkasan Penjualan</h2>

        <p>
            <b>Jumlah Pelanggan:</b>
            <?= (int)$total_pelanggan ?> Orang
        </p>

        <p>
            <b>Total Pendapatan:</b>
            Rp <?= number_format($total_pendapatan, 0, ',', '.') ?>
        </p>

        <hr>

        <!-- GRAFIK PENJUALAN -->
        <h2>Grafik Penjualan Harian</h2>

        <?php if (!empty($labels)): ?>

            <canvas id="myChart" width="800" height="400"></canvas>

        <?php else: ?>

            <p>Tidak ada transaksi pada rentang tanggal tersebut.</p>

        <?php endif; ?>

        <hr>

        <!-- REKAPITULASI -->
        <h2>Rekapitulasi Penjualan</h2>

        <table border="1" cellpadding="8" cellspacing="0">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Total Pendapatan</th>
                    <th>Tanggal Transaksi</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($rekap)): ?>

                    <?php $no = 1; ?>

                    <?php foreach ($rekap as $row): ?>

                        <tr>
                            <td><?= $no++ ?></td>

                            <td>
                                Rp <?= number_format(
                                    $row['total_harian'],
                                    0,
                                    ',',
                                    '.'
                                ) ?>
                            </td>

                            <td><?= htmlspecialchars($row['tgl']) ?></td>
                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="3">Belum ada data penjualan.</td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    <?php elseif ($mulai != '' || $selesai != ''): ?>

        <p>Tanggal tidak valid. Periksa kembali tanggal yang dipilih.</p>

    <?php else: ?>

        <p>Silakan pilih tanggal untuk menampilkan laporan penjualan.</p>

    <?php endif; ?>

    <!-- JAVASCRIPT GRAFIK -->
    <?php if ($valid && !empty($labels)): ?>

        <script>

            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
                type: 'bar',

                data: {
                    labels: <?= json_encode($labels) ?>,

                    datasets: [{
                        label: 'Total Penjualan (Rupiah)',

                        data: <?= json_encode($data_total) ?>,

                        backgroundColor: 'rgba(54, 162, 235, 0.7)',

                        borderColor: 'rgb(54, 162, 235)',

                        borderWidth: 1
                    }]
                },

                options: {
                    responsive: true,

                    scales: {
                        y: {
                            beginAtZero: true,

                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' +
                                        value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

        </script>

    <?php endif; ?>

</body>
</html>
