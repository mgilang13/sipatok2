<?php
class Model_admin_harga_patokan extends CI_Model
{
    private $_table = "invoices";
    
   public function getAllByVerification($is_verified) {

        $sql = "select 
                a.id, 
                a.nomor_invoice,
                a.id_pbph_penjual,
                a.id_pbph_pembeli, 
                a.tgl_invoice, 
                b.NAMA_PERUSAHAAN ,
                a.is_verified
                from 
                invoices a, 
                m_pbph b 
                where a.id_pbph_pembeli = b.NPWSHUT_NO and a.is_verified='$is_verified'";
       
        $query = $this->db->query($sql);
        
        $dataSemuaHP = $query->result();
        
        for($i=0; $i < sizeof($dataSemuaHP); $i++) {
            $dataSemuaHP[$i]->id_pbph_pembeli = $this->getNamaPerusahaan($dataSemuaHP[$i]->id_pbph_pembeli);        
            $dataSemuaHP[$i]->id_pbph_penjual = $this->getNamaPerusahaan($dataSemuaHP[$i]->id_pbph_penjual);        
            }

        return $dataSemuaHP;
    }
    
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

    public function getAll()
    {
        $sql = "select 
                    a.id, 
                    a.nomor_invoice,
                    a.id_pbph_penjual,
                    a.id_pbph_pembeli, 
                    a.tgl_invoice, 
                    b.NAMA_PERUSAHAAN ,
                    a.is_verified
                from 
                    invoices a, 
                    m_pbph b 
                where a.id_pbph_pembeli = b.NPWSHUT_NO";

        $query = $this->db->query($sql);

        $dataSemuaHP = $query->result();

        for($i=0; $i < sizeof($dataSemuaHP); $i++) {
            $dataSemuaHP[$i]->id_pbph_pembeli = $this->getNamaPerusahaan($dataSemuaHP[$i]->id_pbph_pembeli);        
            $dataSemuaHP[$i]->id_pbph_penjual = $this->getNamaPerusahaan($dataSemuaHP[$i]->id_pbph_penjual);        
        }
        
		return $dataSemuaHP;
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

    public function getPenjual(){
        $sql = "select b.NAMA_PERUSAHAAN as penjual from invoices a, m_pbph b where a.id_pbph_penjual = b.NPWSHUT_NO";
        $query = $this->db->query($sql);
		return $query->result();
    }
    /* public function getPembeli(){
        $sql = "select a.id, a.nomor_invoice, a.tgl_invoice, b.NAMA_PERUSAHAAN from invoices a, m_pbph b where a.id_pbph_penjual = b.NPWSHUT_NO";
        $query = $this->db->query($sql);
		return $query->result();
    } */
    public function detail()
    {
        $id_invoice = $this->uri->segment(4);
        $data_user = $this->session->userdata();
        //$id_user = $data_user['id'];
        $sql = "select a.id, 
                z.nama as jenis_dok,
                a.nomor_invoice, 
                a.tgl_invoice, 
                a.tempat_invoice, 
                a.total_volume, 
                a.total_harga, 
                a.file_upload, 
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
                        WHERE a.id_pbph_pembeli = c.NPWSHUT_NO AND f.KODE_PROP=c.KODE_PROP AND a.id = '".$id_invoice."' and a.id_jenis_dok = z.id";
        
		$query = $this->db->query($sql);
		
        return $query->row_array();
    }

    public function _detail()
    {
        $id_menu 	  = $this->uri->segment(4);
        $data_user = $this->session->userdata();
        //$id_user = $data_user['id'];
        $sql = "select d.KETERANGAN as jenis_kayu, g.KETERANGAN as kelompok_kayu, b.harga, b.volume, e.diameter from invoices a, invoice_details b, m_jenis_kayu d, m_diameters e, m_kelompok_jenis_kayu g where a.id=b.id_invoice and b.id_diameter = e.id and d.KAYU_NO = b.id_jenis_kayu and g.KEL_NO = d.KEL_NO and a.id = '".$id_menu."'";
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

    public function getNamaPerusahaan($id_pbph)
    {
        $sql = "select 
                    NAMA_PERUSAHAAN 
                from 
                    invoices, m_pbph 
                where 
                    m_pbph.NPWSHUT_NO = '$id_pbph' ;";
        $query = $this->db->query($sql);
    
        return $query->row()->NAMA_PERUSAHAAN;
    }
    
}