<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Surat_model');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function create() {
        $data['title'] = 'Form Surat';
        $user_id = $this->session->userdata('id');
        $data['user_name'] = $this->session->userdata('nama') ?: 'Pengguna';
        $data['user_role'] = $this->session->userdata('role');

        if ($this->input->post()) {
            $surat_data = array(
                'user_id' => $user_id,
                'judul_surat' => $this->input->post('judul_surat'),
                'keterangan' => $this->input->post('keterangan'),
                'status' => 'draft',
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->Surat_model->create_surat($surat_data);

            // Tambahkan ke history
            $history_data = array(
                'surat_id' => $this->db->insert_id(),
                'user_id' => $user_id,
                'action' => 'created',
                'keterangan' => 'Surat dibuat sebagai draft',
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->Surat_model->add_history($history_data);

            redirect('dashboard');
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('surat/create', $data);
        $this->load->view('template/footer', $data);
    }

    public function status() {
        $data['title'] = 'Status Surat';
        $user_id = $this->session->userdata('id');
        $data['user_name'] = $this->session->userdata('nama') ?: 'Pengguna';
        $data['user_role'] = $this->session->userdata('role');
        $data['surat_status'] = $this->Surat_model->get_surat_status($user_id);
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('surat/status', $data);
        $this->load->view('template/footer', $data);
    }

    public function detail($surat_id) {
        $data['title'] = 'Detail Surat';
        $data['user_name'] = $this->session->userdata('nama') ?: 'Pengguna';
        $data['user_role'] = $this->session->userdata('role');

        // Ambil detail surat
        $data['surat'] = $this->Surat_model->get_surat_by_id($surat_id);
        if (!$data['surat']) {
            show_404();
        }

        // Ambil riwayat surat
        $data['history'] = $this->Surat_model->get_surat_history_by_id($surat_id);

        // Ambil tracking surat
        $data['tracking'] = $this->Surat_model->get_tracking_by_surat_id($surat_id);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('surat/detail', $data);
        $this->load->view('template/footer', $data);
    }

    public function history() {
        $data['title'] = 'History Surat';
        $user_id = $this->session->userdata('id');
        $data['user_name'] = $this->session->userdata('nama') ?: 'Pengguna';
        $data['user_role'] = $this->session->userdata('role');
        $data['surat_history'] = $this->Surat_model->get_surat_history($user_id);
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('surat/history', $data);
        $this->load->view('template/footer', $data);
    }

    public function masuk() {
        $data['title'] = 'Surat Masuk';
        $user_id = $this->session->userdata('id');
        $role_id = $this->db->get_where('user_roles', ['user_id' => $user_id])->row()->role_id;
        $data['user_name'] = $this->session->userdata('nama') ?: 'Pengguna';
        $data['user_role'] = $this->session->userdata('role');
        $data['surat_masuk'] = $this->Surat_model->get_surat_masuk($role_id, $user_id);
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('surat/masuk', $data);
        $this->load->view('template/footer', $data);
    }

    public function arsip() {
        $data['title'] = 'Arsip';
        $user_id = $this->session->userdata('id');
        $data['user_name'] = $this->session->userdata('nama') ?: 'Pengguna';
        $data['user_role'] = $this->session->userdata('role');
        $data['surat_arsip'] = $this->Surat_model->get_surat_arsip($user_id);
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('surat/arsip', $data);
        $this->load->view('template/footer', $data);
    }
}