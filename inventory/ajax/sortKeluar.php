<?php
session_start();
require '../koneksi.php';
  if(!isset($_SESSION['login'])){
    header("location: ../login.php");
    exit;
  }
$keluar= [];
$admin = $_POST["admin"];
$orderby = $_POST["column_name"];
$order = $_POST["order"];
    $sorting = "SELECT * FROM sbrg_keluar 
                INNER JOIN sstock_brg ON sbrg_keluar.idx = sstock_brg.idx order by $orderby $order";
    $result = mysqli_query($conn, $sorting);

    while ($row = mysqli_fetch_assoc($result)) {
        $keluar[] = $row;
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
                <th><a class="column_sort" id="tgl" data-order="<?=$order?>" href="#" >tanggal</a></th>
                <th><a class="column_sort" id="nama" data-order="<?=$order?>" href="#" >nama</a></th>
                <th><a class="column_sort" id="jumlah" data-order="<?=$order?>" href="#" >jumlah</a></th>
                <th><a class="column_sort" id="stock" data-order="<?=$order?>" href="#" >stock</a></th>
                <th><a class="column_sort" id="penerima" data-order="<?=$order?>" href="#" >penerima</a></th>
                <th><a class="column_sort" id="keterangan" data-order="<?=$order?>" href="#" >keterangan</a></th> 
                <?php
                    if($admin=="admin"){
                ?>
                <th>Action</th>
                <?php
                    }
                ?>
            </tr>
            <?php $i = 1; ?>
            <?php foreach ($keluar as $gd) : ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= $gd["tgl"]; ?></td>
                    <td><?= $gd["nama"]; ?></td>
                    <td><?= $gd["jumlah"]; ?></td>
                    <td><?= $gd["stock"]; ?></td>
                    <td><?= $gd["penerima"]; ?></td>
                    <td><?= $gd["keterangan"]; ?></td>
                    <?php
                        if($admin=="admin"){
                    ?>
                    <td>
                        <a href="editbarangkeluar.php?id=<?= $gd["id"]; ?>"><button class="">UPDATE</button></a>
                        <form action="" method="POST">
                            <input type="hidden" name="id" value="<?=$gd["id"]?>">
                            <input type="hidden" name="idx" value="<?=$gd["idx"]?>">
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