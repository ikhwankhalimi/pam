<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Apps extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_user');
		$this->load->model('m_apps');
		$this->load->helper('dompdf_helper');
		$this->load->library('form_validation');

		// jika belum login
		if ($this->session->userdata('islogin') == false) 
		{
			$this->session->set_flashdata('info', '<div class="alert alert-danger" data-animate="fadeInDown"><i class="fa fa-info"></i> Mohon Maaf Anda Harus Login Terlebih Dahulu .. !!!</div>');
			
			redirect('login_user','refresh');
		}
	}

	public function index()
	{

		$data['title'] = "Home";


		$this->template->display('apps/home', $data);
	}

	public function coba_pdf()
	{
		$this->load->helper('dompdf_helper');
		
		$html = $this->load->view('pdf_coba', 0,TRUE);
	
		pdf_create($html, "helo", TRUE, 'potrait');
	}

	/**
	 * Golongan section
	 */
	public function golongan()
	{
		$data = array(
						"title" => "Golongan",
						"gol" => $this->m_apps->get_all('golongan')->result()
					);
		$this->template->display('apps/golongan/index', $data);
	}

	public function tambah_golongan()
	{
		$data['title'] = "Tambah Golongan";

		if (isset($_POST['simpan'])) 
		{
			$record = array(
								"id_gol" => '',
								"nama_gol" => $this->input->post('nama'),
								"tarif" => $this->input->post('tarif')
							);

			$this->m_apps->insert_data('golongan', $record);
				$this->session->set_flashdata('info', '<div class="alert alert-success"><i class="fa fa-info"></i> Tambah Data Berhasil</div>');
				redirect('golongan');
					
		}

		$this->template->display('apps/golongan/tambah', $data);
	}

	public function edit_golongan()
	{
		$data['title'] = "Edit Golongan";

		$id = $this->uri->segment(2);

		if(isset($_POST['edit']))
		{
			$record = array(
							"nama_gol" => $this->input->post('nama'),
							"tarif" => $this->input->post('tarif')
						 );
			 $this->m_apps->update_data('golongan', $record, 'id_gol', $id);
				$this->session->set_flashdata('info', '<div class="alert alert-success"><i class="fa fa-info"></i> Edit Data Berhasil</div>');
				redirect('golongan','refresh');
			 
					
		}

		$data['gol'] = $this->m_apps->get_id('golongan', 'id_gol', $id)->row();
		$this->template->display('apps/golongan/edit', $data);
	}

	public function hapus_golongan()
	{
		$id = $this->input->post('id');

		$this->m_apps->delete_data('golongan', 'id_gol', $id);
	}

	// End golongan

	/**
	 * Pelanggan section 
	 */

	public function pelanggan()
	{
		$data = array(
						"title" => "Data Pelanggan",
						"pelanggan" => $this->m_apps->get_all("pelanggan")->result() 
					 );
	
		$this->template->display('apps/pelanggan/index', $data);
	}

	public function edit_pelanggan()
	{
		$id = $this->input->post('id');

		$params = array(
							"nama" => $this->input->post('nama'),
							"alamat" => $this->input->post('alamat'),
							"telp" => $this->input->post('telp')
					   );

		$this->m_apps->update_data('pelanggan', $params, 'no_pelanggan', $id);
	
	}
	
	public function hapus_pelanggan() 
	{
		$id = $this->input->post('id');
		$this->m_apps->delete_data('pelanggan', 'no_pelanggan', $id);
	}

	public function pendaftaran()
	{
		$data = array(
						"title" => "Pendaftaran Pelanggan",
						"no_rekening" => $this->m_apps->auto_number('registrasi', 'no_rekening', 2, date('my')),
						"golongan" => $this->m_apps->get_all('golongan')->result()

					);


		$this->pendaftaran_rule();

		if ($this->form_validation->run() == TRUE) 
		{

			$pelanggan = array(
								 "no_pelanggan" => $this->input->post('no_rekening'),
								 "nama" => $this->input->post('nama'),
								 "alamat" => $this->input->post('alamat'),
								 "telp" => $this->input->post('telp'),
								 "id_golongan" => $this->input->post('id_golongan')
							  );

			$this->m_apps->insert_data('pelanggan', $pelanggan);

			$registrasi  = array(
								"no_rekening" => $this->input->post('no_rekening'),
							    "no_pelanggan" => $this->input->post('no_rekening'),
							    "angsuran" => 400000,
							    "tgl_registrasi" => date('Y-m-d')
							);		

			$this->m_apps->insert_data('registrasi', $registrasi);

			$stand = array(
							 "id" => '',
							 "no_rekening" => $this->input->post('no_rekening'),
							 "stand_awal" => 0,
							 "stand_akhir" => 0,
							 "bulan" => date('n'),
							 "tahun" => date('Y')
						  );

			$this->m_apps->insert_data('stand', $stand);
		
			$this->session->set_flashdata('input_success', '<div class="alert alert-success">Input pendaftaran berhasil</div>');
		}

		$this->template->display('apps/pelanggan/pendaftaran', $data);
	}

	public function pendaftaran_rule()
	{
		$this->form_validation->set_rules('nama', 'Nama',  'trim|required|xss_clean');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required|xss_clean');
		$this->form_validation->set_rules('telp', 'Telp', 'trim|required|xss_clean');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	public function cari_pelanggan()
	{
		$id = $this->input->post('no_pelanggan');

		$q = $this->m_apps->get_id('pelanggan', 'no_pelanggan', $id)->row_array();

		$data = array();

		if (empty($q)) {
			$data = array(
							"no_pelanggan" => "",
							"nama" => "",
							"alamat" => "",
							"telp" => ""
						);
		}
		else
		{
			$data = array(
							"no_pelanggan" => $q['no_pelanggan'],
							"nama" => $q['nama'],
							"alamat" => $q['alamat'],
							"telp" => $q['telp']
						 );
		}

		echo json_encode($data);
	}

	// END Pelanggan


	/**
	 * Pembayaran Section
	 */

	public function pembayaran()
	{
		$data['title']  = "Pembayaran";
		$data['daftar_rekening'] = $this->m_apps->get_all('pelanggan');
		$data['data_pembayaran'] = $this->m_apps->view_pembayaran();

		$this->template->display('apps/pembayaran/index', $data);
		
	}

	public function list_rekening()
	{
		echo json_encode($this->m_apps->daftar_rekening());
	}

	public function input_pembayaran()
	{
		$data['title'] = "Input Pembayaran";
		$id = $this->uri->segment(2);
		$data['data_rekening'] = $this->m_apps->daftar_rekening(array('no_rekening' => $id, 'bulan_max' => $id));
		$data['id'] = $this->m_apps->auto_number('pembayaran', 'id_pembayaran', 3, date('dmy'));

		//var initial
			$data['pesan'] = '';
		$this->pembayaran_rule();

		if ($this->form_validation->run() == TRUE) {
			
			
			$id_pembayaran = $this->input->post('id_pembayaran');
			$no_rekening  = $this->input->post('no_rekening');
			$pemakaian = $this->input->post('pemakaian');
			$stand_awal  = $this->input->post('stand_awal');
			$stand_akhir = $this->input->post('stand_akhir');
			$bulan = $this->input->post('bulan');
			$tahun = date('Y');
			$tgl_bayar = date('Y-m-d');
			$denda = $this->input->post('denda');
			$adm  = $this->input->post('biaya_admin');
			$bayar_angsuran = $this->input->post("angsuran");
			$totangsuran = $this->input->post("totangsuran");

			$params = array(
								"id_pembayaran" => $id_pembayaran,
								"no_rekening" => $no_rekening,
								"pemakaian" => $pemakaian,
								"bulan" => $bulan,
								"tahun" => $tahun,
								"tgl_pembayaran" => $tgl_bayar,
								"denda" => $denda,
								"adm" => $adm,
								"bayar_angsuran" => $bayar_angsuran,
								"tagihan_air" => $this->input->post('jumlah_bayar'),
								"id_user" => $this->session->userdata('id_user') 
							);
			$checkdata = $this->db->query("SELECT bulan FROM pembayaran
                           WHERE bulan ='$bulan' AND tahun = '$tahun' limit 1");
			
			

			if($checkdata->num_rows() > 0){
				$data['pesan'] = '<div class="alert alert-danger">
									<i class="fa fa-info-circle"></i> Pelanggan sudah bayar di bulan ini!
								</div>';
			}elseif($stand_akhir < $stand_awal){
				$data['pesan'] = '<div class="alert alert-danger">
									<i class="fa fa-info-circle"></i> Stand Akhir harus lebih besar dari stand awal!
								</div>';
			}elseif($bayar_angsuran > $totangsuran){
				$data['pesan'] = '<div class="alert alert-danger">
									<i class="fa fa-info-circle"></i> Jumlah Angsuran tidak boleh lebih dari Total Kekurangan Angsuran!
								</div>';
			}else{

			$this->m_apps->insert_data('pembayaran', $params);

			//Update Angsuran
			$ang = $data['data_rekening']['angsuran'] - $bayar_angsuran;
			$this->m_apps->update_data('registrasi', array('angsuran' => $ang), 'no_rekening', $no_rekening);

			 //insert Stand
			$rec = array(
							"id" => '',
							"no_rekening" => $no_rekening,
							"stand_awal" => $data['data_rekening']['stand_akhir'],
							"stand_akhir" => $this->input->post('stand_akhir'),
							"bulan" => $bulan,
							"tahun" => $tahun
						);

			$this->m_apps->insert_data('stand', $rec);

			redirect('pembayaran_sukses/'.$id_pembayaran."/".$no_rekening."/".$bulan."-".$tahun, 'refresh');
			}

		}
		// show time
		$this->template->display('apps/pembayaran/input_pembayaran', $data);
	}

	public function pembayaran_sukses()
	{
		$data['title'] = "Pembayaran Sukses";

		$id_pembayaran = $this->uri->segment(2);
		$no_rekening = $this->uri->segment(3);
		$period = explode("-", $this->uri->segment(4));

		$data['detail'] = $this->m_apps->detail_pembayaran(array('id_pembayaran' => $id_pembayaran, 'no_rekening' => $no_rekening, "bulan" => $period[0], "tahun" => $period[1]));

		$this->template->display('apps/pembayaran/pembayaran_sukses', $data);
	}

	public function cetak_kwitansi()
	{
		$data['title'] = "Kwitansi Pembayaran";

		$id_pembayaran = $this->uri->segment(2);
		$no_rekening = $this->uri->segment(3);
		$period = explode("-", $this->uri->segment(4));

		$data['detail'] = $this->m_apps->detail_pembayaran(array('id_pembayaran' => $id_pembayaran, 'no_rekening' => $no_rekening, "bulan" => $period[0], "tahun" => $period[1]));

		$html = $this->load->view('apps/pembayaran/cetak_kwitansi', $data, TRUE);

		pdf_create($html, 'Kwitansi Pembayaran '.$data['detail']['id_pembayaran'], TRUE, 'potrait', array(0,0,595.28,420.94));
	}

	public function view_pembayaran()
	{
		$data['title'] = "Detail Data Pembayaran";

		$id_pembayaran = $this->uri->segment(2);
		$no_rekening = $this->uri->segment(3);
		$period = explode("-", $this->uri->segment(4));


		$data['detail'] = $this->m_apps->detail_pembayaran(array('id_pembayaran' => $id_pembayaran, 'no_rekening' => $no_rekening, "bulan" => $period[0], "tahun" => $period[1]));

		$this->template->display('apps/pembayaran/view_pembayaran', $data);
	}

	public function pembayaran_rule()
	{
		$this->form_validation->set_rules('stand_akhir', 'Stand Akhir', 'trim|required|xss_clean');
		$this->form_validation->set_rules('bulan', 'Bulan', 'trim|required|xss_clean');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	public function cek_denda()
	{
		$b_now = $this->input->post('b_now');
		$b_set = date('n');
		$t_set = date('Y');

		if ($b_now < 10) 
		{
			$get_b = "0".$b_now;
		}
		else{
			$get_b = $b_now;
		}

		// b_set
		if ($b_set < 10) 
		{
			$get_b1 = "0".$b_set;
		}
		else{
			$get_b1 = $b_set;
		}

		$time1 = GregorianToJD($get_b, 01, date('Y'));
		$time2 = GregorianToJD($get_b1, 01, $t_set);

		if ($time1 <= $time2) 
		{

			if (date('d') >= 21) 
			{
				echo "3000";
			}
			else
			{
				echo "0";
			}
		}
		else
		{
			echo "0";
		}

	}

	/**
	 * Laporan
	 */


	public function laporan_pelanggan()
	{
		$data['title'] = "Laporan Pelanggan";

		$this->template->display('apps/laporan/laporan_pelanggan', $data);
	}

	public function load_laporan_pelanggan()
	{
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');

		$q = $this->m_apps->list_pelanggan($tgl1, $tgl2);

		if (empty($q)) 
		{
			$data['status'] = "error";
			$data['message'] = "Data tidak ditemukan. coba lagi";
		}
		else
		{
			$data['status'] = "success";
			$data['data'] = array();
			foreach ($q as $row)  {
			 	$data['data'][] = array(
			 		"no_rekening" => $row['no_rekening'],
			 		"nama" => $row['nama'],
			 		"alamat" => $row['alamat'],
			 		"telp" => $row['telp'],
			 		"tgl_registrasi" => $row['tgl_registrasi'],
			 		"golongan" => $row['nama_gol'],
			 		"tarif" => $row['tarif']
			 	);
			}
		}

		echo json_encode($data);

	}	

	public function cetak_laporan_pelanggan()
	{
		$tgl1 = $this->uri->segment(2);
		$tgl2 = $this->uri->segment(3);

		$data['title'] = "Cetak Laporan Pelanggan";
		$data['q'] = $this->m_apps->list_pelanggan($tgl1,$tgl2);

		$html = $this->load->view('apps/laporan/cetak_laporan_pelanggan', $data, TRUE);

		pdf_create($html, 'Laporan Pelanggan '.$tgl1.' s.d '.$tgl2.'.pdf', TRUE, 'landscape', 'A4');
	}

	public function laporan_pembayaran()
	{
		$data['title'] = "Laporan Pembayaran";

		$this->template->display('apps/laporan/laporan_pembayaran', $data);
	}

	public function load_laporan_pembayaran()
	{
		$tgl1 = $this->input->post('tgl1');
		$tgl2 = $this->input->post('tgl2');
	
		$q = $this->m_apps->list_pembayaran(array('tgl1' => $tgl1, 'tgl2' => $tgl2));

		if (empty($q)) 
		{
			$data['status'] = "error";
			$data['message'] = "Data tidak di temukan. coba lagi";
		}
		else
		{
			$data['status'] = "success";
			$data['data'] = array();

			foreach ($q as $r) {
				$data['data'][] = array(
									"no_rekening" => $r['no_rekening'],
									"nama" => $r['nama_pelanggan'],
									"bulan_bayar" => show_month($r['bulan'])." ".$r['tahun'],
									"pemakaian" => $r['pemakaian'],
									"golongan" => $r['nama_gol'],
									"tarif" => $r['tarif'],
									"stand_awal" => $r['stand_awal'],
									"stand_akhir" => $r['stand_akhir'],
									"bayar_angsuran" => $r['bayar_angsuran'],
									"angsuran" => $r['angsuran'],
									"adm" => $r['adm'],
									"denda" => $r['denda'],
									"bulan" => show_month($r['bulan']),
									"tahun" => $r['tahun'],
									"tagihan_air" => $r['tagihan_air'],
									"total_tagihan" => $r['total_tagihan'],
									"tgl_bayar" => $r['tgl_pembayaran']
								  );
			}
		}

		echo json_encode($data);
	}

	public function cetak_laporan_pembayaran()
	{
		$tgl1 = $this->uri->segment(2);
		$tgl2 = $this->uri->segment(3);

		$data['title'] = "Cetak Laporan Pembayaran";
		$data['q'] = $this->m_apps->list_pembayaran(array('tgl1' => $tgl1, 'tgl2' => $tgl2));

		$html = $this->load->view('apps/laporan/cetak_laporan_pembayaran', $data, TRUE);

		pdf_create($html, 'Laporan Pelanggan '.$tgl1.' s.d '.$tgl2.'.pdf', TRUE, 'landscape', 'A4');

	}

	public function load_datepicker()
	{
		
		
	}

	//END LAPORAN

	/**
	 * User section
	 */

	public function user()
	{
		$data = array(
						"title" => "User",
						"user" => $this->m_apps->get_all('user')
					);
		$this->template->display('apps/user/index', $data);
	}

	public function tambah_user()
	{
		$data['title'] = "Tambah User";

		if (isset($_POST['simpan'])) 
		{
			$rec = array(
							"id_user" => "",
							"nama" => $this->input->post('nama'),
							"email" => $this->input->post('email'),
							"username" => $this->input->post('username'),
							"password" => md5($this->input->post('password')),
						);

			$this->m_apps->insert_data('user', $rec);
				$this->session->set_flashdata('info', '<div class="alert alert-success"><i class="fa fa-info"></i> Tambah User Berhasil</div>');
				redirect('user','refresh');
			
		}

		$this->template->display('apps/user/tambah', $data);
	}

	public function edit_user()
	{
		$id = $this->session->userdata('id_user');

		$data['title'] = "Edit Data";

		if (isset($_POST['edit_user'])) 
		{
			$record = array(
								"nama" => $this->input->post('nama'),
								"email" => $this->input->post('email'),
								"username" => $this->input->post('username')
							);
			$this->m_apps->update_data('user', $record, 'id_user', $id);

			$this->session->set_flashdata('info', '<div class="alert alert-success"><i class="fa fa-info"></i> Update User Berhasil... </div>');
			redirect('edit_user','refresh');
		}

		$data['user'] = $this->m_apps->get_id('user', 'id_user', $id)->row();

		$this->template->display('apps/user/edit_user', $data);
	}

	public function ganti_password()
	{
		$id = $this->session->userdata('id_user');

		if (isset($_POST['ganti'])) 
		{
			$rec = array(
							"password" => md5($this->input->post('new'))
						);

			$this->m_apps->update_data('user', $rec, 'id_user', $id);

			$this->session->set_flashdata('info', '<div class="alert alert-danger"> <i class="fa fa-info"></i> Password berhasil di ubah</div>');

			redirect('ganti_password');
		}

		$data['title'] = "Ganti Password";
		$data['user'] = $this->m_apps->get_id('user', 'id_user', $id)->row();

		$this->template->display('apps/user/ganti_password', $data);
	}

	public function hapus_user()
	{

		$id = $this->input->post('id');
		$this->m_apps->delete_data('user', 'id_user', $id);

	}

	// End User
	public function logout()
	{
		$this->session->sess_destroy();

		$this->session->set_flashdata('info', '<div class="alert alert-success"><i class="fa fa-info"></i> Anda Telah Logout..</div>');
		redirect('login_user', 'refresh');
	}


}

/* End of file  */
/* Location: ./application/controllers/ */