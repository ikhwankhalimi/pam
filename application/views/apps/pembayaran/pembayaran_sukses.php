<div class="alert alert-success">
	<h3 align="center"> Pembayaran Tagihan Air Sukses</h3>
	
	<p>Data Pembayar : </p>
	<div class="row">
		<div class="col-md-4 col-xs-6">
			<p>
				<strong>No Transaksi  :</strong> <?php echo $detail['no_rekening'] ?><br>
				<strong>Nama :</strong> <?php echo $detail['nama_pelanggan'] ?><br>
				<strong>Alamat : </strong><?php echo $detail['alamat'] ?><br>
				<strong>Bulan / Tahun :</strong> <?php echo show_month($detail['bulan']). " / ".$detail['tahun'] ?><br>
				<strong>Stand Akhir :</strong> <?php echo $detail['stand_awal'] ?><br>
				<strong>Stand Akhir  :</strong> <?php echo $detail['stand_akhir'] ?><br>
				<strong>Pemakaian : </strong><?php echo $detail['pemakaian'] ?><br>
				<strong>Tarif : </FLAT <br>
				<strong>Golongan :</strong> <?php echo $detail['nama_gol'] ?><br>
				<strong>Harga / M<sup>3</sup> :</strong> Rp. <?php echo  number_format($detail['tarif']) ?><br>
			</p>

		</div>
		<div class="col-md-5 col-xs-6">
				<strong>Bayar Angsuran :</strong> <?php echo number_format($detail['bayar_angsuran']) ?> 
						<?php 
							if ($detail['angsuran'] == 0) 
							{
								echo "(LUNAS)";
							}
							else
							{
								echo "(Sisa Angsuran : ".number_format($detail['angsuran']).")"; 
							}
						?>
				<br>
				<strong>Biaya Administrasi :</strong> Rp. <?php echo number_format($detail['adm']) ?> <br>
				<strong>Denda :</strong> Rp. <?php echo number_format($detail['denda']) ?> <br>
				<strong>Tagihan Air :</strong> Rp. <?php echo number_format($detail['tagihan_air']) ?><br>
				<strong>Total Tagihan :</strong> Rp. <?php echo number_format($detail['total_tagihan']) ?>
		</div>
	</div>
	<div align="center"><a href="<?php echo site_url('cetak_kwitansi/'.$detail['id_pembayaran']."/".$detail['no_rekening']."/".$detail['bulan']."-".$detail['tahun']) ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Cetak </a></div>
</div>