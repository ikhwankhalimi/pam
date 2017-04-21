<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}


	public function phpprint()
	{
		$text = "HEllo";
		$printer = printer_open("PDF");

		printer_write($printer, $text);
		printer_close($printer);
	}

	public function cek_device()
	{
		$this->load->library('user_agent');

		echo $this->agent->browser()."";
		echo $this->agent->platform()." ";
		print_r($this->agent->languages());
	}

	public function cart_ex()
	{
		$this->load->library('cart');

		$data = array(
	        'id'      => 'sku_123ABC',
	        'qty'     => 1,
	        'price'   => 39.95,
	        'name'    => 'T-Shirt',
	        'coupon'         => 'XMAS-50OFF'
		);

		$this->cart->insert($data);

		echo json_encode($this->cart->contents());
	}

	public function deret()
	{
		$a = 10;

		for ($i=1; $i <= $a ; $i++) 
		{ 
			if ($i >= 6 && $i <= 9) {
				echo ".";
			}
			else
			{
				echo $i;
			}
		}
	}

	public function url_en()
	{
		$s = "hello kamu. kajskdjak askj,asjkdajai";

		echo urlencode($s);
	}

	public function sms_form()
	{
		$this->load->view('sms_form');
	}

	public function tgl()
	{
		$this->load->helper('tgl_helper');

		echo tgl_indo(date('Y-m-d'));
	}	

	public function send()
	{
		$pengirim = $this->input->post('pengirim');
		$nomor = $this->input->post('nomor');
		$pesan = urlencode($this->input->post('pesan'));

		$secret = urlencode("R#27L5xN@@");

		$html = file_get_contents("https://www.ginota.com/gemp/sms/json?apiKey=hM81%2BNzGCloUSEo3yDv12fF%2Bf0JZxwCiwa%2BzN5ZF4Js%3D&apiSecret=".$secret."&srcAddr=".$pengirim."&dstAddr=".$nomor."&content=".$pesan);
		
		echo $html;
	}

	public function cetak_suket()
	{
		$this->load->helper('dompdf_helper');

		//f4 = 8.27 in × 12.99 in

		$data['title'] = "helo";
		$html = $this->load->view('suket', $data, TRUE);
		pdf_create($html, 'suket.pdf', TRUE, 'potrait', 'A4');
	}

	public function get_kpu()
	{
		$curl  = curl_init();

		curl_setopt($curl, CURLOPT_URL, 'ibacor.com');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		 curl_setopt($curl, CURLOPT_USERAGENT, "Googlebot/2.1 (http://www.googlebot.com/bot.html)");

		curl_setopt($curl, CURLOPT_NOBODY, false);
		 curl_setopt($curl, CURLOPT_HTTPHEADER, array('Host : localhost'));


		$result = curl_exec($curl);

		curl_close($curl);

		print $result;

	}
}