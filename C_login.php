<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_login extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('m_login');
        
        if(!isset($_SESSION)){
            session_start();
        }
        $this->load->model(array('m_login'));
        if ($this->session->userdata('u_name')) {
            redirect('c_index');
        }
    }
    function index() {
        $this->load->view('v_login');
    }

    function proses() {
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->load->view('v_login');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('v_login');
        } else {
            $usr = $this->input->post('username');
            $psw = $this->input->post('password');
            $u = $usr;
            $p = $psw;
            $cek = $this->m_login->cek($u, $p);
            if ($cek->num_rows() > 0) {
                //login berhasil, buat session
                foreach ($cek->result() as $qad) {
                    $sess_data['u_id'] = $qad->u_id;
                    $sess_data['nama'] = $qad->nama;
                    $sess_data['u_name'] = $qad->u_name;
                    $sess_data['role'] = $qad->role;
                    $this->session->set_userdata($sess_data);
                }
                redirect('c_index');
            } else {
                $this->session->set_flashdata('result_login', '<br>Username atau Password yang anda masukkan salah.');
                redirect('c_login');
            }
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect('c_login');
    }
}
