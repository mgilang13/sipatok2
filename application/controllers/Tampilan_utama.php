<?php

	class Tampilan_utama extends MY_AdminController
	{
		
		function index()
		{
			$data['home_url'] ="Tampilan_utama";

			$qbelum = 'SELECT COUNT(*) AS hasil FROM invoices where is_verified = "0"';
			$data['belum'] = $this->db->query($qbelum)->row_array();

			$qverifproses = 'SELECT COUNT(*) AS hasil FROM invoices where is_verified = "1"';
			$data['verif1'] = $this->db->query($qverifproses)->row_array();

			$qveriftolak = 'SELECT COUNT(*) AS hasil FROM invoices where is_verified = "3"';
			$data['verif2'] = $this->db->query($qveriftolak)->row_array();

			$qkembali = 'SELECT COUNT(*) AS hasil FROM invoices where is_verified = "2"';
			$data['kembali'] = $this->db->query($qkembali)->row_array();

			$this->template->load('template', 'dashboard', $data);
		}

	}

?>