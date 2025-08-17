<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url','form']);
        $this->load->model('UserModel');
        $this->load->model('ShopModel');
        $this->load->model('ActivityModel');
    }

    public function index() { redirect('login'); }

    /**
     * login()
     * - GET => show login view
     * - POST form => authenticate, create session, redirect
     * - POST JSON => authenticate, create session, return JSON + session_id
     */
    public function login() {
        $contentType = $this->input->server('CONTENT_TYPE') ?? '';

        // JSON API
        if (stripos($contentType, 'application/json') !== false) {
            $raw = trim(file_get_contents('php://input')); //body se raw string data
            $data = json_decode($raw, true) ?: [];//data is now assoc array 

            if (empty($data['email']) || empty($data['password'])) {
                return $this->output
                    ->set_status_header(400)
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['status'=>false,'message'=>'Missing credentials']));
            }
            
            // data array is not empty
            $user = $this->UserModel->getUserByEmail($data['email']); //user is now an assoc array
            if ($user && password_verify($data['password'], $user['password'])) {
                $this->_create_session_for_user($user);

                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'status'=>true,
                        'message'=>'Login successful',
                        'user'=>[
                            'u_id'=>$user['u_id'],
                            'name'=>$user['name'],
                            'email'=>$user['email'],
                            'role'=>$user['role'],
                            'shop_id'=>$this->session->userdata('shop_id') ?? null
                        ],
                        'session_id'=>session_id()
                    ]));
            }

            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status'=>false,'message'=>'Invalid credentials']));
        }

        // FORM POST
        if ($this->input->method() === 'post') {
            $email = $this->input->post('email', true);
            $password = $this->input->post('password', true);

            if (empty($email) || empty($password)) {
                $this->session->set_flashdata('error','Missing credentials');
                redirect('login');
            }

            $user = $this->UserModel->getUserByEmail($email);
            if ($user && password_verify($password, $user['password'])) {

                //session banbne ke baad redirect
                $this->_create_session_for_user($user);

                // creating an array for logging
                $loginArray = [
                    'user_id' => $user['u_id'],
                    'action_type' => 'LOGIN',
                    'target_table' => 'null',
                    'target_id' => 'null',
                    'description' => $user['name'] . ' with ID ' . $user['u_id'] . ' logged in',
                ];
                $this->ActivityModel->logActivity($loginArray);
                if ($user['role'] === 'Admin') redirect('admin/dashboard');
                if ($user['role'] === 'Shopkeeper') redirect('shopkeeper/dashboard');
                redirect('worker/dashboard');
            }

            $this->session->set_flashdata('error','Invalid email or password');
            redirect('login');
        }

        // GET => show login view
        $this->load->view('auth/login');
    }

    public function logout($id) {
        // $user = $this->UserModel->getUserById((int)$id);
        $logoutArray = [
            'user_id' => (int)$this->session->userdata('u_id'),
            'action_type' => 'LOGOUT',
            'target_table' => 'null',
            'target_id' => (int)$id,
            'description' => $this->session->userdata('name') . ' logged out successfully'
        ];
        $this->ActivityModel->logActivity($logoutArray);
        $this->session->sess_destroy();

        $this->load->view('auth/logout');        
    }

    /**
     * register()
     * - GET => show register view (if you want to expose it)
     * - POST form or JSON => create user (Admin/Shopkeeper/Worker) — basic validation only
     * NOTE: you may still use AdminController for admin-managed registration; this keeps backward compatibility.
     */
    public function register($id = null) {
        if ($id!==null) {
            $data['record'] = $this->load->UserModel->getUserByID($id);

            //loading the view to pass data
            $this->load->view('register', $data);
        } else {

        $contentType = $this->input->server('CONTENT_TYPE') ?? '';

        // JSON API
        if (stripos($contentType, 'application/json') !== false) {
            $raw = trim(file_get_contents('php://input'));//body se raw data lo
            $input = json_decode($raw, true) ?: [];//json->assoc_array
            // basic validation
            if (empty($input['name']) || empty($input['email']) || empty($input['password']) || empty($input['role'])) {
                return $this->output
                    ->set_status_header(400)
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['status'=>false,'message'=>'Missing required fields']));
            }

            // hash password
            $input['password'] = password_hash($input['password'], PASSWORD_DEFAULT);

            // insert user via UserModel
            $inserted = $this->UserModel->insertUserReturnId([
                'name'=>$input['name'],
                'email'=>$input['email'],
                'password'=>$input['password'],
                'role'=>$input['role'],
                'mobile'=>$input['mobile'] ?? null,
                'gender'=>$input['gender'] ?? null,
                'dob'=>$input['dob'] ?? null,
                'created_at'=>date('Y-m-d H:i:s')
            ]);

            if ($inserted) {
                return $this->output
                    ->set_status_header(201)
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['status'=>true,'message'=>'User created','u_id'=>$inserted]));
            } else {
                return $this->output
                    ->set_status_header(500)
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['status'=>false,'message'=>'Failed to create user']));
            }
        }

        // FORM POST
        if ($this->input->method() === 'post') {
            $name = $this->input->post('name', true);
            $email = $this->input->post('email', true);
            $password = $this->input->post('password', true);
            $role = $this->input->post('role', true);

            if (empty($name) || empty($email) || empty($password) || empty($role)) {
                $this->session->set_flashdata('error','Please fill required fields');
                redirect('register');
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert_id = $this->UserModel->insertUserReturnId([
                'name'=>$name,
                'email'=>$email,
                'password'=>$hash,
                'role'=>$role,
                'mobile'=>$this->input->post('mobile',true),
                'gender'=>$this->input->post('gender',true),
                'dob'=>$this->input->post('dob',true),
                'created_at'=>date('Y-m-d H:i:s')
            ]);

            $registerLog = [
                'user_id' => $insert_id,
                'action_type' => 'Register',
                'target_table' => 'users',
                'target_id' => $insert_id,
                'description' => 'New shop registration by Admin'
            ];
            $this->ActivityModel->logActivity($registerLog);

            $this->session->set_flashdata('success','Registration successful. Please login.');
            redirect('login');
        }
    }
        

        // GET => show view
        $this->load->view('auth/register');
    }

    // sets session and shop_id when needed
    private function _create_session_for_user($user) {
        $sess = [
            'u_id' => $user['u_id'],
            'name' => $user['name'],
            'role' => $user['role'],
            'logged_in' => TRUE
        ];

        if ($user['role'] === 'Shopkeeper') {
            $shop = $this->ShopModel->getShopByShopkeeper($user['u_id']);

            $sess['shop_id'] = ($shop && !empty($shop['s_id'])) ? $shop['s_id'] : null;
        }

        $this->session->set_userdata($sess);
    }
}
