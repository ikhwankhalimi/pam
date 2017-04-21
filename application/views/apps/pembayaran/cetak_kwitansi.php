<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title ?></title>
	<style>
		*{
			margin-top : 5px;
			margin-bottom: -10px;
		 }

		.rek {
			border-style: solid;
			padding: 2px;
			color : #FFFFFF;
		}
	  .table {
	    border-collapse: collapse !important;
		
	  }
	  .table td,
	  .table th {
	    background-color: #fff !important;
	    padding: 5pt;
	  }
	  .table-bordered th,
	  .table-bordered td {
	    border: 1px solid black !important;
	  }
	  .table-header{
	  	width : 100%;
	  }
	  .table-ttd{
	  	width: 100%;
	  }

	  .table tr {
	  	page-break-after: auto;
	  }

	  .sup {
	  	font-size:50%; line-height:250%;
	  }
	</style>
</head>
<body>

	<table style="width: 100%">
		<tr>
			<td width="150">
				<img src="<?php echo base_url('img/logo.jpg') ?>" width="190" height="100" alt="">
			</td>
			<td>
				<center><p>
					Badan Pengelola Sarana Penyedia Air Minum & Sanitasi<br>
					<strong>BPSPAMS "<em>TIRTA ALAMI</em>"</strong><br>
					Desa Sitemu Kecamatan Taman Kabupaten Pemalang <br>
					Telepon : 0878 3047 3883 / 0852 2881 2698
				</p><hr>

				<?php  
					if ($detail['angsuran'] == 0 ) 
					{
						$background = "blue";
						$font = "#000";
					}
					else
					{
						$background = "red";
						$font = "#ff2424";
					}
				?>
				<div class="rek" style="background-color: <?php echo $background; ?>">
					<strong><em>REKENING TAGIHAN AIR MINUM ( BERSIH )</em></strong>
				</div>
				</center>		
			</td>
		</tr>
	</table><br>
	<div align="right">
		<table>
				<tr>
					<td width="50">Nama</td> 
					<td width="5">:</td>
					<td width="150"><?php echo strtoupper($detail['nama_pelanggan']) ?></td>

					<td width="100">No. Pelanggan</td>
					<td width="5"> : </td>
					<td width="150"><?php echo $detail['no_rekening'] ?></td>	
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td><?php echo $detail['alamat'] ?></td>
					
					<td>Bulan / Tahun</td>
					<td>:</td>
					<td><?php echo show_month($detail['bulan'])." / ".$detail['tahun'] ?></td>
				</tr>
			</table>	
	</div>
	<table class="table table-bordered">
		<tr>
			<td width="70" align="center">Awal</td>
			<td width="30" align="center"><?php echo $detail['stand_awal'] ?></td>
			<td width="150">TARIF : FLAT</td>
			<td width="120" align="center">Tagihan Air</td>
			<td width="100"><?php echo "Rp. ".$detail['tagihan_air'] ?></td>
		</tr>
		<tr>
			<td align="center">Akhir</td>
			<td align="center"><?php echo $detail['stand_akhir'] ?></td>
			<td>Golongan : <?php echo ucwords($detail['nama_gol']) ?></td>
			<td align="center">Biaya Adm</td>
			<td><?php echo "Rp. ".$detail['adm'] ?></td>
		</tr>
		<tr>
			<td align="center">Pemakaian</td>
			<td align="center"><?php echo $detail['pemakaian'] ?></td>
			<td>Harga / M<span class="sup">3</span> : <?php echo "Rp. ".$detail['tarif'] ?></td>
			<td align="center">Denda</td>
			<td><?php echo "Rp. ".$detail['denda'] ?></td>
		</tr>
		<tr>
			<td align="center">Minimum</td>
			<td align="center">4</td>
			<td style="color : <?php echo $font ?>">Sisa Angsuran : <?php echo "Rp. ".$detail['angsuran'] ?></td>
			<td align="center">Jumlah Tagihan</td>
			<td><?php echo "Rp. ".$detail['total_tagihan'] ?></td>
		</tr>
	</table>
	<center><small>Info Tagihan, Pengaduan, Kritik Dan Saran Ke. 087830473883</small></center>
	<table style="width: 100%">
		<tr>
			<td>
			<p>ADMIN / KASIR</p>
			<br><br><br><br>
			<p><?php echo strtoupper($detail['nama']) ?></p><br>
			</td>


			<td>
			<p align="right">KETUA BPSPAMS</p>
			<br><br><br><br>
			<p align="right">BUKHOARI</p><br>
			
			</td>
		</tr>
	</table>
	<hr>
	<p align="center">	
		PEMBAYARAN IURAN MULAI TANGGAL 5 SAMPAI 20 SETIAP BULANNYA <br> GUNAKANLAH AIR SECARA BIJAK
	</p>
</body>
</html>