<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title ?></title>
	
	<style>
		.body {
			margin : 20px;
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

	  sup {
	  	font-size:50%; line-height:250%;
	  }

	</style>

</head>
<body>
	
	<h3 align="center">
		Rekapitulasi Pembayaran Pelanggan 
		<br>
		Periode <?php echo $this->uri->segment(2)." s.d ".$this->uri->segment(3) ?>
		<br>
			<strong>BPSPAMS "<em>TIRTA ALAMI</em>"</strong><br>
					Desa Sitemu Kecamatan Taman Kabupaten Pemalang	
	</h3>
	<hr>
	<br>
	<table class="table table-bordered" style="width:100%; font-size: 11px;">
		<thead>
			<tr>
				<th>No Rekening</th>
				<th>Nama</th>
				<th>Bulan Bayar</th>
				<th>Pemakaian</th>

				<th>Stand Awal</th>
				<th>Stand Akhir</th>
				<th>Bayar Angsuran / Sisa Angsuran</th>
				<th>Administrasi / Denda</th>
				<th>Tagihan Air</th>
				<th>Total Tagihan</th>
				<th>Tanggal Pembayaran</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($q as $r): ?>
				<tr>
					<td><?php echo $r['no_rekening'] ?></td>
					<td><?php echo $r['nama_pelanggan'] ?></td>
					<td><?php echo show_month($r['bulan'])." ".$r['tahun'] ?></td>
					<td><?php echo $r['pemakaian']." M<sup>3</sup>" ?></td>
					<td><?php echo $r['stand_awal']." M<sup>3</sup>" ?></td>
					<td><?php echo $r['stand_akhir']." M<sup>3</sup>" ?></td>
					<td>Rp. <?php echo number_format($r['bayar_angsuran'])." / <span style='color:red'>Sisa Angsuran : Rp. ".number_format($r['angsuran'])."</span>" ?></td>
					<td>Adm : Rp. <?php echo number_format($r['adm'])." <br> Denda : Rp. ".number_format($r['denda']) ?></td>
					<td>Rp. <?php echo number_format($r['tagihan_air']) ?></td>
					<td>Rp. <?php echo number_format($r['total_tagihan']) ?></td>
					<td><?php echo $r['tgl_pembayaran'] ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</body>
</html>