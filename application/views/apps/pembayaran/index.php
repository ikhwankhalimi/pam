<div class="">
	<div class="col-lg-12">
		<div class="well well-sm">
			<a href="javascript:tampil_rekening()" class="btn btn-primary">
				<i class="fa fa-list"></i> List rekening
			</a>
		</div>
	</div>
	<div class="col-lg-12">
		<table class="table table-bordered table-responsive" id="tabeldata">
			<thead>
				<tr>
					<th>No Transaksi</th>
					<th>No Rekening</th>
					<th>Nama</th>
					<th>Tanggal Transaksi</th>
					<th>#</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data_pembayaran as $row): ?>
					<tr>
						<td><?php echo $row->id_pembayaran ?></td>
						<td><?php echo $row->no_rekening ?></td>
						<td><?php echo $row->nama ?></td>
						<td><?php echo $row->tgl_pembayaran ?></td>

						<td>
							<a href="<?php echo site_url('view_pembayaran/'.$row->id_pembayaran."/".$row->no_rekening."/".$row->bulan."-".$row->tahun) ?>" class="btn btn-success"><i class="fa fa-eye"></i> View Detail</a>

						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>

<!-- Modal Fade -->
<div class="modal fade" role="modal" id="rekening_list">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				List Rekening
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped" id="datatable">
						<thead>
							<tr>
								<th>No Rekening</th>
								<th>Nama</th>
								<th>Alamat</th>
								<th>Telepon</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody class="list_body">
							<?php foreach ($daftar_rekening->result() as $list): ?>
								<tr>
									<td><?php echo $list->no_pelanggan ?></td>
									<td><?php echo $list->nama ?></td>
									<td><?php echo $list->alamat ?></td>
									<td><?php echo $list->telp ?></td>
									<td><a href="<?php echo site_url('input_pembayaran/'.$list->no_pelanggan) ?>" class="btn btn-success"><i class="fa fa-money"></i> Input Pembayaran</a></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function tampil_rekening()
	{
		$(function(){
			$("#rekening_list").modal("show");
		})
	}
</script>