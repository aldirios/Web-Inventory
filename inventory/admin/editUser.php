<?php
session_start();
require '../koneksi.php';

  if(!isset($_SESSION['login'])){
    header("location: ../login.php");
    exit;
  }

$id = $_GET["id"];
$select_sql = "SELECT * FROM user WHERE id = $id";
$result = mysqli_query($conn, $select_sql);

$user = [];

while ($row = mysqli_fetch_assoc($result)) {
    $user[] = $row;
}
$user = $user[0];

if (isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $role = htmlspecialchars($_POST['role']);

    $password = password_hash($password, PASSWORD_DEFAULT);

    $result = mysqli_query($conn,"SELECT username from user WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)){
        echo "
        <script>
            alert('username telah digunakan. silahkan gunakan yang lain!');
        </script>";
    }else{
        $update_sql = "UPDATE user SET  nama = '$nama' , email = '$email' , password = '$password' , role = '$role' WHERE id = '$id' ";
        $result = mysqli_query($conn, $update_sql);

        if ($result) {
            echo "<script>
                alert('Data berhasil diupdate!');
                document.location.href = 'dataUser.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal diupdate!');
                document.location.href = 'dataUser.php';
            </script>";
        }
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
        <h2>UPDATE DATA</h2>
        <form action="" method="post">
        <input type="hidden" name="id" value="<?= $user["id"]; ?>">
        <label for="username">Username</label><br>
        <input type="text" name="username" id="username" disabled value="<?= $user["username"]; ?>"><br>
        <label for="nama">Nama</label><br>
        <input type="text" name="nama" id="nama" required value="<?= $user["nama"]; ?>"><br>
        <label for="email">Email</label><br>
        <input type="email" name="email" id="email" required value="<?= $user["email"]; ?>"><br>
        <label for="password">Password</label><br>
        <input type="password" name="password" id="Password" required value=""><br>
        <label for="role">Jabatan</label><br>
        <div class="role">
        <input type="radio" name="role" id="role" required value="1" <?= $user['role'] == "1" ? "checked" : "" ?>>
        <label for="role">Admin</label>
        <input type="radio" name="role" id="role" required value="2" <?= $user['role'] == "2" ? "checked" : "" ?>>
        <label for="role">Pegawai</label>
        </div>
        <button type="submit" name="submit">Update</button><br>

        <i class="fas fa-chevron-circle-left"><a href="dataUser.php">Kembali</a></i><br>

        </form>
        </div>
    </div>
</center>
</body>

</html>