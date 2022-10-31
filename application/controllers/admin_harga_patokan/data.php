<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();
        $this->load->model("model_admin_harga_patokan");
        $this->load->library('form_validation');
    }
	public function index()
	{
        $data["hargapatokan"] = $this->model_admin_harga_patokan->getAll();
        $this->template->load('template', "admin_harga_patokan/data", $data);
		//$this->template->load('template', 'harga_patokan/data');
	}
	function detail()
	{
			
			$data["detail"] = $this->model_admin_harga_patokan->detail();
			$data["rincian"] = $this->model_admin_harga_patokan->_detail();

			$this->template->load('template', 'admin_harga_patokan/detail', $data);
	}
	function verifikasi(){
		if (isset($_POST['submit'])) {
			$this->model_admin_harga_patokan->update();
			redirect('admin_harga_patokan/data');
		} else {
			//$id_guru     = $this->uri->segment(3);
			//$data['guru']  = $this->db->get_where('tbl_guru', array('id_guru' => $id_guru))->row_array();
			//$this->template->load('template', 'guru/edit', $data);
			echo 'gagal';
		}
	}
}
