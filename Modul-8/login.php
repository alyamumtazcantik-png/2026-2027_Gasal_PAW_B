<?php
include 'koneksi.php';

if (isset($_SESSION['id_user'])) {
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Sistem Penjualan</title>
</head>
<body>

<h2>LOGIN SISTEM PENJUALAN</h2>

<?php
if (isset($_GET['pesan'])) {
    echo "<p>Username atau password salah!</p>";
}
?>

<form action="proses_login.php" method="POST">

    <label>Username</label><br>
    <input type="text" name="username" required>
    <br><br>

    <label>Password</label><br>
    <input type="password" name="password" required>
    <br><br>

    <button type="submit" name="login">Login</button>

</form>

</body>
</html>
