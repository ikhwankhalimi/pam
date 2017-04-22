<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_apps extends CI_Model {

	public function get_all($table)
	{
		return $this->db->get($table);
	}

	public function daftar_rekening($params=array()){

		if (isset($params['no_rekening'])) 
		{
			$this->db->where('registrasi.no_rekening', $params['no_rekening']);
		}

		$this->db->select('registrasi.no_rekening, pelanggan.nama, pelanggan.alamat, pelanggan.telp, stand.stand_awal, stand.stand_akhir, stand.bulan, stand.tahun, golongan.nama_gol, golongan.tarif, registrasi.angsuran');
		$this->db->join('registrasi', 'registrasi.no_pelanggan = pelanggan.no_pelanggan');
		$this->db->join('golongan', 'golongan.id_gol = pelanggan.id_golongan');
		$this->db->join('stand', 'stand.no_rekening = registrasi.no_rekening');
		$this->db->order_by('stand.id','DESC');

		if (isset($params['bulan_max'])) 
		{
			$this->db->where("stand.bulan IN (SELECT MAX(bulan) AS bulan FROM stand WHERE no_rekening = '".$params['no_rekening']."' AND tahun='".date('Y')."')");
		}

		if (isset($params['no_rekening']))
		{
			return $this->db->get('pelanggan')->row_array();
		}
		else
		{	
			return $this->db->get('pelanggan')->result();
		}
	}

	public function get_id($table, $key, $id)
	{
		$this->db->where($key, $id);
		return $this->db->get($table);
	}

	public function insert_data($table, $record)
	{
		$this->db->insert($table, $record);
	}

	public function update_data($table, $record, $key, $value)
	{
		$this->db->where($key, $value);
		$this->db->update($table, $record);
	}

	public function delete_data($table, $key, $value)
	{
		$this->db->where($key, $value);
		$this->db->delete($table);
	}

	public function auto_number($table, $kolom, $lebar=0, $awalan=null)
	{
		$this->db->select($kolom)
				 ->from($table)
				 ->limit(1)
				 ->order_by($kolom, 'desc');
		$query = $this->db->get();

		$row = $query->result_array();
		$cek = $query->num_rows();
		
		if ($cek == 0) 
		{
			$nomor = 1;
		}
		else
		{
			$nomor = intval(substr($row[0][$kolom], strlen($awalan)))+1;
		}

		if ($lebar > 0) 
		{
			$result = $awalan.str_pad($nomor, $lebar, "0", STR_PAD_LEFT)+0;
		}
		else
		{
			$result = $awalan.$nomor;
		}

		return $result;
	}

	public function detail_pembayaran($params=array())
	{	
		if (isset($params['id_pembayaran'])) 
		{
			$this->db->where('id_pembayaran', $params['id_pembayaran']);
		}

		if (isset($params['no_rekening'])) 
		{
			$this->db->where('pembayaran.no_rekening', $params['no_rekening']);
		}

		if (isset($params['bulan'])) {
			$this->db->where('stand.bulan', $params['bulan']);
		}

		if (isset($params['tahun'])) {
			$this->db->where('stand.tahun', $params['tahun']);
		}

		if (isset($params['tgl1']) && isset($params['tgl2'])) 
		{
			$this->db->where("tgl_pembayaran >=", $params['tgl1']);
			$this->db->where("tgl_pembayaran <=", $params['tgl2']);	
		}

		$this->db->select("pembayaran.no_rekening, id_pembayaran, pelanggan.nama AS nama_pelanggan, pelanggan.alamat, pembayaran.no_rekening, pembayaran.bulan, pembayaran.tahun, pembayaran.pemakaian, golongan.nama_gol, golongan.tarif, stand.stand_awal, stand.stand_akhir, pembayaran.bayar_angsuran, registrasi.angsuran, pembayaran.adm, pembayaran.denda, tagihan_air, (tagihan_air + pembayaran.adm + pembayaran.denda + pembayaran.bayar_angsuran) AS total_tagihan, user.nama"); 

		
		$this->db->join('registrasi', 'registrasi.no_rekening = pembayaran.no_rekening');
		$this->db->join('pelanggan', 'pelanggan.no_pelanggan = registrasi.no_pelanggan');
		$this->db->join('golongan', 'golongan.id_gol = pelanggan.id_golongan');
		$this->db->join('stand', 'stand.no_rekening = registrasi.no_rekening');
		$this->db->join('user', 'user.id_user = pembayaran.id_user');

		if (isset($params['id_pembayaran'])) 
		{
			return $this->db->get('pembayaran')->row_array();
		}
		else
		{
			return $this->db->get('pembayaran')->result();
		}
	}

	public function view_pembayaran()
	{
		$this->db->select('pembayaran.id_pembayaran, .pembayaran.no_rekening, pembayaran.bulan, pembayaran.tahun, pembayaran.tgl_pembayaran, pelanggan.nama, pembayaran.bulan, pembayaran.tahun');
		$this->db->join('registrasi', 'registrasi.no_rekening = pembayaran.no_rekening');
		$this->db->join('pelanggan', 'pelanggan.no_pelanggan = registrasi.no_pelanggan');

		return $this->db->get('pembayaran')->result();
	}

	public function list_pelanggan($tgl1, $tgl2)
	{
		$this->db->select('registrasi.no_rekening, pelanggan.nama, pelanggan.alamat, pelanggan.telp, golongan.nama_gol, golongan.tarif, registrasi.tgl_registrasi');
		$this->db->join("pelanggan", "pelanggan.no_pelanggan = registrasi.no_pelanggan");
		$this->db->join('golongan', 'golongan.id_gol = pelanggan.id_golongan');
		$this->db->where('tgl_registrasi >=', $tgl1);
		$this->db->where('tgl_registrasi <=', $tgl2);

		return $this->db->get('registrasi')->result_array();

	}

	public function list_pembayaranold($params = array())
	{
		if (isset($params['id_pembayaran'])) 
		{
			$this->db->where('id_pembayaran', $params['id_pembayaran']);
		}

		if (isset($params['no_rekening'])) 
		{
			$this->db->where('pembayaran.no_rekening', $params['no_rekening']);
		}

		if (isset($params['bulan'])) {
			$this->db->where('stand.bulan', $params['bulan']);
			$this->db->where('stand.id = (SELECT max(id) FROM stand)');
		}

		if (isset($params['tahun'])) {
			$this->db->where('stand.tahun', $params['tahun']);
		}

		if (isset($params['tgl1']) && isset($params['tgl2'])) 
		{
			$this->db->where("tgl_pembayaran >=", $params['tgl1']);
			$this->db->where("tgl_pembayaran <=", $params['tgl2']);	
		}

		$this->db->select("pembayaran.no_rekening, id_pembayaran, pelanggan.nama AS nama_pelanggan, pelanggan.alamat, pembayaran.no_rekening, pembayaran.bulan, pembayaran.tahun, pembayaran.pemakaian, golongan.nama_gol, golongan.tarif, stand.stand_awal, stand.stand_akhir, pembayaran.bayar_angsuran, registrasi.angsuran, pembayaran.adm, pembayaran.denda, tagihan_air, (tagihan_air + pembayaran.adm + pembayaran.denda + pembayaran.bayar_angsuran) AS total_tagihan, user.nama, pembayaran.tgl_pembayaran"); 

		
		/*$this->db->join('registrasi', 'registrasi.no_rekening = pembayaran.no_rekening');
		$this->db->join('pelanggan', 'pelanggan.no_pelanggan = registrasi.no_pelanggan');
		$this->db->join('golongan', 'golongan.id_gol = pelanggan.id_golongan');
		$this->db->join('stand', 'stand.no_rekening = registrasi.no_rekening');
		$this->db->join('user', 'user.id_user = pembayaran.id_user');
		*/
		$this->db->join('pembayaran', 'pembayaran.no_rekening=pelanggan.no_pelanggan');
$this->db->join('golongan', 'golongan.id_gol=pelanggan.id_golongan');
$this->db->join('stand', 'stand.no_rekening=pembayaran.no_rekening');
$this->db->join('stand', 'stand.no_rekening=pelanggan.no_pelanggan');
$this->db->join('pembayaran', 'pembayaran.bulan=stand.bulan');
$this->db->join('pembayaran', 'pembayaran.tahun=stand.tahun');
$this->db->join('registrasi', 'registrasi.no_pelanggan = pembayaran.no_rekening');
$this->db->join('user', 'user.id_user = pembayaran.id_user');

		if (isset($params['id_pembayaran'])) 
		{
			return $this->db->get('pembayaran')->row_array();
		}
		else
		{
			return $this->db->get('pembayaran')->result_array();
		}
	}

	public function list_pembayaran($tgl1,$tgl2)
	{
		$this->db->query("SELECT pembayaran.no_rekening, id_pembayaran, pelanggan.nama AS nama_pelanggan, pelanggan.alamat, pembayaran.no_rekening, pembayaran.bulan, pembayaran.tahun, pembayaran.pemakaian, golongan.nama_gol, golongan.tarif, stand.stand_awal, stand.stand_akhir, pembayaran.bayar_angsuran, registrasi.angsuran, pembayaran.adm, pembayaran.denda, tagihan_air, (tagihan_air + pembayaran.adm + pembayaran.denda + pembayaran.bayar_angsuran) AS total_tagihan, user.nama, pembayaran.tgl_pembayaran FROM pembayaran,pelanggan,golongan,stand,user,registrasi WHERE pembayaran.no_rekening=pelanggan.no_pelanggan AND golongan.id_gol=pelanggan.id_golongan AND stand.no_rekening=pembayaran.no_rekening AND stand.no_rekening=pelanggan.no_pelanggan AND pembayaran.bulan=stand.bulan AND pembayaran.tahun=stand.tahun AND registrasi.no_pelanggan = pembayaran.no_rekening AND user.id_user = pembayaran.id_user AND pembayaran.tgl_pembayaran BETWEEN '$tgl1' AND '$tgl2'")->result_array();	
	}
}

/* End of file  */
/* Location: ./application/models/ */