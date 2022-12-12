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
                if ($curl['status']) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                    $response['error'] = array(
                        'menu'=>$curl['message'],
                    );
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