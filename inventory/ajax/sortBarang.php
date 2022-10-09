<?php
session_start();
require '../koneksi.php';

  if(!isset($_SESSION['login'])){
    header("location: ../login.php");
    exit;
  }

$stock= [];
$admin= $_POST["admin"];
$orderby = $_POST["column_name"];
$order = $_POST["order"];
    $sorting = "SELECT * FROM sstock_brg order by $orderby $order";
    $result = mysqli_query($conn, $sorting);

    while ($row = mysqli_fetch_assoc($result)) {
        $stock[] = $row;
    }

if($order=='desc'){
    $order = 'asc';
}else{
    $order='desc';
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
    <table>
            <table class="table" >
            <tr>
                <th>No</th>
                <th><a class="column_sort" id="nama" data-order="<?=$order?>" href="#" >nama</a></th>
                <th><a class="column_sort" id="jenis" data-order="<?=$order?>" href="#" >jenis</a></th>
                <th><a class="column_sort" id="merk" data-order="<?=$order?>" href="#" >merk</a></th>
                <th><a class="column_sort" id="ukuran" data-order="<?=$order?>" href="#" >ukuran</a></th>
                <th><a class="column_sort" id="stock" data-order="<?=$order?>" href="#" >stock</a></th>
                <th><a class="column_sort" id="satuan" data-order="<?=$order?>" href="#" >satuan</a></th>
                <th><a class="column_sort" id="lokasi" data-order="<?=$order?>" href="#" >lokasi</a></th>
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
                    <td><?= $gd["nama"]; ?></td>
                    <td><?= $gd["jenis"]; ?></td>
                    <td><?= $gd["merk"]; ?></td>
                    <td><?= $gd["ukuran"]; ?></td>
                    <td><?= $gd["stock"]; ?></td>
                    <td><?= $gd["satuan"]; ?></td>
                    <td><?= $gd["lokasi"]; ?></td>
                    <?php 
                        if($admin=="admin"){
                    ?>
                    <td>
                        <a href="editBarang.php?id=<?= $gd["idx"]; ?>"><button class="">UPDATE</button></a>

                        <form action="" method="POST">
                            <input type="hidden" name="id" value="<?=$gd["idx"]?>">
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