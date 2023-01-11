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
		
		$data['user'] = $this->session->userdata();

        $data["hargapatokan"] = $this->model_harga_patokan->getAll($data['user']);
				
        $this->template->load('template', "harga_patokan/data", $data);
		//$this->template->load('template', 'harga_patokan/data');
	}

	function detail()
	{		
			$data['home_url'] = "Tampilan_operator";

			$id_invoice = $this->uri->segment(4);

			$data['user'] = $this->session->userdata();
			$data_user = $data['user'];
			
			$data["detail"] = $this->model_harga_patokan->detail();
			$data["rincian"] = $this->model_harga_patokan->_detail();
			
			$file_name = uniqid().'_'.$data_user['id_user'].$data_user['id_pbph'];
			
			if (isset($_POST['submit'])) { 

				$this->model_harga_patokan->edit_dikembalikan($file_name);
				redirect('Tampilan_operator');
			}

			$this->template->load('template', 'harga_patokan/detail', $data);
	}
	function verifikasi(){	
		$data['home_url'] = "Tampilan_operator";
		
		if (isset($_POST['submit'])) {
			$this->model_harga_patokan->update();
			redirect('harga_patokan/data');
		} else {
			//$id_guru     = $this->uri->segment(3);
			//$data['guru']  = $this->db->get_where('tbl_guru', array('id_guru' => $id_guru))->row_array();
			//$this->template->load('template', 'guru/edit', $data);
			echo 'gagal';
		}
	}

	function edit () {
			$data['user'] = $this->session->userdata();
			
			$data_user = $data['user'];
			
			$data["detail"] = $this->model_harga_patokan->detail();
			$data["rincian"] = $this->model_harga_patokan->_detail();

			$file_name = uniqid().'_'.$data_user['id_user'].$data_user['id_pbph'];

			if (isset($_POST['submit'])) { 
				$this->model_harga_patokan->edit_dikembalikan($file_name);
				redirect('harga_patokan/data');
			}

			$this->load->view('harga_patokan/edit', $data);
	}
}