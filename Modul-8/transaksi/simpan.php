<?php
require_once '../cek_login.php';
require_once '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$id_barang = (int) $_POST['id_barang'];
$jumlah = (int) $_POST['jumlah'];
$tanggal = $_POST['tanggal'];

$id_pelanggan = !empty($_POST['id_pelanggan'])
    ? (int) $_POST['id_pelanggan']
    : null;

$tgl = DateTime::createFromFormat('!Y-m-d', $tanggal);

if (!$tgl || $tgl->format('Y-m-d') !== $tanggal) {
    die("Tanggal transaksi tidak valid.");
}

if ($id_barang <= 0 || $jumlah < 1) {
    die("Data barang atau jumlah tidak valid.");
}

mysqli_begin_transaction($koneksi);

try {

    $stmt = mysqli_prepare($koneksi,
        "SELECT harga, stok FROM barang
         WHERE id_barang = ? FOR UPDATE"
    );

    mysqli_stmt_bind_param($stmt, "i", $id_barang);
    mysqli_stmt_execute($stmt);

    $barang = mysqli_fetch_assoc(
        mysqli_stmt_get_result($stmt)
    );

    if (!$barang) {
        throw new Exception("Barang tidak ditemukan.");
    }

    if ($barang['stok'] < $jumlah) {
        throw new Exception("Stok barang tidak mencukupi.");
    }

    $harga = $barang['harga'];
    $subtotal = $harga * $jumlah;

    $id_user = $_SESSION['id_user'];

    $stmt = mysqli_prepare($koneksi,
        "INSERT INTO transaksi
        (id_user, id_pelanggan, tanggal, total)
        VALUES (?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "iisd",
        $id_user,
        $id_pelanggan,
        $tanggal,
        $subtotal
    );

    mysqli_stmt_execute($stmt);

    $id_transaksi = mysqli_insert_id($koneksi);

    $stmt = mysqli_prepare($koneksi,
        "INSERT INTO transaksi_detail
        (id_transaksi, id_barang, jumlah, harga, subtotal)
        VALUES (?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "iiidd",
        $id_transaksi,
        $id_barang,
        $jumlah,
        $harga,
        $subtotal
    );

    mysqli_stmt_execute($stmt);

    $stmt = mysqli_prepare($koneksi,
        "UPDATE barang
         SET stok = stok - ?
         WHERE id_barang = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $jumlah,
        $id_barang
    );

    mysqli_stmt_execute($stmt);

    mysqli_commit($koneksi);

    header("Location: index.php");
    exit;

} catch (Throwable $e) {

    mysqli_rollback($koneksi);

    die("Transaksi gagal: " .
        htmlspecialchars($e->getMessage()));
}
?>
