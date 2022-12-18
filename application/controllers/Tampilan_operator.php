<?php

	class Tampilan_operator extends MY_OperatorController
	{
		
		function index()
		{
			$data['home_url']="Tampilan_operator";

			$data_user = $this->session->userdata();
			
			$nama_role = $data_user['nama_role'];
		
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
								on mp.KODE_PROP = mp2.KODE_PROP 
								join m_bphp mb 
								on mb.KODE_BSPHH = mp2.BSPHH 
								join m_pulau mp3 
								on mp3.KODE_PULAU = mb.PULAU ";

			if($nama_role == "PBPH / Industri / Perhutani") {
				$id_user = $data_user['id_user'];
			
				$data['belum'] = $this->qbelum($id_user, NULL, NULL, NULL, $invoices_userRole_users);
				$data['verif'] = $this->qverif($id_user, NULL, NULL, NULL, $invoices_userRole_users);
				$data['verif2'] = $this->qverif2($id_user, NULL, NULL, NULL, $invoices_userRole_users);
				$data['kembali'] = $this->qkembali($id_user, NULL, NULL, NULL, $invoices_userRole_users);

			} else if ($nama_role == "Dinas Kehutanan") {
				$id_dinas = $data_user['id_dinas'];
				
				$data['belum'] = $this->qbelum(NULL, $id_dinas, NULL, NULL, $invoices_mPBPH);
				$data['verif'] = $this->qverif(NULL, $id_dinas, NULL, NULL, $invoices_mPBPH);
				$data['verif2'] = $this->qverif2(NULL, $id_dinas, NULL, NULL, $invoices_mPBPH);
				$data['kembali'] = $this->qkembali(NULL, $id_dinas, NULL, NULL, $invoices_mPBPH);
			} else if ($nama_role == "BPHP") {
				$id_balai = $data_user['id_balai'];

				$data['belum'] = $this->qbelum(NULL,NULL,$id_balai, NULL, $invoices_mBPHP);
				$data['verif'] = $this->qverif(NULL,NULL,$id_balai, NULL, $invoices_mBPHP);
				$data['verif2'] = $this->qverif2(NULL,NULL,$id_balai, NULL, $invoices_mBPHP);
				$data['kembali'] = $this->qkembali(NULL,NULL,$id_balai, NULL, $invoices_mBPHP);
			} else if ($nama_role == "Verifikator") {
				$id_pulau = $data_user['id_pulau'];

				$data['belum'] = $this->qbelum(NULL,NULL,NULL, $id_pulau, $invoices_mPulau);
				$data['verif'] = $this->qverif(NULL,NULL,NULL, $id_pulau, $invoices_mPulau);
				$data['verif2'] = $this->qverif2(NULL,NULL,NULL, $id_pulau, $invoices_mPulau);
				$data['kembali'] = $this->qkembali(NULL,NULL, NULL, $id_pulau, $invoices_mPulau);
			}

			$data['notifikasi_dikembalikan'] = $this->notifikasi_dikembalikan();

			$this->template->load('template', 'dashboard-operator',$data);
		}

		public function qbelum($id_user, $id_dinas, $id_balai, $id_pulau, $sql_awal) {
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
			} else if ($id_pulau != NULL) {
				$sql_operator_pulau = " where mp3.KODE_PULAU = '$id_pulau' $belum";
				$data = $this->db->query($sql_awal.$sql_operator_pulau)->row_array();
			}
			
			return $data;
		}

		public function qverif($id_user, $id_dinas, $id_balai, $id_pulau, $sql_awal) {
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
			} else if ($id_pulau != NULL) {
				$sql_operator_pulau = " where mp3.KODE_PULAU = '$id_pulau' $verif";
				$data = $this->db->query($sql_awal.$sql_operator_pulau)->row_array();
			}

			return $data;
		}

		public function qverif2($id_user, $id_dinas, $id_balai, $id_pulau, $sql_awal) {
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
			} else if ($id_pulau != NULL) {
				$sql_operator_pulau = " where mp3.KODE_PULAU = '$id_pulau' $verif";
				$data = $this->db->query($sql_awal.$sql_operator_pulau)->row_array();
			}

			return $data;
		}

		public function qkembali($id_user, $id_dinas, $id_balai, $id_pulau, $sql_awal) {
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
			} else if ($id_pulau != NULL) {
				$sql_operator_pulau = " where mp3.KODE_PULAU = '$id_pulau' $kembali";
				$data = $this->db->query($sql_awal.$sql_operator_pulau)->row_array();
			}

			return $data;
		}

		public function notifikasi_dikembalikan () {

			$sql = "select i.id, mp.NAMA_PERUSAHAAN, i.nomor_invoice
					from users u
					join user_role ur 
						on ur.id_user = u.id
					join invoices i 
						on i.id_user = u.id
					join m_pbph mp 
						on i.id_pbph_pembeli = mp.NPWSHUT_NO 
					where ur.id_user = '2' and is_verified = '2'";
			$data = $this->db->query($sql);

		return $data;
		}



	}

?>