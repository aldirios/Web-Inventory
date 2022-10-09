<?php 
session_start();
	include 'koneksi.php';
	  if(!isset($_SESSION['login'])){
    header("location: login.php");
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style/laporan.css">
	<title>Laporan Stock Barang</title>
</head>
<body>
	<div id="print">
		<table class='table1'>
            <tr>
				<td>
					<img src='image/logo.png' height="120" width="120">
				</td>
				<td>
					<h2>INVENTORY</h2>
					<h2>Our Market</h2>
					<p>JL.PRAMUKA NO.10 SAMARINDA 70144 TELP(0012)2255771-234567 (FAX.2255771)</p>
				</td>
			</tr>
		</table>
		<table class='table'>   
			<td>
				<hr/>
			</td>
		</table>
			<td>
				<h3>LAPORAN STOCK BARANG</h3>
			</td>
		<table id="tabel" border='1' class='table'>
		<tr>
			<th>No</th>
			<th>Nama Barang</th>
			<th>Jenis</th>
			<th>Merk</th>
			<th>Ukuran</th>
			<th>Stock</th>
			<th>Satuan</th>
			<th>Lokasi</th>
		</tr>
		<?php 
			$brgs=mysqli_query($conn,"SELECT * from sstock_brg order by nama ASC");
			$no=1;
			while($p=mysqli_fetch_array($brgs)){
		?>
												
		<tr>
			<td><?php echo $no++ ?></td>
			<td><?php echo $p['nama'] ?></td>
			<td><?php echo $p['jenis'] ?></td>
			<td><?php echo $p['merk'] ?></td>
			<td><?php echo $p['ukuran'] ?></td>
			<td><?php echo $p['stock'] ?></td>
			<td><?php echo $p['satuan'] ?></td>
			<td><?php echo $p['lokasi'] ?></td>
		</tr>		
		<?php 
			}
		?>
		</table>
	</div>
	<div id="print">
		<table width="450" align="right" class="ttd">
			<tr>
				<td width="100px" style="padding:20px 20px 20px 20px;" align="center">
					<strong>SAMARINDA, <?= date('d-m-Y');?> </strong><br>
					<strong>MENGETAHUI</strong><br>
					<strong>KEPALA PERUSAHAAN</strong>
					<br><br><br><br>
					<strong><u>Aldi Rio Setiawan</u><br></strong>
					<small>NIM. 1915026038</small>

				</td>
			</tr>
		</table>
	</div>
<script>
	window.print();
</script>
</body>
</html>