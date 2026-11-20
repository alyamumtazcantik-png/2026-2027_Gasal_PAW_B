
<?php
include '../koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM supplier");

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Supplier</title>
</head>
<body>

<h2>Data Supplier</h2>

<a href="tambah.php">Tambah Supplier</a>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama Supplier</th>
        <th>Alamat</th>
        <th>Telepon</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;
    while ($data = mysqli_fetch_assoc($query)) {
    ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($data['nama_supplier']); ?></td>
        <td><?= htmlspecialchars($data['alamat']); ?></td>
        <td><?= htmlspecialchars($data['telepon']); ?></td>
        <td>
            <a href="edit.php?id=<?= $data['id_supplier']; ?>">Edit</a> |
            <a href="hapus.php?id=<?= $data['id_supplier']; ?>"
               onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>

</table>

</body>
</html>
