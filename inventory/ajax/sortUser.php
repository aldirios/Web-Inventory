<?php
session_start();
require '../koneksi.php';
  if(!isset($_SESSION['login'])){
    header("location: ../login.php");
    exit;
  }
$user= [];
$orderby = $_POST["column_name"];
$order = $_POST["order"];
    $sorting = "SELECT * FROM user order by $orderby $order";
    $result = mysqli_query($conn, $sorting);

    while ($row = mysqli_fetch_assoc($result)) {
        $user[] = $row;
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
                <th><a class="column_sort" id="username" data-order="<?=$order?>" href="#" >username</a></th>
                <th><a class="column_sort" id="nama" data-order="<?=$order?>" href="#" >nama</a></th>
                <th><a class="column_sort" id="email" data-order="<?=$order?>" href="#" >email</a></th>
                <th><a class="column_sort" id="role" data-order="<?=$order?>" href="#" >role</a></th>
                <th>Action</th>
            </tr>
            <?php $i = 1; ?>
            <?php foreach ($user as $gd) : ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= $gd["username"]; ?></td>
                    <td><?= $gd["nama"]; ?></td>
                    <td><?= $gd["email"]; ?></td>
                    <td><?= $gd["role"]==1 ? 'Admin' : 'pegawai';?></td>
                    <td>
                        <a href="editUser.php?id=<?= $gd["id"]; ?>"><button class="">UPDATE</button></a>
                        <form action="" method="POST">
                            <input type="hidden" name="id" value="<?=$gd["id"]?>">
                            <button type="submit" name="hapus">HAPUS</button>
                        </form>
                    </td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </table>
</body>
</html>