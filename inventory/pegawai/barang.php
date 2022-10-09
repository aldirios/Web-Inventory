<?php
session_start();

require '../koneksi.php';

  if(!isset($_SESSION['login'])){
    header("location: ../login.php");
    exit;
  }

$read_sql = "SELECT * FROM sstock_brg";
$result = mysqli_query($conn, $read_sql);

$stock = [];

while ($row = mysqli_fetch_assoc($result)) {
    $stock[] = $row;
}

if (isset($_POST['hapus'])) {
    $id = $_GET["id"];

    $delete_sql = "DELETE FROM sstock_brg WHERE idx = $id";
    $result = mysqli_query($conn, $delete_sql);

    if ($result) {
        echo "<script>
            alert('Data berhasil dihapus!');
            document.location.href = 'barang.php';
        </script>";
    } else {
        echo "<script>
            alert('Data gagal dihapus!');
            document.location.href = 'barang.php';
        </script>";
    }
}

if (isset($_POST["tambah"])) {
    $nama = htmlspecialchars($_POST["nama"]);
    $jenis = htmlspecialchars($_POST["jenis"]);
    $merk = htmlspecialchars($_POST["merk"]);
    $ukuran = htmlspecialchars($_POST["ukuran"]);
    $stock = htmlspecialchars($_POST["stock"]);
    $satuan = htmlspecialchars($_POST["satuan"]);
    $lokasi = htmlspecialchars($_POST["lokasi"]);

    $create_sql = "INSERT INTO sstock_brg (nama,jenis,merk,ukuran,stock,satuan,lokasi) VALUES ('$nama','$jenis','$merk','$ukuran','$stock','$satuan','$lokasi')";
    $result = mysqli_query($conn, $create_sql);

    if ($result) {
        echo "<script>
            alert('Data berhasil ditambahkan!');
            document.location.href = 'barang.php';
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
    <h1>Stock Barang</h1>
    <input type="text" name="keyword" id="keyword" placeholder="Masukkan Kata Kunci..." required>
    <a id="tambah" class="tambah" href="#">tambah</a>
    
    <div id="table">
        <table class="table" >
            <tr>
                <th>No</th>
                <th><a class="column_sort" id="nama" data-order="desc" href="#" >nama</a></th>
                <th><a class="column_sort" id="jenis" data-order="desc" href="#" >jenis</a></th>
                <th><a class="column_sort" id="merk" data-order="desc" href="#" >merk</a></th>
                <th><a class="column_sort" id="ukuran" data-order="desc" href="#" >ukuran</a></th>
                <th><a class="column_sort" id="stock" data-order="desc" href="#" >stock</a></th>
                <th><a class="column_sort" id="satuan" data-order="desc" href="#" >satuan</a></th>
                <th><a class="column_sort" id="lokasi" data-order="desc" href="#" >lokasi</a></th>
            </tr>
            <?php $i = 1; ?>
            <?php foreach ($stock as $gd) : ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= $gd["nama"]; ?></td>
                    <td><?= $gd["jenis"]; ?></td>
                    <td><?= $gd["merk"]; ?></td>
                    <td><?= $gd["ukuran"]; ?></td>
                    <td><?= $gd["stock"]; ?></td>
                    <td><?= $gd["satuan"]; ?></td>
                    <td><?= $gd["lokasi"]; ?></td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </table>
    </div><br>
        <i class="fas fa-chevron-circle-left"><a href="menu.php">Kembali</a></i><br><br>
    </div>

    <div class="banner">
        <form action="" method="post">
        <h2>TAMBAH DATA STOCK BARANG</h2><br>


        <input type="text" name="nama" placeholder="nama barang" required><br>
 
        <input type="text" name="jenis" placeholder="jenis barang" required><br>

        <input type="text" name="merk" placeholder="merk barang" required><br>

        <input type="text" name="ukuran" placeholder="ukuran barang" required><br>

        <input type="text" name="stock" placeholder="stock barang" required><br>

        <input type="text" name="satuan" placeholder="satuan barang" required><br>

        <input type="text" name="lokasi" placeholder="lokasi barang" required><br>

        <button type="submit" class="btn solid" name="tambah">Tambah</button><br>
        <i class="fas fa-chevron-circle-left"><a href="barang.php">Cancel</a></i>        

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
    xhr.open("GET", "../ajax/searchBarang.php?admin=pegawai&keyword=" + keyword.value, true);
    xhr.send();
    });

    $(document).ready(function(){
        $(document).on('click','.column_sort',function(){
            var column_name = $(this).attr("id");
            var order = $(this).data("order");
            var admin = "pegawai";
            $.ajax({
                url:"../ajax/sortBarang.php",
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