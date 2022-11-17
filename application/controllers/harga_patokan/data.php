<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends MY_OperatorController {

	public function __construct()
    {
        parent::__construct();
        $this->load->model("model_harga_patokan");
        $this->load->library('form_validation');
    }
	public function index()
	{
		$data['home_url'] = "Tampilan_operator";
		
		$data_user = $this->session->userdata();
		
        $data["hargapatokan"] = $this->model_harga_patokan->getAll($data_user);
		
        $this->template->load('template', "harga_patokan/data", $data);
		//$this->template->load('template', 'harga_patokan/data');
	}
	function detail()
	{		
			$data["detail"] = $this->model_harga_patokan->detail();
			$data["rincian"] = $this->model_harga_patokan->_detail();

			$this->template->load('template', 'harga_patokan/detail', $data);
	}
}