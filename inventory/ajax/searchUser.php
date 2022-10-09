<?php
session_start();
require '../koneksi.php';

  if(!isset($_SESSION['login'])){
    header("location: ../login.php");
    exit;
  }

$keyword = $_GET["keyword"];

$user=[];

$search = "SELECT * FROM user WHERE 
            username LIKE '%$keyword%' OR 
            nama LIKE '%$keyword%' OR 
            email LIKE '%$keyword%'";
$result = mysqli_query($conn, $search);

while ($row = mysqli_fetch_assoc($result)) {
    $user[] = $row;
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
                <th><a class="column_sort" id="username" data-order="desc" href="#" >username</a></th>
                <th><a class="column_sort" id="nama" data-order="desc" href="#" >nama</a></th>
                <th><a class="column_sort" id="email" data-order="desc" href="#" >email</a></th>
                <th><a class="column_sort" id="role" data-order="desc" href="#" >role</a></th>
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
                        <a href="editUser.php?id=<?= $gd["id"]; ?>"><button class="">edit data</button></a>
                        <form action="" method="POST">
                            <input type="hidden" name="id" value="<?=$gd["id"]?>">
                            <button type="submit" name="hapus">hapus</button>
                        </form>
                    </td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
    </table>
</body>
</html>