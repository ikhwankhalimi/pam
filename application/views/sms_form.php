<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>SMS</title>

	<script src="http://localhost/assets/jQuery-2.1.4.min.js"></script>
</head>
<body>
	<h3>SMS FORM</h3>
	 Nama Pengirim : <input type="text" id="pengirim"> <br>
	 Nomor Penerima : <input type="text" id="nomor"> <br>
	 Pesan : <textarea  id="pesan" cols="30" rows="10"></textarea> <br>

	 <button type="button" id="kirim">kirim</button>

	<br><br>

	<div class="notif"></div>

	<script>
			$(function(){
				$("#kirim").click(function(){


					var peng = $("#pengirim").val();
					var no = $("#nomor").val();
					var pes = $("#pesan").val();

					$.ajax({
						url : "<?php echo site_url('welcome/send') ?>",
						type : "POST",
						data : {
							pengirim : peng,
							nomor : no,
							pesan : pes
						},
						dataType : "JSON",
						success : function(msg){
							if (msg.status  == 0){
								$('.notif').html('<span style="color:green">Terkirim</span>');

							}
							else
							{
								$('.notif').html('<span style="color:red">Gagal</span><br>Status :'+msg.status+', desc = '+msg.desc);

														
							}
						},

						error : function(XMLHttpRequest){
							alert(XMLHttpRequest.responsetext);
						}
					})
				})

				});

	</script>
</body>
</html>