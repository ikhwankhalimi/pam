<div class="error">
	
	<?php  
		echo $pesan;
		echo form_error('stand_akhir');
		echo form_error('bulan');
		if ($angsuranbayar->num_rows() > 0) {
		$ang = $angsuranbayar->row();			
		if ($ang->bayar_angsuran == 0) {			
	?>
	<br>

	<div class="alert alert-danger">
									<i class="fa fa-info-circle"></i> Informasi Tunggakan Angsuran! <br>
				Pembayaran Angsuran Bulan lalu anda kosong (Rp. 0)
				
				<br>Anda harus membayar angsuran pada bulan ini, atau dapat melihat history angsuran selengkapnya
				<a href="<?php echo site_url('view_angsuran/'.$data_rekening['no_rekening']) ?>" target="_blank">disini</a>
								</div>
	<?php }} ?>			
</div>
<h2 align="right">TOTAL BAYAR  : Rp. <span class="print_tot"></span></h2>
<h4 align="right">JUMLAH UANG : Rp. <span class="print_uang"></span></h4>
<h4 align="right">KEMBALIAN : Rp. <span class="print_kembali"></span></h4>
<div class="row">
	<div class="col-md-6 well well-sm">
		<form action="" method="POST">
			<input type="hidden" name="id_pembayaran" value="<?php echo $id ?>">
			<div class="form-group">
				<label for="" class="control-label">No Rekening : </label>
				<input type="text" class="form-control" name="no_rekening" readonly="" value="<?php echo $data_rekening['no_rekening'] ?>">
			</div>
			<div class="form-group">
				<label for="" class="control-label">Nama :</label>
				<input type="text" name="nama" class="form-control" value="<?php echo $data_rekening['nama'] ?>" readonly>
			</div>
			<div class="form-group">
				<label for="" class="control-label">Stand Awal : </label>
				<input type="text" class="form-control" name="stand_awal" value="<?php echo $data_rekening['stand_akhir'] ?>" readonly>
				<p>* <em>Otomatis mengambil stand akhir dari stand sebelumnya</em></p>
			</div>
			<div class="form-group">
				<label for="" class="control-label">Stand Akhir :</label>
				<input type="text" class="form-control" name="stand_akhir" placeholder="Masukan stand akhir"> 
			</div>
			<div class="form-group">
				<label for="" class="control-label">Pemakaian : </label>
				<input type="text" class="form-control" name="pemakaian" value="0" readonly>
			</div>
			<div class="form-group">
				<label for="" class="control-label">Bulan Pembayaran : </label>
				<select name="bulan" id="bulan" class="form-control" disabled="">
					<option value=""> -- Pilih Bulan --</option>
					<?php  
						for ($i=1; $i <= 12 ; $i++) { 
							echo '<option value="'.$i.'">'.show_month($i).'</option>';
						}
					?>	
				</select>
			</div>
			<div class="form-group">
				<label for="" class="control-label">Denda : </label>
				<input type="text" class="form-control" name="denda" value="0" readonly>
			</div>
			
		
	</div>
	<div class="col-md-6">
		<div class="well well-sm">
			<div class="form-group">
				<label for="" class="control-label">Biaya Administrasi : </label>
				<input type="text" name="biaya_admin" class="form-control" value="5000" readonly>
			</div>
			<div class="form-group">
				Isi form dibawah, jika Pelanggan ingin membayar angsuran.
				<br>Sisa Angsuran : Rp. <?php echo number_format($data_rekening['angsuran']) ?>								
				<p class="d">
				<input type="text" class="form-control angsuran" name="angsuran" value="0" placeholder="Masukan berapa angsuran yang 
				dibayar" <?php if($data_rekening['angsuran'] == 0) { echo "readonly"; } ?>/>
				<input type="hidden" class="form-control" name="totangsuran" value="<?php echo $data_rekening['angsuran'] ?>">

				</p>
			</div>

			<div class="form-group">
				<label for="" class="control-label">Jumlah Tagihan Air : </label>
				<input type="text" name="jumlah_bayar" class="form-control" value="0" readonly="">
				<p><em>* Pemakaian x Tarif/M <sup>3</sup></em></p> 				
			</div>
			
			<div class="form-group">
				<label for="" class="control-label">Total Bayar</label>
				<input type="text" name="total_bayar" class="form-control" id="tot" value = "0" readonly> 
				<p><em>* Jumlah Tagihan + Biaya Administrasi + (Angsuran) + Denda</em></p>
			</div>
			<div class="form-group">
				<label for="" class="control-label">Jumlah Uang : </label>
				<input type="text" name="jumlah_uang" class="form-control" id="uang">
			</div>

			<div class="form-group">
				<button type="submit" name="simpan" class="btn btn-success">Input Pembayaran</button>
			</div>
		</div>
		</form>
	</div>
