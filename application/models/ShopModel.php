<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShopModel extends CI_Model {

    // get shop row by shopkeeper user id
    public function getShopByShopkeeper($shopkeeper_u_id) {
        return $this->db->get_where('shops', ['shopkeeper_id' => $shopkeeper_u_id])->row_array();
    }
}
