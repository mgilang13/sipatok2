<?php

	class Tampilan_operator extends MY_OperatorController
	{
		
		function index()
		{
			$data['home_url']="Tampilan_operator";

			$this->template->load('template', 'dashboard-operator',$data);
		}

	}

?>