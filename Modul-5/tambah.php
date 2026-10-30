<?php
require 'koneksi.php';

if (isset($_POST['simpan'])) {

    $nama = trim($_POST['nama']);
    $telp = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    if ($nama == '' || $telp == '' || $alamat == '') {

        $error = "Semua kolom harus diisi!";

    } else {

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO supplier (nama, telp, alamat)
             VALUES (?, ?, ?)"
        );

        mysqli_stmt_bind_param($stmt, "sss", $nama, $telp, $alamat);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?pesan=tambah");
            exit;
        } else {
            $error = "Data gagal ditambahkan!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Supplier</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: white;
            color: #444;
            margin: 0;
            padding: 35px 18px;
        }

        .container {
            max-width: 850px;
            margin: auto;
        }

        h1 {
            color: #52869c;
            font-size: 30px;
            font-weight: normal;
            border-bottom: 1px solid #ddd;
            padding-bottom: 14px;
            margin-bottom: 28px;
        }

        form {
            max-width: 570px;
            margin: auto;
        }

        .form-group {
            display: grid;
            grid-template-columns: 125px 1fr;
            gap: 18px;
            align-items: center;
            margin-bottom: 15px;
        }

        label {
            text-align: right;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #86b7d1;
        }

        .btn {
            padding: 9px 13px;
            border: none;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-success {
            background: #78b64b;
        }

        .btn-danger {
            background: #c9252d;
        }

        .form-actions {
            margin-left: 143px;
        }

        .alert {
            background: #fbeaea;
            color: #a52a2a;
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 4px;
        }

        @media(max-width: 600px) {
            .form-group {
                grid-template-columns: 1fr;
                gap: 7px;
            }

            label {
                text-align: left;
            }

            .form-actions {
                margin-left: 0;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Tambah Data Master Supplier Baru</h1>

    <?php if (isset($error)): ?>
        <div class="alert">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama"
                   placeholder="Nama" required>
        </div>

        <div class="form-group">
            <label>Telp</label>
            <input type="text" name="telp"
                   placeholder="Telp" required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat"
                   placeholder="Alamat" required>
        </div>

        <div class="form-actions">

            <button type="submit" name="simpan"
                    class="btn btn-success">
                Simpan
            </button>

            <a href="index.php" class="btn btn-danger">
                Batal
            </a>

        </div>

    </form>

</div>

</body>
</html>