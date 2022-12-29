<?php

	class Tampilan_operator extends MY_OperatorController
	{
		
		public function __construct()
    	{
			parent::__construct();
        	$this->load->model("model_harga_patokan");
    	}

		public function index()
		{
			$data['home_url']="Tampilan_operator";

			$is_verified = $this->uri->segment(3);

			$data_user = $this->session->userdata();
			
			$id_role = $data_user['id_role'];
			$data['id_role'] = $id_role;
		
			$invoices_userRole_users = "select count(*) as hasil
										from users u
										join user_role ur 
											on ur.id_user = u.id
										join invoices i 
											on i.id_user = u.id";
			//dinas
			$invoices_mPBPH = "	select count(*) as hasil
								from invoices i
								join m_pbph mp 
								on i.id_pbph_penjual = mp.NPWSHUT_NO";
			// balai
			$invoices_mBPHP = "	select count(*) as hasil 
								from invoices i
								join m_pbph mp 
								On i.id_pbph_penjual = mp.NPWSHUT_NO
								join m_provinsi mp2
								on mp.KODE_PROP  = mp2.KODE_PROP
								join m_bphp mb 
								on mb.KODE_BSPHH = mp2.BSPHH";

			$invoices_mPulau = "select count(*) as hasil
								from invoices i 
								join m_pbph mp 
								on i.id_pbph_penjual = mp.NPWSHUT_NO 
								join m_provinsi mp2 
								on mp.KODE_PROP = mp2.KODE_PROP";

			// PBPH/Industri/Perhutani
			if($id_role == "5") {
				$id_user = $data_user['id_user'];
			
				$data['belum'] = $this->qbelum($id_user, NULL, NULL, NULL, $invoices_userRole_users);
				$data['verif'] = $this->qverif($id_user, NULL, NULL, NULL, $invoices_userRole_users);
				$data['verif2'] = $this->qverif2($id_user, NULL, NULL, NULL, $invoices_userRole_users);
				$data['kembali'] = $this->qkembali($id_user, NULL, NULL, NULL, $invoices_userRole_users);

				// Dinas Kehutanan 
			} else if ($id_role == "4") {
				$id_dinas = $data_user['id_dinas'];
				
				$data['belum'] = $this->qbelum(NULL, $id_dinas, NULL, NULL, $invoices_mPBPH);
				$data['verif'] = $this->qverif(NULL, $id_dinas, NULL, NULL, $invoices_mPBPH);
				$data['verif2'] = $this->qverif2(NULL, $id_dinas, NULL, NULL, $invoices_mPBPH);
				$data['kembali'] = $this->qkembali(NULL, $id_dinas, NULL, NULL, $invoices_mPBPH);
			
				// Balai Pengelolaan Hutan Lestari
			} else if ($id_role == "3") {
				$id_balai = $data_user['id_balai'];

				$data['belum'] = $this->qbelum(NULL,NULL,$id_balai, NULL, $invoices_mBPHP);
				$data['verif'] = $this->qverif(NULL,NULL,$id_balai, NULL, $invoices_mBPHP);
				$data['verif2'] = $this->qverif2(NULL,NULL,$id_balai, NULL, $invoices_mBPHP);
				$data['kembali'] = $this->qkembali(NULL,NULL,$id_balai, NULL, $invoices_mBPHP);
			
				// Verifikator 
			} else if ($id_role == "2") {
				$nama_wilayah = $data_user['KETERANGAN'];

				$data['belum'] = $this->qbelum(NULL,NULL,NULL, $nama_wilayah, $invoices_mPulau);
				$data['verif'] = $this->qverif(NULL,NULL,NULL, $nama_wilayah, $invoices_mPulau);
				$data['verif2'] = $this->qverif2(NULL,NULL,NULL, $nama_wilayah, $invoices_mPulau);
				$data['kembali'] = $this->qkembali(NULL,NULL, NULL, $nama_wilayah, $invoices_mPulau);
			}

			if(isset($is_verified)) {
				$data['hargapatokan'] = $this->model_harga_patokan->getAllByVerification($data_user, $is_verified);
			} else {
				$data["hargapatokan"] = $this->model_harga_patokan->getAll($data_user);
			}
			

			$this->template->load('template', 'dashboard-operator',$data);
		}

		public function qbelum($id_user, $id_dinas, $id_balai, $nama_wilayah, $sql_awal) {
			$belum = " and is_verified = '0'";

			if($id_user != NULL) {
				$sql_operator_perusahaan = " where ur.id_user = '$id_user' $belum";
				$data = $this->db->query($sql_awal.$sql_operator_perusahaan)->row_array();
			} else if ($id_dinas != NULL) {
				$sql_operator_dinas = " where mp.KODE_PROP = '$id_dinas' $belum";
				$data = $this->db->query($sql_awal.$sql_operator_dinas)->row_array();
			} else if ($id_balai != NULL) {
				$sql_operator_balai = " where mb.KODE_BSPHH = '$id_balai' $belum";
				$data = $this->db->query($sql_awal.$sql_operator_balai)->row_array();
			} else if ($nama_wilayah != NULL) {
				$sql_operator_pulau = " where mp2.WILAYAH = '$nama_wilayah' $belum";
				$data = $this->db->query($sql_awal.$sql_operator_pulau)->row_array();
			}
			
			return $data;
		}

		public function qverif($id_user, $id_dinas, $id_balai, $nama_wilayah, $sql_awal) {
			$verif = " and is_verified = '1'";

			if($id_user != NULL) {
				$sql_operator_perusahaan = " where ur.id_user = '$id_user' $verif";
				$data = $this->db->query($sql_awal.$sql_operator_perusahaan)->row_array();
			} else if ($id_dinas != NULL) {
				$sql_operator_dinas = " where mp.KODE_PROP = '$id_dinas' $verif";
				$data = $this->db->query($sql_awal.$sql_operator_dinas)->row_array();
			} else if ($id_balai != NULL) {
				$sql_operator_balai = " where mb.KODE_BSPHH = '$id_balai' $verif";
				$data = $this->db->query($sql_awal.$sql_operator_balai)->row_array();
			} else if ($nama_wilayah != NULL) {
				$sql_operator_pulau = " where mp2.WILAYAH = '$nama_wilayah' $verif";
				$data = $this->db->query($sql_awal.$sql_operator_pulau)->row_array();
			}

			return $data;
		}

		public function qverif2($id_user, $id_dinas, $id_balai, $nama_wilayah, $sql_awal) {
			$verif = " and is_verified = '3'";

			if($id_user != NULL) {
				$sql_operator_perusahaan = " where ur.id_user = '$id_user' $verif";
				$data = $this->db->query($sql_awal.$sql_operator_perusahaan)->row_array();
			} else if ($id_dinas != NULL) {
				$sql_operator_dinas = " where mp.KODE_PROP = '$id_dinas' $verif";
				$data = $this->db->query($sql_awal.$sql_operator_dinas)->row_array();
			} else if ($id_balai != NULL) {
				$sql_operator_balai = " where mb.KODE_BSPHH = '$id_balai' $verif";
				$data = $this->db->query($sql_awal.$sql_operator_balai)->row_array();
			} else if ($nama_wilayah != NULL) {
				$sql_operator_pulau = " where mp2.WILAYAH = '$nama_wilayah' $verif";
				$data = $this->db->query($sql_awal.$sql_operator_pulau)->row_array();
			}

			return $data;
		}

		public function qkembali($id_user, $id_dinas, $id_balai, $nama_wilayah, $sql_awal) {
			$kembali = " and is_verified = '2'";

			if($id_user != NULL) {
				$sql_operator_perusahaan = " where ur.id_user = '$id_user' $kembali";
				$data = $this->db->query($sql_awal.$sql_operator_perusahaan)->row_array();
			} else if ($id_dinas != NULL) {
				$sql_operator_dinas = " where mp.KODE_PROP = '$id_dinas' $kembali";
				$data = $this->db->query($sql_awal.$sql_operator_dinas)->row_array();
			} else if ($id_balai != NULL) {
				$sql_operator_balai = " where mb.KODE_BSPHH = '$id_balai' $kembali";
				$data = $this->db->query($sql_awal.$sql_operator_balai)->row_array();
			} else if ($nama_wilayah != NULL) {
				$sql_operator_pulau = " where mp2.WILAYAH = '$nama_wilayah' $kembali";
				$data = $this->db->query($sql_awal.$sql_operator_pulau)->row_array();
			}

			return $data;
		}

	}

?>