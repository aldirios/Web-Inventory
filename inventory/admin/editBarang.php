<?php
session_start();
require '../koneksi.php';

  if(!isset($_SESSION['login'])){
    header("location: ../login.php");
    exit;
  }

$id = $_GET["id"];

$select_sql = "SELECT * FROM sstock_brg WHERE idx = $id";
$result = mysqli_query($conn, $select_sql);

$barang = [];

while ($row = mysqli_fetch_assoc($result)) {
    $barang[] = $row;
}
$barang = $barang[0];

if (isset($_POST["submit"])) {
    $nama = htmlspecialchars($_POST["nama"]);
    $jenis = htmlspecialchars($_POST["jenis"]);
    $merk = htmlspecialchars($_POST["merk"]);
    $ukuran = htmlspecialchars($_POST["ukuran"]);
    $satuan = htmlspecialchars($_POST["satuan"]);
    $lokasi = htmlspecialchars($_POST["lokasi"]);

    $update_sql = "UPDATE sstock_brg SET nama = '$nama', jenis= '$jenis', merk='$merk', ukuran = '$ukuran', satuan = '$satuan', lokasi = '$lokasi' WHERE idx = '$id'";
    $result = mysqli_query($conn, $update_sql);

    if ($result) {
        echo "<script>
            alert('Data berhasil diupdate!');
            document.location.href = 'barang.php';
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
    <h2>UPDATE DATA STOCK BARANG</h2>

    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $barang["idx"]; ?>">
        <label for="nama">Nama</label><br>
        <input type="text" name="nama" id="nama" value="<?= $barang["nama"]; ?>"><br>
        <label for="jenis">Jenis</label><br>
        <input type="text" name="jenis" id="jenis" value="<?= $barang["jenis"]; ?>"><br>
        <label for="merk">Merk</label><br>
        <input type="text" name="merk" id="merk" value="<?= $barang["merk"]; ?>"><br>
        <label for="ukuran">Ukuran</label><br>
        <input type="text" name="ukuran" id="ukuran" value="<?= $barang["ukuran"]; ?>"><br>
        <label for="stock">Stock</label><br>
        <input type="text" name="stock" id="stock" disabled value="<?= $barang["stock"]; ?>"><br>
        <label for="satuan">Satuan</label><br>
        <input type="text" name="satuan" id="satuan" value="<?= $barang["satuan"]; ?>"><br>
        <label for="lokasi">Lokasi</label><br>
        <input type="text" name="lokasi" id="lokasi" value="<?= $barang["lokasi"]; ?>"><br>
        <button type="submit" name="submit">Update</button><br>

        <i class="fas fa-chevron-circle-left"><a href="barang.php">Kembali</a></i> <br>
        </form>

        </div>
    </div>
</center>

</html>