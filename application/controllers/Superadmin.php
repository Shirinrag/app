<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/ColorFound.php';

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
    function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    function random_color() {
            return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }
	public function dashboard()
	{  
		if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $curl = $this->link->hits('dashboard-data', array(), '', 0);
            $curl = json_decode($curl, true);  
            $data['total_user_count'] = $curl['total_user_count'];
            $data['total_place_count'] = $curl['total_place_count'];
            $data['total_booking_count'] = $curl['total_booking_count'];
            $data['total_download_count'] = $curl['total_download_count'];
            $monthly_count_of_user = $curl['monthly_count_of_user'];
            foreach ($monthly_count_of_user as $monthly_count_of_user_key => $monthly_count_of_user_row) {
                       $month= $monthly_count_of_user_row['month'];
                       $dateObj   = DateTime::createFromFormat('!m', $month);
                       $monthName[] = $dateObj->format('F');
                       $user_monthly_count[]=$monthly_count_of_user_row['total'];
                       $color = $this->random_color();
                        $colorFound = new ColorFound;
                        $instance = $colorFound->getName("#".$color); 
                        $color_1[] = $instance;               
               }
               $data['month'] =  '"'.implode('","', $monthName).'"';
               $data['user_monthly_count'] =  '"'.implode('","', $user_monthly_count).'"';            
               $data['color'] =  '"'.implode('","', $color_1).'"';            
			   $this->load->view('super_admin/dashboard',$data);
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
            $company_name = $this->input->post('company_name');
            // $vendor_type = $this->input->post('vendor_type');

            $this->form_validation->set_rules('username','username', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('first_name','First Name', 'trim|required|alpha',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('last_name','Last Name', 'trim|required|alpha',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('email','Last Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('contact_no','Contact No', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('password','Password', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('user_type','Admin Role', 'trim|required',array('required' => 'You must provide a %s',));
            if($user_type==5){
                $this->form_validation->set_rules('company_name','Company Name', 'trim|required',array('required' => 'You must provide a %s',));
                // $this->form_validation->set_rules('vendor_type','Vendor Type', 'trim|required',array('required' => 'You must provide a %s',));
            }
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
                    'company_name' => strip_tags(form_error('company_name')),
                    // 'vendor_type' => strip_tags(form_error('vendor_type')),
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
                    'company_name'=>$company_name,
                    // 'vendor_type'=>$vendor_type,
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
            $company_name = $this->input->post('edit_company_name');
            // $vendor_type = $this->input->post('edit_vendor_type');

            $this->form_validation->set_rules('edit_username','Username', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_first_name','First Name', 'trim|required|alpha',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_last_name','Last Name', 'trim|required|alpha',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_email','Last Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_contact_no','Contact No', 'trim|required',array('required' => 'You must provide a %s',));
            // $this->form_validation->set_rules('password','Password', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_user_type','Admin Role', 'trim|required',array('required' => 'You must provide a %s',));
            if($user_type==5){
                $this->form_validation->set_rules('edit_company_name','Company Name', 'trim|required',array('required' => 'You must provide a %s',));
                // $this->form_validation->set_rules('edit_vendor_type','Vendor Type', 'trim|required',array('required' => 'You must provide a %s',));

            }
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
                    'edit_company_name' => strip_tags(form_error('edit_company_name')),
                    // 'edit_vendor_type' => strip_tags(form_error('edit_vendor_type')),
                );
            } else {
                $curl_data = array(
                    // 'username'=>$username,
                    'first_name'=>$first_name,
                    'last_name'=>$last_name,
                    'email'=>$email,
                    'mobile_no'=>$contact_no,
                    // 'password'=>$password,
                    'user_type'=>$user_type,
                    'company_name'=>$company_name,
                    // 'vendor_type'=>$vendor_type,
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
    public function display_all_booking_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('booking-history-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['booking_history_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function display_all_extend_booking_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('extend-booking-history-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['extend_booking_history_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
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
            $data['vehicle_data'] = $curl['vehicle_data'];
            $data['pass_days_data'] = $curl['pass_days_data'];
            $data['currency_data'] = $curl['currency_data'];  
            // echo '<pre>'; print_r($data); exit;      
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
    public function get_vehicle_details()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $vehicle_id = $this->input->post('vehicle_id');
            if (!empty($vehicle_id)) {
                $curl_data = array('id' => $vehicle_id);
                $curl = $this->link->hits('get-vehicle-details', $curl_data);
                $curl = json_decode($curl, TRUE);      
                    // echo '<pre>'; print_r($curl); exit;
                 if (!empty($curl['vehicle_data'])) {
                    $response['status'] = 'success';
                    $response['vehicle_data'] = $curl['vehicle_data'];   
                    $response['pass_days_data'] = $curl['pass_days_data']; 
                    $response['currency_data'] = $curl['currency_data'];   
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
            // $result = validation_two_wheeler('from_hours_1','to_hours_1','price_1',$_POST);exit;
            // echo '<pre>'; print_r($_POST); exit;
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
            $fk_vehicle_type = $this->input->post('fk_vehicle_type');
            $ext_price = $this->input->post('ext_price');
            $per_hour_charges = $this->input->post('per_hour_charges');
            $place_count = $this->input->post('place_count');
            $reserved_place_count = $this->input->post('reserved_place_count');
            $total_place_count = $this->input->post('total_place_count');
            $referral_code = $this->input->post('referral_code');
            $place_type = $this->input->post('place_type');
            

            // echo '<pre>'; print_r($_POST); exit;
            $this->form_validation->set_rules('fk_vendor_id','Vendor', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('fk_country_id','Country', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('fk_state_id','State', 'trim|required',array('required' => 'You must provide a %s',));
            // $this->form_validation->set_rules('fk_city_id','City', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('place_name','Place Name', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('address','Address', 'trim|required',array('required' => 'You must provide a %s',));
            // $this->form_validation->set_rules('pincode','Pincode', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('latitude','Latitude', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('longitude','Longitude', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('slots','Slots', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('fk_place_status_id','Place Status', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('fk_parking_price_type','Price Type', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('referral_code','Referral Code', 'trim|required',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'fk_vendor_id' => strip_tags(form_error('fk_vendor_id')),
                    'fk_country_id' => strip_tags(form_error('fk_country_id')),
                    'fk_state_id' => strip_tags(form_error('fk_state_id')),
                    // 'fk_city_id' => strip_tags(form_error('fk_city_id')),
                    'place_name' => strip_tags(form_error('place_name')),
                    'address' => strip_tags(form_error('address')),
                    // 'pincode' => strip_tags(form_error('pincode')),
                    'latitude' => strip_tags(form_error('latitude')),
                    'longitude' => strip_tags(form_error('longitude')),
                    'slots' => strip_tags(form_error('slots')),
                    'fk_place_status_id' => strip_tags(form_error('fk_place_status_id')),
                    'fk_parking_price_type' => strip_tags(form_error('fk_parking_price_type')),
                    'referral_code' => strip_tags(form_error('referral_code')),
                );
            } else {
                $sample_image = '';
                $is_signature_file = true;
                if (!empty($_FILES['place_image']['name'])) {
                    $filename = $_FILES['place_image']['name'];
                    $test_img = $filename;
                    $test_img = preg_replace('/\s/', '_', $test_img);
                    $test_image = mt_rand(100000, 999999) . '_' .$test_img;
                    $setting['image_path'] = $_FILES['place_image']['tmp_name'];
                    $setting['image_name'] = $test_image;
                    $setting['compress_path'] = './uploads/';
                    $setting['jpg_compress_level'] = 5;
                    $setting['png_compress_level'] = 5;
                    $setting['create_thumb'] = FALSE;
                    $this->load->library('imgcompressor');
                    $results = $this->imgcompressor->do_compress($setting);
                    if (empty($results['data']['compressed']['name'])) {
                        $is_signature_file = false;
                        $response['status'] = 'failure';
                        $response['error'] = array(
                            'place_image' => $results['message'],
                        );
                    } else {
                        $sample_image = 'uploads/'.$test_image;
                    }
                }  
                if(!empty($fk_vehicle_type)){
                    foreach ($fk_vehicle_type as $fk_vehicle_type_key => $fk_vehicle_type_row) {
                    
                         $from_hours[$fk_vehicle_type_row] = $this->input->post('from_hours_'.$fk_vehicle_type_row);              
                         $to_hours[$fk_vehicle_type_row] = $this->input->post('to_hours_'.$fk_vehicle_type_row);              
                         $price[$fk_vehicle_type_row] = $this->input->post('price_'.$fk_vehicle_type_row);    
                         $currency[$fk_vehicle_type_row] = $this->input->post('currency_'.$fk_vehicle_type_row);    
                         $no_of_days[$fk_vehicle_type_row] = $this->input->post('no_of_days_'.$fk_vehicle_type_row);    
                         $cost[$fk_vehicle_type_row] = $this->input->post('cost_'.$fk_vehicle_type_row);    
                         $currencys[$fk_vehicle_type_row] = $this->input->post('currencys_'.$fk_vehicle_type_row);    
                         // echo '<pre>'; print_r($from_hours);
                    }
                }      
                
                 if ($is_signature_file) {
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
                            'from_hours'=>json_encode(@$from_hours),
                            'to_hours'=>json_encode(@$to_hours),
                            'price'=>json_encode(@$price),
                            'currency'=>json_encode(@$currency),
                            'per_hour_charges'=>$per_hour_charges,
                            'fk_vehicle_type' =>json_encode($fk_vehicle_type),
                            'place_count'=>$place_count,
                            'reserved_place_count'=>$reserved_place_count,
                            'total_place_count'=>$total_place_count,
                            'referral_code'=>$referral_code,
                            'place_type'=>$place_type,
                            'no_of_days'=>json_encode(@$no_of_days),
                            'cost'=>json_encode(@$cost),
                            'currencys'=>json_encode(@$currencys),
                            'place_image'=> $sample_image
                        );             
                        // echo '<pre>'; print_r($curl_data); exit;  
                        $curl = $this->link->hits('add-place', $curl_data);
                        $curl = json_decode($curl, true);
                        if ($curl['status']==1) {
                            $response['status']='success';
                        } else {
                            $response['status'] = 'failure';
                             $response['error'] = array("place_name" => $curl['message']);
                        }
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
            $status1 ='';  $option='';$place_type='';
            foreach ($place_status as $place_status_key => $place_status_row) {
                if ($parking_place_data_row['fk_place_status_id'] == $place_status_row['id']) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $option .= '<option value="'.$place_status_row['id'].'" '.$selected.'>'.$place_status_row['place_status'].'</option>';
            }            
            if($parking_place_data_row['parking_place_type']==1){
                $place_type = "Slot Place";
            }else if($parking_place_data_row['parking_place_type']==2){
                $place_type = "POS Place";
            }else if($parking_place_data_row['parking_place_type']==3){
                $place_type = "Both";
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $parking_place_data_row['place_name'];
            $row[] = $place_type;
            $row[] = $parking_place_data_row['country_name'];
            $row[] = $parking_place_data_row['firstName']." ".$parking_place_data_row['lastName'];      
            $row[] = $parking_place_data_row['slots'];

            $row[] = '<select class="chosen-select-deselect update_parking_status chosen_init " id="'.$parking_place_data_row['id'].'" name="status">'.$option.'
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
            $data['parking_place_vehicle_type'] = $curl['parking_place_vehicle_type'];
            $data['selected_parking_place_vehicle_type'] = $curl['selected_parking_place_vehicle_type'];
            $data['vehicle_type'] = $curl['vehicle_type'];
            $data['monthly_price_slab'] = $curl['monthly_price_slab'];
            $data['pass_days_data'] = $curl['pass_days_data'];
            $data['currency_data'] = $curl['currency_data'];
            $response = $data;
        }else {
            $response['status']='login_failure'; 
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_place_details()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            // echo '<pre>'; print_r($_POST); exit;                        
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
            $ext_price = $this->input->post('edit_ext_price');
            $fk_vehicle_type = $this->input->post('edit_fk_vehicle_type');
            $per_hour_charges = $this->input->post('edit_per_hour_charges');
            $place_count = $this->input->post('edit_place_count');
            $reserved_place_count = $this->input->post('edit_reserved_place_count');
            $total_place_count = $this->input->post('edit_total_place_count');
            $edit_referral_code = $this->input->post('edit_referral_code');  
            $edit_place_type = $this->input->post('edit_place_type');
            $edit_profile_img = $this->input->post('last_price_image');
            $edit_place_image = $this->input->post('last_place_image');
            $is_file = true;
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
            $this->form_validation->set_rules('edit_referral_code','Referral Code', 'trim|required',array('required' => 'You must provide a %s',));
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
                    'edit_referral_code' => strip_tags(form_error('edit_referral_code')),
                );
            } else {
                if(!empty($fk_vehicle_type)){
                    foreach ($fk_vehicle_type as $fk_vehicle_type_key => $fk_vehicle_type_row) {
                        $hour_price_slab_id[$fk_vehicle_type_row] = $this->input->post('hour_price_slab_id_'.$fk_vehicle_type_row);                    
                        $from_hours[$fk_vehicle_type_row] = $this->input->post('edit_from_hours_'.$fk_vehicle_type_row);              
                        $to_hours[$fk_vehicle_type_row] = $this->input->post('edit_to_hours_'.$fk_vehicle_type_row);              
                        $price[$fk_vehicle_type_row] = $this->input->post('edit_price_'.$fk_vehicle_type_row);      
                        $currency[$fk_vehicle_type_row] = $this->input->post('edit_currency_'.$fk_vehicle_type_row);     
                        $monthly_price_slab_id[$fk_vehicle_type_row] = $this->input->post('edit_monthly_price_slab_id_'.$fk_vehicle_type_row);      
                        $edit_no_of_days[$fk_vehicle_type_row] = $this->input->post('edit_no_of_days_'.$fk_vehicle_type_row);      
                        $edit_cost[$fk_vehicle_type_row] = $this->input->post('edit_cost_'.$fk_vehicle_type_row);      
                        $currencys[$fk_vehicle_type_row] = $this->input->post('edit_currencys_'.$fk_vehicle_type_row);      
                    }
                }
                if (!empty($_FILES['edit_price_image']['name'])) {
                    $edit_profile_img = trim($_FILES['edit_price_image']['name']);
                    $edit_profile_img = preg_replace('/\s/', '_', $edit_profile_img);
                    $profile_image = mt_rand(100000, 999999) . '_' . $edit_profile_img;
                    $config['upload_path'] = './uploads/';
                    $config['file_name'] = $profile_image;
                    $config['overwrite'] = TRUE;
                    $config["allowed_types"] = 'jpg|jpeg|png|bmp';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('edit_price_image')) {
                        $is_file = false;
                        $errors = $this->upload->display_errors();
                        $response['status'] = 'failure';
                        $response['error'] = array('edit_price_image' => $errors,);
                    }
                } 
                if (!empty($_FILES['edit_place_image']['name'])) {
                    $edit_place_image = trim($_FILES['edit_place_image']['name']);
                    $edit_place_image = preg_replace('/\s/', '_', $edit_place_image);
                    $edit_place_image_data = mt_rand(100000, 999999) . '_' . $edit_place_image;
                    $config['upload_path'] = './uploads/';
                    $config['file_name'] = $edit_place_image_data;
                    $config['overwrite'] = TRUE;
                    $config["allowed_types"] = 'jpg|jpeg|png|bmp';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('edit_place_image')) {
                        $is_file = false;
                        $errors = $this->upload->display_errors();
                        $response['status'] = 'failure';
                        $response['error'] = array('edit_place_image' => $errors,);
                    }
                } 
                if ($is_file) {
                
                    if (!empty($profile_image)) {
                        $edit_profile_img = 'uploads/' .$profile_image;
                    }
                    if (!empty($edit_place_image_data)) {
                        $edit_place_image = 'uploads/' .$edit_place_image_data;
                    }
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
                            'hour_price_slab_id'=>json_encode(@$hour_price_slab_id),
                            'from_hours'=>json_encode(@$from_hours),
                            'to_hours'=>json_encode(@$to_hours),
                            'price'=>json_encode(@$price),
                            'currency'=>json_encode(@$currency),
                            'id'=>$id,
                            'fk_vehicle_type'=>json_encode($fk_vehicle_type),
                            'per_hour_charges'=>$per_hour_charges,
                            'place_count'=>$place_count,
                            'reserved_place_count'=>$reserved_place_count,
                            'total_place_count'=>$total_place_count,
                            'referral_code'=>$edit_referral_code,
                            'place_type'=>$edit_place_type,
                            'monthly_price_slab_id'=>json_encode(@$monthly_price_slab_id),
                            'no_of_days'=>json_encode(@$edit_no_of_days),
                            'cost'=>json_encode(@$edit_cost),
                            'currencys'=>json_encode(@$currencys),
                            'price_image' => $edit_profile_img,     
                            'place_image' => $edit_place_image,     
                        );
                        // echo '<pre>'; print_r($curl_data); exit;
                        $curl = $this->link->hits('update-place', $curl_data);
                        $curl = json_decode($curl, true);
                        if ($curl['status']==1) {
                            $response['status']='success';
                        } else {
                            $response['status'] = 'failure';
                             $response['error'] = array("edit_place_name" => $curl['message']);
                        }
                }
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_parking_status()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $id = $this->input->post('id'); 
            $status = $this->input->post('status'); 
            if (empty($id)) {
                $response['message'] = 'Place Status id is required.';
                $response['status'] = 0;
            }else if(empty($status)) {
                $response['message'] = 'status is required.';
                $response['status'] = 0;
            }else{
                $curl_data = array(   
                  'id'=>$id,
                  'status'=>$status,
                );             
                $curl = $this->link->hits('update-parking-place-status',$curl_data);
                $curl = json_decode($curl, TRUE);
                // echo '<pre>'; print_r($curl); exit;
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
    // =====================Add Dvice===============================================
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
            $bluetooth_device_name = $this->input->post('bluetooth_device_name'); 
            $service_key = $this->input->post('service_key');     
            $curl_data = array(
                'edit_id'=>$edit_id,
                'fk_machine_id'=>json_encode($fk_machine_id),
                'slot_id'=>json_encode($edit_slot_id),
                'bluetooth_device_name'=>json_encode($bluetooth_device_name),
                'service_key'=>json_encode($service_key),
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
    public function update_delete_device_status()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $id = $this->input->post('id'); 
            $status = $this->input->post('status'); 
            $place_id = $this->input->post('place_id'); 
            // echo '<pre>'; print_r($_POST); exit;
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
                  'place_id'=>$place_id
                );
                $curl = $this->link->hits('delete-slots-device-status',$curl_data);
                $curl = json_decode($curl, TRUE);
                                // echo '<pre>'; print_r($curl); exit;

                if($curl['status']==1){
                    $response['message']='Slot Deleted Changed successfully';
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
            $duty_time = $this->input->post('duty_time');       

            $curl_data = array(
                'fk_place_id'=>json_encode($fk_place_id),
                'fk_verifier_id'=>json_encode($fk_verifier_id),
                'date'=>json_encode($date),
                'duty_time'=>json_encode($duty_time),
            );
            // echo '<pre>'; print_r($curl_data); exit;
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
    // ======================== Blogs ================================
    public function add_blogs()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');               
            $this->load->view('super_admin/add_blogs');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function save_blogs_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $title = $this->input->post('title');
            $description = $this->input->post('description');         
            $this->form_validation->set_rules('title', 'Title', 'required|trim', array('required' => 'You must provide a %s'));            
            $this->form_validation->set_rules('description', 'Description', 'required|trim', array('required' => 'You must provide a %s'));
            if ($this->form_validation->run() == FALSE) {
                $response['status'] = 'failure';
                $response['error'] = array('title' => strip_tags(form_error('title')), 
                    'description' => strip_tags(form_error('description')),);
            } else {
                $sample_image = '';
                $is_signature_file = true;
                if (!empty($_FILES['image']['name'])) {
                    $filename = $_FILES['image']['name'];
                    $test_img = $filename;
                    $test_img = preg_replace('/\s/', '_', $test_img);
                    $test_image = mt_rand(100000, 999999) . '_' .$test_img;
                    $setting['image_path'] = $_FILES['image']['tmp_name'];
                    $setting['image_name'] = $test_image;
                    $setting['compress_path'] = './uploads/blogs/';
                    $setting['jpg_compress_level'] = 5;
                    $setting['png_compress_level'] = 5;
                    $setting['create_thumb'] = FALSE;
                    $this->load->library('imgcompressor');
                    $results = $this->imgcompressor->do_compress($setting);
                    if (empty($results['data']['compressed']['name'])) {
                        $is_signature_file = false;
                        $response['status'] = 'failure';
                        $response['error'] = array(
                            'image' => $results['message'],
                        );
                    } else {
                        $sample_image = 'uploads/blogs/'.$test_image;
                    }
                }else {
                    $is_signature_file = false;
                    $response['status'] = 'failure';
                    $response['error'] = array('image' => "Image required",);
                }
               
                if ($is_signature_file) {
                    $curl_data = array(
                        'title' => $title,
                        'description' => $description, 
                        'image' => $sample_image,
                    );
                    $curl = $this->link->hits('save-blogs', $curl_data);
                    $curl = json_decode($curl, TRUE);
                    if ($curl['status']) {
                        $response['status'] = 'success';
                        $response['msg'] = "Blogs Added successfully";
                    } else {
                        $response['status'] = 'failure';
                        $response['error'] = array('title' => $curl['message'],);
                    }
                }
            }
        } else {
            $response['status'] = 'failure';
            $response['url'] = base_url() . "Admin";
        }
        echo json_encode($response);
    }

    public function display_all_blogs_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-blogs-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['blogs_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_blogs_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $id = $this->input->post('edit_id');
            $title = $this->input->post('edit_title');
            $description = $this->input->post('edit_description');
            $is_file = true;
            $edit_profile_img = $this->input->post('last_inserted_image');
            // echo '<pre>'; print_r($edit_profile_img); exit;
            $this->form_validation->set_rules('edit_title', 'Title', 'required|trim', array('required' => 'You must provide a %s'));
            
            $this->form_validation->set_rules('edit_description', 'Description', 'required|trim', array('required' => 'You must provide a %s'));
            if ($this->form_validation->run() == FALSE) {
                $response['status'] = 'failure';
                $response['error'] = array('edit_title' => strip_tags(form_error('edit_title')), 
                    'edit_description' => strip_tags(form_error('edit_description')),);
            } else {
               
               if (!empty($_FILES['edit_image']['name'])) {
                    $edit_profile_img = trim($_FILES['edit_image']['name']);
                    $edit_profile_img = preg_replace('/\s/', '_', $edit_profile_img);
                    $profile_image = mt_rand(100000, 999999) . '_' . $edit_profile_img;
                    $config['upload_path'] = './uploads/blogs/';
                    $config['file_name'] = $profile_image;
                    $config['overwrite'] = TRUE;
                    $config["allowed_types"] = 'jpg|jpeg|png|bmp';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('edit_image')) {
                        $is_file = false;
                        $errors = $this->upload->display_errors();
                        $response['status'] = 'failure';
                        $response['error'] = array('edit_image' => $errors,);
                    }
                } 
                if ($is_file) {
                
                    if (!empty($profile_image)) {
                        $edit_profile_img = 'uploads/blogs/' . $profile_image;
                    }
                    $curl_data = array(
                        'title' => $title,
                        'description' => $description, 
                        'image' => $edit_profile_img,
                        'id' => $id
                    );
                    $curl = $this->link->hits('update-blogs', $curl_data);
                    $curl = json_decode($curl, TRUE);
                    if ($curl['status']) {
                        $response['status'] = 'success';
                        $response['msg'] = "Blogs Updated successfully";
                    } else {
                        $response['status'] = 'failure';
                        $response['error'] = array('edit_title' => $curl['message'],);
                    }
                }
            }
        } else {
            $response['status'] = 'failure';
            $response['url'] = base_url() . "Admin";
        }
        echo json_encode($response);
    }
    public function delete_blogs()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $id = $this->input->post('delete_blogs_id'); 
            if (empty($id )) {
                $response['message'] = 'id is required.';
                $response['status'] = 0;
            } else {
                $curl_data = array(   
                  'id'=>$id,
                );            
                $curl = $this->link->hits('delete-blogs',$curl_data);
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

     public function excel_upload_place() {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
                error_reporting(0);
                $this->load->library('excel');
                if (!empty($_FILES["excel_upload"]["name"])) {
                    $path = $_FILES["excel_upload"]["tmp_name"];
                    $object = PHPExcel_IOFactory::load($path);
                    foreach ($object->getWorksheetIterator() as $worksheet) {
                        $highestRow = $worksheet->getHighestRow();
                        $highestColumn = $worksheet->getHighestColumn();
                        $img = 0;
                        for ($row = 2;$row <= $highestRow; $row++) {
                            if (!empty($worksheet->getCellByColumnAndRow(1, $row)->getValue()) && ($object->getIndex($worksheet) == '0')) {
                                $fk_vendor_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                                $fk_country_id = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                                $fk_state_id = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                                $fk_city_id = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                                $place_name = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                                $address = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                                $pincode = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                                $latitude = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                                $longitude = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                                $slots = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                                $fk_place_status_id = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                                $fk_parking_price_type = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                                $ext_price = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                                    
                                $curl_data = array(
                                    'fk_vendor_id' =>$fk_vendor_id,
                                    'fk_country_id' =>$fk_country_id,
                                    'fk_state_id' =>$fk_state_id,
                                    'fk_city_id' =>$fk_city_id,
                                    'place_name' => $place_name,
                                    'address' =>$address,
                                    'pincode' =>$pincode,
                                    'latitude' =>$latitude,
                                    'longitude' =>$longitude,
                                    'slots' =>$slots,
                                    'fk_place_status_id' =>$fk_place_status_id,
                                    'fk_parking_price_type' =>$fk_parking_price_type,
                                    'ext_price' =>$ext_price
                                );
                                // echo '<pre>'; print_r($curl_data); exit;
                                $curl = $this->link->hits('add-place', $curl_data);
                                // echo '<pre>'; print_r($curl); exit;
                                $curl = json_decode($curl, TRUE);
                                // array_push($a, $curl['last_inserted_id']);
                                // array_push($b, $curl['product_id']);
                            }
                            // if (!empty($worksheet->getCellByColumnAndRow(1, $row)->getValue()) && ($object->getIndex($worksheet) == '1')) {
                            //     $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                            //     $att_value = [];
                            //     $p_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                            //     $color = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                            //     $quantity = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                            //     $price = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                            //     //$meta_tag = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                            //     for ($col = 5;$col < $highestColumnIndex;$col++) {
                            //         $att_value[] = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                            //     }
                            //     $color = explode("_", $color);
                            //     $curl_data2 = array('log_in_id' => $log_in_id, 'p_id' => $p_id, 'color' => $color[0], 'quantity' => $quantity, 'price' => $price, 'attribute_ids' => implode(',', $att_id), 'attribute_values' => implode(',', $att_value), 'upload_image' => $image_name[$img], 'last_inserted_id' => json_encode($a), 'product_ids' => json_encode($b),);
                            //     $img++;
                            //     $curl2 = $this->link->hits('excel-add-product1', $curl_data2);
                            //     $curl2 = json_decode($curl2, TRUE);
                            //     if ($curl['status']) {
                            //         $response['status'] = 'success';
                            //     } else {
                            //         $response['status'] = 'failure';
                            //         $response['error'] = array('product_name' => $curl['message'],);
                            //     }
                            // }
                        }
                        if ($curl['status']==1) {
                            $response['status']='success';
                            $response['msg'] = "Place Added successfully";
                        } else {
                            $response['status'] = 'failure';
                             $response['error'] = array("place_name" => $curl['message']);
                        }
                    }
                    
                }
        } else {
             $response['status'] = 'failure';
            $response['url'] = base_url() . "superadmin";
        }
        echo json_encode($response);
    }
    // ========================= Vehicle Type ============================
    public function add_vehicle_type()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $this->load->view('super_admin/vehicle_type');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function save_vehicle_type_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            
            $vehicle_type = $this->input->post('vehicle_type');        
            $this->form_validation->set_rules('vehicle_type','Vehicle Type', 'trim|required|callback_alpha_dash_space',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'vehicle_type' => strip_tags(form_error('vehicle_type')),
                );
            } else {
                $curl_data = array(
                    'vehicle_type'=>$vehicle_type,
                );
                $curl = $this->link->hits('add-vehicle-type', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                     $response['error'] = array("vehicle_type" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function display_all_vehicle_type_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-vehicle-type-data', array(), '', 0);
            // echo '<pre>'; print_r($curl); exit;
            $curl = json_decode($curl, true);
            $response['data'] = $curl['vehicle_type'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_vehicle_type_status()
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
                $curl = $this->link->hits('update-vehicle-type-status',$curl_data);
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
    public function update_vehicle_type_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            
            $edit_id = $this->input->post('edit_id');        
            $edit_vehicle_type = $this->input->post('edit_vehicle_type');        
            $this->form_validation->set_rules('edit_vehicle_type','Price Status', 'trim|required|callback_alpha_dash_space',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'edit_vehicle_type' => strip_tags(form_error('edit_vehicle_type')),
                );
            } else {
                $curl_data = array(
                    'vehicle_type'=>$edit_vehicle_type,
                    'id' =>$edit_id
                );
                $curl = $this->link->hits('update-vehicle-type-data', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array("edit_vehicle_type" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }

    public function delete_vehicle_type()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $id = $this->input->post('delete_vehicle_id'); 
            if (empty($id )) {
                $response['message'] = 'id is required.';
                $response['status'] = 0;
            } else {
                $curl_data = array(   
                  'id'=>$id,
                );            
                $curl = $this->link->hits('delete-vehicle-type',$curl_data);
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
    public function pos_device_map()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
              $curl = $this->link->hits('get-pos-map-data', array(), '', 0);
                $curl = json_decode($curl, true);
                $response['place_list'] = $curl['place_list'];
                $response['device_id'] = $curl['device_id'];
            $this->load->view('super_admin/pos_device_map',$response);
        } else {
            redirect(base_url().'superadmin');
        }
    }

    public function add_pos_device_map()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            
            $fk_place_id = $this->input->post('fk_place_id');        
            $device_id = $this->input->post('device_id');        
            $this->form_validation->set_rules('fk_place_id','Place', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('device_id','Device Id', 'trim|required',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'fk_place_id' => strip_tags(form_error('fk_place_id')),
                    'device_id' => strip_tags(form_error('device_id')),
                );
            } else {
                $curl_data = array(
                    'fk_place_id' => $fk_place_id,
                    'device_id' => $device_id,
                );
                $curl = $this->link->hits('add-pos-device-map', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array("device_id" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function display_all_pos_device_map_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-pos-device-map-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['pos_device_map_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_pos_device_map_details()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            
            $fk_place_id = $this->input->post('edit_place_id');        
            $device_id = $this->input->post('edit_device_id');        
            $id = $this->input->post('edit_id');        
            $this->form_validation->set_rules('edit_place_id','Place', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_device_id','Device Id', 'trim|required',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'edit_place_id' => strip_tags(form_error('edit_place_id')),
                    'edit_device_id' => strip_tags(form_error('edit_device_id')),
                );
            } else {
                $curl_data = array(
                    'fk_place_id' => $fk_place_id,
                    'device_id' => $device_id,
                    'id' => $id,
                );
                $curl = $this->link->hits('update-pos-device-map', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array("edit_device_id" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }

    public function delete_pos_device()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $id = $this->input->post('delete_pos_device_id'); 
            if (empty($id )) {
                $response['message'] = 'id is required.';
                $response['status'] = 0;
            } else {
                $curl_data = array(   
                  'id'=>$id,
                );            
                $curl = $this->link->hits('delete-pos-device-map',$curl_data);
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
    public function change_pos_device_map_status()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $id = $this->input->post('id'); 
            $status = $this->input->post('status'); 
            if (empty($id)) {
                $response['message'] = 'Id is required.';
                $response['status'] = 0;
            }else if($status=='') {
                $response['message'] = 'status is required.';
                $response['status'] = 0;
            }else{
                $curl_data = array(   
                  'id'=>$id,
                  'status'=>$status,
                );                
                $curl = $this->link->hits('update-pos-device-map-status',$curl_data);
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
    public function pos_verifier_duty_allocation()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
                $curl = $this->link->hits('get-all-pos-verifier', array(), '', 0);
                $curl = json_decode($curl, true);
                $response['place_list'] = $curl['place_list'];
                $response['pos_verifier_list'] = $curl['pos_verifier_list'];
            $this->load->view('super_admin/pos_verifier_duty_allocation',$response);
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function get_pos_verifier_allocation_data()
    {
         if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
                $curl = $this->link->hits('get-all-pos-verifier', array(), '', 0);
                $curl = json_decode($curl, true);
                $response['place_list'] = $curl['place_list'];
                $response['pos_verifier_list'] = $curl['pos_verifier_list'];
        }else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);      
    }
    public function save_pos_vrifier_duty_allocation()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');            
            $fk_place_id = $this->input->post('fk_place_id');        
            $fk_pos_verifier_id = $this->input->post('fk_pos_verifier_id');
            $date = $this->input->post('date');       
            $curl_data = array(
                'fk_place_id'=>json_encode($fk_place_id),
                'fk_pos_verifier_id'=>json_encode($fk_pos_verifier_id),
                'date'=>json_encode($date),
            );
            $curl = $this->link->hits('save-pos-verifier-duty-allocation', $curl_data);
            $curl = json_decode($curl, true);
            if ($curl['status']==1) {
                $response['status']='success';
            } else {
                 $response['status'] = 'failure';
                 $response['error'] = array("fk_pos_verifier_id" => $curl['message']);
            }
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }

    public function display_all_pos_duty_allocation_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-pos-duty-allocation-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['pos_duty_allocation'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function delete_pos_duty_allocation()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $id = $this->input->post('delete_pos_duty_allocation_id'); 
            if (empty($id )) {
                $response['message'] = 'Duty Allocation id is required.';
                $response['status'] = 0;
            } else {
                $curl_data = array(   
                  'id'=>$id,
                );            
                $curl = $this->link->hits('delete-pos-duty-allocation',$curl_data);
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

    public function add_pos_device()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $this->load->view('super_admin/add_pos_device');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function save_pos_device_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');            
            $device_id = $this->input->post('device_id');         
            $curl_data = array(
                'device_id'=>json_encode($device_id),
            );
            $curl = $this->link->hits('add-pos-device', $curl_data);
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
    public function display_all_pos_device_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-pos-device-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['device_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function change_pos_device_status()
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
                $curl = $this->link->hits('update-pos-device-status',$curl_data);
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
    public function pos_booking()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $this->load->view('super_admin/pos_booking');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function display_all_pos_booking_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-pos-booking-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['pos_booking_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function user_terms_n_condition()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $curl = $this->link->hits('user-terms-n-condition', array(), '', 0);
            $curl = json_decode($curl, true);
            $data['user_terms_n_condition'] = $curl['user_terms_n_condition'];
            // echo '<pre>'; print_r($data); exit;
            $this->load->view('super_admin/user_terms_n_condition',$data);
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function verifier_terms_n_condition()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $curl = $this->link->hits('verifier-terms-n-condition', array(), '', 0);
            $curl = json_decode($curl, true);
            $data['verifier_terms_n_condition'] = $curl['verifier_terms_n_condition'];

            $this->load->view('super_admin/verifier_terms_n_condition',$data);
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function vendor_terms_n_condition()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $curl = $this->link->hits('vendor-terms-n-condition', array(), '', 0);
            $curl = json_decode($curl, true);
            $data['vendor_terms_n_condition'] = $curl['vendor_terms_n_condition'];

            $this->load->view('super_admin/vendor_terms_n_condition',$data);
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function update_terms_n_condition()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');            
            $terms_condition = $this->input->post('terms_condition');        
            $id = $this->input->post('id');        
            $this->form_validation->set_rules('id','Place', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('terms_condition','Terms & Condition', 'trim|required',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'id' => strip_tags(form_error('id')),
                    'terms_condition' => strip_tags(form_error('terms_condition')),
                );
            } else {
                $curl_data = array(
                    'id' => $id,
                    'terms_condition' => $terms_condition,
                );
                $curl = $this->link->hits('update-terms-n-condition', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                    $response['message']=$curl['message'];
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array("terms_condition" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function suggested_parking_place()
    {
       if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $this->load->view('super_admin/suggested_parking_place');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function display_all_suggested_parking_place_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-suggested-parking-place_data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['suggested_place'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function customer_support()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $curl = $this->link->hits('get-customer-support-details', array(), '', 0);
            $curl = json_decode($curl, true);
            $data['issue_type'] = $curl['issue_type'];
            $data['user_list'] = $curl['user_list'];
            $data['booking_id_list'] = $curl['booking_id_list'];
            $this->load->view('super_admin/customer_support',$data);
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function add_complaint()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            // echo '<pre>'; print_r($_POST); exit;
            $id = $session_data['id'];         
            $description = $this->input->post('description');
            $fk_booking_id = $this->input->post('fk_booking_id');
            $contact_no = $this->input->post('contact_no');
            $fk_issue_type_id = $this->input->post('fk_issue_type_id');
            $user_type = $this->input->post('user_type');

            if($user_type==1){
                $fk_user_id = $this->input->post('fk_user_id');
            }else{
                $fk_user_id = $this->input->post('user_name');
            }

            
            if($user_type== 1){
                $this->form_validation->set_rules('fk_user_id','User Name', 'trim|required',array('required' => 'You must provide a %s',));
                $this->form_validation->set_rules('fk_booking_id','Booking Id', 'trim|required',array('required' => 'You must provide a %s',));
            }else{
                 $this->form_validation->set_rules('user_name','User Name', 'trim|required',array('required' => 'You must provide a %s',));
            }        
            $this->form_validation->set_rules('contact_no','Contact No', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('fk_issue_type_id','Issue Type', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('user_type','User Type', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('description','Description', 'trim|required',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'user_name' => strip_tags(form_error('user_name')),
                    'fk_user_id' => strip_tags(form_error('fk_user_id')),
                    'fk_issue_type_id' => strip_tags(form_error('fk_issue_type_id')),
                    'contact_no' => strip_tags(form_error('contact_no')),
                    'description' => strip_tags(form_error('description')),
                    'user_type' => strip_tags(form_error('user_type')),
                    'fk_booking_id' => strip_tags(form_error('fk_booking_id')),
                );
            } else {
                $curl_data = array(
                    'fk_booking_id'=>$fk_booking_id,
                    'fk_user_id'=>$fk_user_id,
                    'fk_issue_type_id'=>$fk_issue_type_id,
                    'description'=>$description,
                    'contact_no'=>$contact_no,
                    'user_type'=>$user_type,
                );
                $curl = $this->link->hits('add-complaint-details', $curl_data);
                // echo '<pre>'; print_r($curl); exit;
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array("fk_user_id" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response); 
    }

    public function display_all_register_user_complaint_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-register-user-complaint-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['register_user_complaint_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function display_all_unregister_user_complaint_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-unregister-user-complaint-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['unregister_user_complaint_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }

    public function update_register_user_complaint()
    {
         if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
                 
            $action_type = $this->input->post('action_type');
            $customer_care_remark = $this->input->post('customer_care_remark');
            $edit_id = $this->input->post('edit_id');
            $complaint_status = $this->input->post('complaint_status');
     
            $this->form_validation->set_rules('action_type','Action Type', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('customer_care_remark','Customer Care Remark', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('complaint_status','Complaint Status', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('edit_id','Id ', 'trim|required',array('required' => 'You must provide a %s',));
            
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'action_type' => strip_tags(form_error('action_type')),
                    'customer_care_remark' => strip_tags(form_error('customer_care_remark')),
                    'complaint_status' => strip_tags(form_error('complaint_status')),
                    'edit_id' => strip_tags(form_error('edit_id')),
                );
            } else {
                $curl_data = array(
                    'edit_id'=>$edit_id,
                    'action_type'=>$action_type,
                    'customer_care_remark'=>$customer_care_remark,
                    'complaint_status'=>$complaint_status,
                );
                $curl = $this->link->hits('update-register-user-complaint-details', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array("fk_user_id" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response); 
    }

    public function update_unregister_user_complaint()
    {
         if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
                 
            $action_type = $this->input->post('unr_action_type');
            $customer_care_remark = $this->input->post('unr_customer_care_remark');
            $edit_id = $this->input->post('unr_edit_id');
            $complaint_status = $this->input->post('unr_complaint_status');
     
            $this->form_validation->set_rules('unr_action_type','Action Type', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('unr_customer_care_remark','Customer Care Remark', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('unr_complaint_status','Complaint Status', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('unr_edit_id','Id ', 'trim|required',array('required' => 'You must provide a %s',));
            
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'unr_action_type' => strip_tags(form_error('unr_action_type')),
                    'unr_customer_care_remark' => strip_tags(form_error('unr_customer_care_remark')),
                    'unr_complaint_status' => strip_tags(form_error('unr_complaint_status')),
                    'unr_edit_id' => strip_tags(form_error('unr_edit_id')),
                );
            } else {
                $curl_data = array(
                    'edit_id'=>$edit_id,
                    'action_type'=>$action_type,
                    'customer_care_remark'=>$customer_care_remark,
                    'complaint_status'=>$complaint_status,
                );
                $curl = $this->link->hits('update-un-register-user-complaint-details', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array("fk_user_id" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response); 
    }
    public function slot_complaint()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');           
            $this->load->view('super_admin/slot_issue');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function display_all_slot_complaint_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-slot-complaint-data', array(), '', 0);
            
            $curl = json_decode($curl, true);
            $response['data'] = $curl['slot_complaint_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    // ======================== Referral Code =================================
    public function referral_code()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $this->load->view('super_admin/referral_code');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function save_referral_code()
    {
       if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            
            $referral_code = $this->input->post('referral_code');        
            $this->form_validation->set_rules('referral_code','Price Status', 'trim|required',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'referral_code' => strip_tags(form_error('referral_code')),
                );
            } else {
                $curl_data = array(
                    'referral_code'=>$referral_code,
                );
                $curl = $this->link->hits('add-referral-code', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                     $response['error'] = array("referral_code" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function display_all_referral_code_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-referral-code', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['referral_code_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_referral_code_status()
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
                $curl = $this->link->hits('update-referral-code-status',$curl_data);
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
    public function update_referral_code_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            
            $edit_id = $this->input->post('edit_id');        
            $edit_referral_code = $this->input->post('edit_referral_code');        
            $this->form_validation->set_rules('edit_referral_code','Referral Code', 'trim|required',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'edit_referral_code' => strip_tags(form_error('edit_referral_code')),
                );
            } else {
                $curl_data = array(
                    'referral_code'=>$edit_referral_code,
                    'id' =>$edit_id
                );
                $curl = $this->link->hits('update-referral-code-data', $curl_data);
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
    public function delete_referral_code()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $id = $this->input->post('delete_referral_code_id'); 
            if (empty($id)) {
                $response['message'] = 'Referral Code Id is required.';
                $response['status'] = 0;
            } else {
                $curl_data = array(   
                  'id'=>$id,
                );            
                $curl = $this->link->hits('delete-referral-code',$curl_data);
                $curl = json_decode($curl, TRUE);            
                if($curl['message']=='success'){
                    $response['message']=$curl['message'];
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
    // ======================= Map Referal Code ================================
    public function map_referral_code()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $this->load->view('super_admin/map_referral_code');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    // ============================ Privacy Policy===================================

    public function privacy_n_policy()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $curl = $this->link->hits('user-privacy-n-policy', array(), '', 0);
            $curl = json_decode($curl, true);
            $data['user_privacy_n_policy'] = $curl['user_privacy_n_policy'];
            $this->load->view('super_admin/privacy_policy',$data);
        } else {
            redirect(base_url().'superadmin');
        }
    }
     public function update_privacy_n_policy()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');            
            $privacy_n_policy = $this->input->post('privacy_n_policy');        
            $id = $this->input->post('id');        
            $this->form_validation->set_rules('id','Place', 'trim|required',array('required' => 'You must provide a %s',));
            $this->form_validation->set_rules('privacy_n_policy','Terms & Condition', 'trim|required',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'id' => strip_tags(form_error('id')),
                    'privacy_n_policy' => strip_tags(form_error('privacy_n_policy')),
                );
            } else {
                $curl_data = array(
                    'id' => $id,
                    'privacy_policy' => $privacy_n_policy,
                );
                $curl = $this->link->hits('update-privacy-n-policy', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                    $response['message']=$curl['message'];
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array("privacy_n_policy" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }

    public function vendor_map_place()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
             $curl = $this->link->hits('get-vendor-map-place-data', array(), '', 0);
                $curl = json_decode($curl, true);
                $response['place_list'] = $curl['place_list'];
                $response['vendor_list'] = $curl['vendor_list'];
            $this->load->view('super_admin/vendor_map_place',$response);
        } else {
            redirect(base_url().'superadmin');
        }
    }

    public function save_vendor_map_place()
    {
         if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
                
            $fk_vendor_id = $this->input->post('fk_vendor_id');
            $fk_place_id = $this->input->post('fk_place_id');
            $this->form_validation->set_rules('fk_place_id[]','Place', 'trim|required',array('required' => 'You must provide a %s',));            
            $this->form_validation->set_rules('fk_vendor_id','Vendor', 'trim|required',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'fk_vendor_id' => strip_tags(form_error('fk_vendor_id')),
                    'fk_place_id' => strip_tags(form_error('fk_place_id[]')),
                );
            } else {
                $curl_data = array(
                    'fk_vendor_id'=>$fk_vendor_id,
                    'fk_place_id'=>json_encode($fk_place_id),
                );
                $curl = $this->link->hits('add-vendor-mapped-place', $curl_data);
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array("fk_vendor_id" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response); 
    }

    public function display_all_vendor_map_place_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-vendor-map-place-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['vendor_map_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function get_vendor_map_place_data_on_id()
    {
       if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $id = $this->input->post('id');
            $curl_data = array('id'=>$id);
            $curl = $this->link->hits('get-vendor-map-place-data-on-id',$curl_data);
            $curl = json_decode($curl, true);
            $response['vendor_map_data'] = $curl['vendor_map_data'];
            $response['place_list'] = $curl['place_list'];
            $response['selected_parking_place_id'] = $curl['selected_parking_place_id'];

        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function update_vendor_map_with_image()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
                
            $id = $this->input->post('edit_id');
            $fk_vendor_id = $this->input->post('edit_fk_vendor_id');
            $fk_place_id = $this->input->post('edit_fk_place_id');
            $this->form_validation->set_rules('edit_fk_place_id[]','Place', 'trim|required',array('required' => 'You must provide a %s',));            
            $this->form_validation->set_rules('edit_fk_vendor_id','Vendor', 'trim|required',array('required' => 'You must provide a %s',));
            if ($this->form_validation->run() == false) {
                $response['status'] = 'failure';
                $response['error'] = array(
                    'edit_fk_vendor_id' => strip_tags(form_error('edit_fk_vendor_id')),
                    'edit_fk_place_id' => strip_tags(form_error('edit_fk_place_id[]')),
                );
            } else {
                $curl_data = array(
                    'id'=>$id,
                    'fk_vendor_id'=>$fk_vendor_id,
                    'fk_place_id'=>json_encode($fk_place_id),
                );
                $curl = $this->link->hits('update-vendor-mapped-place', $curl_data);
                // echo '<pre>'; print_r($curl); exit;
                $curl = json_decode($curl, true);
                if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array("edit_fk_vendor_id" => $curl['message']);
                }
            }
        } else {
            $resoponse['status']='login_failure';
        }
        echo json_encode($response); 
    }
    public function add_nfc_device()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $this->load->view('super_admin/add_nfc_device');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function save_nfc_device_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');            
            $device_id = $this->input->post('nfc_device_id');         
            $curl_data = array(
                'device_id'=>$device_id,
            );
            $curl = $this->link->hits('add-nfc-device', $curl_data);
            $curl = json_decode($curl, true);
            if ($curl['status']==1) {
                $response['status']='success';
            } else {
                $response['status'] = 'failure';
                $response['error'] = array("nfc_device_id" => $curl['message']);
            }
        } else {
            $resoponse['status']='login_failure';
            $resoponse['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function display_all_nfc_device_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-nfc-device-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['device_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }

     public function change_nfc_device_status()
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
                $curl = $this->link->hits('update-nfc-device-status',$curl_data);
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
    public function applied_for_vendor()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $this->load->view('super_admin/applied_for_vendor');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function display_all_applied_for_vendor_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-applied-for-vendor-data', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['applied_for_vendor_data'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }
    public function user_pass_details()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $this->load->view('super_admin/user_pass_details');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    public function display_all_user_pass_details()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-user-pass-details', array(), '', 0);
            $curl = json_decode($curl, true);
            $response['data'] = $curl['user_pass_details'];
        } else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
    }

     public function update_bluetooth_device_status()
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
                $curl = $this->link->hits('update-bluetooth-device-status',$curl_data);
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
    public function add_referral_code()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $this->load->view('super_admin/referral_code');
        } else {
            redirect(base_url().'superadmin');
        }
    }
    
}