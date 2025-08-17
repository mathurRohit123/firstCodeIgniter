<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WorkerModel extends CI_Model {

    public function insertWorker($data) {
        $this->db->insert('workers', $data);
        return (int)$this->db->insert_id();
    }

    public function getAllWorkers() {
        $this->db->select('w.*, u.name as user_name, u.email, u.mobile, s.shop_name');
        $this->db->from('workers w');
        $this->db->join('users u','u.u_id = w.worker_id','left');
        $this->db->join('shops s','s.s_id = w.shop_id','left');
        $this->db->order_by('w.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getWorkerById($w_id) {
        $this->db->select('w.*, u.name as user_name, u.email, u.password, u.mobile, u.gender, u.dob, s.shop_name');
        $this->db->from('workers w');
        $this->db->join('users u','u.u_id = w.worker_id','left');
        $this->db->join('shops s','s.s_id = w.shop_id','left');
        $this->db->where('w.w_id', $w_id);
        return $this->db->get()->row_array();
    }

    public function getWorkerByUserId($user_id) {
        $this->db->select('w.*, u.name as user_name, u.email, u.mobile, s.shop_name, s.location');
        $this->db->from('workers w');
        $this->db->join('users u','u.u_id = w.worker_id','left');
        $this->db->join('shops s','s.s_id = w.shop_id','left');
        $this->db->where('w.worker_id', $user_id);
        return $this->db->get()->row_array();
    }

    public function getWorkersByShop($shop_id) {
        $this->db->select('w.*, u.name as user_name, u.email, u.mobile, u.gender, u.dob');
        $this->db->from('workers w');
        $this->db->join('users u','u.u_id = w.worker_id','left');
        $this->db->where('w.shop_id', $shop_id);
        $this->db->order_by('w.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getWorkerCountByShop($shop_id) {
        if (!$shop_id) return 0;
        return $this->db->get_where('workers', ['shop_id' => $shop_id])->num_rows();
    }

    public function updateWorker($w_id, $userUpdate = [], $workerUpdate = []) {
        $this->db->trans_start();
        
        // echo '<pre>';
        // print_r($userUpdate);
        // print_r($workerUpdate);
        // die();
        // Update user table if user data provided
        if (!empty($userUpdate) && isset($userUpdate['u_id'])) {
            $u_id = $userUpdate['u_id'];//fetch-out users.u_id
            unset($userUpdate['u_id']);
            if (!empty($userUpdate)) {
                $this->db->where('u_id', $u_id)->update('users', $userUpdate);
            }
        }
        
        // Update worker table
        if (!empty($workerUpdate)) {
            $this->db->where('w_id',$w_id)->update('workers',$workerUpdate);
        }

        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function deleteWorker($w_id) {
        $this->db->select('*');
        $this->db->from('workers');
        $this->db->where('w_id', $w_id);
        $hold = $this->db->get()->row_array();
        $this->db->where('w_id',$w_id)->delete('workers');
        $u_id = $hold['worker_id'];
        // $this->db->
        // return ($hold);
        // die();
        $this->db->where('u_id',$u_id)->delete('users');
        return $this->db->affected_rows() > 0;
    }

    public function getWorkersByType($worker_type, $shop_id = null) {
        $this->db->select('w.*, u.name as user_name, u.email, s.shop_name');
        $this->db->from('workers w');
        $this->db->join('users u','u.u_id = w.worker_id','left');
        $this->db->join('shops s','s.s_id = w.shop_id','left');
        $this->db->where('w.role', $worker_type);
        if ($shop_id) {
            $this->db->where('w.shop_id', $shop_id);
        }
        return $this->db->get()->result_array();
    }

    public function getActiveWorkers($shop_id = null) {
        $this->db->select('w.*, u.name as user_name, u.email');
        $this->db->from('workers w');
        $this->db->join('users u','u.u_id = w.user_id','left');
        $this->db->where('u.is_active', 1); // assuming you have is_active field
        if ($shop_id) {
            $this->db->where('w.shop_id', $shop_id);
        }
        return $this->db->get()->result_array();
    }

    // Get workers with their latest activity
    public function getWorkersWithActivity($shop_id) {
        $this->db->select('w.*, u.name as user_name, u.email, 
                          MAX(a.created_at) as last_activity');
        $this->db->from('workers w');
        $this->db->join('users u','u.u_id = w.user_id','left');
        $this->db->join('activity_logs a','a.user_id = w.user_id','left');
        $this->db->where('w.shop_id', $shop_id);
        $this->db->group_by('w.w_id, w.user_id, w.shop_id, w.worker_id, w.role, 
                            w.joined_on, w.created_at, u.name, u.email');
        $this->db->order_by('w.created_at', 'DESC');
        return $this->db->get()->result_array();
    }
}