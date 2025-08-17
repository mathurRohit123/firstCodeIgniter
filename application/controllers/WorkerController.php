<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WorkerController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url','form']);
        $this->load->model('CategoryModel');
        $this->load->model('ProductModel');
        $this->load->model('WorkerModel');
        $this->load->model('ActivityModel');

        // Check if user is logged in and is a Worker
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'Worker') {
            redirect('login');
        }
    }

    // Worker Dashboard
    public function dashboard() {
        $worker = $this->WorkerModel->getWorkerByUserId($this->session->userdata('u_id'));
        $data['worker'] = $worker;
        $data['user'] = $this->session->userdata();
        
        if ($worker) {
            $data['products_count'] = $this->ProductModel->getProductCountByShop($worker['shop_id']);
            $data['categories_count'] = $this->CategoryModel->getCategoryCountByShop($worker['shop_id']);
        }
        
        // $this->load->view('layouts/header');
        $this->load->view('worker/dashboard', $data);
        // $this->load->view('layouts/footer');
    }

    /**
     * Categories management for workers
     * worker can only look for categories available
     */
    public function categories() {
        $worker = $this->WorkerModel->getWorkerByUserId($this->session->userdata('u_id'));
        if (!$worker) {
            redirect('worker/dashboard');
        }
        $data['categories'] = $this->CategoryModel->getCategoriesByShop($worker['shop_id']);

        // $this->load->view('layouts/header');
        $this->load->view('worker/categories/index', $data);
        // $this->load->view('layouts/footer');
    }

    /**
     * Products management for workers
     */
    public function products() {
        $worker = $this->WorkerModel->getWorkerByUserId($this->session->userdata('u_id'));
        if (!$worker) {
            redirect('worker/dashboard');
        }
        $data['products'] = $this->ProductModel->getProductsByShop($worker['shop_id']);
        $data['categories'] = $this->CategoryModel->getCategoriesByShop($worker['shop_id']);

        // $this->load->view('layouts/header');
        $this->load->view('worker/products/index', $data);
        // $this->load->view('layouts/footer');
    }

    public function addProduct() {
        $worker = $this->WorkerModel->getWorkerByUserId($this->session->userdata('u_id'));
        if (!$worker) {
            redirect('worker/dashboard');
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $name = $this->input->post('name');
            $price = $this->input->post('price');
            $quantity = $this->input->post('quantity');
            $category_id = $this->input->post('category_id');

            if (empty($name) || empty($price) || empty($quantity) || empty($category_id)) {
                $this->session->set_flashdata('error','Please fill all required fields.');
                redirect('worker/products/add');
            }

            $data = [
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'category_id' => $category_id,
                'created_by' => $this->session->userdata('u_id'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $p_id = $this->ProductModel->insertProduct($data);
            if ($p_id) {
                $prodAddLog = [
                    'user_id' => $this->session->userdata('u_id'),
                    'action_type' => 'added product',
                    'target_table' => 'products',
                    'target_id' => $p_id,
                    'description' => 'worker with user_id added a product with target_id',
                ];
                $this->ActivityModel->logActivity($prodAddLog);
                $this->session->set_flashdata('success','Product added successfully.');
            } else {
                $this->session->set_flashdata('error','Failed to add product.');
            }
            redirect('worker/products');
        } else {
            $data['categories'] = $this->CategoryModel->getCategoriesByShop($worker['shop_id']);
            // $this->load->view('layouts/header');
            $this->load->view('worker/products/add', $data);
            // $this->load->view('layouts/footer');
        }
    }

    public function editProduct($id) {
        $worker = $this->WorkerModel->getWorkerByUserId($this->session->userdata('u_id'));
        if (!$worker) {
            redirect('worker/dashboard');
        }

        $product = $this->ProductModel->getProductById((int)$id);
        if (!$product || $product['shop_id'] != $worker['shop_id']) {
            $this->session->set_flashdata('error','Product not found or not in your shop.');
            redirect('worker/products');
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data = [];

            if ($this->input->post('name')) $data['name'] = $this->input->post('name');

            if ($this->input->post('price')) $data['price'] = $this->input->post('price');

            if ($this->input->post('quantity')) $data['quantity'] = $this->input->post('quantity');

            if ($this->input->post('category_id')) $data['category_id'] = $this->input->post('category_id');

            $ok = $this->ProductModel->updateProduct((int)$id, $data);
            if ($ok) {
                $prodUpdateLog = [
                    'user_id' => $this->session->userdata('u_id'),
                    'action_type' => 'update',
                    'target_table' => 'products',
                    'target_id' => $id,
                    'description' => 'worker with user_id edited a product at target_id',
                ];
                $this->ActivityModel->logActivity($prodUpdateLog);

                $this->session->set_flashdata('success','Product updated successfully.');
            } else {
                $this->session->set_flashdata('error','Failed to update product.');
            }
            redirect('worker/products');
        } else {
            $data['product'] = $product;
            $data['categories'] = $this->CategoryModel->getCategoriesByShop($worker['shop_id']);
            // $this->load->view('layouts/header');
            $this->load->view('worker/products/edit', $data);
            // $this->load->view('layouts/footer');
        }
    }
    
    public function deleteProduct($id) {
        $worker = $this->WorkerModel->getWorkerByUserId($this->session->userdata('u_id'));
        if (!$worker) {
            return $this->output->set_status_header(403)->set_content_type('application/json')->set_output(json_encode(['status'=>false,'message'=>'forbidden']));
        }

        $method = $this->input->server('REQUEST_METHOD');
        if ($method === 'POST') {
            $product = $this->ProductModel->getProductById((int)$id);
            if ($product && $product['shop_id'] == $worker['shop_id']) {
                $ok = $this->ProductModel->deleteProduct($id);
                if ($ok) {
                    $prodDeleteLog = [
                        'user_id' => $this->session->userdata('u_id'),
                        'action_type' => 'delete',
                        'target_table' => 'products',
                        'target_id' => $id,
                        'description' => 'worker with user_id deleted a product at target_id',
                    ];
                    $this->ActivityModel->logActivity($prodDeleteLog);
                    $this->session->set_flashdata('success', 'Product deleted successfully.');
                    // return $this->output->set_content_type('application/json')->set_output(json_encode(['status'=>true]));
                } else {
                    $this->session->set_flashdata('error', 'Failed to delete product.');
                }
            }
            // $this->session->set_flashdata('error', 'Failed to delete product.');
            // return $this->output->set_status_header(500)->set_content_type('application/json')->set_output(json_encode(['status'=>false, 'message' => 'Failed to delete product.']));
        }
        redirect('worker/products');
    }

    /**
     * Get worker's own details
     */
    public function profile() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'Worker') {
            return $this->output->set_status_header(403)->set_content_type('application/json')
                ->set_output(json_encode(['status'=>false,'message'=>'forbidden']));
        }

        $worker = $this->WorkerModel->getWorkerByUserId($this->session->userdata('u_id'));
        if ($worker) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['status'=>true,'data'=>$worker]));
        }
        return $this->output->set_status_header(404)->set_content_type('application/json')
            ->set_output(json_encode(['status'=>false,'message'=>'Worker not found']));
    }
}
