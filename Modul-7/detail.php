<?php
include 'koneksi.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = mysqli_prepare($conn,
    "SELECT * FROM transaksi WHERE id_transaksi = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$transaksi = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$transaksi) {
    die("Transaksi tidak ditemukan!");
}

$pesan = "";

if (isset($_POST['simpan'])) {
    $kode = $_POST['kode_barang'];
    $qty = (int)$_POST['qty'];

    if ($kode != "" && $qty > 0) {

       
        $stmt = mysqli_prepare($conn,
            "SELECT id_detail FROM transaksi_detail
             WHERE id_transaksi = ? AND kode_barang = ?");
        mysqli_stmt_bind_param($stmt, "is", $id, $kode);
        mysqli_stmt_execute($stmt);

        $cek = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($cek) > 0) {
            $pesan = "Barang sudah ada dalam transaksi!";
        } else {

            $stmt = mysqli_prepare($conn,
                "SELECT harga FROM barang WHERE kode_barang = ?");
            mysqli_stmt_bind_param($stmt, "s", $kode);
            mysqli_stmt_execute($stmt);

            $barang = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

            if ($barang) {
                $harga = $barang['harga'];

                // Simpan detail
                $stmt = mysqli_prepare($conn,
                    "INSERT INTO transaksi_detail
                    (id_transaksi, kode_barang, qty, harga)
                    VALUES (?, ?, ?, ?)");

                mysqli_stmt_bind_param($stmt, "isid",
                    $id, $kode, $qty, $harga);

                if (mysqli_stmt_execute($stmt)) {

                    // Hitung ulang total transaksi
                    $stmt = mysqli_prepare($conn,
                        "UPDATE transaksi
                         SET total = (
                            SELECT COALESCE(SUM(harga * qty), 0)
                            FROM transaksi_detail
                            WHERE id_transaksi = ?
                         )
                         WHERE id_transaksi = ?");

                    mysqli_stmt_bind_param($stmt, "ii", $id, $id);
                    mysqli_stmt_execute($stmt);

                    header("Location: detail.php?id=" . $id);
                    exit;
                }
            }
        }
    } else {
        $pesan = "Pilih barang dan jumlah yang benar!";
    }
}

$stmt = mysqli_prepare($conn,
    "SELECT * FROM barang
     WHERE kode_barang NOT IN (
        SELECT kode_barang FROM transaksi_detail
        WHERE id_transaksi = ?
     )
     ORDER BY nama_barang");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$barang = mysqli_stmt_get_result($stmt);

// Data detail
$stmt = mysqli_prepare($conn,
    "SELECT td.*, b.nama_barang
     FROM transaksi_detail td
     JOIN barang b ON td.kode_barang = b.kode_barang
     WHERE td.id_transaksi = ?");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$detail = mysqli_stmt_get_result($stmt);

$stmt = mysqli_prepare($conn,
    "SELECT total FROM transaksi WHERE id_transaksi = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$total = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
    <style>
        body { font-family: Arial; margin: 30px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background: #ddd; }
    </style>
</head>
<body>

<h2>Detail Transaksi</h2>

<a href="index.php">Kembali</a>

<p>
    ID Transaksi: <?= $transaksi['id_transaksi'] ?><br>
    Tanggal: <?= $transaksi['tanggal'] ?><br>
    Pelanggan: <?= htmlspecialchars($transaksi['nama_pelanggan']) ?>
</p>

<h3>Tambah Detail Barang</h3>

<p><?= htmlspecialchars($pesan) ?></p>

<form method="POST">
    Barang:<br>
    <select name="kode_barang" required>
        <option value="">-- Pilih Barang --</option>
        <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
            <option value="<?= htmlspecialchars($b['kode_barang']) ?>">
                <?= htmlspecialchars($b['nama_barang']) ?>
                - Rp <?= number_format($b['harga'], 0, ',', '.') ?>
            </option>
        <?php } ?>
    </select>

    <br><br>

    Jumlah:<br>
    <input type="number" name="qty" min="1" required>

    <br><br>

    <button type="submit" name="simpan">Tambah Detail</button>
</form>

<h3>Daftar Detail</h3>

<table>
<tr>
    <th>Kode Barang</th>
    <th>Nama Barang</th>
    <th>Harga</th>
    <th>Jumlah</th>
    <th>Subtotal</th>
</tr>

<?php while ($d = mysqli_fetch_assoc($detail)) { ?>
<tr>
    <td><?= htmlspecialchars($d['kode_barang']) ?></td>
    <td><?= htmlspecialchars($d['nama_barang']) ?></td>
    <td>Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
    <td><?= $d['qty'] ?></td>
    <td>Rp <?= number_format($d['harga'] * $d['qty'], 0, ',', '.') ?></td>
</tr>
<?php } ?>
</table>

<h3>Total Transaksi:
    Rp <?= number_format($total['total'], 0, ',', '.') ?>
</h3>

</body>
</html>
