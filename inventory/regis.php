<?php
    session_start();
    require 'koneksi.php';

    if(isset($_SESSION['login'])){
        if($_SESSION['role']==1){
            header("location: admin/menu.php");
            exit;
        }else{
            header("location: pegawai/menu.php");
            exit;
        }
    }

    if(isset($_POST['register'])){
        $username = htmlspecialchars($_POST['username']);
        $nama = htmlspecialchars($_POST['nama']);
        $password = htmlspecialchars($_POST['password']);
        $cpassword = htmlspecialchars($_POST['cpassword']);
        $email = htmlspecialchars($_POST['email']);

        if($password === $cpassword){

            $password = password_hash($password, PASSWORD_DEFAULT);

            $result = mysqli_query($conn,"SELECT username from user WHERE username = '$username'");
            if(mysqli_fetch_assoc($result)){
                echo "
                <script>
                    alert('username telah digunakan. silahkan gunakan yang lain!');
                    document.location.href = 'regis.php';
                </script>";
            }else{
                $sql = "INSERT INTO user (username,nama,email,password,role) VALUES ('$username','$nama','$email','$password', '2')";
                $result = mysqli_query($conn,$sql);
                if(mysqli_affected_rows($conn)>0){
                    echo "
                    <script>
                        alert('Registrasi Berhasil');
                        document.location.href = 'login.php';
                    </script>";
                }else{
                    echo "
                    <script>
                        alert('Registrasi Gagal!');
                        document.location.href = 'regis.php';
                    </script>";
                }
            }
        }else{
            echo "<script>
                alert('Konfirmasi Password Anda Tidak Sesuai!');
                document.location.href = 'regis.php';
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
    <title>Regis</title>
    <link rel = "stylesheet" type = "text/css" href = "style/login.css";
    <script
    src="https://kit.fontawesome.com/64d58efce2.js"
    crossorigin="anonymous"
    ></script>
</head>

<body style="background: url(image/bg.jpg); background-size: cover;" class="trans">
    <div class="container">
    <center>
    <div class="white-text" >
        <div class="form-container" >
            <form action="" method="post">
            <h2 class="title">REGISTRASI</h2>
                <?php if(isset($error)){
                    echo "<p style='color: red;'>Username atau Password salah!</p>";
                }?>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="nama" placeholder="nama" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="E-mail" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="cpassword" placeholder="Ulangi Password" required>
                </div>

                <button type="submit" class="btn solid" name="register">Daftar</button><br>
                <i class="fas fa-chevron-circle-left"><a href="index.php">Kembali</a></i><br>
                <p>Sudah memiliki akun?<a href="login.php">Login Sekarang</a></p>
            </form>
        </div>
    </div>
<center>
</body>
</html>