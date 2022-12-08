<?php
class Model_harga_patokan extends CI_Model
{
    public function save($data_user) {
        $id_user = $data_user['id_user'];
        $id_pbph_penjual = $data_user['id_pbph'];
        $id_invoice = $id_user.$id_pbph_penjual.time();
        $tanggal = date("Y-m-d");

        $data = array(
            'id'                => $id_invoice,
            'id_user'	        => $id_user,
            'id_jenis_dok'      => $this->input->post('id_jenis_dok'),
            'id_pbph_penjual'	=> $id_pbph_penjual,
            'id_pbph_pembeli'	=> $this->input->post('id_pbph_pembeli', TRUE),
            'tgl_input'         => $tanggal,
            'nomor_invoice'	    => $this->input->post('nomor_invoice', TRUE),
            'tgl_invoice'	    => $this->input->post('tgl_invoice', TRUE),
            'tempat_invoice'    => $this->input->post('tempat_invoice', TRUE),
            'file_upload'       => $id_invoice,
            'total_harga'       => $this->input->post('total_harga', TRUE),
            'total_volume'      => $this->input->post('total_volume', TRUE),
            'is_verified'	    => "0",
            'tgl_input'         => $tanggal
            
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
                'id_satuan'   => $this->input->post('id_satuan', TRUE)[$i],
            ); 
        }

        $this->db->insert('invoices', $data);
        $this->db->insert_batch('invoice_details', $invoice_details);
    }

    private $_table = "invoices";

    public function getAll($data_user)
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
            $data = $this->db->query($invoices_mBPHP.$sql_operator_balai);

        } else if($nama_role == "Verifikator") { //Verifikator Pulau
            
            $id_pulau = $data_user['id_pulau'];

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
                                        on mp.KODE_PROP = mp2.KODE_PROP 
                                    join m_bphp mb 
                                        on mb.KODE_BSPHH = mp2.BSPHH 
                                    join m_pulau mp3 
                                        on mp3.KODE_PULAU = mb.PULAU ";
        
            $sql_operator_pulau = " where mp3.KODE_PULAU = '$id_pulau'";
            $data = $this->db->query($invoices_mPulau.$sql_operator_pulau);
        }

        return $data->result();
    }

    public function detail()
    {
        $id_menu 	  = $this->uri->segment(4);
        $data_user = $this->session->userdata();
        $id_user = $data_user['id'];
        $sql = "select a.id, a.nomor_invoice, a.tgl_invoice, a.tempat_invoice, c.NAMA_PERUSAHAAN, c.KOTA, f.KETERANGAN as provinsi, a.total_volume, a.total_harga, a.is_verified, a.file_upload from invoices a, m_pbph c, m_provinsi f where a.id_pbph_pembeli = c.NPWSHUT_NO and f.KODE_PROP=c.KODE_PROP and a.id_user = '".$id_user."' and a.id = '".$id_menu."'";
		$query = $this->db->query($sql);
		return $query->row_array();
    }
    public function _detail()
    {
        $id_menu 	  = $this->uri->segment(4);
        $data_user = $this->session->userdata();
        $id_user = $data_user['id'];
        $sql = "select d.KETERANGAN as jenis_kayu, g.KETERANGAN as kelompok_kayu, b.harga, b.volume, e.diameter from invoices a, invoice_details b, m_jenis_kayu d, m_diameters e, m_kelompok_jenis_kayu g where a.id=b.id_invoice and b.id_diameter = e.id and d.KAYU_NO = b.id_jenis_kayu and g.KEL_NO = d.KEL_NO and a.id_user = '".$id_user."' and a.id = '".$id_menu."'";
		$query = $this->db->query($sql);
		return $query->result_array();
    }
    public function peraturan()
    {
        $sql = "select * from peraturan";
		$query = $this->db->query($sql);
		return $query->result();
    }
}