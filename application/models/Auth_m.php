<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_m extends CI_Model {
    public function login($username, $password) {
        $this->db->where('username', $username);
        $this->db->where('password', MD5($password)); // Use MD5 for password hashing
        $query = $this->db->get('users');
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return FALSE;
    }
}