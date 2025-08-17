<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ActivityModel extends CI_Model {

    public function logActivity($data) {
        $activity = [
            'user_id' => $data['user_id'],
            'action_type' => $data['action_type'], // CREATE, UPDATE, DELETE, LOGIN
            'target_table' => $data['target_table'] ?? null,
            'target_id' => $data['target_id'] ?? null,
            'description' => $data['description'],
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('activity_logs', $activity);
        return (int)$this->db->insert_id();
    }

    public function getActivitiesByUser($user_id, $limit = 50) {
        $this->db->select('a.*, u.name as user_name');
        $this->db->from('activity_logs a');
        $this->db->join('users u', 'u.u_id = a.user_id', 'left');
        $this->db->where('a.user_id', $user_id);
        $this->db->order_by('a.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function getAllActivities($limit = 100) {
        $this->db->select('a.*, u.name as user_name, u.role as user_role');
        $this->db->from('activity_logs a');
        $this->db->join('users u', 'u.u_id = a.user_id', 'left');
        $this->db->order_by('a.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function getActivitiesByShop($shop_id, $limit = 50) {
        // Get activities related to a specific shop
        $this->db->select('a.*, u.name as user_name, u.role as user_role');
        $this->db->from('activity_logs a');
        $this->db->join('users u', 'u.u_id = a.user_id', 'left');
        
        // Complex join to filter by shop activities
        $this->db->group_start()
            // Shopkeeper activities
            ->where_in('u.u_id', function($subquery) use ($shop_id) {
                $subquery->select('shopkeeper_id')
                         ->from('shops')
                         ->where('s_id', $shop_id);
            })
            // OR Worker activities from this shop
            ->or_where_in('u.u_id', function($subquery) use ($shop_id) {
                $subquery->select('user_id')
                         ->from('workers')
                         ->where('shop_id', $shop_id);
            })
            ->group_end();
            
        $this->db->order_by('a.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function getActivitiesByType($action_type, $limit = 50) {
        $this->db->select('a.*, u.name as user_name, u.role as user_role');
        $this->db->from('activity_logs a');
        $this->db->join('users u', 'u.u_id = a.user_id', 'left');
        $this->db->where('a.action_type', $action_type);
        $this->db->order_by('a.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function getActivitiesByDateRange($start_date, $end_date, $limit = 100) {
        $this->db->select('a.*, u.name as user_name, u.role as user_role');
        $this->db->from('activity_logs a');
        $this->db->join('users u', 'u.u_id = a.user_id', 'left');
        $this->db->where('DATE(a.created_at) >=', $start_date);
        $this->db->where('DATE(a.created_at) <=', $end_date);
        $this->db->order_by('a.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function deleteOldActivities($days = 90) {
        $cutoff_date = date('Y-m-d H:i:s', strtotime("-{$days} days"));
        $this->db->where('created_at <', $cutoff_date);
        $this->db->delete('activity_logs');
        return $this->db->affected_rows();
    }
}