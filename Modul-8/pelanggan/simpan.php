
<?php
include '../koneksi.php';

if (isset($_POST['simpan'])) {

    $nama = trim($_POST['nama_pelanggan']);
    $alamat = trim($_POST['alamat']);
    $telepon = trim($_POST['telepon']);

    $stmt = mysqli_prepare($koneksi,
        "INSERT INTO pelanggan (nama_pelanggan, alamat, telepon)
         VALUES (?, ?, ?)"
    );

    mysqli_stmt_bind_param($stmt, "sss", $nama, $alamat, $telepon);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menyimpan pelanggan: " . mysqli_error($koneksi);
    }

} else {
    header("Location: tambah.php");
    exit;
}
?>
