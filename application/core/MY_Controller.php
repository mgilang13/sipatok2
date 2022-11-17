<?php if (! defined('BASEPATH')) exit('No direct script access');

class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->_check_auth();
    }

    private function _check_auth(){
        if($this->session->userdata('id') == NULL){
            $this->session->sess_destroy();
            redirect('auth');
        } 
    }
}

class MY_AdminController extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->_check_auth();
    }

    private function _check_auth(){
        if($this->session->userdata('id') == NULL or $this->session->userdata('id_role') != '1'){
            $this->session->sess_destroy();
            redirect('auth');
        }
    }
}

class MY_OperatorController extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->_check_auth();
    }

    private function _check_auth(){
        $id_role = $this->session->userdata('id_role');
        $data_roles = ['2', '3', '4', '5'];

        if($this->session->userdata('id') == NULL or !in_array($id_role, $data_roles)){
            $this->session->sess_destroy();
            redirect('auth');
        }
    }
}