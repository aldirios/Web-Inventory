<?php
session_start();
require '../koneksi.php';

  if(!isset($_SESSION['login'])){
    header("location: ../login.php");
    exit;
  }

$id = $_GET["id"];

$select_sql = "SELECT * FROM pengeluaran WHERE id = $id";
$result = mysqli_query($conn, $select_sql);

$barang = [];

while ($row = mysqli_fetch_assoc($result)) {
    $barang[] = $row;
}
$barang = $barang[0];

if (isset($_POST["submit"])) {
    $jumlah = htmlspecialchars($_POST["jumlah"]);
    $tanggal = htmlspecialchars($_POST["tanggal"]);
    $pengeluaran = htmlspecialchars($_POST["pengeluaran"]);

    $update_sql = "UPDATE pengeluaran SET jumlah = '$jumlah', tanggal= '$tanggal', pengeluaran='$pengeluaran'";
    $result = mysqli_query($conn, $update_sql);

    if ($result) {
        echo "<script>
            alert('Data berhasil diupdate!');
            document.location.href = 'pengeluaran.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal diupdate!');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <link rel = "stylesheet" type = "text/css" href = "../style/style.css";
    <script
    src="https://kit.fontawesome.com/64d58efce2.js"
    crossorigin="anonymous"
    ></script>
</head>

<body style="background: url(../image/bg.jpg); background-size: cover;" class="trans">
<center>
    <div class="white-text" >
            <div class= "form-container">
    <h2>UPDATE DATA PENGELUARAN</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $barang["id"]; ?>">
        <label for="jumlah">jumlah</label><br>
        <input type="number" min="1" name="jumlah" id="jumlah" value="<?= $barang["jumlah"]; ?>"><br>
        <label for="tanggal">tanggal</label><br>
        <input type="date" name="tanggal" id="tanggal" value="<?= $barang["tanggal"]; ?>"><br>
        <label for="keterangan">keterangan</label><br>
        <input type="text" name="keterangan" id="keterangan" value="<?= $barang["keterangan"]; ?>"><br>
        <button type="submit" name="submit">Update</button><br>

        <i class="fas fa-chevron-circle-left"><a href="pengeluaran.php">Kembali</a></i>   
        </form>
        </div>
    </div>
</center>
</body>

</html>