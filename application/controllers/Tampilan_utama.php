<?php

	class Tampilan_utama extends MY_AdminController
	{
		
		public function __construct()
    {
		parent::__construct();
        $this->load->model("model_admin_harga_patokan");
    }

		function index()
		{
			$data['home_url'] ="Tampilan_utama";
			$is_verified = $this->uri->segment(3);

			$qbelum = 'SELECT COUNT(*) AS hasil FROM invoices where is_verified = "0"';
			$data['belum'] = $this->db->query($qbelum)->row_array();
			
			$qverifproses = 'SELECT COUNT(*) AS hasil FROM invoices where is_verified = "1"';
			$data['verif1'] = $this->db->query($qverifproses)->row_array();
			
			$qveriftolak = 'SELECT COUNT(*) AS hasil FROM invoices where is_verified = "3"';
			$data['verif2'] = $this->db->query($qveriftolak)->row_array();
			
			$qkembali = 'SELECT COUNT(*) AS hasil FROM invoices where is_verified = "2"';
			$data['kembali'] = $this->db->query($qkembali)->row_array();
	
			if(isset($is_verified)) {
				$data['hargapatokan'] = $this->model_admin_harga_patokan->getAllByVerification($is_verified);
			} else {
				$data['hargapatokan'] = $this->model_admin_harga_patokan->getAll();
			}

			$data["penjual"] = $this->model_admin_harga_patokan->getPenjual();
			
			$this->template->load('template', 'dashboard', $data);
		}
	}

?>