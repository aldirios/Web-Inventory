<?php
session_start();

require '../koneksi.php';

  if(!isset($_SESSION['login'])){
    header("location: ../login.php");
    exit;
  }

$read_sql = "SELECT * FROM pengeluaran";
$result = mysqli_query($conn, $read_sql);

$stock = [];

while ($row = mysqli_fetch_assoc($result)) {
    $stock[] = $row;
}

if (isset($_POST['hapus'])) {
    $id = $_GET["id"];

    $delete_sql = "DELETE FROM pengeluaran WHERE id = $id";
    $result = mysqli_query($conn, $delete_sql);

    if ($result) {
        echo "<script>
            alert('Data berhasil dihapus!');
            document.location.href = 'pengeluaran.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal dihapus!');
            document.location.href = 'pengeluaran.php';
        </script>";
    }
}

if (isset($_POST["tambah"])) {
    $jumlah = htmlspecialchars($_POST["jumlah"]);
    $tanggal = htmlspecialchars($_POST["tanggal"]);
    $keterangan = htmlspecialchars($_POST["keterangan"]);

    $create_sql = "INSERT INTO pengeluaran (jumlah,tanggal,keterangan) VALUES ('$jumlah','$tanggal','$keterangan')";
    $result = mysqli_query($conn, $create_sql);

    if ($result) {
        echo "<script>
            alert('Data berhasil ditambahkan!');
            document.location.href = 'pengeluaran.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal ditambahkan!');
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
    <title>Stok Barang</title>
    <link rel = "stylesheet" type = "text/css" href = "../style/style.css";
    <script
    src="https://kit.fontawesome.com/64d58efce2.js"
    crossorigin="anonymous"
    ></script>
</head>

<body>
<center>
    <div class="container">
    <h1>DATA PENGELUARAN</h1>
    <input type="text" name="keyword" id="keyword" placeholder="Masukkan Kata Kunci..." required>
    <a id="tambah" class="tambah" href="#">tambah</a>
    
    <div id="table">
        <table class="table" >
            <tr>
                <th>No</th>
                <th><a class="column_sort" id="jumlah" data-order="desc" href="#" >jumlah</a></th>
                <th><a class="column_sort" id="tanggal" data-order="desc" href="#" >tanggal</a></th>
                <th><a class="column_sort" id="keterangan" data-order="desc" href="#" >keterangan</a></th>
            </tr>
            <?php $i = 1; ?>
            <?php foreach ($stock as $gd) : ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= $gd["jumlah"]; ?></td>
                    <td><?= $gd["tanggal"]; ?></td>
                    <td><?= $gd["keterangan"]; ?></td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </table>
    </div><br>
        <i class="fas fa-chevron-circle-left"><a href="menu.php">Kembali</a></i><br><br>
    </div>

    <div class="banner">
        <form class="form" action="" method="post">
        <h2>TAMBAH DATA PENGELUARAN</h2><br>

        <label>jumlah</label><br>
        <input type="number" min="1" name="jumlah" placeholder="jumlah" required><br>
 
        <label>tanggal</label><br>
        <input type="date" name="tanggal" placeholder="tanggal" required><br>

        <label>keterangan</label><br>
        <input type="text" name="keterangan" placeholder="keterangan" required><br>

        <button type="submit" class="btn solid" name="tambah">Tambah</button><br>
        <i class="fas fa-chevron-circle-left"><a href="pengeluaran.php">Kembali</a></i>        

    </form>
    </div>
</center>



<script src="../java/jquery-3.6.0.min.js"></script>
<script src="../java/script.js"></script>
<script>
    //mengambil elemen yang dibutuhkan
    var keyword = document.getElementById("keyword");
    var table = document.getElementById("table");

    //tambahkan event ketika keyword ditulis
    keyword.addEventListener("keyup", function () {
    //buat objek ajax
    var xhr = new XMLHttpRequest();

    //cek ajax
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
        table.innerHTML = xhr.responseText;
        }
    };

    //eksekusi ajax
    xhr.open("GET", "../ajax/searchPengeluaran.php?admin=pegawai&keyword=" + keyword.value, true);
    xhr.send();
    });

    $(document).ready(function(){
        $(document).on('click','.column_sort',function(){
            var column_name = $(this).attr("id");
            var order = $(this).data("order");
            var admin = "pegawai";
            $.ajax({
                url:"../ajax/sortPengeluaran.php",
                method:"post",
                data:{column_name:column_name,order:order,admin:admin},
                success:function(response)
                {
                   $('#table').html(response);
                }
            })
         });
        });
</script>
</body>
</html>