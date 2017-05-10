<a href="<?php echo site_url('pembayaran') ?>" class="btn btn-danger pull-right"><i class="fa fa-reply"></i> Kembali</a><br><br>
<div class="well well-sm">
	<h3 align="center"> Detail Angsuran</h3>
	
	<p>Data Angsuran : </p>
	<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered" id="datatable">
		<thead>
			<tr>
				<td>No Pelanggan</td>
				<td>Nama</td>
				<td>Bulan/Tahun</td>
				<td>Bayar Angsuran</td>				
			</tr>
		</thead>
		<tbody>
			<?php foreach ($detail as $p): ?>
				<tr>
					<td><?php echo $p->no_pelanggan ?></td>
					<td><?php echo $p->nama ?></td>
					<td><?php echo show_month($p->bulan) ?>/<?php echo $p->tahun ?></td>					
					<td>Rp. <?php echo $p->bayar_angsuran ?></td>					
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	</div>
	</div>	
</div>