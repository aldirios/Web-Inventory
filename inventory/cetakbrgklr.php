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
	<title>Laporan Barang Keluar</title>
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
				<h3>LAPORAN BARANG KELUAR</h3>
			</td>
		<table border='1' class='table' width="90%">
			<tr>
				<th>No</th>
				<th>Tanggal</th>
				<th>Nama Barang</th>
				<th>Jenis</th>
				<th>Merk</th>
				<th>Ukuran</th>
				<th>Jumlah</th>
				<th>Satuan</th>
				<th>Penerima</th>
				<th>Keterangan</th>
			</tr>
			<?php 
				$brg=mysqli_query($conn,"SELECT * FROM sbrg_keluar sb, sstock_brg st where sb.idx=st.idx ORDER BY sb.id ASC");
				$no=1;
				while($b=mysqli_fetch_array($brg)){
			?>
												
			<tr>
				<td><?php echo $no++ ?></td>
				<td><?php $tanggals=$b['tgl']; echo date("d-M-Y", strtotime($tanggals)) ?></td>
				<td><?php echo $b['nama'] ?></td>
				<td><?php echo $b['jenis'] ?></td>
				<td><?php echo $b['merk'] ?></td>
				<td><?php echo $b['ukuran'] ?></td>
				<td><?php echo $b['jumlah'] ?></td>
				<td><?php echo $b['satuan'] ?></td>
				<td><?php echo $b['penerima'] ?></td>
				<td><?php echo $b['keterangan'] ?></td>
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