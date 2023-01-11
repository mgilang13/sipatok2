<?php
class Model_harga_patokan extends CI_Model
{

    public function save($data_user, $file_name) {
        $id_user = $data_user['id_user'];
        $id_pbph_penjual = $data_user['id_pbph'];
        $id_invoice = uniqid().'_'.$id_user.$id_pbph_penjual;
        $tgl_input = date("Y-m-d H:i:s");
        $tgl_update = $tgl_input;

        $data = array(
            'id'                => $id_invoice,
            'id_user'	        => $id_user,
            'id_jenis_dok'      => $this->input->post('id_jenis_dok'),
            'id_pbph_penjual'	=> $id_pbph_penjual,
            'id_pbph_pembeli'	=> $this->input->post('id_pbph_pembeli', TRUE),
            'tgl_input'         => $tgl_input,
            'tgl_update'        => $tgl_update,
            'nomor_invoice'	    => $this->input->post('nomor_invoice', TRUE),
            'tgl_invoice'	    => $this->input->post('tgl_invoice', TRUE),
            //'tempat_invoice'    => $this->input->post('tempat_invoice', TRUE),
            'file_upload'       => $file_name,
            'total_harga'       => $this->input->post('total_harga', TRUE),
            'total_volume'      => $this->input->post('total_volume', TRUE),
            'is_verified'	    => "0"
            
        );

        $invoice_details = [];
        
        $length_details = sizeof($this->input->post('id_jenis_kayu'));

        for($i = 0; $i < $length_details; $i++) {
            $invoice_details[$i] =  array(
                'id_invoice'    => $id_invoice,
                'id_jenis_kayu' => $this->input->post('id_jenis_kayu', TRUE)[$i],
                'harga'         => $this->input->post('harga', TRUE)[$i],
                'volume'        => $this->input->post('volume', TRUE)[$i],
                'id_diameter'   => $this->input->post('id_diameter', TRUE)[$i],
                //'id_satuan'   => $this->input->post('id_satuan', TRUE)[$i],
            ); 
        }

        $this->db->insert('invoices', $data);
        $this->db->insert_batch('invoice_details', $invoice_details);
    }

    private $_table = "invoices";

    public function getAll($data_user)
    {
        $nama_role = $data_user['nama_role'];
        $id_role = $data_user['id_role'];

        $id_user = $data_user['id_user'];

        if($id_role == '5') {
            //operator perusahaan
            $invoices_userRole_users = "select i.id, 
                                            i.nomor_invoice,
                                            i.id_pbph_penjual,
                                            i.id_pbph_pembeli, 
                                            i.tgl_invoice,
                                            i.tgl_input, 
                                            mp.NAMA_PERUSAHAAN ,
                                            i.is_verified
                                        from users u
                                        join user_role ur 
                                            on ur.id_user = u.id
                                        join invoices i 
                                            on i.id_user = u.id
                                        join m_pbph mp
                                            on mp.NPWSHUT_NO = i.id_pbph_pembeli";

            $sql_operator_perusahaan = " where ur.id_user = '$id_user' order by tgl_input desc";
            $data = $this->db->query($invoices_userRole_users.$sql_operator_perusahaan);

        } else if($id_role == '4') {
            $id_dinas = $data_user['id_dinas'];

            $invoices_mPBPH = "	select i.id, 
                                    i.nomor_invoice,
                                    i.id_pbph_penjual,
                                    i.id_pbph_pembeli, 
                                    i.tgl_invoice, 
                                    mp.NAMA_PERUSAHAAN ,
                                    i.is_verified
                                from invoices i
                                join m_pbph mp 
                                    on i.id_pbph_penjual = mp.NPWSHUT_NO";
            
            $sql_operator_dinas = " where mp.KODE_PROP = '$id_dinas'";
            $data = $this->db->query($invoices_mPBPH.$sql_operator_dinas);

        } else if($id_role == '3') {
            
            $id_balai = $data_user['id_balai'];

            $invoices_mBPHP = "	select i.id, 
                                    i.nomor_invoice,
                                    i.id_pbph_penjual,
                                    i.id_pbph_pembeli, 
                                    i.tgl_invoice, 
                                    mp.NAMA_PERUSAHAAN ,
                                    i.is_verified 
                                from invoices i
                                join m_pbph mp 
                                    On i.id_pbph_penjual = mp.NPWSHUT_NO
                                join m_provinsi mp2
                                    on mp.KODE_PROP  = mp2.KODE_PROP
                                join m_bphp mb 
                                    on mb.KODE_BSPHH = mp2.BSPHH";
            
            $sql_operator_balai = " where mb.KODE_BSPHH = '$id_balai'";
            $data = $this->db->query($invoices_mBPHP.$sql_operator_balai);

        } else if($id_role == '2') { //Verifikator Pulau
            
            $nama_wilayah = $data_user['KETERANGAN'];

            $invoices_mPulau = "    select i.id,
                                        i.nomor_invoice,
                                        i.id_pbph_penjual,
                                        i.id_pbph_pembeli, 
                                        i.tgl_invoice, 
                                        mp.NAMA_PERUSAHAAN ,
                                        i.is_verified 
                                    from invoices i 
                                    join m_pbph mp 
                                        on i.id_pbph_penjual = mp.NPWSHUT_NO 
                                    join m_provinsi mp2 
                                        on mp.KODE_PROP = mp2.KODE_PROP";
        
            $sql_operator_pulau = " where mp2.WILAYAH = '$nama_wilayah'";
            $data = $this->db->query($invoices_mPulau.$sql_operator_pulau);
        }

        return $data->result();
    }

