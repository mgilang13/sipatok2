<?php
class Model_harga_patokan extends CI_Model
{
    public function save($data_user) {
        $id_user = $data_user['id'];
        $id_pbph_penjual = $data_user['id_pbph'];
        $id_invoice = $id_user.$id_pbph_penjual.time();
        $tanggal = date("Y-m-d");


        $data = array(
            'id'                => $id_invoice,
            'id_user'	        => $id_user,
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
            );        
        }

        $this->db->insert('invoices', $data);
        $this->db->insert_batch('invoice_details', $invoice_details);
    }

    private $_table = "invoices";

    public function getAll()
    {
        $data_user = $this->session->userdata();
        $id_user = $data_user['id'];
        $sql = "select 
                    a.id, 
                    a.nomor_invoice, 
                    a.tgl_invoice, 
                    b.NAMA_PERUSAHAAN,
                    a.is_verified 
                from 
                    invoices a, 
                    m_pbph b 
                where a.id_pbph_pembeli = b.NPWSHUT_NO and a.id_user = '".$id_user."'";
		$query = $this->db->query($sql);
		return $query->result();
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