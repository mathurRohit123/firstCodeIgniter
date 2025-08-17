<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url','form']);
        $this->load->model('AdminModel');   // shopkeeper CRUD model
        $this->load->model('UserModel');
        $this->load->model('WorkerModel');
        $this->load->model('ActivityModel');
    }

    // dashboard placeholder
    public function dashboard() {
        // ensure admin
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'Admin') {
            redirect('login');
        }
        $this->load->view('admin/dashboard'); // create a simple view or redirect elsewhere
    }

    /**
     * shopkeepers()
     * - GET (no id) -> list all shopkeepers
     * - GET (id) -> return single shopkeeper
     * - POST -> create shopkeeper (form or JSON)
     * - PUT -> update shopkeeper (API)
     * - DELETE -> delete shopkeeper (API)
     */
    public function shopkeepers($id = null) {
        // admin check
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'Admin') {
            // for simplicity redirect or return JSON forbidden
            if ($this->input->is_ajax_request()) {
                return $this->output->set_status_header(403)->set_content_type('application/json')->set_output(json_encode(['status'=>false,'message'=>'forbidden']));
            }
            redirect('login');
        }

        $method = $this->input->server('REQUEST_METHOD');
        
        if ($method === 'GET') {
            if ($id === null) {
                // List all shopkeepers
                $data['shopkeepers'] = $this->AdminModel->getAllShopkeepers();
                // $this->load->view('layouts/header');
                $this->load->view('admin/shopkeepers/index', $data);
                // $this->load->view('layouts/footer');
            } else {
                // Get single shopkeeper
                $row = $this->AdminModel->getShopkeeperById((int)$id);
                if ($row) {
                    return $this->output->set_content_type('application/json')->set_output(json_encode(['status'=>true,'data'=>$row]));
                }
                return $this->output->set_status_header(404)->set_content_type('application/json')->set_output(json_encode(['status'=>false,'message'=>'Shopkeeper not found']));
            }
        }

        // POST, PUT, DELETE methods will be handled by dedicated functions for simplicity and clarity in routing.
    }

    /**
     * Add a new shopkeeper (form submission)
     */
    public function addShopkeeper() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'Admin') {
            redirect('login');
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $mobile = $this->input->post('mobile');
            $gender = $this->input->post('gender');
            $dob = $this->input->post('dob');            
            $shop_name = $this->input->post('shop_name');
            $reg_id = $this->input->post('reg_id');
            $location = $this->input->post('location');
            
            if (empty($name) || empty($email) || empty($password) || empty($shop_name) || empty($location) || empty($mobile) || empty($gender) || empty($dob) || empty($reg_id) || empty($location)) {
                $this->session->set_flashdata('error','Please fill all required fields');
                redirect('admin/shopkeepers/add');
            }

            $userExists = $this->UserModel->getUserByEmail($email);
            if ($userExists) {
                $this->session->set_flashdata('error','Email already in use.');
                redirect('admin/shopkeepers/add');
            }

            $userData = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'mobile' => $mobile,
                'gender' => $gender,
                'dob' => $dob,
                'role' => 'Shopkeeper',
                'created_at' => date('Y-m-d H:i:s'),
                'is_active' => 1
            ];

            $shopData = [
                'shop_name' => $shop_name,
                'reg_id' => $reg_id,
                'location' => $location,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $ok = $this->AdminModel->createShopkeeper($userData, $shopData);
            if ($ok) {
                $this->session->set_flashdata('success','Shopkeeper created successfully.');
                redirect('admin/shopkeepers');
            } else {
                $this->session->set_flashdata('error','Failed to create shopkeeper.');
                redirect('admin/shopkeepers/add');
            }
        } else {
            // GET request, show form
            // $this->load->view('layouts/header');
            $this->load->view('admin/shopkeepers/add');
            // $this->load->view('layouts/footer');
        }
    }

    /**
     * Edit an existing shopkeeper
     */
    public function editShopkeeper($id) {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'Admin') {
            redirect('login');
        }
        
        $shopkeeper = $this->AdminModel->getShopkeeperById((int)$id);
        if (!$shopkeeper) {
            $this->session->set_flashdata('error','Shopkeeper not found.');
            redirect('admin/shopkeepers');
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $userData = [];
            $shopData = [];
            
            if ($this->input->post('name')) {
                $userData['name'] = $this->input->post('name');
            }
            if ($this->input->post('email')) {
                $userData['email'] = $this->input->post('email');
            }
            if ($this->input->post('password')) {
                $userData['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }
            if ($this->input->post('mobile')) {
                $userData['mobile'] = $this->input->post('mobile');
            }
            $userData['updated_at'] = date('Y-m-d H:i:s');

            if ($this->input->post('shop_name')) {
                $shopData['shop_name'] = $this->input->post('shop_name');
            }
            if ($this->input->post('reg_id')) {
                $shopData['reg_id'] = $this->input->post('reg_id');
            }
            if ($this->input->post('location')) {
                $shopData['location'] = $this->input->post('location');
            }
            $shopData['updated_at'] = date('Y-m-d H:i:s');
            
            $ok = $this->AdminModel->updateShopkeeper((int)$id, $userData, $shopData);
            
            if ($ok) {
                $updateLog = [
                    'user_id' => $this->session->userdata('u_id'),
                    'action_type' => 'edited a shopkeeper with ID ' . $id,
                    'target_table' => 'users, shops',
                    'target_id' => $id,
                    'description' => 'Admin with user_id edited a shopkeeper at target_id',
                ];
                $this->ActivityModel->logActivity($updateLog);
                $this->session->set_flashdata('success','Shopkeeper updated successfully.');
            } else {
                $this->session->set_flashdata('error','Failed to update shopkeeper.');
            }
            redirect('admin/shopkeepers');
        } else {
            // GET request, show form with data
            $data['shopkeeper'] = $shopkeeper;
            // $this->load->view('layouts/header');
            $this->load->view('admin/shopkeepers/edit', $data);
            // $this->load->view('layouts/footer');
        }
    }

    /**
     * Delete a shopkeeper
     */
    public function deleteShopkeeper($id) {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'Admin') {
            return $this->output->set_status_header(403)->set_content_type('application/json')->set_output(json_encode(['status'=>false,'message'=>'forbidden']));
        }
        
        $method = $this->input->server('REQUEST_METHOD');
        if ($method === 'POST') {
            $ok = $this->AdminModel->deleteShopkeeper((int) $id);
            if ($ok) {
                $deleteLog = [
                    'user_id' => $this->session->userdata('u_id'),
                    'action_type' => 'deleted shopkeeper with ID ' . $id,
                    'target_table' => 'users, shops',
                    'target_id' => $id,
                    'description' => 'deleted the record from all tables',
                ];
                $this->ActivityModel->logActivity($deleteLog);
                $this->session->set_flashdata('success', 'Shopkeeper deleted successfully.');
                $this->load->view('admin/shopkeepers');
                return $this->output->set_content_type('application/json')->set_output(json_encode(['status'=>true]));
                
            } else {
                return $this->output->set_status_header(500)->set_content_type('application/json')->set_output(json_encode(['status'=>false, 'message' => 'Failed to delete shopkeeper.']));
            }
        }
        redirect('admin/shopkeepers');
    }
}