    public function getAllByVerification($data_user, $is_verified)
    {
        $nama_role = $data_user['nama_role'];
        $id_user = $data_user['id_user'];

        if($nama_role == "PBPH / Industri / Perhutani") {
            //operator perusahaan
            $invoices_userRole_users = "select i.id, 
                                            i.nomor_invoice,
                                            i.id_pbph_penjual,
                                            i.id_pbph_pembeli, 
                                            i.tgl_invoice, 
                                            mp.NAMA_PERUSAHAAN ,
                                            i.is_verified
                                        from users u
                                        join user_role ur 
                                            on ur.id_user = u.id
                                        join invoices i 
                                            on i.id_user = u.id
                                        join m_pbph mp
                                            on mp.NPWSHUT_NO = i.id_pbph_pembeli";

            $sql_operator_perusahaan = " where ur.id_user = '$id_user'";
            
            if(isset($is_verified)) {
                $sql_operator_perusahaan .= " and i.is_verified = '$is_verified'";
            }

            $data = $this->db->query($invoices_userRole_users.$sql_operator_perusahaan);

        } else if($nama_role == "Dinas Kehutanan") {
            $id_dinas = $data_user['id_dinas'];

            $invoices_mPBPH = "	select i.id, 
                                    i.nomor_invoice,
                                    i.id_pbph_penjual,
                                    i.id_pbph_pembeli, 
                                    i.tgl_invoice, 
                                    mp.NAMA_PERUSAHAAN ,
                                    i.is_verified
                                from invoices i
                                join m_pbph mp 
                                    on i.id_pbph_penjual = mp.NPWSHUT_NO";
            
            $sql_operator_dinas = " where mp.KODE_PROP = '$id_dinas'";
            
            if(isset($is_verified)) {
                $sql_operator_dinas .= " and i.is_verified = '$is_verified'";
            }

            $data = $this->db->query($invoices_mPBPH.$sql_operator_dinas);

        } else if($nama_role == "BPHP") {
            
            $id_balai = $data_user['id_balai'];

            $invoices_mBPHP = "	select i.id, 
                                    i.nomor_invoice,
                                    i.id_pbph_penjual,
                                    i.id_pbph_pembeli, 
                                    i.tgl_invoice, 
                                    mp.NAMA_PERUSAHAAN ,
                                    i.is_verified 
                                from invoices i
                                join m_pbph mp 
                                    On i.id_pbph_penjual = mp.NPWSHUT_NO
                                join m_provinsi mp2
                                    on mp.KODE_PROP  = mp2.KODE_PROP
                                join m_bphp mb 
                                    on mb.KODE_BSPHH = mp2.BSPHH";
            
            $sql_operator_balai = " where mb.KODE_BSPHH = '$id_balai'";
            if(isset($is_verified)) {
                $sql_operator_balai .= " and i.is_verified = '$is_verified'";
            }

            $data = $this->db->query($invoices_mBPHP.$sql_operator_balai);

        } else if($nama_role == "Verifikator") { //Verifikator Pulau
            
            $nama_wilayah = $data_user['KETERANGAN'];

            $invoices_mPulau = "    select i.id,
                                        i.nomor_invoice,
                                        i.id_pbph_penjual,
                                        i.id_pbph_pembeli, 
                                        i.tgl_invoice, 
                                        mp.NAMA_PERUSAHAAN ,
                                        i.is_verified 
                                    from invoices i 
                                    join m_pbph mp 
                                        on i.id_pbph_penjual = mp.NPWSHUT_NO 
                                    join m_provinsi mp2 
                                        on mp.KODE_PROP = mp2.KODE_PROP";
        
            $sql_operator_pulau = " where mp2.WILAYAH = '$nama_wilayah'";
            

            if(isset($is_verified)) {
                $sql_operator_pulau .= " and i.is_verified = '$is_verified'";
            }

            $data = $this->db->query($invoices_mPulau.$sql_operator_pulau);
        }

        return $data->result();
    }

