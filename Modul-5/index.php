<?php
require 'koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM supplier ORDER BY id ASC");

if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Master Supplier</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            color: #444;
            margin: 0;
            padding: 35px 18px;
            font-size: 14px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        h1 {
            color: #52869c;
            font-size: 30px;
            font-weight: normal;
            border-bottom: 1px solid #ddd;
            padding-bottom: 14px;
            margin-bottom: 25px;
        }

        .toolbar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 18px;
        }

        .btn {
            display: inline-block;
            padding: 9px 13px;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-success {
            background: #78b64b;
        }

        .btn-edit {
            background: #ed790d;
            margin-right: 5px;
        }

        .btn-danger {
            background: #c9252d;
        }

        .btn:hover {
            opacity: 0.85;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #d6dce0;
            padding: 11px 10px;
            text-align: left;
        }

        th {
            background: #d9edf7;
            color: #444;
        }

        tbody tr:nth-child(even) {
            background: #fafafa;
        }

        tbody tr:hover {
            background: #f3f8fa;
        }

        .action-cell {
            white-space: nowrap;
        }

        .alert {
            background: #eaf6e7;
            border: 1px solid #c9e2c2;
            padding: 12px;
            margin-bottom: 18px;
            color: #47743b;
            border-radius: 4px;
        }

        .empty {
            text-align: center;
            padding: 20px;
        }

        @media(max-width: 600px) {
            .container {
                overflow-x: auto;
            }

            h1 {
                font-size: 24px;
            }

            table {
                min-width: 600px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Data Master Supplier</h1>

    <?php if (isset($_GET['pesan'])): ?>
        <div class="alert">
            <?php
            if ($_GET['pesan'] == 'tambah') {
                echo "Data berhasil ditambahkan!";
            } elseif ($_GET['pesan'] == 'edit') {
                echo "Data berhasil diperbarui!";
            } elseif ($_GET['pesan'] == 'hapus') {
                echo "Data berhasil dihapus!";
            }
            ?>
        </div>
    <?php endif; ?>

    <div class="toolbar">
        <a href="tambah.php" class="btn btn-success">
            Tambah Data
        </a>
    </div>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Telp</th>
            <th>Alamat</th>
            <th>Tindakan</th>
        </tr>

        <?php if (mysqli_num_rows($query) > 0): ?>

            <?php $no = 1; ?>

            <?php while ($data = mysqli_fetch_assoc($query)): ?>

                <tr>
                    <td><?= $no++; ?></td>

                    <td><?= htmlspecialchars($data['nama']); ?></td>

                    <td><?= htmlspecialchars($data['telp']); ?></td>

                    <td><?= htmlspecialchars($data['alamat']); ?></td>

                    <td class="action-cell">

                        <a href="edit.php?id=<?= $data['id']; ?>"
                           class="btn btn-edit">
                            Edit
                        </a>

                        <a href="hapus.php?id=<?= $data['id']; ?>"
                           class="btn btn-danger"
                           onclick="return confirm('Anda yakin akan menghapus supplier ini?')">
                            Hapus
                        </a>

                    </td>
                </tr>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>
                <td colspan="5" class="empty">
                    Belum ada data supplier.
                </td>
            </tr>

        <?php endif; ?>

    </table>

</div>

</body>
</html>