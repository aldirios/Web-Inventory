<?php
session_start();
require '../koneksi.php';

  if(!isset($_SESSION['login'])){
    header("location: ../login.php");
    exit;
  }

$keyword = $_GET["keyword"];

$admin = $_GET["admin"];
$masuk=[];

$search = "SELECT * FROM sbrg_masuk 
            INNER JOIN sstock_brg ON sbrg_masuk.idx = sstock_brg.idx WHERE 
            tgl LIKE '%$keyword%' OR 
            jumlah LIKE '%$keyword%' OR 
            keterangan LIKE '%$keyword%' OR 
            nama LIKE '%$keyword%' OR 
            jenis LIKE '%$keyword%' OR 
            merk LIKE '%$keyword%' OR 
            stock LIKE '%$keyword%'";
$result = mysqli_query($conn, $search);

while ($row = mysqli_fetch_assoc($result)) {
    $masuk[] = $row;
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
            <tr>
                <th>No</th>
                <th><a class="column_sort" id="tgl" data-order="desc" href="#" >tanggal</a></th>
                <th><a class="column_sort" id="nama" data-order="desc" href="#" >nama</a></th>
                <th><a class="column_sort" id="jumlah" data-order="desc" href="#" >jumlah</a></th>
                <th><a class="column_sort" id="jenis" data-order="desc" href="#" >jenis</a></th>
                <th><a class="column_sort" id="merk" data-order="desc" href="#" >merk</a></th>
                <th><a class="column_sort" id="stock" data-order="desc" href="#" >stock</a></th>
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
            <?php foreach ($masuk as $gd) : ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= $gd["tgl"]; ?></td>
                    <td><?= $gd["nama"]; ?></td>
                    <td><?= $gd["jumlah"]; ?></td>
                    <td><?= $gd["jenis"]; ?></td>
                    <td><?= $gd["merk"]; ?></td>
                    <td><?= $gd["stock"]; ?></td>
                    <td><?= $gd["keterangan"]; ?></td>
                    <?php
                        if($admin=="admin"){
                    ?>
                    <td>
                        <a href="editbarangmasuk.php?id=<?= $gd["id"]; ?>"><button class="">UPDATE</button></a>
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