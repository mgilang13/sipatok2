<?php

	class Tampilan_utama extends CI_Controller
	{
		
		function index()
		{
			$qbelum = 'SELECT COUNT(*) AS hasil FROM invoices where is_verified = "0"';
			$data['belum'] = $this->db->query($qbelum)->row_array();

			$qverif = 'SELECT COUNT(*) AS hasil FROM invoices where is_verified = "1"';
			$data['verif'] = $this->db->query($qverif)->row_array();

			$qkembali = 'SELECT COUNT(*) AS hasil FROM invoices where is_verified = "2"';
			$data['kembali'] = $this->db->query($qkembali)->row_array();

			$this->template->load('template', 'dashboard', $data);
		}

	}

?>