<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Auth_m');
        $this->load->model('Dashboard_m');
    }

    public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $user = $this->Auth_m->login($username, $password);

            if ($user) {
                $user_role = $this->Dashboard_m->get_user_role($user->id);
                $session_data = array(
                    'id' => $user->id,
                    'username' => $user->username,
                    'nama' => $user->name,
                    'role' => $user_role,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($session_data);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah!');
                redirect('auth/login');
            }
        }

        $this->load->view('auth/login');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}