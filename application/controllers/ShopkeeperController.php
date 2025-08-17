<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShopkeeperController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url','form']);
        $this->load->model('WorkerModel');
        $this->load->model('UserModel');
        $this->load->model('CategoryModel');
        $this->load->model('ProductModel');
        $this->load->model('ActivityModel');
        $this->load->model('ShopModel');

        // Check if user is logged in and is a Shopkeeper
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'Shopkeeper') {
            redirect('login');
        }
    }

    // Dashboard
    public function dashboard() {
        $data['shopkeeper'] = $this->session->userdata();

        $data['shop'] = $this->ShopModel->getShopByShopkeeper($this->session->userdata('u_id'));

        $data['workers_count'] = $this->WorkerModel->getWorkerCountByShop($this->session->userdata('shop_id'));

        $data['categories_count'] = $this->CategoryModel->getCategoryCountByShop($this->session->userdata('shop_id'));

        $data['products_count'] = $this->ProductModel->getProductCountByShop($this->session->userdata('shop_id'));
        
        // $this->load->view('layouts/header');
        $this->load->view('shopkeeper/dashboard', $data);
        // $this->load->view('layouts/footer');
    }

    // Workers Management
    public function workers() {
        $shop_id = $this->session->userdata('shop_id');
        $data['workers'] = $this->WorkerModel->getWorkersByShop($shop_id);

        // $this->load->view('layouts/header');
        $this->load->view('shopkeeper/workers/index', $data);
        // $this->load->view('layouts/footer');
    }

    public function addWorker() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $mobile = (int) ($this->input->post('mobile'));
            
            $gender = $this->input->post('gender');
            $dob = $this->input->post('dob');
            $joined_on = $this->input->post('joined_on');
            $worker_role = $this->input->post('worker_role');

            if (empty($name) || empty($email) || empty($password) || empty($joined_on) || empty($worker_role) || empty($mobile) || empty($gender)) {
                $this->session->set_flashdata('error','Please fill all required fields');
                redirect('shopkeeper/workers/add');
            }

            $userExists = $this->UserModel->getUserByEmail($email);
            if ($userExists) {
                $this->session->set_flashdata('error','Email already in use.');
                redirect('shopkeeper/workers/add');
            }

            // Create user
            $userData = [
                'name' => $name,
                'email' => $email,
                'mobile' => $mobile,
                'gender' => $gender,
                'dob' => $dob,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'Worker',
                'created_at' => date('Y-m-d H:i:s'),
                'is_active' => 1
            ];
            $u_id = $this->UserModel->insertUserReturnId($userData);

            // Create worker
            if ($u_id) {
                $workerData = [
                    'worker_id' => $u_id,
                    'shop_id' => $this->session->userdata('shop_id'),
                    'joined_on' => $joined_on,
                    'role' => $worker_role,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $ok = $this->WorkerModel->insertWorker($workerData);
                if ($ok) {
                    $insertLog = [
                        'user_id' => $this->session->userdata('u_id'),
                        'action_type' => 'create',
                        'target_table' => 'users, workers',
                        'target_id' => $u_id,
                        'description' => 'shopkeeper added a new worker at target_id and at ' . $ok,
                    ];
                    $this->ActivityModel->logActivity($insertLog);
                    $this->session->set_flashdata('success','Worker added successfully.');
                } else {
                    $this->session->set_flashdata('error','Failed to add worker.');
                }
                // $this->session->set_flashdata('success','Worker added successfully.');
            } else {
                $this->session->set_flashdata('error','Failed to add worker.');
            }
            redirect('shopkeeper/workers');
        } else {
            // $this->load->view('layouts/header');
            $this->load->view('shopkeeper/workers/add');
            // $this->load->view('layouts/footer');
        }
    }

    public function editWorker($id) {
        // $id is $w_id
        $worker = $this->WorkerModel->getWorkerById((int)$id);

        if (!$worker){
            $this->session->set_flashdata('error','Worker not found');
            redirect('shopkeeper/workers');
        }

        $workerShopID = (int) trim($worker['shop_id']);
        $sessionShopID = (int) trim($this->session->userdata('shop_id'));

        if ($workerShopID !== $sessionShopID){
            $this->session->set_flashdata('error','Worker not in your shop.');
            redirect('shopkeeper/workers');
        }
    
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $userData = [];
            $workerData = [];
            
            $userData['u_id'] = (int) ($this->input->post('worker_id'));

            if ($this->input->post('name')) $userData['name'] = $this->input->post('name');

            if ($this->input->post('email')) $userData['email'] = $this->input->post('email');

            if ($this->input->post('password')) {
                $userData['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }

            if ($this->input->post('mobile')) $userData['mobile'] = (int)$this->input->post('mobile');
            // if ($this->input->post('date_of_joining')) $workerData['date_of_joining'] = $this->input->post('date_of_joining');

            if ($this->input->post('role')) $workerData['role'] = $this->input->post('role');

            $userData['updated_at'] = date('Y-m-d H:i:s');

            $ok = $this->WorkerModel->updateWorker($id, $userData, $workerData);
            if ($ok) {
                $updateLog = [
                    'user_id' => $this->session->userdata('u_id'),
                    'action_type' => 'update',
                    'target_table' => 'users, workers',
                    'target_id' => $userData['u_id'],
                    'description' => 'shopkeeper with user_id updated the worker with target_id',
                ];

                $this->ActivityModel->logActivity($updateLog);

                $this->session->set_flashdata('success','Worker updated successfully.');
            } else {
                $this->session->set_flashdata('error','Failed to update worker.');
            }
            redirect('shopkeeper/workers');
        } else {
            $data['worker'] = $worker;
            // $this->load->view('layouts/header');
            // print_r($data);
            // die();
            $this->load->view('shopkeeper/workers/edit', $data);
            // $this->load->view('layouts/footer');
        }
    }

    public function deleteWorker($id) {
        // id is of workers table
        $method = $this->input->server('REQUEST_METHOD');
        if ($method === 'POST') {
            $worker = $this->WorkerModel->getWorkerById((int)$id);

            if ($worker && $worker['shop_id'] == $this->session->userdata('shop_id')) {
                $ok = $this->WorkerModel->deleteWorker($id);

                // print_r($ok);
                // die();
                if ($ok) {
                    $deleteLog = [
                        'user_id' => $this->session->userdata('u_id'),
                        'action_type' => 'delete',
                        'target_table' => 'users, workers',
                        'target_id' => $worker['worker_id'],
                        'description' => 'shopkeeper with user_id deleted the records of a worker with target_id',
                    ];
                    $this->ActivityModel->logActivity($deleteLog);
                    $this->session->set_flashdata('success', 'Worker deleted successfully.');
                    // return $this->output->set_content_type('application/json')->set_output(json_encode(['status'=>true]));
                } else {
                    $this->session->set_flashdata('error', 'Failed to delete worker.');
                }
            }
            // return $this->output->set_status_header(500)->set_content_type('application/json')->set_output(json_encode(['status'=>false, 'message' => 'Failed to delete worker.']));
        }
        redirect('shopkeeper/workers');
    }

    // Categories Management
    public function categories() {
        $shop_id = $this->session->userdata('shop_id');
        $data['categories'] = $this->CategoryModel->getCategoriesByShop($shop_id);

        // $this->load->view('layouts/header');
        $this->load->view('shopkeeper/categories/index', $data);
        // $this->load->view('layouts/footer');
    }

    public function addCategory() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $category_name = $this->input->post('category_name');

            if (empty($category_name)) {
                $this->session->set_flashdata('error','Category name is required.');
                redirect('shopkeeper/categories/add');
            }

            $data = [
                'shop_id' => $this->session->userdata('shop_id'),
                'category_name' => $category_name,
                'created_by' => $this->session->userdata('u_id'),
                'added_at' => date('Y-m-d H:i:s')
            ];
            
            $c_id = $this->CategoryModel->insertCategory($data);
            if ($c_id) {
                $catInsertLog = [
                    'user_id' => $this->session->userdata('u_id'),
                    'action_type' => 'added a new category',
                    'target_table' => 'categories',
                    'target_id' => $c_id,
                    'description' => 'added a new category at shop ID ' . $this->session->userdata('shop_id'),
                ];
                $this->ActivityModel->logActivity($catInsertLog);

                $this->session->set_flashdata('success','Category added successfully.');
            } else {
                $this->session->set_flashdata('error','Failed to add category.');
            }
            redirect('shopkeeper/categories');
        } else {
            // $this->load->view('layouts/header');
            $this->load->view('shopkeeper/categories/add');
            // $this->load->view('layouts/footer');
        }
    }

    public function editCategory($id) {
        //id is categories: c_id
        $category = $this->CategoryModel->getCategoryById((int)$id);
        if (!$category || $category['shop_id'] != $this->session->userdata('shop_id')) {
            $this->session->set_flashdata('error','Category not found or not in your shop.');
            redirect('shopkeeper/categories');
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $category_name = $this->input->post('category_name');
            $ok = $this->CategoryModel->updateCategory((int)$id, ['category_name' => $category_name, 'created_by' => $this->session->userdata('shop_id')]);

            if ($ok) {
                $catUpdateLog = [
                    'user_id' => $this->session->userdata('u_id'),
                    'action_type' => 'updated categories',
                    'target_table' => 'categories',
                    'target_id' => $id,
                    'description' => 'shopkeeper with user_id updated a category at target_id ID'
                ];
                $this->ActivityModel->logActivity($catUpdateLog);
                $this->session->set_flashdata('success','Category updated successfully.');
            } else {
                $this->session->set_flashdata('error','Failed to update category.');
            }
            redirect('shopkeeper/categories');
        } else {
            $data['category'] = $category;
            // $this->load->view('layouts/header');
            $this->load->view('shopkeeper/categories/edit', $data);
            // $this->load->view('layouts/footer');
        }
    }

    public function deleteCategory($id) {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method === 'POST') {
            $category = $this->CategoryModel->getCategoryById((int)$id);
            if ($category && $category['shop_id'] == $this->session->userdata('shop_id')) {
                $ok = $this->CategoryModel->deleteCategory($id);
                if ($ok) {
                    $catDeleteLog = [
                        'user_id' => $this->session->userdata('u_id'),
                        'action_type' => 'delete',
                        'target_table' => 'categories',
                        'target_id' => $id,
                        'description' => 'shopkeeper with user_id deleted a category present at target_id',
                    ];
                    $this->ActivityModel->logActivity($catDeleteLog);
                    $this->session->set_flashdata('success', 'Category deleted successfully.');
                    // redirect('shopkeeper/categories');
                    // return $this->output->set_content_type('application/json')->set_output(json_encode(['status'=>true]));
                } else {
                    $this->session->set_flashdata('error', 'Failed to delete category which has products');
                }
            }
            // $this->session->set_flashdata('error', 'Failed to delete category.');
            // return $this->output->set_status_header(500)->set_content_type('application/json')->set_output(json_encode(['status'=>false, 'message' => 'Failed to delete category.']));
        }
        redirect('shopkeeper/categories');
    }

    // Products Management
    public function products() {
        $shop_id = $this->session->userdata('shop_id');
        $data['products'] = $this->ProductModel->getProductsByShop($shop_id);

        // echo "<pre>";
        // print_r($data);
        // die();

        // $this->load->view('layouts/header');
        $this->load->view('shopkeeper/products/index', $data);
        // $this->load->view('layouts/footer');
    }

    public function addProduct() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $name = $this->input->post('name');
            $price = $this->input->post('price');
            $quantity = $this->input->post('quantity');
            $category_id = $this->input->post('category_id');

            if (empty($name) || empty($price) || empty($quantity)) {
                $this->session->set_flashdata('error','Please fill all required fields.');
                redirect('shopkeeper/products/add');
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
                    'action_type' => 'create',
                    'target_table' => 'products',
                    'target_id' => $p_id,
                    'description' => 'shopkeeper with user_id added a product at target_id',
                ];
                $this->ActivityModel->logActivity($prodAddLog);
                $this->session->set_flashdata('success','Product added successfully.');
            } else {
                $this->session->set_flashdata('error','Failed to add product.');
            }
            redirect('shopkeeper/products');
        } else {
            $shop_id = $this->session->userdata('shop_id');
            $data['categories'] = $this->CategoryModel->getCategoriesByShop($shop_id);
            // $this->load->view('layouts/header');
            $this->load->view('shopkeeper/products/add', $data);

    //         echo '<pre>';
    // print_r($data);
    // die();
            // $this->load->view('layouts/footer');
        }
    }

    public function editProduct($id) {
        $product = $this->ProductModel->getProductById((int)$id);
        if (!$product || $product['shop_id'] != $this->session->userdata('shop_id')) {
            $this->session->set_flashdata('error','Product not found or not in your shop.');
            redirect('shopkeeper/products');
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $data = [];

            if ($this->input->post('name')) $data['name'] = $this->input->post('name');

            if ($this->input->post('price')) $data['price'] = $this->input->post('price');

            if ($this->input->post('quantity')) $data['quantity'] = $this->input->post('quantity');

            // if ($this->input->post('category_id')) $data['category_id'] = $this->input->post('category_id');

            $ok = $this->ProductModel->updateProduct((int)$id, $data);
            if ($ok) {
                $prodUpdateLog = [
                    'user_id' => $this->session->userdata('u_id'),
                    'action_type' => 'update',
                    'target_table' => 'products',
                    'target_id' => $id,
                    'description' => 'shopkeeper with user_id update a product with target_id',
                ];
                $this->ActivityModel->logActivity($prodUpdateLog);
                $this->session->set_flashdata('success','Product updated successfully.');
            } else {
                $this->session->set_flashdata('error','Failed to update product.');
            }
            redirect('shopkeeper/products');
        } else {
            $shop_id = $this->session->userdata('shop_id');
            $data['product'] = $product;
            $data['categories'] = $this->CategoryModel->getCategoriesByShop($shop_id);
            // $this->load->view('layouts/header');
            $this->load->view('shopkeeper/products/edit', $data);
            // $this->load->view('layouts/footer');
        }
    }

    public function deleteProduct($id) {
        // id is p_id
        $method = $this->input->server('REQUEST_METHOD');
        if ($method === 'POST') {
            $product = $this->ProductModel->getProductById((int)$id);
            if ($product && $product['shop_id'] == $this->session->userdata('shop_id')) {
                $ok = $this->ProductModel->deleteProduct($id);
                if ($ok) {
                    $prodDeleteLog = [
                        'user_id' => $this->session->userdata('u_id'),
                        'action_type' => 'delete',
                        'target_table' => 'products',
                        'target_id' => $id,
                        'description' => 'shopkeeper with user_id deleted a product at target_id'
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
        redirect('shopkeeper/products');
    }
}
