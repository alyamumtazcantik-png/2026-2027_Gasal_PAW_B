<?php
include 'koneksi.php';

$akun = [
    ['owner', 'owner123', 'Administrator', 1],
    ['kasir', 'kasir123', 'Kasir', 2]
];

foreach ($akun as $data) {
    $username = $data[0];
    $password = password_hash($data[1], PASSWORD_DEFAULT);
    $nama = $data[2];
    $level = $data[3];

    $stmt = mysqli_prepare($koneksi,
        "INSERT INTO `user` (username, password, nama, level)
         VALUES (?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE
         password = VALUES(password),
         nama = VALUES(nama),
         level = VALUES(level)"
    );

    mysqli_stmt_bind_param(
        $stmt, "sssi",
        $username, $password, $nama, $level
    );

    mysqli_stmt_execute($stmt);
}

echo "Akun Owner dan Kasir berhasil dibuat!";
?>
