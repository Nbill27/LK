<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_m extends CI_Model {
    public function get_all_users_with_roles() {
        $this->db->select('u.*, r.nama_role, p.nama_prodi, f.nama_fakultas');
        $this->db->from('user u');
        $this->db->join('user_role ur', 'u.id_user = ur.id_user', 'left');
        $this->db->join('role r', 'ur.id_role = r.id_role', 'left');
        $this->db->join('dosen d', 'u.id_user = d.id_user', 'left');
        $this->db->join('prodi p', 'd.id_prodi = p.id_prodi', 'left');
        $this->db->join('kaprodi k', 'u.id_user = k.id_user', 'left');
        $this->db->join('prodi p2', 'k.id_prodi = p2.id_prodi', 'left', 'p2.id_prodi = COALESCE(d.id_prodi, k.id_prodi)');
        $this->db->join('dekan dk', 'u.id_user = dk.id_user', 'left');
        $this->db->join('fakultas f', 'dk.id_fakultas = f.id_fakultas', 'left');
        $this->db->group_by('u.id_user');
        $query = $this->db->get();
        $results = $query->result_array();

        foreach ($results as &$result) {
            $roles = $this->get_user_roles($result['id_user']);
            $role_names = array_column($roles, 'nama_role');
            $result['roles'] = implode(', ', $role_names);
            $result['nama_prodi'] = $result['nama_prodi'] ?? '-';
            $result['nama_fakultas'] = $result['nama_fakultas'] ?? '-';
        }

        return $results;
    }

    public function get_total_users() {
        return $this->db->count_all('user');
    }

    public function get_all_prodis() {
        $this->db->select('*');
        $this->db->from('prodi');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_fakultas() {
        $this->db->select('*');
        $this->db->from('fakultas');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_user_by_id($id_user) {
        $this->db->select('u.*, r.nama_role');
        $this->db->from('user u');
        $this->db->join('user_role ur', 'u.id_user = ur.id_user', 'left');
        $this->db->join('role r', 'ur.id_role = r.id_role', 'left');
        $this->db->where('u.id_user', $id_user);
        $query = $this->db->get();
        $user = $query->row_array();
        $user['roles'] = $this->get_user_roles($id_user);
        return $user;
    }

    public function get_user_by_id_with_prodi_fakultas($id_user) {
        $this->db->select('u.*, r.nama_role, p.nama_prodi, f.nama_fakultas, d.id_prodi, dk.id_fakultas');
        $this->db->from('user u');
        $this->db->join('user_role ur', 'u.id_user = ur.id_user', 'left');
        $this->db->join('role r', 'ur.id_role = r.id_role', 'left');
        $this->db->join('dosen d', 'u.id_user = d.id_user', 'left');
        $this->db->join('prodi p', 'd.id_prodi = p.id_prodi', 'left');
        $this->db->join('kaprodi k', 'u.id_user = k.id_user', 'left');
        $this->db->join('prodi p2', 'k.id_prodi = p2.id_prodi', 'left', 'p2.id_prodi = COALESCE(d.id_prodi, k.id_prodi)');
        $this->db->join('dekan dk', 'u.id_user = dk.id_user', 'left');
        $this->db->join('fakultas f', 'dk.id_fakultas = f.id_fakultas', 'left');
        $this->db->where('u.id_user', $id_user);
        $query = $this->db->get();
        $user = $query->row_array();
        $user['roles'] = $this->get_user_roles($id_user);
        $user['nama_prodi'] = $user['nama_prodi'] ?? '-';
        $user['nama_fakultas'] = $user['nama_fakultas'] ?? '-';
        return $user;
    }

    public function get_user_roles($id_user) {
        $this->db->select('r.*');
        $this->db->from('user_role ur');
        $this->db->join('role r', 'ur.id_role = r.id_role');
        $this->db->where('ur.id_user', $id_user);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_roles() {
        $this->db->select('*');
        $this->db->from('role');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_user($data) {
        $this->db->insert('user', $data);
        return $this->db->insert_id();
    }

    public function update_user($id_user, $data) {
        $this->db->where('id_user', $id_user);
        $this->db->update('user', $data);
    }

    public function delete_user($id_user) {
        $this->db->where('id_user', $id_user);
        $this->db->delete('user');
    }

    public function add_role_to_user($user_id, $role_id) {
        $data = ['id_user' => $user_id, 'id_role' => $role_id];
        $this->db->insert('user_role', $data);
    }

    public function remove_role_from_user($user_id, $role_id) {
        $this->db->where('id_user', $user_id);
        $this->db->where('id_role', $role_id);
        return $this->db->delete('user_role');
    }

    public function assign_dosen($user_id, $prodi_id) {
        $this->db->where('id_user', $user_id);
        $this->db->delete('dosen');
        if ($prodi_id) {
            $data = ['id_user' => $user_id, 'id_prodi' => $prodi_id];
            $this->db->insert('dosen', $data);
        }
    }

    public function assign_kaprodi($user_id, $prodi_id) {
        $this->db->where('id_user', $user_id);
        $this->db->delete('kaprodi');
        if ($prodi_id) {
            $data = ['id_user' => $user_id, 'id_prodi' => $prodi_id];
            $this->db->insert('kaprodi', $data);
        }
    }

    public function assign_dekan($user_id, $fakultas_id) {
        $this->db->where('id_user', $user_id);
        $this->db->delete('dekan');
        if ($fakultas_id) {
            $data = ['id_user' => $user_id, 'id_fakultas' => $fakultas_id];
            $this->db->insert('dekan', $data);
        }
    }

    public function get_prodi_by_id($id_prodi) {
        $this->db->where('id_prodi', $id_prodi);
        $query = $this->db->get('prodi');
        return $query->row_array();
    }

    public function add_prodi($data) {
        $this->db->insert('prodi', $data);
    }

    public function update_prodi($id_prodi, $data) {
        $this->db->where('id_prodi', $id_prodi);
        $this->db->update('prodi', $data);
    }

    public function delete_prodi($id_prodi) {
        $this->db->where('id_prodi', $id_prodi);
        $this->db->delete('prodi');
    }

    public function get_all_klasifikasi_surat() {
        $this->db->select('*');
        $this->db->from('klasifikasi_surat');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_klasifikasi_surat($data) {
        $this->db->insert('klasifikasi_surat', $data);
    }

    public function get_klasifikasi_surat_by_id($id_klasifikasi_surat) {
        $this->db->where('id_klasifikasi_surat', $id_klasifikasi_surat);
        $query = $this->db->get('klasifikasi_surat');
        return $query->row_array();
    }

    public function update_klasifikasi_surat($id_klasifikasi_surat, $data) {
        $this->db->where('id_klasifikasi_surat', $id_klasifikasi_surat);
        $this->db->update('klasifikasi_surat', $data);
    }

    public function delete_klasifikasi_surat($id_klasifikasi_surat) {
        $this->db->where('id_klasifikasi_surat', $id_klasifikasi_surat);
        $this->db->delete('klasifikasi_surat');
    }

    public function get_role_by_name($nama_role) {
        $this->db->where('nama_role', $nama_role);
        $query = $this->db->get('role');
        return $query->row_array();
    }

    public function add_role($data) {
        $this->db->insert('role', $data);
    }
}