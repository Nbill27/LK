<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth/login');
        }
        $this->load->model('Dashboard_m');
    }

    public function index() {
        $data = array();
        $data['title'] = 'Admin Panel';
        $data['content_view'] = 'admin/index';
        $data['user_role'] = $this->session->userdata('role'); // Ambil role dari session
        $data['user_name'] = $this->session->userdata('username'); // Untuk header (opsional)

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data); // Kirim $data ke sidebar
        $this->load->view($data['content_view'], $data);
        $this->load->view('template/footer', $data);
    }

    public function add_user() {
        $data = array();
        $data['title'] = 'Tambah Pengguna';
        $data['content_view'] = 'admin/add_user';
        $data['user_role'] = $this->session->userdata('role'); // Ambil role dari session
        $data['user_name'] = $this->session->userdata('username'); // Untuk header (opsional)
        $data['roles'] = $this->Dashboard_m->get_all_roles();

        if ($this->input->post('action') == 'add') {
            $data_user = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => MD5($this->input->post('password')),
                'name' => $this->input->post('name'),
                'nip' => $this->input->post('nip')
            );
            $role_id = $this->input->post('role_id');
            $user_id = $this->Dashboard_m->add_user($data_user);
            if ($user_id) {
                $this->Dashboard_m->assign_role($user_id, $role_id);
                $this->session->set_flashdata('success', 'Pengguna berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan pengguna.');
            }
            redirect('admin/add_user');
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data); // Kirim $data ke sidebar
        $this->load->view($data['content_view'], $data);
        $this->load->view('template/footer', $data);
    }

    public function manage_user() {
        $data = array();
        $data['title'] = 'Kelola Pengguna';
        $data['content_view'] = 'admin/manage_user';
        $data['user_role'] = $this->session->userdata('role'); // Ambil role dari session
        $data['user_name'] = $this->session->userdata('username'); // Untuk header (opsional)
        $data['users'] = $this->Dashboard_m->get_all_users_with_roles();
        $data['roles'] = $this->Dashboard_m->get_all_roles();

        if ($this->input->post('action') == 'edit') {
            $user_id = $this->input->post('edit_user_id');
            $data_user = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'name' => $this->input->post('name'),
                'nip' => $this->input->post('nip')
            );
            if ($this->input->post('password')) {
                $data_user['password'] = MD5($this->input->post('password'));
            }
            $role_id = $this->input->post('role_id');
            $this->Dashboard_m->update_user($user_id, $data_user);
            $this->Dashboard_m->update_user_role($user_id, $role_id);
            $this->session->set_flashdata('success', 'Pengguna berhasil diedit.');
            redirect('admin/manage_user');
        }

        if ($this->input->post('action') == 'delete') {
            $this->Dashboard_m->delete_user($this->input->post('delete_user_id'));
            $this->session->set_flashdata('success', 'Pengguna berhasil dihapus.');
            redirect('admin/manage_user');
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data); // Kirim $data ke sidebar
        $this->load->view($data['content_view'], $data);
        $this->load->view('template/footer', $data);
    }
}