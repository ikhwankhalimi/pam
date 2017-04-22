<link rel="stylesheet" href="<?php echo base_url();?>/assets/datepicker/datepicker3.css">
<script src="<?php echo base_url();?>/assets/datepicker/bootstrap-datepicker.js"></script>

<script>
	$(function(){
		$(".d").datepicker({
			format : 'yyyy-mm-dd'
		});
	})
</script>
<div class="well well-sm">
	<div class="row">
		<div class="col-md-4">
			<input type="text" id="tgl1" class="form-control d">
		</div>
		<div class="col-md-4">
			<input type="text" id="tgl2" class="form-control d">
		</div>
		<div class="col-md-2">
			<button type=button id="filter" class="btn btn-primary"> <i class="fa fa-search"></i> Filter</button>		
		</div>
	</div>
</div>

<div class="well">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="table table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<td>No Rekening</td>
							<td>Nama</td>
							<td>Bulan Bayar</td>
							<td>Pemakaian</td>
							<td>Golongan</td>
							<td>Stand Awal / Stand Akhir</td>
							<td>Bayar Angsuran / Sisa Angsuran</td>
							<td>Administrasi / Denda</td>
							<td>Tagihan Air</td>
							<td>Total Tagihan</td>
							<td>Tanggal Pembayaran</td>
						</tr>
					</thead>
					<tbody class="datanya">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="cetak" align="center"></div>


<script type="text/javascript">
	
	$(function(){

		$("#filter").click(function(){
			$.ajax({
				url : "<?php echo site_url('load_laporan_pembayaran') ?>",
				type : "POST",
				data : {
					tgl1 : $("#tgl1").val(),
					tgl2 : $("#tgl2").val()
				},
				dataType : "json",
				beforeSend : function(){
					$(".datanya").html('<tr><td colspan="6">Mencari data ... </td></tr>');
					$(".cetak").html('');
				},
				success : function(msg)
				{
					$(".datanya").html('');

					if (msg.status == "success") 
					{
						$.each(msg.data, function(i, v) {
								d = '<tr>';
								d += '	<td>'+this.no_rekening+'</td>';
								d += '	<td>'+this.nama+'</td>';
								d += ' 	<td>'+this.bulan+' '+this.tahun+'</td>';
								d += ' 	<td>'+this.pemakaian+' M<sup>3</sup></td>';
								d += ' 	<td>'+this.golongan+' / Rp. '+this.tarif+'</td>';
								d += '	<td>'+this.stand_awal+' / '+this.stand_akhir+'</td>';
								d += ' 	<td>Bayar Angsuran : Rp. '+this.bayar_angsuran+' <br> <span style="color:red">Sisa Angsuran : '+this.angsuran+'</span></td>';
								d += '	<td>Adm : Rp. '+this.adm+' <br> Denda : Rp. '+this.denda+'</td>';
								d += '	<td>Rp. '+this.tagihan_air+'</td>';
								d += '	<td>Rp. '+this.total_tagihan+'</td>';
								d += '	<td>'+this.tgl_bayar+'</td>';
								d += '</tr>';
							$(".datanya").append(d);
							$(".cetak").html('<a href="<?php echo site_url('cetak_laporan_pembayaran') ?>/'+$("#tgl1").val()+'/'+$("#tgl2").val()+'" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> Cetak</a>');
						});
					}
					else if(msg.status == "error")
					{
						$(".datanya").html('<tr><td colspan="6">'+msg.message+'</td></tr>');
						$(".cetak").html("");
					}
				}
			})			
		});

	})

</script>