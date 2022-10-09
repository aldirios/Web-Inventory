<?php 
session_start();
include '../koneksi.php';

  if(!isset($_SESSION['login'])){
    header("location: ../login.php");
    exit;
  }

$id = $_GET["id"];

$select_sql = "SELECT * FROM sbrg_keluar 
            INNER JOIN sstock_brg ON sbrg_keluar.idx = sstock_brg.idx where id = '$id'";
$result = mysqli_query($conn, $select_sql);

$b = [];

while ($row = mysqli_fetch_assoc($result)) {
    $b[] = $row;
}
$b = $b[0];

    if(isset($_POST['update'])){
        $id = $_POST['id']; //iddata
        $idx = $_POST['idx']; //idbarang
        $jumlah = htmlspecialchars($_POST['jumlah']);
        $keterangan = htmlspecialchars($_POST['keterangan']);
        $penerima = htmlspecialchars($_POST['penerima']);
        $tanggal = htmlspecialchars($_POST['tanggal']);

        $lihatstock = mysqli_query($conn,"select * from sstock_brg where idx='$idx'"); //lihat stock barang itu saat ini
        $stocknya = mysqli_fetch_array($lihatstock); //ambil datanya
        $stockskrg = $stocknya['stock'];//jumlah stocknya skrg

        $lihatdataskrg = mysqli_query($conn,"select * from sbrg_keluar where id='$id'"); //lihat qty saat ini
        $preqtyskrg = mysqli_fetch_array($lihatdataskrg); 
        $qtyskrg = $preqtyskrg['jumlah'];//jumlah skrg

        if($jumlah >= $qtyskrg){
            //ternyata inputan baru lebih besar jumlah keluarnya, maka kurangi lagi stock barang
            $hitungselisih = $jumlah-$qtyskrg;
            $kurangistock = $stockskrg-$hitungselisih;

            $queryx = mysqli_query($conn,"update sstock_brg set stock='$kurangistock' where idx='$idx'");
            $updatedata1 = mysqli_query($conn,"update sbrg_keluar set tgl='$tanggal',jumlah='$jumlah',penerima='$penerima',keterangan='$keterangan' where id='$id'");
            
            //cek apakah berhasil
            if ($updatedata1 && $queryx){

                echo " <div class='alert alert-success'>
                    <strong>Success!</strong> Redirecting you back in 1 seconds.
                </div>
                <meta http-equiv='refresh' content='1; url= barangKeluar.php'/>  ";
                } else { echo "<div class='alert alert-warning'>
                    <strong>Failed!</strong> Redirecting you back in 3 seconds.
                </div>
                <meta http-equiv='refresh' content='3; url= barangKeluar.php'/> ";
                };

        } else {
            //ternyata inputan baru lebih kecil jumlah keluarnya, maka tambahi lagi stock barang
            $hitungselisih = $qtyskrg-$jumlah;
            $tambahistock = $stockskrg+$hitungselisih;

            $query1 = mysqli_query($conn,"update sstock_brg set stock='$tambahistock' where idx='$idx'");

            $updatedata = mysqli_query($conn,"update sbrg_keluar set tgl='$tanggal', jumlah='$jumlah', penerima='$penerima', keterangan='$keterangan' where id='$id'");
            
            //cek apakah berhasil
            if ($query1 && $updatedata){

                echo " <div class='alert alert-success'>
                    <strong>Success!</strong> Redirecting you back in 1 seconds.
                </div>
                <meta http-equiv='refresh' content='1; url= barangKeluar.php'/>  ";
                } else { echo "<div class='alert alert-warning'>
                    <strong>Failed!</strong> Redirecting you back in 3 seconds.
                </div>
                <meta http-equiv='refresh' content='3; url= barangKeluar.php'/> ";
                };

        };
    };
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang Keluar</title>
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
    <h2>EDIT DATA BARANG KELUAR</h2>
    <form action="" method="post">

        <label for="tanggal">Tanggal</label><br>
        <input type="date" id="tanggal" name="tanggal" value="<?php echo $b['tgl'] ?>"><br>
                                                            
        <label for="nama">Barang</label><br>
        <input type="text" id="nama" name="nama" value="<?php echo $b['nama'] ?> <?php echo $b['merk'] ?> <?php echo $b['jenis'] ?>" disabled><br>

        <label for="ukuran">Ukuran</label><br>
        <input type="text" id="ukuran" name="ukuran" value="<?php echo $b['ukuran'] ?>" disabled><br>

        <label for="jumlah">Jumlah</label><br>
        <input type="text" id="jumlah" name="jumlah" value="<?php echo $b['jumlah'] ?>"><br>
        
        <label for="penerima">Penerima</label><br>
        <input type="text" id="penerima" name="penerima" value="<?php echo $b['penerima'] ?>"><br>
        
        <label for="keterangan">Keterangan</label><br>
        <input type="text" id="keterangan" name="keterangan" value="<?php echo $b['keterangan'] ?>"><br>
        <input type="hidden" name="id" value="<?=$b['id'];?>">
        <input type="hidden" name="idx" value="<?=$b['idx'];?>">
        
        <button type="submit" class="btn btn-success" name="update">Simpan</button><br>

        <i class="fas fa-chevron-circle-left"><a href="barangKeluar.php">Kembali</a></i>

        </form>
        </div>
    </div>
</center>
</body>
</html>