
<?php
include 'cek_login.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Sistem Penjualan</title>
</head>
<body>

<h2>SISTEM INFORMASI PENJUALAN</h2>

<p>
    Selamat datang,
    <b><?php echo htmlspecialchars($_SESSION['nama']); ?></b>
</p>

<p>
    Level:
    <?php echo ($_SESSION['level'] == 1) ? "Owner" : "Kasir"; ?>
</p>

<hr>

<a href="home.php">Home</a> |

<?php if ($_SESSION['level'] == 1) { ?>

    <b>Data Master:</b>
    <a href="barang/index.php">Barang</a> |
    <a href="supplier/index.php">Supplier</a> |
    <a href="pelanggan/index.php">Pelanggan</a> |
    <a href="user/index.php">User</a> |

<?php } ?>

<a href="transaksi/index.php">Transaksi</a> |
<a href="laporan/index.php">Laporan</a> |

<a href="logout.php"
   onclick="return confirm('Yakin ingin logout?')">
   Logout
</a>

<hr>

<h3>Halaman Home</h3>

<p>Anda berhasil login ke Sistem Penjualan.</p>

</body>
</html>
