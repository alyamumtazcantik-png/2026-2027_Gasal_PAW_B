<?php
include 'koneksi.php';

$data = [
    ['owner', 'owner123', 'Pemilik Toko', 1],
    ['kasir', 'kasir123', 'Petugas Kasir', 2]
];

foreach ($data as $d) {

    $username = $d[0];
    $password = password_hash($d[1], PASSWORD_DEFAULT);
    $nama = $d[2];
    $level = $d[3];

    $cek = mysqli_prepare(
        $koneksi,
        "SELECT id_user FROM user WHERE username = ?"
    );

    mysqli_stmt_bind_param($cek, "s", $username);
    mysqli_stmt_execute($cek);

    $hasil = mysqli_stmt_get_result($cek);

    if (mysqli_num_rows($hasil) == 0) {

        $stmt = mysqli_prepare(
            $koneksi,
            "INSERT INTO user
            (username, password, nama, level)
            VALUES (?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sssi",
            $username,
            $password,
            $nama,
            $level
        );

        mysqli_stmt_execute($stmt);
        echo "Akun $username berhasil dibuat!<br>";

    } else {
        echo "Akun $username sudah tersedia.<br>";
    }
}
?>
