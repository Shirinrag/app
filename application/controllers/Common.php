<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {

	public function login()
	{
		$this->form_validation->set_rules('login_email', 'Username ', 'required|trim',array(
				'required' => 'You must provide an %s',
			)
		);
		$this->form_validation->set_rules('login_password', 'Password', 'trim|required',
			array(
				'required' => 'You must provide a %s',
			)
		);		
		if ($this->form_validation->run() == FALSE) {
            $response['status'] = 'failure';
            $response['error'] = array(
            	'login_email' => strip_tags(form_error('login_email')), 
            	'login_password' => strip_tags(form_error('login_password')),
            );
        } else{
			$username= $this->input->post('login_email');  
		  	$password= $this->input->post('login_password'); 
		  	$curl_data = array(
				'username'=>$username,
			  	'password'=>$password,
			);
			$curl = $this->link->hits('loggedin-data',$curl_data);
			// echo '<pre>'; print_r($curl); exit;
			$curl = json_decode($curl, TRUE);
			if($curl['status']==1){
				if (@$curl['data']['user_type']=="1") {
					$this->session->set_userdata('parking_adda_superadmin_logged_in', @$curl['data']);
					$url=base_url().'superadmin/dashboard';	
					$response['url']=$url; 
					$response['status']='success';
				} else if (@$curl['data']['user_type']=="2") {
					$this->session->set_userdata('parking_adda_admin_logged_in', @$curl['data']);
					$url=base_url().'superadmin/dashboard';	
					$response['url']=$url; 
					$response['status']='success';
				} else if (@$curl['data']['user_type']=="3") {
					$this->session->set_userdata('parking_adda_verifier_logged_in', @$curl['data']);
					$url=base_url().'superadmin/dashboard';	
					$response['url']=$url; 
					$response['status']='success';
				} else if (@$curl['data']['user_type']=="5") {
					$this->session->set_userdata('parking_adda_vendor_logged_in', @$curl['data']);
					$url=base_url().'superadmin/dashboard';	
					$response['url']=$url; 
					$response['status']='success';
				} else if (@$curl['data']['user_type']=="6") {
					$this->session->set_userdata('parking_adda_engg_logged_in', @$curl['data']);
					$url=base_url().'superadmin/dashboard';	
					$response['url']=$url; 
					$response['status']='success';
				}else if (@$curl['data']['user_type']=="7") {
					$this->session->set_userdata('parking_adda_legal_check_team_logged_in', @$curl['data']);
					$url=base_url().'superadmin/dashboard';	
					$response['url']=$url; 
					$response['status']='success';
				} else if (@$curl['data']['user_type']=="8") {
					$this->session->set_userdata('parking_adda_ground_team_logged_in', @$curl['data']);
					$url=base_url().'superadmin/dashboard';	
					$response['url']=$url; 
					$response['status']='success';
				} else if (@$curl['data']['user_type']=="9") {
					$this->session->set_userdata('parking_adda_customer_care_logged_in', @$curl['data']);
					$url=base_url().'superadmin/dashboard';	
					$response['url']=$url; 
					$response['status']='success';
				} else if (@$curl['data']['user_type']=="11") {
					$this->session->set_userdata('parking_adda_admin_verifier_logged_in', @$curl['data']);
					$url=base_url().'superadmin/dashboard';	
					$response['url']=$url; 
					$response['status']='success';
				} else if (@$curl['data']['user_type']=="12") {
					$this->session->set_userdata('parking_adda_mis_logged_in', @$curl['data']);
					$url=base_url().'superadmin/dashboard';	
					$response['url']=$url; 
					$response['status']='success';
				} 
			} else if($curl['status']=='wrong_username'){
				$response['status']='failure';  
				$response['error'] = array( 
            		'login_email' =>$curl['message'],
            	); 				
			} else {
		  		$response['status'] = 'failure';
            	$response['error'] = array( 
            		'login_password' =>$curl['message'],
            	);
		  	}
		} 
		echo json_encode($response);
	}

	public function logout()
	{
		$this->session->sess_destroy();
        redirect(base_url().'superadmin'); 
	}
}