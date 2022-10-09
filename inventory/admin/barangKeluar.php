<?php
session_start();

require '../koneksi.php';

  if(!isset($_SESSION['login'])){
    header("location: ../login.php");
    exit;
  }

$read_sql = "SELECT * FROM sbrg_keluar 
            INNER JOIN sstock_brg ON sbrg_keluar.idx = sstock_brg.idx";
$result = mysqli_query($conn, $read_sql);

$keluar = [];

while ($row = mysqli_fetch_assoc($result)) {
    $keluar[] = $row;
}

if(isset($_POST['hapus'])){
        $id = $_POST['id'];
        $idx = $_POST['idx'];

        $lihatstock = mysqli_query($conn,"select * from sstock_brg where idx='$idx'"); //lihat stock barang itu saat ini
        $stocknya = mysqli_fetch_array($lihatstock); //ambil datanya
        $stockskrg = $stocknya['stock'];//jumlah stocknya skrg

        $lihatdataskrg = mysqli_query($conn,"select * from sbrg_keluar where id='$id'"); //lihat qty saat ini
        $preqtyskrg = mysqli_fetch_array($lihatdataskrg); 
        $qtyskrg = $preqtyskrg['jumlah'];//jumlah skrg

        $adjuststock = $stockskrg+$qtyskrg;

        $queryx = mysqli_query($conn,"update sstock_brg set stock='$adjuststock' where idx='$idx'");
        $del = mysqli_query($conn,"delete from sbrg_keluar where id='$id'");

        
        //cek apakah berhasil
        if ($queryx && $del){

            echo " <div class='alert alert-success'>
                <strong>Success!</strong> Redirecting you back in 1 seconds.
              </div>
            <meta http-equiv='refresh' content='1; url= barangKeluar.php'/>  ";
            } else { echo "<div class='alert alert-warning'>
                <strong>Failed!</strong> Redirecting you back in 1 seconds.
              </div>
             <meta http-equiv='refresh' content='1; url= barangKeluar.php'/> ";
            }
}

if (isset($_POST['tambah'])) {
    $barang=$_POST['barang']; //id barang
    $qty=htmlspecialchars($_POST['qty']);
    $tanggal=htmlspecialchars($_POST['tanggal']);
    $penerima=htmlspecialchars($_POST['penerima']);
    $ket=htmlspecialchars($_POST['ket']);

    $dt=mysqli_query($conn,"select * from sstock_brg where idx='$barang'");
    $data=mysqli_fetch_array($dt);
    $sisa=$data['stock']-$qty;
    $query1 = mysqli_query($conn,"update sstock_brg set stock='$sisa' where idx='$barang'");

    $query2 = mysqli_query($conn,"insert into sbrg_keluar (idx,tgl,jumlah,penerima,keterangan) values('$barang','$tanggal','$qty','$penerima','$ket')");

    if($query1 && $query2){
        echo " <div class='alert alert-success'>
        <strong>Success!</strong> Redirecting you back in 1 seconds.
    </div>
    <meta http-equiv='refresh' content='1; url= barangKeluar.php'/>  ";

    } else {
        echo "<div class='alert alert-warning'>
        <strong>Failed!</strong> Redirecting you back in 1 seconds.
    </div>
    <meta http-equiv='refresh' content='1; url= barangKeluar.php'/> ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Keluar</title>
    <link rel = "stylesheet" type = "text/css" href = "../style/style.css";
    <script
    src="https://kit.fontawesome.com/64d58efce2.js"
    crossorigin="anonymous"
    ></script>
</head>

<body>
<center>
    <div class="container">
    <h1>Barang Keluar</h1>
    <input type="text" name="keyword" id="keyword" placeholder="masukkan kata kunci...">
    <a id="tambah" class="tambah" href="#">tambah</a>

    <div id="table">
        <table class="table">
            <tr>
                <th>No</th>
                <th><a class="column_sort" id="tgl" data-order="desc" href="#" >tanggal</a></th>
                <th><a class="column_sort" id="nama" data-order="desc" href="#" >nama</a></th>
                <th><a class="column_sort" id="jumlah" data-order="desc" href="#" >jumlah</a></th>
                <th><a class="column_sort" id="stock" data-order="desc" href="#" >stock</a></th>
                <th><a class="column_sort" id="penerima" data-order="desc" href="#" >penerima</a></th>
                <th><a class="column_sort" id="keterangan" data-order="desc" href="#" >keterangan</a></th>
                <th>Action</th>
            </tr>
            <?php $i = 1; ?>
            <?php foreach ($keluar as $gd) : ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= $gd["tgl"]; ?></td>
                    <td><?= $gd["nama"]; ?></td>
                    <td><?= $gd["jumlah"]; ?></td>
                    <td><?= $gd["stock"]; ?></td>
                    <td><?= $gd["penerima"]; ?></td>
                    <td><?= $gd["keterangan"]; ?></td>
                    <td>
                        <a href="editbarangkeluar.php?id=<?= $gd["id"]; ?>"><button class="">UPDATE</button></a>
                        <form action="" method="POST">
                            <input type="hidden" name="id" value="<?=$gd["id"]?>">
                            <input type="hidden" name="idx" value="<?=$gd["idx"]?>">
                            <button type="submit" name="hapus">DELETE</button>
                        </form>
                    </td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </table>
    </div><br>
    <i class="fas fa-chevron-circle-left"><a href="menu.php">Kembali</a></i><br><br>
    </div>


    <div class="banner">
    	<form action="" method="post">
            <h2 class="title">INPUT BARANG KELUAR</h2><br>
            <label>Tanggal</label><br>
	    	<input name="tanggal" type="date" required><br>

			<label>Nama Barang</label><br>
			<select name="barang" required>
                <?php
                    $det=mysqli_query($conn,"select * from sstock_brg order by nama ASC");
                    while($d=mysqli_fetch_array($det)){
                ?>
                <option value="<?php echo $d['idx'] ?>"><?php echo $d['nama'] ?> <?php echo $d['jenis'] ?> <?php echo $d['merk'] ?>, Uk. <?php echo $d['ukuran'] ?></option>
                <?php
                    }
                ?>
			</select><br>

			<label>Jumlah</label><br>
			<input name="qty" type="number" min="1" placeholder="Jumlah" required><br>


			<label>Penerima</label><br>
			<input name="penerima" type="text" class="form-control" placeholder="Penerima barang" required><br>

			<label>Keterangan</label><br>
			<input name="ket" type="text" placeholder="Keterangan" required><br>

    		<button type="submit" class="btn solid" name="tambah">Tambah</button><br>
            <i class="fas fa-chevron-circle-left"><a href="barangKeluar.php">Cancel</a></i>     
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
    xhr.open("GET", "../ajax/searchKeluar.php?admin=admin&keyword=" + keyword.value, true);
    xhr.send();
    });

    $(document).ready(function(){
        $(document).on('click','.column_sort',function(){
            var column_name = $(this).attr("id");
            var order = $(this).data("order");
            var admin = "admin";
            $.ajax({
                url:"../ajax/sortKeluar.php",
                method:"post",
                data:{column_name:column_name,order:order,admin:admin},
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