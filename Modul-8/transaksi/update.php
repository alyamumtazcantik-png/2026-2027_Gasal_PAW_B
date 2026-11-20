<?php
require_once '../cek_login.php';
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$id_transaksi = (int)$_POST['id_transaksi'];
$id_barang_baru = (int)$_POST['id_barang'];
$jumlah_baru = (int)$_POST['jumlah'];

$id_pelanggan = !empty($_POST['id_pelanggan'])
    ? (int)$_POST['id_pelanggan']
    : null;

if ($id_transaksi <= 0 || $id_barang_baru <= 0 || $jumlah_baru < 1) {
    die("Data transaksi tidak valid.");
}

mysqli_begin_transaction($koneksi);

try {

    $stmt = mysqli_prepare($koneksi,
        "SELECT id_barang, jumlah
         FROM transaksi_detail
         WHERE id_transaksi = ?
         FOR UPDATE"
    );

    mysqli_stmt_bind_param($stmt, "i", $id_transaksi);
    mysqli_stmt_execute($stmt);

    $lama = mysqli_fetch_assoc(
        mysqli_stmt_get_result($stmt)
    );

    if (!$lama) {
        throw new Exception("Transaksi tidak ditemukan.");
    }

    $stmt = mysqli_prepare($koneksi,
        "UPDATE barang
         SET stok = stok + ?
         WHERE id_barang = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $lama['jumlah'],
        $lama['id_barang']
    );

    mysqli_stmt_execute($stmt);

    $stmt = mysqli_prepare($koneksi,
        "SELECT harga, stok
         FROM barang
         WHERE id_barang = ?
         FOR UPDATE"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id_barang_baru
    );

    mysqli_stmt_execute($stmt);

    $barang = mysqli_fetch_assoc(
        mysqli_stmt_get_result($stmt)
    );

    if (!$barang) {
        throw new Exception("Barang tidak ditemukan.");
    }

    if ($barang['stok'] < $jumlah_baru) {
        throw new Exception("Stok barang tidak mencukupi.");
    }

    $harga = $barang['harga'];
    $subtotal = $harga * $jumlah_baru;

    $stmt = mysqli_prepare($koneksi,
        "UPDATE barang
         SET stok = stok - ?
         WHERE id_barang = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $jumlah_baru,
        $id_barang_baru
    );

    mysqli_stmt_execute($stmt);

    $stmt = mysqli_prepare($koneksi,
        "UPDATE transaksi_detail
         SET id_barang = ?,
             jumlah = ?,
             harga = ?,
             subtotal = ?
         WHERE id_transaksi = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "iiddi",
        $id_barang_baru,
        $jumlah_baru,
        $harga,
        $subtotal,
        $id_transaksi
    );

    mysqli_stmt_execute($stmt);

    $stmt = mysqli_prepare($koneksi,
        "UPDATE transaksi
         SET id_pelanggan = ?,
             total = ?
         WHERE id_transaksi = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "idi",
        $id_pelanggan,
        $subtotal,
        $id_transaksi
    );

    mysqli_stmt_execute($stmt);

    mysqli_commit($koneksi);

    header("Location: index.php");
    exit;

} catch (Throwable $e) {

    mysqli_rollback($koneksi);

    die("Update transaksi gagal: " .
        htmlspecialchars($e->getMessage()));
}
?>
