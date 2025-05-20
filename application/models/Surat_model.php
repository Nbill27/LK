<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_model extends CI_Model {
    public function get_total_surat($user_id = null) {
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        return $this->db->count_all_results('surat_lk');
    }

    public function get_surat_by_status($status, $user_id = null) {
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        $this->db->where('status', $status);
        return $this->db->get('surat_lk')->result();
    }

    public function get_surat_history($user_id) {
        $this->db->select('surat_lk.*, history_surat.action, history_surat.keterangan, history_surat.created_at');
        $this->db->from('history_surat');
        $this->db->join('surat_lk', 'history_surat.surat_id = surat_lk.id');
        $this->db->where('history_surat.user_id', $user_id);
        $this->db->order_by('history_surat.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_surat_to_approve($role_id, $user_id) {
        $this->db->select('surat_lk.*, users.name as pengirim');
        $this->db->from('tracking_surat');
        $this->db->join('surat_lk', 'tracking_surat.surat_id = surat_lk.id');
        $this->db->join('users', 'surat_lk.user_id = users.id');
        $this->db->where('tracking_surat.role_id', $role_id);
        $this->db->where('tracking_surat.status', 'pending');
        return $this->db->get()->result();
    }

    public function get_surat_masuk($role_id, $user_id) {
        $this->db->select('surat_lk.*, users.name as pengirim');
        $this->db->from('tracking_surat');
        $this->db->join('surat_lk', 'tracking_surat.surat_id = surat_lk.id');
        $this->db->join('users', 'surat_lk.user_id = users.id');
        $this->db->where('tracking_surat.role_id', $role_id);
        $this->db->where('tracking_surat.status !=', 'pending');
        return $this->db->get()->result();
    }

    public function get_notifications($role_id, $user_id) {
        $this->db->from('tracking_surat');
        $this->db->where('role_id', $role_id);
        $this->db->where('status', 'pending');
        return $this->db->count_all_results();
    }

    public function get_pending_by_user($user_id, $role_id) {
        $this->db->select('surat_lk.*');
        $this->db->from('surat_lk');
        $this->db->join('tracking_surat', 'tracking_surat.surat_id = surat_lk.id');
        $this->db->where('surat_lk.user_id', $user_id);
        $this->db->where('tracking_surat.role_id', $role_id);
        $this->db->where('tracking_surat.status', 'pending');
        return $this->db->get()->result();
    }

    public function get_approved_by_user($user_id, $role_id) {
        $this->db->select('surat_lk.*');
        $this->db->from('surat_lk');
        $this->db->join('tracking_surat', 'tracking_surat.surat_id = surat_lk.id');
        $this->db->where('surat_lk.user_id', $user_id);
        $this->db->where('tracking_surat.role_id', $role_id);
        $this->db->where('tracking_surat.status', 'approved');
        return $this->db->get()->result();
    }

    public function get_surat_status($user_id) {
        $this->db->select('surat_lk.*, tracking_surat.status');
        $this->db->from('surat_lk');
        $this->db->join('tracking_surat', 'tracking_surat.surat_id = surat_lk.id', 'left');
        $this->db->where('surat_lk.user_id', $user_id);
        $this->db->order_by('surat_lk.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_surat_arsip($user_id) {
        $this->db->select('surat_lk.*');
        $this->db->from('surat_lk');
        $this->db->join('tracking_surat', 'tracking_surat.surat_id = surat_lk.id');
        $this->db->where('tracking_surat.status', 'archived');
        $this->db->order_by('surat_lk.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function create_surat($data) {
        return $this->db->insert('surat_lk', $data);
    }

    public function add_history($data) {
        return $this->db->insert('history_surat', $data);
    }

    public function add_tracking($data) {
        return $this->db->insert('tracking_surat', $data);
    }

    public function update_tracking($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('tracking_surat', $data);
    }

    public function update_surat($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('surat_lk', $data);
    }

    public function get_surat_by_id($surat_id) {
        $this->db->select('surat_lk.*, users.name as pengirim');
        $this->db->from('surat_lk');
        $this->db->join('users', 'surat_lk.user_id = users.id');
        $this->db->where('surat_lk.id', $surat_id);
        return $this->db->get()->row();
    }

    public function get_surat_history_by_id($surat_id) {
        $this->db->select('history_surat.*, users.name as pelaku');
        $this->db->from('history_surat');
        $this->db->join('users', 'history_surat.user_id = users.id');
        $this->db->where('history_surat.surat_id', $surat_id);
        $this->db->order_by('history_surat.created_at', 'ASC');
        return $this->db->get()->result();
    }

    public function get_tracking_by_surat_id($surat_id) {
        $this->db->select('tracking_surat.*, roles.name as role_name');
        $this->db->from('tracking_surat');
        $this->db->join('roles', 'tracking_surat.role_id = roles.id');
        $this->db->where('tracking_surat.surat_id', $surat_id);
        $this->db->order_by('tracking_surat.created_at', 'ASC');
        return $this->db->get()->result();
    }
}