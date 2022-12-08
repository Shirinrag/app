<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {

	public function login()
	{
		$this->form_validation->set_rules('login_email', 'Username ', 'required|trim|valid_email',array(
				'required' => 'You must provide an %s',
				'valid_email' => 'You must provide valid %s',
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
				'email'=>$username,
			  	'password'=>$password,
			);
			$curl = $this->link->hits('users-login',$curl_data);
			$curl = json_decode($curl, TRUE);
			if($curl['status']==1){
				if (@$curl['data']['user_type']=="Superadmin") {
					$this->session->set_userdata('eg_tech_superadmin_logged_in', @$curl['data']);
					$url=base_url().'dashboard';	
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
}