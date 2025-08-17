<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductModel extends CI_Model {

    public function insertProduct($data) {
        $this->db->insert('products', $data);
        return (int)$this->db->insert_id();
    }

    public function getProductsByShop($shop_id) {
        $this->db->select('p.*, c.category_name, c.shop_id, u.name as created_by_name');
        $this->db->from('products p');
        $this->db->join('categories c', 'c.c_id = p.category_id', 'inner');
        $this->db->join('users u', 'u.u_id = p.created_by', 'left');
        $this->db->where('c.shop_id', $shop_id);
        $this->db->order_by('p.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getProductById($p_id) {
        $this->db->select('p.*, c.category_name, c.shop_id');
        $this->db->from('products p');
        $this->db->join('categories c', 'c.c_id = p.category_id', 'inner');
        $this->db->where('p.p_id', $p_id);
        return $this->db->get()->row_array();
    }

    public function updateProduct($p_id, $data) {
        if (empty($data)) return true;
        $this->db->where('p_id', $p_id)->update('products', $data);
        return $this->db->affected_rows() >= 0;
    }

    public function deleteProduct($p_id) {
        $this->db->where('p_id', $p_id)->delete('products');
        return $this->db->affected_rows() > 0;
    }

    public function getProductCountByShop($shop_id) {
        if (!$shop_id) return 0;
        $this->db->select('COUNT(p.p_id) as count');
        $this->db->from('products p');
        $this->db->join('categories c', 'c.c_id = p.category_id', 'inner');
        $this->db->where('c.shop_id', $shop_id);
        $result = $this->db->get()->row_array();
        return (int)$result['count'];
    }

    public function getAllProducts() {
        $this->db->select('p.*, c.category_name, s.shop_name, u.name as created_by_name');
        $this->db->from('products p');
        $this->db->join('categories c', 'c.c_id = p.category_id', 'inner');
        $this->db->join('shops s', 's.s_id = c.shop_id', 'left');
        $this->db->join('users u', 'u.u_id = p.created_by', 'left');
        $this->db->order_by('p.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getProductsByCategory($category_id) {
        $this->db->select('p.*, u.name as created_by_name');
        $this->db->from('products p');
        $this->db->join('users u', 'u.u_id = p.created_by', 'left');
        $this->db->where('p.category_id', $category_id);
        $this->db->order_by('p.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function updateQuantity($p_id, $new_quantity) {
        $this->db->where('p_id', $p_id)->update('products', ['quantity' => $new_quantity]);
        return $this->db->affected_rows() > 0;
    }

    public function getLowStockProducts($shop_id, $threshold = 5) {
        $this->db->select('p.*, c.category_name');
        $this->db->from('products p');
        $this->db->join('categories c', 'c.c_id = p.category_id', 'inner');
        $this->db->where('c.shop_id', $shop_id);
        $this->db->where('p.quantity <=', $threshold);
        $this->db->order_by('p.quantity', 'ASC');
        return $this->db->get()->result_array();
    }
}