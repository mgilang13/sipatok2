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
			$this->model_harga_patokan->save($data_user);
			redirect('harga_patokan/input');
		} else {
			$this->template->load('template', 'harga_patokan/input');
		}
	}
}
