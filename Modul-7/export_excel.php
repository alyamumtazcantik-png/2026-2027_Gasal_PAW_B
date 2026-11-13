<?php
require_once __DIR__ . '/koneksi.php';

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

if (
    !preg_match('/^\d{4}-\d{2}-\d{2}$/', $mulai) ||
    !preg_match('/^\d{4}-\d{2}-\d{2}$/', $selesai) ||
    $mulai > $selesai
) {
    die("Tanggal laporan tidak valid.");
}

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

$rekap = [];
$total_pendapatan = 0;

while (mysqli_stmt_fetch($stmt)) {

    $rekap[] = [
        'tgl' => $tgl,
        'total_harian' => $total_harian
    ];

    $total_pendapatan += $total_harian;
}

mysqli_stmt_close($stmt);

// Query jumlah pelanggan unik
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

// Header untuk file Excel
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "\xEF\xBB\xBF";
?>

<html>
<head>
    <meta charset="UTF-8">
</head>

<body>

<h2>LAPORAN PENJUALAN</h2>

<p>
    Periode:
    <?= htmlspecialchars($mulai) ?>
    sampai
    <?= htmlspecialchars($selesai) ?>
</p>

<table border="1">

    <tr>
        <th>No</th>
        <th>Tanggal Transaksi</th>
        <th>Total Pendapatan</th>
    </tr>

    <?php if (!empty($rekap)): ?>

        <?php $no = 1; ?>

        <?php foreach ($rekap as $row): ?>

            <tr>
                <td><?= $no++ ?></td>

                <td>
                    <?= htmlspecialchars($row['tgl']) ?>
                </td>

                <td>
                    <?= $row['total_harian'] ?>
                </td>
            </tr>

        <?php endforeach; ?>

    <?php else: ?>

        <tr>
            <td colspan="3">Tidak ada transaksi.</td>
        </tr>

    <?php endif; ?>

    <tr>
        <th colspan="2">Total Pendapatan</th>
        <th><?= $total_pendapatan ?></th>
    </tr>

    <tr>
        <th colspan="2">Jumlah Pelanggan Unik</th>
        <th><?= (int)$total_pelanggan ?></th>
    </tr>

</table>

</body>
</html>
