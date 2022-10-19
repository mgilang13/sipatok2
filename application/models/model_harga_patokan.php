<?php
class Model_harga_patokan extends CI_Model
{
    public function save($data_user) {
        $id_user = $data_user['id'];
        $id_pbph_penjual = $data_user['id_pbph'];
        $id_invoice = $id_user.$id_pbph_penjual.time();


        $data = array(
            'id'                => $id_invoice,
            'id_user'	        => $id_user,
            'id_pbph_penjual'	=> $id_pbph_penjual,
            'id_pbph_pembeli'	=> $this->input->post('id_pbph_pembeli', TRUE),
            'nomor_invoice'	    => $this->input->post('nomor_invoice', TRUE),
            'tgl_invoice'	    => $this->input->post('tgl_invoice', TRUE),
            'tempat_invoice'    => $this->input->post('tempat_invoice', TRUE),
            // 'file_upload'	    => $this->input->post('file_upload', TRUE),
            'is_verified'	    => "0",
            
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
}