<?php
defined('BASEPATH') OR exit("No direct script access allowed");

class UserModel extends CI_Model {

    public function getUserByID($id){
        $this->db->select('u*, s.s_id as shop_id, s.reg_id, s.shop_name, s.location');
        $this->db->from('users u');
        $this->db->join('shops s', 'u.u_id = s.shopkeeper_id', 'inner');
        $this->db->where('u.u_id', $id);
        return $this->db->get()->row_array();
    }

    public function getUserByEmail($email) {
        return $this->db->get_where('users', ['email' => $email])->row_array();
        //row_array() returns 1 assoc_array
    }

    // Insert user array and return inserted u_id (or false)
    public function insertUserReturnId($data) {
        $this->db->insert('users', $data);
        $id = $this->db->insert_id();// last insert ki id dega
        return ($id > 0) ? (int)$id : false;
    }

    public function updateUser($u_id, $data){
        if (empty($data)) return true;
        $this->db->where('u_id', $u_id)->update('users', $data);
        return $this->db->affected_rows() >= 0;
    }

    public function deleteUser($u_id) {
        $this->db->where('u_id', $u_id)->delete('users');
    }

    public function getAllUsers(){
        $this->db->order_by('created_at', 'DESC');
        return $this->db->affected_rows() > 0;
    }

    public function getUsersByRole($role){
        return $this->db->get_where('users', ['role' => $role])->row_array();
    }
}
