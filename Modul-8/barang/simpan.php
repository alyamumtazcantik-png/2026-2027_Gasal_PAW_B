<?php
require_once '../koneksi.php';
require_once '../cek_owner.php';

if (isset($_POST['simpan'])) {

    $kode_barang = trim($_POST['kode_barang']);
    $id_supplier = (int) $_POST['id_supplier'];
    $nama_barang = trim($_POST['nama_barang']);
    $harga = (float) $_POST['harga'];
    $stok = (int) $_POST['stok'];

    $stmt = mysqli_prepare($koneksi,
        "INSERT INTO barang
        (kode_barang, id_supplier, nama_barang, harga, stok)
        VALUES (?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        die("Prepare gagal: " . mysqli_error($koneksi));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "sisdi",
        $kode_barang,
        $id_supplier,
        $nama_barang,
        $harga,
        $stok
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    } else {
        die("Gagal menyimpan barang: " .
            mysqli_stmt_error($stmt));
    }

} else {
    header("Location: tambah.php");
    exit;
}
?>
