
<?php
include '../koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM user");

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
</head>
<body>

<h2>Data User</h2>

<a href="tambah.php">Tambah User</a>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Username</th>
        <th>Nama</th>
        <th>Level</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;
    while ($data = mysqli_fetch_assoc($query)) {
    ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($data['username']); ?></td>
        <td><?= htmlspecialchars($data['nama']); ?></td>
        <td><?= $data['level'] == 1 ? 'Owner' : 'Kasir'; ?></td>
        <td>
            <a href="edit.php?id=<?= $data['id_user']; ?>">Edit</a> |
            <a href="hapus.php?id=<?= $data['id_user']; ?>"
               onclick="return confirm('Yakin ingin menghapus user?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>

</table>

</body>
</html>
