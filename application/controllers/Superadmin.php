<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends CI_Controller {

	public function index()
	{
		$this->load->view('super_admin/login');
	}
	public function dashboard()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
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
	public function add_roles()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
			$this->load->view('super_admin/add_role');
		} else {
            redirect(base_url().'superadmin');
        }
	}
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
                 // echo '<pre>'; print_r($curl); exit;

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
                // echo '<pre>'; print_r($curl); exit;

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
            $resoponse['url']=base_url().'admin';
        }
        echo json_encode($response);
	}
    public function display_all_admin_data()
    {
        if ($this->session->userdata('parking_adda_superadmin_logged_in'))
        {
            $curl = $this->link->hits('display-all-admin-data', array(), '', 0);
            // echo '<pre>'; print_r(); exit;
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
                echo '<pre>'; print_r($curl); exit;
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
	public function booking_history()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
			$this->load->view('super_admin/booking_history');
		} else {
            redirect(base_url().'superadmin');
        }
	}
}