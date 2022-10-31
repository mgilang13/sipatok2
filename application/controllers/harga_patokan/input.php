<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Input extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_harga_patokan');
	}

	public function index()
	{				
		$data_user = $this->session->userdata();
		$id_pbph = $data_user['id_pbph'];

		$data['pbph']  = $this->db->get_where('m_pbph', array('NPWSHUT_NO' => $id_pbph))->row_array();
		
		$this->template->load('template', 'harga_patokan/input', $data);
	}

	public function add()
	{
		$data_user = $this->session->userdata();

		if (isset($_POST['submit'])) {

			$file_name = $data_user['id'].$data_user['id_pbph'].time();
			
			$rules = $this->model_harga_patokan->rules();
			$this->form_validation->set_rules($rules);
			$this->form_validation->set_rules('id_pbph_pembeli','Perusahaan Pembeli','required|callback_check_pbph');
        	$this->form_validation->set_message('check_pbph', 'Perusahaan Pembeli belum dipilih');

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
				redirect('harga_patokan/input');
			}
		} else {
			$this->template->load('template', 'harga_patokan/input');
		}
	}
}
