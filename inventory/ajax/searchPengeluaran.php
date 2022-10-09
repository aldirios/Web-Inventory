<?php
session_start();
require '../koneksi.php';
  if(!isset($_SESSION['login'])){
    header("location: ../login.php");
    exit;
  }
$keyword = $_GET["keyword"];
$admin = $_GET["admin"];
$stock=[];

$search = "SELECT * FROM pengeluaran WHERE 
            jumlah LIKE '%$keyword%' OR 
            tanggal LIKE '%$keyword%' OR 
            keterangan LIKE '%$keyword%'";
$result = mysqli_query($conn, $search);

while ($row = mysqli_fetch_assoc($result)) {
    $stock[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table class="table">
            <tr>
                <th>No</th>
                <th><a class="column_sort" id="jumlah" data-order="desc" href="#" >jumlah</a></th>
                <th><a class="column_sort" id="tanggal" data-order="desc" href="#" >tanggal</a></th>
                <th><a class="column_sort" id="keterangan" data-order="desc" href="#" >keterangan</a></th>
                <?php 
                    if($admin=="admin"){
                ?>
                <th>Action</th>
                <?php 
                    }
                ?>
            </tr>
            <?php $i = 1; ?>
            <?php foreach ($stock as $gd) : ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= $gd["jumlah"]; ?></td>
                    <td><?= $gd["tanggal"]; ?></td>
                    <td><?= $gd["keterangan"]; ?></td>
                    <?php 
                        if($admin=="admin"){
                    ?>
                    <td>
                        <a href="editPengeluaran.php?id=<?= $gd["id"]; ?>"><button class="">UPDATE</button></a>                    

                        <form action="" method="POST">
                            <input type="hidden" name="id" value="<?=$gd["id"]?>">
                            <button type="submit" name="hapus">DELETE</button>
                        </form>
                    </td>
                    <?php
                        }
                    ?>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </table>
</body>
</html>