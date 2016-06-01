<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_index extends CI_Controller {
    	public function index()
	{
		$this->load->view('v_index');
	}
	function logout() {
        $this->session->sess_destroy();
        redirect('c_login');
    }
}