    public function detail()
    {
        $id_invoice = $this->uri->segment(4);
        $data_user = $this->session->userdata();
        //$id_user = $data_user['id'];
        $sql = "select a.id,
                a.id as id_invoice, 
                a.is_verified,
                a.id_jenis_dok,
                a.id_pbph_pembeli,
                z.nama as jenis_dok,
                a.nomor_invoice, 
                a.tgl_invoice, 
                a.tempat_invoice, 
                a.total_volume, 
                a.total_harga, 
                a.file_upload,
                a.keterangan, 
                (SELECT b.NAMA_PERUSAHAAN 
                        FROM invoices a, 
                            m_pbph b 
                        WHERE a.id_pbph_penjual = b.NPWSHUT_NO and a.id = '".$id_invoice."') as penjual, 
                                c.NAMA_PERUSAHAAN as pembeli, 
                                c.KOTA, f.KETERANGAN as provinsi 
                        FROM invoices a, 
                                m_pbph c, 
                                m_provinsi f,
                                m_jenis_dok z 
                        WHERE a.id_pbph_pembeli = c.NPWSHUT_NO AND f.KODE_PROP=c.KODE_PROP AND a.id = '".$id_invoice."' and z.id = a.id_jenis_dok";
        
		$query = $this->db->query($sql);
		
        return $query->row_array();
    }
    public function _detail()
    {
        $id_menu 	  = $this->uri->segment(4);
        $data_user = $this->session->userdata();
        //$id_user = $data_user['id'];
        $sql = "select b.id_invoice, b.id_jenis_kayu, d.KETERANGAN as jenis_kayu, g.KETERANGAN as kelompok_kayu, b.harga, b.volume, b.id_diameter, e.diameter, a.keterangan as alasan, g.KEL_NO from invoices a, invoice_details b, m_jenis_kayu d, m_diameters e, m_kelompok_jenis_kayu g where a.id=b.id_invoice and b.id_diameter = e.id and d.KAYU_NO = b.id_jenis_kayu and g.KEL_NO = d.KEL_NO and a.id = '".$id_menu."'";
		$query = $this->db->query($sql);
		return $query->result_array();
    }

