<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryModel extends CI_Model {

    public function insertCategory($data) {
        $this->db->insert('categories', $data);
        return (int)$this->db->insert_id();
    }

    public function getCategoriesByShop($shop_id) {
        $this->db->select('c.*, u.name as created_by_name');
        $this->db->from('categories c');
        $this->db->join('users u', 'u.u_id = c.created_by', 'left');
        $this->db->where('c.shop_id', $shop_id);
        $this->db->order_by('c.added_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getCategoryById($c_id) {
        return $this->db->get_where('categories', ['c_id' => $c_id])->row_array();
    }

    public function updateCategory($c_id, $data) {
        if (empty($data)) return true;
        $this->db->where('c_id', $c_id)->update('categories', $data);
        return $this->db->affected_rows() >= 0;
    }

    public function deleteCategory($c_id) {
        // Check if category has products
        $productCount = $this->db->get_where('products', ['category_id' => $c_id])->num_rows();
        if ($productCount > 0) {
            return false; // Cannot delete category with products
        }
        
        $this->db->where('c_id', $c_id)->delete('categories');
        return $this->db->affected_rows() > 0;
    }

    public function getCategoryCountByShop($shop_id) {
        if (!$shop_id) return 0;
        return $this->db->get_where('categories', ['shop_id' => $shop_id])->num_rows();
    }

    public function getAllCategories() {
        $this->db->select('c.*, s.shop_name, u.name as created_by_name');
        $this->db->from('categories c');
        $this->db->join('shops s', 's.s_id = c.shop_id', 'left');
        $this->db->join('users u', 'u.u_id = c.created_by', 'left');
        $this->db->order_by('c.added_at', 'DESC');
        return $this->db->get()->result_array();
    }
}