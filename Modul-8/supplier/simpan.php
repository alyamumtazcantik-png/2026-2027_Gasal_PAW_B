
<?php
include '../koneksi.php';
require_once '../cek_owner.php';

if (isset($_POST['simpan'])) {

    $nama = trim($_POST['nama_supplier']);
    $alamat = trim($_POST['alamat']);
    $telepon = trim($_POST['telepon']);

    $stmt = mysqli_prepare($koneksi,
        "INSERT INTO supplier (nama_supplier, alamat, telepon)
         VALUES (?, ?, ?)"
    );

    if (!$stmt) {
        die("Prepare gagal: " . mysqli_error($koneksi));
    }

    mysqli_stmt_bind_param($stmt, "sss", $nama, $alamat, $telepon);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    } else {
        die("Gagal menyimpan: " . mysqli_stmt_error($stmt));
    }

} else {
    header("Location: tambah.php");
    exit;
}
?>