    public $table = "invoices";
    function update()
    {
      $data = array(
        //tabel di database => name di form
        'is_verified'       => $this->input->post('verifikasi', TRUE),
        'keterangan'   => $this->input->post('keterangan', TRUE),
        //'semester_aktif'  = $this->input->post('semester_aktif', TRUE)
      );
      $id = $this->input->post('id_invoice');
      $this->db->where('id', $id);
      $this->db->update($this->table, $data);
    }

    public function edit_dikembalikan($file_name)
    {
        $tgl_update = date("Y-m-d H:i:s");

        $data = array(
            'id_jenis_dok'  => $this->input->post('id_jenis_dok'),
            'id_pbph_pembeli'	=> $this->input->post('id_pbph_pembeli', TRUE),
            'nomor_invoice'	    => $this->input->post('nomor_invoice', TRUE),
            'tgl_invoice'	    => $this->input->post('tgl_invoice', TRUE),
            'total_harga'       => $this->input->post('total_harga', TRUE),
            'total_volume'      => $this->input->post('total_volume', TRUE),
            'file_upload'       => $file_name,
            'is_verified'	    => "0",
        );

        $id_invoice = $this->input->post('id_invoice');

        $invoice = $this->db->get_where('invoices', array('id' => $id_invoice))->row();

        if(isset($_FILES['file_upload'])) {
            $file_name_old = $invoice->file_upload.".pdf";
    
            unlink(FCPATH."uploads/invoices/".$file_name_old);
        } 

        $invoice_details = [];
        
        $length_details = sizeof($this->input->post('id_jenis_kayu'));

        for($i = 0; $i < $length_details; $i++) {
            $invoice_details[$i] =  array(
                'id_invoice'    => $id_invoice,
                'id_jenis_kayu' => $this->input->post('id_jenis_kayu', TRUE)[$i],
                'harga'         => $this->input->post('harga', TRUE)[$i],
                'volume'        => $this->input->post('volume', TRUE)[$i],
                'id_diameter'   => $this->input->post('id_diameter', TRUE)[$i],
                //'id_satuan'   => $this->input->post('id_satuan', TRUE)[$i],
            ); 
        }

        //hapus data lama
        $this->db->where('id_invoice', $id_invoice);
        $this->db->delete('invoice_details');


        // upload gambar
        $config['upload_path']          = './uploads/invoices/';
			$config['allowed_types']        = 'pdf';
			$config['max_size']             = 10240;
			$config['file_name']			= $file_name;
			
			$this->load->library('upload', $config);

			if ($this->form_validation->run() == FALSE && !$this->upload->do_upload('file_upload')) {
				
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('error', $error);
				
				$this->index();
			} else {
				$this->upload->data();
            }
            //update data invoice
        $this->db->where('id', $id_invoice);
        $this->db->update('invoices', $data);
        //masukkan data baru
        $this->db->insert_batch('invoice_details', $invoice_details);
    }

    public function getKalkulasiData()
    {
        $sql = "select mp3.KETERANGAN as wilayah, md.diameter as sortimen, mjk.KETERANGAN as jenis_kayu, avg(id.harga/id.volume) as harga_patokan
        from invoices i
        join invoice_details id 
        on id.id_invoice = i.id
        join m_diameters md 
        on md.id = id.id_diameter 
        join m_jenis_kayu mjk 
        on mjk.KAYU_NO = id.id_jenis_kayu 
        join m_pbph mp 
        on i.id_pbph_penjual = mp.NPWSHUT_NO 
        join m_provinsi mp2 
        on mp.KODE_PROP = mp2.KODE_PROP 
        join m_bphp mb 
        on mb.KODE_BSPHH = mp2.BSPHH 
        join m_pulau mp3 
        on mp3.KODE_PULAU = mb.PULAU
        where i.is_verified = '1'
        group by mjk.KETERANGAN, mp3.KETERANGAN, md.diameter;";

        $query = $this->db->query($sql);

        $kalkulasi_data = $query->result();        
		return $kalkulasi_data;
    }
}