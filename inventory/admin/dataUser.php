<?php
session_start();

require '../koneksi.php';

  if(!isset($_SESSION['login'])){
    header("location: ../login.php");
    exit;
  }

$read_sql = "SELECT * FROM user";
$result = mysqli_query($conn, $read_sql);

$user = [];

while ($row = mysqli_fetch_assoc($result)) {
    $user[] = $row;
}

if(isset($_POST['tambah'])){
        $username = htmlspecialchars($_POST['username']);
        $nama = htmlspecialchars($_POST['nama']);
        $password = htmlspecialchars($_POST['password']);
        $cpassword = htmlspecialchars($_POST['cpassword']);
        $email = htmlspecialchars($_POST['email']);
        $role = htmlspecialchars($_POST['role']);

        if($password === $cpassword){

            $password = password_hash($password, PASSWORD_DEFAULT);

            $result = mysqli_query($conn,"SELECT username from user WHERE username = '$username'");
            if(mysqli_fetch_assoc($result)){
                echo "
                <script>
                    alert('username telah digunakan. silahkan gunakan yang lain!');
                </script>";
            }else{
                $sql = "INSERT INTO user (username,nama,email,password,role) VALUES ('$username','$nama','$email','$password', '$role')";
                $result = mysqli_query($conn,$sql);
                if(mysqli_affected_rows($conn)>0){
                    echo "
                    <script>
                        alert('Tambah User Berhasil');
                        document.location.href = 'dataUser.php';
                    </script>";
                }else{
                    echo "
                    <script>
                        alert('Tambah User Gagal!');
                    </script>";
                }
            }
        }else{
            echo "<script>
                alert('Konfirmasi Password Anda Tidak Sesuai!');
                </script>";
        }
    }

if (isset($_POST['hapus'])) {
$id = $_POST["id"];

$delete_sql = "DELETE FROM user WHERE id = $id";
$result = mysqli_query($conn, $delete_sql);

if ($result) {
    echo "<script>
        alert('Data berhasil dihapus!');
        document.location.href = 'dataUser.php';
    </script>";
} else {
    echo "<script>
        alert('Data gagal dihapus!');
        document.location.href = 'dataUser.php';
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
    <title>Data User</title>
    <link rel = "stylesheet" type = "text/css" href = "../style/style.css";
    <script
    src="https://kit.fontawesome.com/64d58efce2.js"
    crossorigin="anonymous"
    ></script>
</head>

<body>
<center>
    <div class="container">
    <h1>Data User</h1>
    <input type="text" name="keyword" id="keyword" placeholder="Masukkan Kata Kunci...">
    <a id="tambah" class="tambah" href="#">tambah</a>
    
    <div id="table">
        <table class="table" >
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
    </div>
        <br><i class="fas fa-chevron-circle-left"><a href="menu.php">Kembali</a></i><br><br>
    </div>

    <div class="banner">
        <form action="" method="post">
        <h2 class="title">TAMBAH USER</h2>
                <?php if(isset($error)){
                    echo "<p style='color: red;'>Username atau Password salah!</p>";
                }?>
                    <input type="text" name="username" placeholder="Username" required><br>
                    <input type="text" name="nama" placeholder="Nama" required><br>
                    <input type="email" name="email" placeholder="E-mail" required><br>
                    <input type="password" name="password" placeholder="Password" required><br>
                    <input type="password" name="cpassword" placeholder="Ulangi Password" required><br>
                    <div class="role">
                    <input type="radio" name="role" id="role" required>
                    <label for="role">Admin</label>
                    <input type="radio" name="role" id="role" required>
                    <label for="role">Pegawai</label>
                    </div>

                <button type="submit" class="btn solid" name="tambah">Daftar</button><br>
                <i class="fas fa-chevron-circle-left"><a href="dataUser.php">Kembali</a></i>
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
    xhr.open("GET", "../ajax/searchUser.php?keyword=" + keyword.value, true);
    xhr.send();
    });

    $(document).ready(function(){
        $(document).on('click','.column_sort',function(){
            var column_name = $(this).attr("id");
            var order = $(this).data("order");
            $.ajax({
                url:"../ajax/sortUser.php",
                method:"post",
                data:{column_name:column_name,order:order},
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