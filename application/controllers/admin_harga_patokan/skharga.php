<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skharga extends MY_AdminController {

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
	public function __construct()
    {
        parent::__construct();
        $this->load->model("model_admin_harga_patokan");
    }
	
	public function index()
	{
		$data['home_url'] = "Tampilan_utama";

		$data['kalkulasi_data'] = $this->model_admin_harga_patokan->getKalkulasiData();
		
        $this->template->load('template', "admin_harga_patokan/skharga", $data);
	}

	public function input()
	{
        //$data["peraturan"] = $this->model_admin_harga_patokan->peraturan();
		$data['home_url'] = 'Tampilan_utama';
        $this->template->load('template', "admin_harga_patokan/inputsk", $data);
	}
	function detail()
	{		
			$data["detail"] = $this->model_admin_harga_patokan->detail();
			$data["rincian"] = $this->model_admin_harga_patokan->_detail();

			$this->template->load('template', 'admin_harga_patokan/detail', $data);
	}
	public function add()
	{
		$data_user = $this->session->userdata();

		if (isset($_POST['submit'])) {

			$file_name = $data_user['id'].$data_user['id_pbph'].time();
			
			$this->form_validation->set_rules('nomor_invoice', 'Nomor Invoice', 'required');
			$this->form_validation->set_rules('total_harga', 'Total Harga', 'required');
			$this->form_validation->set_rules('total_volume', 'Total Volume', 'required');

			$this->form_validation->set_rules('id_pbph_pembeli','Perusahaan Pembeli','required|callback_check_pbph');
        	$this->form_validation->set_message('check_pbph', 'Perusahaan Pembeli belum dipilih');
			
			if(empty($_FILE['file_upload']['name'])) {
				$this->form_validation->set_rules('file_upload', 'File Invoice', 'required');
			}

			//validasi foto yang di upload
			$config['upload_path']          = './uploads/invoices/';
			$config['allowed_types']        = 'pdf';
			$config['max_size']             = 1024;
			$config['file_name']			= $file_name;
			
			$this->load->library('upload', $config);

			if ($this->form_validation->run() == FALSE && !$this->upload->do_upload('file_upload')) {
				
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('error', $error);
				
				$this->index();
			} else {
				$this->upload->data();
				$this->model_harga_patokan->save($data_user);

				$success = "Data Berhasil disimpan";
				$this->session->set_flashdata('success', $success);
				
				redirect('harga_patokan/input');
			}
		} else {
			$this->template->load('template', 'admin_harga_patokan/sk/add');
		}
	}
}
