<?php 
session_start();
include '../koneksi.php';

  if(!isset($_SESSION['login'])){
    header("location: ../login.php");
    exit;
  }

$id = $_GET["id"];

$select_sql = "SELECT * FROM sbrg_masuk 
            INNER JOIN sstock_brg ON sbrg_masuk.idx = sstock_brg.idx where id = '$id'";
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
        $tanggal = htmlspecialchars($_POST['tanggal']);

        $lihatstock = mysqli_query($conn,"SELECT * FROM sstock_brg WHERE idx='$idx'"); //lihat stock barang itu saat ini
        $stock = mysqli_fetch_array($lihatstock); //ambil datanya
        $stockskrg = $stock['stock'];//jumlah stocknya skrg

        $lihatdataskrg = mysqli_query($conn,"SELECT * FROM sbrg_masuk WHERE id='$id'"); //lihat qty saat ini
        $preqtyskrg = mysqli_fetch_array($lihatdataskrg); 
        $qtyskrg = $preqtyskrg['jumlah'];//jumlah skrg

        if($jumlah >= $qtyskrg){
            //ternyata inputan baru lebih besar jumlah masuknya, maka tambahi lagi stock barang
            $hitungselisih = $jumlah-$qtyskrg;
            $tambahistock = $stockskrg+$hitungselisih;

            $queryx = mysqli_query($conn,"UPDATE sstock_brg SET stock='$tambahistock' WHERE idx='$idx'");
            $updatedata1 = mysqli_query($conn,"UPDATE sbrg_masuk SET tgl='$tanggal',jumlah='$jumlah', keterangan='$keterangan' WHERE id='$id'");
            
            //cek apakah berhasil
            if ($updatedata1 && $queryx){

                echo " <div class='alert alert-success'>
                    <strong>Success!</strong> Redirecting you back in 1 seconds.
                </div>
                <meta http-equiv='refresh' content='1; url= barangMasuk.php'/>  ";
                } else { echo "<div class='alert alert-warning'>
                    <strong>Failed!</strong> Redirecting you back in 3 seconds.
                </div>
                <meta http-equiv='refresh' content='3; url= barangMasuk.php'/> ";
                };

        } else {
            //ternyata inputan baru lebih kecil jumlah masuknya, maka kurangi lagi stock barang
            $hitungselisih = $qtyskrg-$jumlah;
            $kurangistock = $stockskrg-$hitungselisih;
            echo $kurangistock;

            $query1 = mysqli_query($conn,"UPDATE sstock_brg SET stock='$kurangistock' WHERE idx='$idx'");

            $updatedata = mysqli_query($conn,"UPDATE sbrg_masuk SET tgl='$tanggal', jumlah='$jumlah', keterangan='$keterangan' WHERE id='$id'");
            
            //cek apakah berhasil
            if ($query1 && $updatedata){

                echo " <div class='alert alert-success'>
                    <strong>Success!</strong> Redirecting you back in 1 seconds.
                </div>
                <meta http-equiv='refresh' content='1; url= barangMasuk.php'/>  ";
                } else { echo "<div class='alert alert-warning'>
                    <strong>Failed!</strong> Redirecting you back in 3 seconds.
                </div>
                <meta http-equiv='refresh' content='3; url= barangMasuk.php'/> ";
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
    <title>Edit Barang Masuk</title>
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
    <h2>EDIT DATA BARANG MASUK</h2>
    <form action="" method="post">

        <label for="tanggal">Tanggal</label><br>
        <input type="date" id="tanggal" name="tanggal" value="<?php echo $b['tgl'] ?>"><br>
                                                            
        <label for="nama">Barang</label><br>
        <input type="text" id="nama" name="nama" value="<?php echo $b['nama'] ?> <?php echo $b['merk'] ?> <?php echo $b['jenis'] ?>" disabled><br>

        <label for="ukuran">Ukuran</label><br>
        <input type="text" id="ukuran" name="ukuran" value="<?php echo $b['ukuran'] ?>" disabled><br>

        <label for="jumlah">Jumlah</label><br>
        <input type="text" id="jumlah" name="jumlah" value="<?php echo $b['jumlah'] ?>"><br>
        
        <label for="keterangan">Keterangan</label><br>
        <input type="text" id="keterangan" name="keterangan" value="<?php echo $b['keterangan'] ?>"><br>
        <input type="hidden" name="id" value="<?=$b['id'];?>">
        <input type="hidden" name="idx" value="<?=$b['idx'];?>">
                                                            
        <button type="submit" class="btn btn-success" name="update">Simpan</button><br>

        <i class="fas fa-chevron-circle-left"><a href="barangMasuk.php">Kembali</a></i>   

        </form>
        </div>
    </div>
</center>
</body>
</html>