<?php
    session_start();
    require '../koneksi.php';

  if(!isset($_SESSION['login'])){
    header("location: ../login.php");
    exit;
  }

    $id = $_SESSION['id'];
    $select = "SELECT * FROM user WHERE id = '$id'";

    $result = mysqli_query($conn, $select);
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
                document.location.href = 'menu.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal diupdate!');
                document.location.href = 'menu.php';
            </script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Menu Pegawai</title>
    <link rel="stylesheet" type="text/css" href="../style/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  </head>
  <body>

  <div class="header">
      <h1>INVENTORY</h1>
      <p>By <b>Our Market </b></p>
  </div>

  <div class="topbar">
    <h1>WebsiteInventory</h1>
    <div>
      <a href="../logout.php">LogOut</a>
      <a class="profil" href="#">profil</a>
    </div>
		</div>
    <div class="navigasi">
      <a href="#aboutus">About Us</a>
      <a href="#ouractivities">Our Activities</a>
      <a href="#content">Event</a>
      <a href="#contact">Contact</a>
      <a href="barang.php">Stock Barang</a>
      <a href="barangMasuk.php">Barang Masuk</a>
      <a href="barangKeluar.php">Barang Keluar</a>
      <a href="pengeluaran.php">pengeluaran</a>
      <div class="bingkai">        
        <a id="cetak" class="cetak" href="#">laporan</a>
        <div class="laporan">
          <div>
          <a href="../cetakstkbrg.php">Stock Barang</a>
          <a href="../cetakbrgmsk.php">Barang Masuk</a>
          <a href="../cetakbrgklr.php">Barang Keluar</a>
          <a href="../cetakpengeluaran.php">Pengeluaran</a>
        </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="side">
        <h2 id="aboutus">About Us</h2>
        <h5>Photo of us</h5>
        <div class="gambar" style="height: 230px">
          <img src="../image/gambar1.jpeg" alt="gambar1" />
        </div>
        <br />

        <h2 id="ouractivities">Our Activities</h2>
        <h5>Photo of our activities</h5>
        <div class="gambar" style="height: 230px">
          <img src="../image/gambar2.jpg" alt="gambar2" />
        </div>
        <br />
        <div class="gambar" style="height: 230px">
          <img src="../image/gambar3.jpg" alt="gambar3" />
        </div>
        <br />
        <div class="gambar" style="height: 230px">
          <img src="../image/gambar4.jpg" alt="gambar4" />
        </div>
        <br />
        <div class="gambar" style="height: 230px">
          <img src="../image/gambar5.jpg" alt="gambar5" />
        </div>
        <br />
        <br /><br /><br /><br /><br />

        <h2 id="contact">Contact Us</h2>


    <footer>
        <div>
            <p>Contact : </p><br>
            <a href="https://web.facebook.com/aldi.riosetiawan.1"><span class="fab fa-facebook-f">&emsp;</span></a>
            <a href="https://twitter.com/"><span class="fab fa-twitter">&emsp;</span></a>
            <a href="https://www.instagram.com/p/CUh0qFAvoJ3/?utm_medium=copy_link"><span class="fab fa-instagram">&emsp;</span></a>
            <a href="https://www.youtube.com/watch?v=je_5NDXoiW4"><span class="fab fa-youtube"></span>&emsp;</a><br><br>
            <a href="mailto:nikenpe19032001@gmail.com">nikenpe19032001@gmail.com</a><br><br>
            <a href="mailto:reeserox0@gmail.com">reeserox0@gmail.com</a><br><br>
            <a href="mailto:aldirios2409@gmail.com">aldirios2409@gmail.com</a><br><br>
        </div>
    </footer>


      </div>
      <div class="main">
        <h2 id="content">Event Natal</h2>
        <h5>Tahun 2022</h5>
        <div class="gambar2" style="height: 350px">
          <img src="../image/gambar6.jpg" alt="gambar6" />
        </div>
        <p>Catatan Event Natal</p>
        <p>
          Tanggal Event   : ...
        </p>
        <p>
          Batas Waktu Event   : ...
        </p>
        <p>
          Besar Potongan Harga   : ...
        </p>
        <p>
          Barang yang masuk Event   : ...
        </p>

        <br />
        <h2>Event Lebaran</h2>
        <h5>Tahun 2022</h5>
        <div class="gambar2" style="height: 350px">
          <img src="../image/gambar7.jpg" alt="gambar7" />
        </div>
        <p>Catatan Event Lebaran</p>
        <p>
          Tanggal Event   : ...
        </p>
        <p>
          Batas Waktu Event   : ...
        </p>
        <p>
          Besar Potongan Harga   : ...
        </p>
        <p>
          Barang yang masuk Event   : ...
        </p>

      </div>
    </div>

        <div class="banner1" >
    <center>
        <h2>Profil User</h2>
        <form action="" method="post">
        <input type="hidden" name="id" value="<?= $user["id"]; ?>">
        <label for="username">Username</label><br>
        <input style="color: #333;" type="text" name="username" id="username" disabled value="<?= $user["username"]; ?>"><br>
        <label for="email">Nama</label><br>
        <input type="text" name="nama" id="nama" value="<?= $user["nama"]; ?>" required><br>
        <label for="email">Email</label><br>
        <input type="email" name="email" id="email" value="<?= $user["email"]; ?>" required><br>
        <label for="password">Password</label><br>
        <input type="password" name="password" id="Password" value="" required><br>
        <button type="submit" name="submit">Update</button><br>
        </form>
  </center>
    </div>

		<script src="../java/jquery-3.6.0.min.js"></script>
		<script src="../java/script.js"></script>
  </body>
</html>
