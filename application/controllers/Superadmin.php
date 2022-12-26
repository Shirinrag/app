<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends CI_Controller {

    public function alpha_dash_space($fullname){
        if (! preg_match('/^[a-zA-Z\s]+$/', $fullname)) {
            $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha characters & White spaces');
            return FALSE;
        } else {
            return TRUE;
        }
    }
	public function index()
	{
		$this->load->view('super_admin/login');
	}
	public function dashboard()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $curl = $this->link->hits('dashboard-data', array(), '', 0);
            $curl = json_decode($curl, true);         
			$this->load->view('super_admin/dashboard');
		} else {
            redirect(base_url().'superadmin');
        }
	}
	public function profile()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
			$this->load->view('super_admin/profile');
		} else {
            redirect(base_url().'superadmin');
        }
	}
    // ============================ Roles ================================
	public function add_roles()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
			$this->load->view('super_admin/add_role');
		} else {
            redirect(base_url().'superadmin');
        }
	}
    // ====================== User List=================================
	public function user()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
			$this->load->view('super_admin/add_user');
		} else {
            redirect(base_url().'superadmin');
        }
	}
	public function display_all_user_data()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in'))
		{
			$curl = $this->link->hits('display-all-user-data', array(), '', 0);
        	$curl = json_decode($curl, true);
        	$response['data'] = $curl['user_data'];
		} else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
	}
    public function change_user_status(){
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $id = $this->input->post('id'); 
            $status = $this->input->post('status'); 
            if (empty($id )) {
                $response['message'] = 'User id is required.';
                $response['status'] = 0;
            }else if($status=='') {
                $response['message'] = 'status is required.';
                $response['status'] = 0;
            }else{
                $curl_data = array(   
                  'id'=>$id,
                  'status'=>$status,
                );
                $curl = $this->link->hits('update-user-status',$curl_data);
                $curl = json_decode($curl, TRUE);
                if($curl['message']=='success'){
                    $response['message']='Status Changed successfully';
                    $response['status'] = 1;
                }else{
                    $response['message'] = $curl['message'];
                    $response['status'] = 0;
                }
            }
        } else {
            $response['status'] = 'failure';
            $response['url'] = base_url() . "login";
        }
        echo json_encode($response);
    }
    // ========================== Add Admin ===============================
	public function add_admin()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $curl = $this->link->hits('get-all-user-type', array(), '', 0);
        	$curl = json_decode($curl, true);
        	$data['user_type_data'] = $curl['user_type_data'];
			$this->load->view('super_admin/add_admin',$data);
		} else {
            redirect(base_url().'superadmin');
        }
	}
	public function save_admin_data()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $id = $session_data['id'];
            $username = $this->input->post('username');
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $email = $this->input->post('email');
            $contact_no = $this->input->post('contact_no');
            $password = $this->input->post('password');
            $user_type = $this->input->post('user_type');

            $this->form_validation->set_rules('username','username', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('first_name','First Name', 'trim|required|alpha',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('last_name','Last Name', 'trim|required|alpha',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('email','Last Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('contact_no','Contact No', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('password','Password', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('user_type','Admin Role', 'trim|required',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'username' => strip_tags(form_error('username')),
                    'first_name' => strip_tags(form_error('first_name')),
                    'last_name' => strip_tags(form_error('last_name')),
                    'email' => strip_tags(form_error('email')),
                    'contact_no' => strip_tags(form_error('contact_no')),
                    'password' => strip_tags(form_error('password')),
                    'user_type' => strip_tags(form_error('user_type')),
                );
            } else {
                $curl_data = array(
                    'username'=>$username,
                    'first_name'=>$first_name,
                    'last_name'=>$last_name,
                    'email'=>$email,
                    'mobile_no'=>$contact_no,
                    'password'=>$password,
                    'user_type'=>$user_type,
                );
                $curl = $this->link->hits('add-admin', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    if ($curl['error_status'] == 'email') {
                            $error = 'email';
                        } else if ($curl['error_status'] == 'contact_no') {
                            $error = 'contact_no';
                        }else{
                            $error = 'username';
                        }
                    $response['status'] = 'failure';
                     $response['error'] = array($error => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
            // $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
	}
    public function display_all_admin_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-admin-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['admin_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_admin_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $id = $this->input->post('edit_id');
            $username = $this->input->post('edit_username');
            $first_name = $this->input->post('edit_first_name');
            $last_name = $this->input->post('edit_last_name');
            $email = $this->input->post('edit_email');
            $contact_no = $this->input->post('edit_contact_no');
            // $password = $this->input->post('password');
            $user_type = $this->input->post('edit_user_type');

            $this->form_validation->set_rules('edit_username','Username', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_first_name','First Name', 'trim|required|alpha',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_last_name','Last Name', 'trim|required|alpha',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_email','Last Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_contact_no','Contact No', 'trim|required',array('required' => 'You must provide a %s',));
            // $this->form_validation->set_rules('password','Password', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_user_type','Admin Role', 'trim|required',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'edit_username' => strip_tags(form_error('edit_username')),
                    'edit_first_name' => strip_tags(form_error('edit_first_name')),
                    'edit_last_name' => strip_tags(form_error('edit_last_name')),
                    'edit_email' => strip_tags(form_error('edit_email')),
                    'edit_contact_no' => strip_tags(form_error('edit_contact_no')),
                    // 'password' => strip_tags(form_error('password')),
                    'edit_user_type' => strip_tags(form_error('edit_user_type')),
                );
            } else {
                $curl_data = array(
                    'username'=>$username,
                    'first_name'=>$first_name,
                    'last_name'=>$last_name,
                    'email'=>$email,
                    'mobile_no'=>$contact_no,
                    // 'password'=>$password,
                    'user_type'=>$user_type,
                    'id' =>$id
                );
                $curl = $this->link->hits('update-admin', $curl_data);
                $curl = json_decode($curl, true);
                
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    if ($curl['error_status'] == 'email') {
                            $error = 'edit_email';
                        } else {
                            $error = 'edit_contact_no';
                        }
                    $response['status'] = 'failure';
                     $response['error'] = array($error => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'admin';
        }
        echo json_encode($response);
    }
    public function delete_admin(){   
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $id = $this->input->post('delete_admin_id'); 
            if (empty($id )) {
                $response['message'] = 'Admin id is required.';
                $response['status'] = 0;
            } else {
                $curl_data = array(   
                  'id'=>$id,
                );            
                $curl = $this->link->hits('delete-admin',$curl_data);
                $curl = json_decode($curl, TRUE);
            
                if($curl['message']=='success'){
                    $response['message']='Data Deleted successfully';
                    $response['status'] = 1;
                } else {
                    $response['message'] = $curl['message'];
                    $response['status'] = 0;
                }
            }
        } else {
            $response['status'] = 'failure';
            $response['url'] = base_url() . "superadmin";
        }
        echo json_encode($response);
    }
    // ============================ Booking History======================
	public function booking_history()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
			$this->load->view('super_admin/booking_history');
		} else {
            redirect(base_url().'superadmin');
        }
	}
    // ========================= Place Status ============================
    public function add_place_status()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $this->load->view('super_admin/place_status');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function save_place_status_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            
            $place_status = $this->input->post('place_status');        
            $this->form_validation->set_rules('place_status','Price Status', 'trim|required|callback_alpha_dash_space',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'place_status' => strip_tags(form_error('place_status')),
                );
            } else {
                $curl_data = array(
                    'place_status'=>$place_status,
                );
                $curl = $this->link->hits('add-place-status', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                     $response['error'] = array("place_status" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function display_all_place_status_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-place-status-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['place_status'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_place_status()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $id = $this->input->post('id'); 
            $status = $this->input->post('status'); 
            if (empty($id)) {
                $response['message'] = 'Place Status id is required.';
                $response['status'] = 0;
            }else if($status=='') {
                $response['message'] = 'status is required.';
                $response['status'] = 0;
            }else{
                $curl_data = array(   
                  'id'=>$id,
                  'status'=>$status,
                );                
                $curl = $this->link->hits('update-place-status',$curl_data);
                $curl = json_decode($curl, TRUE);
                if($curl['message']=='success'){
                    $response['message']='Status Changed successfully';
                    $response['status'] = 1;
                }else{
                    $response['message'] = $curl['message'];
                    $response['status'] = 0;
                }
            }
        } else {
            $response['status'] = 'failure';
            $response['url'] = base_url() . "login";
        }
        echo json_encode($response);
    }
    public function update_place_status_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            
            $edit_id = $this->input->post('edit_id');        
            $edit_place_status = $this->input->post('edit_place_status');        
            $this->form_validation->set_rules('edit_place_status','Price Status', 'trim|required|alpha',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'edit_place_status' => strip_tags(form_error('edit_place_status')),
                );
            } else {
                $curl_data = array(
                    'place_status'=>$edit_place_status,
                    'id' =>$edit_id
                );
                $curl = $this->link->hits('update-place-status-data', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array("edit_place_status" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    // ============================Price Type============================
    public function add_price_type()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $this->load->view('super_admin/price_type');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function save_price_type_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            
            $price_type = $this->input->post('price_type');        
            $this->form_validation->set_rules('price_type','Price Type', 'trim|required|callback_alpha_dash_space',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'price_type' => strip_tags(form_error('price_type')),
                );
            } else {
                $curl_data = array(
                    'price_type'=>$price_type,
                );
                $curl = $this->link->hits('add-price-type', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                     $response['error'] = array("price_type" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function display_all_price_type_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-price-type-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['price_type'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_price_type_status()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $id = $this->input->post('id'); 
            $status = $this->input->post('status'); 
            if (empty($id)) {
                $response['message'] = 'Place Status id is required.';
                $response['status'] = 0;
            }else if($status=='') {
                $response['message'] = 'status is required.';
                $response['status'] = 0;
            }else{
                $curl_data = array(   
                  'id'=>$id,
                  'status'=>$status,
                );                
                $curl = $this->link->hits('update-price-type',$curl_data);
                $curl = json_decode($curl, TRUE);
                if($curl['message']=='success'){
                    $response['message']='Status Changed successfully';
                    $response['status'] = 1;
                }else{
                    $response['message'] = $curl['message'];
                    $response['status'] = 0;
                }
            }
        } else {
            $response['status'] = 'failure';
            $response['url'] = base_url() . "login";
        }
        echo json_encode($response);
    }
    public function update_price_type_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            
            $edit_id = $this->input->post('edit_id');        
            $edit_price_type = $this->input->post('edit_price_type');        
            $this->form_validation->set_rules('edit_price_type','Price Status', 'trim|required|alpha',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'edit_price_type' => strip_tags(form_error('edit_price_type')),
                );
            } else {
                $curl_data = array(
                    'price_type'=>$edit_price_type,
                    'id' =>$edit_id
                );
                $curl = $this->link->hits('update-price-type-data', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array("edit_price_type" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    // ======================== Bonus Price===========================
    public function add_bonus_price()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $this->load->view('super_admin/add_bonus');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function save_bonus_price_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            
            $bonus_amount = $this->input->post('bonus_amount');        
            $this->form_validation->set_rules('bonus_amount','Bonus Price', 'trim|required|numeric',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'bonus_amount' => strip_tags(form_error('bonus_amount')),
                );
            } else {
                $curl_data = array(
                    'bonus_amount'=>$bonus_amount,
                );
                $curl = $this->link->hits('add-bonus-amount', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                     $response['error'] = array("bonus_amount" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function display_all_bonus_price_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-bonus-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['bonus_price'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_bonus_price_status()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $id = $this->input->post('id'); 
            $status = $this->input->post('status'); 
            if (empty($id)) {
                $response['message'] = 'Place Status id is required.';
                $response['status'] = 0;
            }else if($status=='') {
                $response['message'] = 'status is required.';
                $response['status'] = 0;
            }else{
                $curl_data = array(   
                  'id'=>$id,
                  'status'=>$status,
                );                
                $curl = $this->link->hits('update-bonus-status',$curl_data);
                $curl = json_decode($curl, TRUE);
                if($curl['message']=='success'){
                    $response['message']='Status Changed successfully';
                    $response['status'] = 1;
                }else{
                    $response['message'] = $curl['message'];
                    $response['status'] = 0;
                }
            }
        } else {
            $response['status'] = 'failure';
            $response['url'] = base_url() . "login";
        }
        echo json_encode($response);
    }
    // ====================Parking Place ===============================
    public function parking_place()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $curl = $this->link->hits('get-all-parking-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $data['countries_data'] = $curl['countries_data'];
            $data['place_status'] = $curl['place_status'];
            $data['price_type'] = $curl['price_type'];
            $data['vendor'] = $curl['vendor'];
            $this->load->view('super_admin/parking_place',$data);
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function get_state_data_on_country_id() {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $country_id = $this->input->post('country_id');
            if (!empty($country_id)) {
                $curl_data = array('country_id' => $country_id);
                $curl = $this->link->hits('get-state-data-on-country-id', $curl_data);
                $curl = json_decode($curl, TRUE);
                if (!empty($curl['state_data'])) {
                    $response['status'] = 'success';
                    $response['state_data'] = $curl['state_data'];
                } else {
                    $response['status'] = 'failure';
                }
            } else {
                $response['status'] = 'failure';
            }
        } else {
            $url = base_url();
            $response['status'] = 'login_failure';
            $response['message'] = $url;
        }
        echo json_encode($response);
    }

    public function get_city_data_on_state_id()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $state_id = $this->input->post('state_id');
            if (!empty($state_id)) {
                $curl_data = array('state_id' => $state_id);
                $curl = $this->link->hits('get-city-data-on-state-id', $curl_data);
                $curl = json_decode($curl, TRUE);
                if (!empty($curl['city_data'])) {
                    $response['status'] = 'success';
                    $response['city_data'] = $curl['city_data'];
                } else {
                    $response['status'] = 'failure';
                }
            } else {
                $response['status'] = 'failure';
            }
        } else {
            $url = base_url();
            $response['status'] = 'login_failure';
            $response['message'] = $url;
        }
        echo json_encode($response);
    }
    public function save_parking_place()
    {
         if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');            
            $fk_vendor_id = $this->input->post('fk_vendor_id');        
            $fk_country_id = $this->input->post('fk_country_id');        
            $fk_state_id = $this->input->post('fk_state_id');        
            $fk_city_id = $this->input->post('fk_city_id');        
            $place_name = $this->input->post('place_name');        
            $address = $this->input->post('address');        
            $pincode = $this->input->post('pincode');        
            $latitude = $this->input->post('latitude');        
            $longitude = $this->input->post('longitude');        
            $slots = $this->input->post('slots');        
            $fk_place_status_id = $this->input->post('fk_place_status_id');        
            $fk_parking_price_type = $this->input->post('fk_parking_price_type');            
            $from_hours = $this->input->post('from_hours');              
            $to_hours = $this->input->post('to_hours');              
            $price = $this->input->post('price');              
            $ext_price = $this->input->post('ext_price');

            $this->form_validation->set_rules('fk_vendor_id','Vendor', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('fk_country_id','Country', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('fk_state_id','State', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('fk_city_id','City', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('place_name','Place Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('address','Address', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('pincode','Pincode', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('latitude','Latitude', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('longitude','Longitude', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('slots','Slots', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('fk_place_status_id','Place Status', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('fk_parking_price_type','Price Type', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('ext_price','Extension Price', 'trim|required',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'fk_vendor_id' => strip_tags(form_error('fk_vendor_id')),
                    'fk_country_id' => strip_tags(form_error('fk_country_id')),
                    'fk_state_id' => strip_tags(form_error('fk_state_id')),
                    'fk_city_id' => strip_tags(form_error('fk_city_id')),
                    'place_name' => strip_tags(form_error('place_name')),
                    'address' => strip_tags(form_error('address')),
                    'pincode' => strip_tags(form_error('pincode')),
                    'latitude' => strip_tags(form_error('latitude')),
                    'longitude' => strip_tags(form_error('longitude')),
                    'slots' => strip_tags(form_error('slots')),
                    'fk_place_status_id' => strip_tags(form_error('fk_place_status_id')),
                    'fk_parking_price_type' => strip_tags(form_error('fk_parking_price_type')),
                    'ext_price' => strip_tags(form_error('ext_price')),
                );
            } else {
                $curl_data = array(
                    'fk_vendor_id'=>$fk_vendor_id,
                    'fk_country_id'=>$fk_country_id,
                    'fk_state_id'=>$fk_state_id,
                    'fk_city_id'=>$fk_city_id,
                    'place_name'=>$place_name,
                    'address'=>$address,
                    'pincode'=>$pincode,
                    'latitude'=>$latitude,
                    'longitude'=>$longitude,
                    'slots'=>$slots,
                    'fk_place_status_id'=>$fk_place_status_id,
                    'fk_parking_price_type'=>$fk_parking_price_type,
                    'ext_price'=>$ext_price,
                    'from_hours'=>json_encode($from_hours),
                    'to_hours'=>json_encode($to_hours),
                    'price'=>json_encode($price),
                );
                $curl = $this->link->hits('add-place', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                     $response['error'] = array("bonus_amount" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function display_all_parking_place()
    {
        $parking_place_data = $this->link->hits('display-all-parking-place-data', array());
        $parking_place_data = json_decode($parking_place_data, true);
        $place_status = $parking_place_data['place_status'];
        $data = array();
        $no = @$_POST['start'];
        foreach ($parking_place_data['parking_place_data'] as $parking_place_data_key => $parking_place_data_row) {
            $status1 ='';  $option='';
            foreach ($place_status as $place_status_key => $place_status_row) {
                if ($parking_place_data_row['fk_place_status_id'] == $place_status_row['id']) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $option .= '<option value="'.$place_status_row['id'].'" '.$selected.'>'.$place_status_row['place_status'].'</option>';
            }            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $parking_place_data_row['place_name'];
            $row[] = $parking_place_data_row['country_name'];
            $row[] = $parking_place_data_row['firstName']." ".$parking_place_data_row['lastName'];      
            $row[] = $parking_place_data_row['slots'];

            $row[] = '<select class="chosen-select-deselect update_order_status chosen_init " id="'.$parking_place_data_row['id'].'" name="status">'.$option.'
                        </select>';
            $edit_html = '';
            $edit_html = '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="ti-pencil edit_place_data" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#edit_place_modal" id="'.$parking_place_data_row['id'].'"></i></a><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Delete Details" class="remove-row"><i class="ti-trash a_delete_user" href="#a_delete_user_modal" class="trigger-btn" data-bs-toggle="modal" data-bs-target="#delete_admin" aria-hidden="true"></i></a></span>';
            $row[] = $edit_html;
            $data[] = $row;
        }
        $output = array("draw" => @$_POST['draw'], "recordsTotal" => $parking_place_data['count'], "recordsFiltered" => $parking_place_data['count_filtered'], "data" => $data);
        echo json_encode($output);
    }
    public function get_parking_place_details_on_id() {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
                $id = $this->input->post('id');
                $curl_data = array('id' => $id);
                $curl = $this->link->hits('get-parking-place-details-on-id', $curl_data);
                $curl = json_decode($curl, TRUE);
                $data['parking_place_data'] = $curl['parking_place_data'];
                $data['hour_price_slab'] = $curl['hour_price_slab'];
                $data['slot_info'] = $curl['slot_info'];
                $data['state_details'] = $curl['state_details'];
                $data['city_details'] = $curl['city_details'];
                $data['device_data'] = $curl['device_data'];
                $response = $data;
        }else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_place_details()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');            
            $id = $this->input->post('edit_id');        
            $fk_vendor_id = $this->input->post('edit_fk_vendor_id');        
            $fk_country_id = $this->input->post('edit_fk_country_id');       
            $fk_state_id = $this->input->post('edit_fk_state_id');        
            $fk_city_id = $this->input->post('edit_fk_city_id');        
            $place_name = $this->input->post('edit_place_name');        
            $address = $this->input->post('edit_address');        
            $pincode = $this->input->post('edit_pincode');        
            $latitude = $this->input->post('edit_latitude');        
            $longitude = $this->input->post('edit_longitude');        
            $slots = $this->input->post('edit_slots');        
            $fk_place_status_id = $this->input->post('edit_fk_place_status_id');        
            $fk_parking_price_type = $this->input->post('edit_fk_parking_price_type');             
            $hour_price_slab_id = $this->input->post('hour_price_slab_id');
            $from_hours = $this->input->post('edit_from_hours');              
            $to_hours = $this->input->post('edit_to_hours');              
            $price = $this->input->post('edit_price');              
            $ext_price = $this->input->post('edit_ext_price');

            $this->form_validation->set_rules('edit_fk_vendor_id','Vendor', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_fk_country_id','Country', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_fk_state_id','State', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_fk_city_id','City', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_place_name','Place Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_address','Address', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_pincode','Pincode', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_latitude','Latitude', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_longitude','Longitude', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_slots','Slots', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_fk_place_status_id','Place Status', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_fk_parking_price_type','Price Type', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_ext_price','Extension Price', 'trim|required',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'edit_fk_vendor_id' => strip_tags(form_error('edit_fk_vendor_id')),
                    'edit_fk_country_id' => strip_tags(form_error('edit_fk_country_id')),
                    'edit_fk_state_id' => strip_tags(form_error('edit_fk_state_id')),
                    'edit_fk_city_id' => strip_tags(form_error('edit_fk_city_id')),
                    'edit_place_name' => strip_tags(form_error('edit_place_name')),
                    'edit_address' => strip_tags(form_error('edit_address')),
                    'edit_pincode' => strip_tags(form_error('edit_pincode')),
                    'edit_latitude' => strip_tags(form_error('edit_latitude')),
                    'edit_longitude' => strip_tags(form_error('edit_longitude')),
                    'edit_slots' => strip_tags(form_error('edit_slots')),
                    'edit_fk_place_status_id' => strip_tags(form_error('edit_fk_place_status_id')),
                    'edit_fk_parking_price_type' => strip_tags(form_error('edit_fk_parking_price_type')),
                    'edit_ext_price' => strip_tags(form_error('edit_ext_price')),
                );
            } else {
                $curl_data = array(
                    'fk_vendor_id'=>$fk_vendor_id,
                    'fk_country_id'=>$fk_country_id,
                    'fk_state_id'=>$fk_state_id,
                    'fk_city_id'=>$fk_city_id,
                    'place_name'=>$place_name,
                    'address'=>$address,
                    'pincode'=>$pincode,
                    'latitude'=>$latitude,
                    'longitude'=>$longitude,
                    'slots'=>$slots,
                    'fk_place_status_id'=>$fk_place_status_id,
                    'fk_parking_price_type'=>$fk_parking_price_type,
                    'ext_price'=>$ext_price,
                    'hour_price_slab_id'=>json_encode($hour_price_slab_id),
                    'from_hours'=>json_encode($from_hours),
                    'to_hours'=>json_encode($to_hours),
                    'price'=>json_encode($price),
                    'id'=>$id
                );
                $curl = $this->link->hits('update-place', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                     $response['error'] = array("bonus_amount" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function add_device()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $this->load->view('super_admin/add_device');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function save_device_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');            
            $device_id = $this->input->post('device_id');         
            $curl_data = array(
                'device_id'=>json_encode($device_id),
            );
            $curl = $this->link->hits('add-device', $curl_data);
            $curl = json_decode($curl, true);
            if ($curl['status']==1) {
                $response['status']='success';
            } else {
                $response['status'] = 'failure';
                $response['error'] = array("device_id" => $curl['message']);
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function display_all_device_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-device-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['device_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function change_device_status()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $id = $this->input->post('id'); 
            $status = $this->input->post('status'); 
            if (empty($id)) {
                $response['message'] = 'id is required.';
                $response['status'] = 0;
            }else if($status=='') {
                $response['message'] = 'status is required.';
                $response['status'] = 0;
            }else{
                $curl_data = array(   
                  'id'=>$id,
                  'status'=>$status,
                );
                $curl = $this->link->hits('update-device-status',$curl_data);
                $curl = json_decode($curl, TRUE);
                if($curl['message']=='success'){
                    $response['message']='Status Changed successfully';
                    $response['status'] = 1;
                }else{
                    $response['message'] = $curl['message'];
                    $response['status'] = 0;
                }
            }
        } else {
            $response['status'] = 'failure';
            $response['url'] = base_url() . "login";
        }
        echo json_encode($response);
    }
    // ============== Ground Team Parking List==============================
    public function parking_list()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $this->load->view('super_admin/parking_list');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function display_all_parking_place_data()
    {
        $parking_place_data = $this->link->hits('display-all-parking-place-data', array());
        $parking_place_data = json_decode($parking_place_data, true);
        $place_status = $parking_place_data['place_status'];
        $data = array();
        $no = @$_POST['start'];
        foreach ($parking_place_data['parking_place_data'] as $parking_place_data_key => $parking_place_data_row) {
            $status1 ='';  $option='';
            foreach ($place_status as $place_status_key => $place_status_row) {
                if ($parking_place_data_row['fk_place_status_id'] == $place_status_row['id']) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $option .= '<option value="'.$place_status_row['id'].'" '.$selected.'>'.$place_status_row['place_status'].'</option>';
            }            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $parking_place_data_row['place_name'];
            $row[] = $parking_place_data_row['address'];
            $row[] = $parking_place_data_row['firstName']." ".$parking_place_data_row['lastName'];      
            $row[] = $parking_place_data_row['slots'];

            // $row[] = '<select class="chosen-select-deselect update_order_status chosen_init " id="'.$parking_place_data_row['id'].'" name="status">'.$option.'
            //             </select>';
            $edit_html = '';
            $edit_html = '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="ti-pencil edit_place_data" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#edit_place_modal" id="'.$parking_place_data_row['id'].'"></i></a></span>';
            $row[] = $edit_html;
            $data[] = $row;
        }
        $output = array("draw" => @$_POST['draw'], "recordsTotal" => $parking_place_data['count'], "recordsFiltered" => $parking_place_data['count_filtered'], "data" => $data);
        echo json_encode($output);
    }

    public function save_device_mapped()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            
            $edit_id = $this->input->post('edit_id');        
            $fk_machine_id = $this->input->post('fk_machine_id');        
            $edit_slot_id = $this->input->post('edit_slot_id');       
            $curl_data = array(
                'edit_id'=>$edit_id,
                'fk_machine_id'=>json_encode($fk_machine_id),
                'slot_id'=>json_encode($edit_slot_id),
            );
            $curl = $this->link->hits('save-mapped-device', $curl_data);
            $curl = json_decode($curl, true);
            if ($curl['status']==1) {
                $response['status']='success';
            } else {
                 $response['status'] = 'failure';
                 $response['error'] = array("fk_machine_id" => $curl['message']);
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_machine_device_status()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $id = $this->input->post('id'); 
            $status = $this->input->post('status'); 
            if (empty($id)) {
                $response['message'] = 'User id is required.';
                $response['status'] = 0;
            }else if($status=='') {
                $response['message'] = 'status is required.';
                $response['status'] = 0;
            }else{
                $curl_data = array(   
                  'id'=>$id,
                  'status'=>$status,
                );
                $curl = $this->link->hits('update-machine-device-status',$curl_data);
                $curl = json_decode($curl, TRUE);
                if($curl['message']=='success'){
                    $response['message']='Status Changed successfully';
                    $response['status'] = 1;
                }else{
                    $response['message'] = $curl['message'];
                    $response['status'] = 0;
                }
            }
        } else {
            $response['status'] = 'failure';
            $response['url'] = base_url() . "login";
        }
        echo json_encode($response);
    }
    // ======================== Duty Allocation ================================
    public function duty_allocation()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
                $curl = $this->link->hits('get-allocation-data', array(), '', 0);
                // echo '<pre>'; print_r($curl); exit;
                $curl = json_decode($curl, true);
                $response['place_list'] = $curl['place_list'];
                $response['verifier_list'] = $curl['verifier_list'];
               
            $this->load->view('super_admin/duty_allocation',$response);
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function get_allocation_data()
    {
         if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
                $curl = $this->link->hits('get-allocation-data', array(), '', 0);
                $curl = json_decode($curl, true);
                $response['place_list'] = $curl['place_list'];
                $response['verifier_list'] = $curl['verifier_list'];
               
        }else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);      
    }
    public function save_duty_allocation()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            
            $fk_place_id = $this->input->post('fk_place_id');        
            $fk_verifier_id = $this->input->post('fk_verifier_id');        
            $date = $this->input->post('date');       
            $curl_data = array(
                'fk_place_id'=>json_encode($fk_place_id),
                'fk_verifier_id'=>json_encode($fk_verifier_id),
                'date'=>json_encode($date),
            );
            $curl = $this->link->hits('save-duty-allocation', $curl_data);
            $curl = json_decode($curl, true);
            if ($curl['status']==1) {
                $response['status']='success';
            } else {
                 $response['status'] = 'failure';
                 $response['error'] = array("fk_verifier_id" => $curl['message']);
            }
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }

    public function display_all_duty_allocation_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-duty-allocation-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['duty_allocation'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
  
     public function get_duty_allocation_details_on_id() {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
                $id = $this->input->post('id');
                $curl_data = array('id' => $id);
                $curl = $this->link->hits('get-duty-allocation-details-on-id', $curl_data);
                $curl = json_decode($curl, TRUE);
                $data['duty_allocation'] = $curl['duty_allocation'];
                
                $response = $data;
        }else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function delete_duty_allocation()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $id = $this->input->post('delete_duty_allocation_id'); 
            if (empty($id )) {
                $response['message'] = 'Duty Allocation id is required.';
                $response['status'] = 0;
            } else {
                $curl_data = array(   
                  'id'=>$id,
                );            
                $curl = $this->link->hits('delete-duty-allocation',$curl_data);
                // echo '<pre>'; print_r($curl); exit;
                $curl = json_decode($curl, TRUE);
            
                if($curl['message']=='success'){
                    $response['message']='Data Deleted successfully';
                    $response['status'] = 1;
                } else {
                    $response['message'] = $curl['message'];
                    $response['status'] = 0;
                }
            }
        } else {
            $response['status'] = 'failure';
            $response['url'] = base_url() . "superadmin";
        }
        echo json_encode($response);
    }
}