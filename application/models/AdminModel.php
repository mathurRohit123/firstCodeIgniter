<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminModel extends CI_Model {

    // get all shopkeepers + shop name + worker count (MySQL safe)
    public function getAllShopkeepers() {
        $this->db->select('u.u_id,u.name,u.email, u.mobile, u.dob,  s.reg_id, s.location, COALESCE(MAX(s.shop_name),"No Shop") as shop_name, COUNT(w.w_id) as total_workers');
        $this->db->from('users u');
        $this->db->join('shops s','s.shopkeeper_id = u.u_id','left');
        $this->db->join('workers w','w.shop_id = s.s_id','left');
        $this->db->where('u.role','Shopkeeper');
        $this->db->group_by('u.u_id,u.name,u.email, u.mobile, u.dob, s.reg_id, s.location');
        return $this->db->get()->result_array();
    }

    public function getShopkeeperById($u_id) {
        $this->db->select('u.*, s.*');
        $this->db->from('users u');
        $this->db->join('shops s','s.shopkeeper_id = u.u_id','left');
        $this->db->where('u.u_id',$u_id);
        return $this->db->get()->row_array();
    }

    // create user + shop inside transaction
    public function createShopkeeper($userData, $shopData) {
        $this->db->trans_start();
        $this->db->insert('users', $userData);
        $u_id = $this->db->insert_id();
        $shopData['shopkeeper_id'] = $u_id;
        $this->db->insert('shops', $shopData);
        $logAdd = [
                    'user_id' => $this->session->userdata('u_id'),
                    'action_type' => "create",
                    'target_table' => 'users, shops',
                    'target_id' => $u_id,
                    'description' => 'Admin created a new shopkeeper record at ID ' . $u_id,
                ];
        $this->ActivityModel->logActivity($logAdd);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function updateShopkeeper($u_id, $userData = [], $shopData = []) {
        $this->db->trans_start();
        if (!empty($userData)) $this->db->where('u_id',$u_id)->update('users',$userData);
        if (!empty($shopData)) $this->db->where('shopkeeper_id',$u_id)->update('shops',$shopData);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function deleteShopkeeper($u_id) {
        $this->db->trans_start();
        // $deleteLog = [
        //             'user_id' => $this->session->userdata('u_id'),
        //             'action_type' => 'deleted shopkeeper with ID ' . $u_id,
        //             'target_table' => 'users, shops',
        //             'target_id' => $u_id,
        //             'description' => 'deleted the record from all tables',
        //         ];
        // $this->ActivityModel->logActivity($deleteLog);
        $this->db->where('shopkeeper_id',$u_id)->delete('shops');
        $this->db->where('u_id',$u_id)->delete('users');
        $this->db->where('worker_id',$u_id)->delete('workers'); // optional: remove their workers if user id stored
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