</div>

<script>

//hitung pemakaian
	$(function(){
		$("input[name=stand_akhir]").keyup(function(){
			var awal = $("input[name=stand_awal]").val();
			var akhir = $("input[name=stand_akhir]").val();

				tot_pemakaian = parseInt(akhir) - parseInt(awal);

				if (akhir == ""){
					$("input[name=pemakaian]").val(0);
					$("#bulan").attr('disabled', '');;
				}
				else
				{
					$("input[name=pemakaian]").val(tot_pemakaian);
					$("#bulan").removeAttr('disabled');
				}

		});

	})
	// cek denda
	$(function(){
		$("#bulan").change(function(){
			var bulan_now = $(this).val();
			var bulan_set = <?php echo $data_rekening['bulan'] ?>;
			var tahun_set = <?php echo $data_rekening['tahun'] ?>;
			
			$.ajax({
				url  : "<?php echo site_url('cek_denda') ?>",
				type : "POST",
				data : {
					b_now : bulan_now,
					b_set : bulan_set,
					t_set : tahun_set
				},
				success : function(msg){
					$("input[name=denda]").val(msg);

					var tarif  = <?php echo $data_rekening['tarif'] ?>;
					var admin = $('input[name=biaya_admin]').val();
					var denda = $('input[name=denda]').val();
					var jumlah_bayar = $('input[name=jumlah_bayar]').val();
					var angsuran = $("input[name=angsuran]").val();

					var total_bayar = parseInt(jumlah_bayar) + parseInt(admin) + parseInt(denda) + parseInt(angsuran);			
					$("input[name=total_bayar]").val(total_bayar);
					$(".print_tot").html($("input[name=total_bayar]").val());

					//hitung kembalian
					var total = $("#tot").val();

					var kembali = parseInt($("#uang").val()) - parseInt(total);

					$(".print_uang").html($("#uang").val());
					$(".print_kembali").html(kembali);
				}
			})

		});
	})


	//hitung jumlah bayar
	$(function(){
		$("input[name=stand_akhir]").keyup(function(){
			var pemakaian = $("input[name=pemakaian]").val();
			var tarif  = <?php echo $data_rekening['tarif'] ?>;
			var admin = $('input[name=biaya_admin]').val();
			var denda = $('input[name=denda]').val();
			var angsuran = $("input[name=angsuran]").val();

			if (pemakaian <= 4)
			{
				jumlah_bayar = 7200;
			}
			else
			{
				jumlah_bayar = parseInt(pemakaian) * parseInt(tarif);
			}
			
			var total_bayar = parseInt(jumlah_bayar) + parseInt(admin) + parseInt(denda) + parseInt(angsuran);

			$("input[name=jumlah_bayar]").val(jumlah_bayar);
			$("input[name=total_bayar]").val(total_bayar);	
			$(".print_tot").html($("input[name=total_bayar]").val());	

			//hitung kembalian
			var total = $("#tot").val();

			var kembali = parseInt($("#uang").val()) - parseInt(total);

			$(".print_uang").html($("#uang").val());
			$(".print_kembali").html(kembali);	
		});

	})

	$(function(){
		$(".angsuran").keyup(function(){
			var tarif  = <?php echo $data_rekening['tarif'] ?>;
			var admin = $('input[name=biaya_admin]').val();
			var denda = $('input[name=denda]').val();
			var jumlah_bayar = $('input[name=jumlah_bayar]').val();
			var angsuran = $("input[name=angsuran]").val();

			var total_bayar = parseInt(jumlah_bayar) + parseInt(admin) + parseInt(denda) + parseInt(angsuran);
			$("input[name=total_bayar]").val(total_bayar);
			$(".print_tot").html($("input[name=total_bayar]").val());

			//hitung kembalian
			var total = $("#tot").val();

			var kembali = parseInt($("#uang").val()) - parseInt(total);

			$(".print_uang").html($("#uang").val());
			$(".print_kembali").html(kembali);
		});
	})

	//Uang kembali
	$(function(){
		$("#uang").keyup(function(){
			var total = $("#tot").val();

			var kembali = parseInt($("#uang").val()) - parseInt(total);

			$(".print_uang").html($("#uang").val());
			$(".print_kembali").html(kembali);
		})
	})
</script>