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

	</style>

</head>
<body>
	
	<h3 align="center">
		Rekapitulasi Pelanggan Terdaftar
		<br>
		<?php echo $this->uri->segment(2)." s.d ".$this->uri->segment(3) ?>
		<br>
			<strong>BPSPAMS "<em>TIRTA ALAMI</em>"</strong><br>
					Desa Sitemu Kecamatan Taman Kabupaten Pemalang	
	</h3>
	<hr>
	<br>
	<table class="table table-bordered" style="width:100%">
		<thead>
			<tr>
				<th>No rekening</th>
				<th>Nama</th>
				<th>Alamat</th>
				<th>Telp</th>
				<th>Golongan</th>
				<th>Tanggal Registrasi</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($q as $r): ?>
				<tr>
					<td><?php echo $r['no_rekening'] ?></td>
					<td><?php echo $r['nama'] ?></td>
					<td><?php echo $r['alamat'] ?></td>
					<td><?php echo $r['telp'] ?></td>
					<td><?php echo $r['nama_gol']." / Rp. ".number_format($r['tarif']) ?></td>
					<td><?php echo $r['tgl_registrasi'] ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</body>
</html>