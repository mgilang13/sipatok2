<?php

	class Auth extends CI_Controller
	{

		function __construct()
		{
			parent::__construct();
			$this->load->model('model_user');
			$this->load->model('model_guru');
		}
		
		function index()
		{
			$this->load->view('auth/login');
		}

		function check_login()
		{
			if (isset($_POST['submit'])) {
				
				$username	= $this->input->post('username');
				$password 	= $this->input->post('password');
				
				$loginOperator	= $this->model_user->loginOperator($username, $password);
				$loginAdmin		= $this->model_user->loginAdmin($username, $password);

				if (!empty($loginOperator)) {					
					$this->session->set_userdata($loginOperator);
					
					redirect('tampilan_operator');

				} else if (!empty($loginAdmin)) {
					$this->session->set_userdata($loginAdmin);
					redirect('tampilan_utama');

				} else {
					redirect('auth');
				}
			} else {
				redirect('auth');
			}
		}

		function logout()
		{
			$this->session->sess_destroy();
			redirect('auth');
		}

	}

?>