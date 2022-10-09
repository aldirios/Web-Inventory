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

    if(isset($_POST['login'])){
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        $select = "SELECT * FROM user WHERE username = '$username'";

        $result = mysqli_query($conn, $select);
        
        if(mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password , $row['password'])){
                $_SESSION['id']=$row['id'];
                $_SESSION['role']=$row['role'];
                if($row['role']==1){
                    $_SESSION['login']=true;
                    header("location: admin/menu.php");
                    exit;
                }
                else if($row['role']==2){
                    $_SESSION['login']=true;
                    header("location: pegawai/menu.php");
                    exit;
                }
            }
        }
        $error = true;
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel = "stylesheet" type = "text/css" href = "style/login.css";
    <script
    src="https://kit.fontawesome.com/64d58efce2.js"
    crossorigin="anonymous"
    ></script>
</head>
<body style="background: url(image/bg.jpg); background-size: cover;" class="trans">
<center>
    <div class="white-text" style="margin-top: 100px;">
        <div class="form-container" >
            <form action="" method="post">
            <h2 class="title">LOGIN</h2>
                <?php if(isset($error)){
                    echo "<p style='color: red;'>Username atau Password salah!</p>";
                }?>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn solid" name="login">Login</button><br>
                <i class="fas fa-chevron-circle-left"><a href="index.php">Kembali</a></i><br>
                <p>belum memiliki akun?<a href="regis.php">Buat Akun</a></p>
            </form>
        </div>
    </div>
</center>
</body>
</html>