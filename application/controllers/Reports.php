<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	public function user_reports()
	{
	    	if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
                 $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
		        $this->load->view('super_admin/user_reports');
	    	} else {
                redirect(base_url().'superadmin');
            }
	}
	public function display_all_user_report_data()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in'))
		{
	        $from_date = @$this->input->post('from_date');
	        $to_date = @$this->input->post('to_date');     
	        $curl_data = array('from_date'=>$from_date,'to_date'=>$to_date);
	      	$user_details = $this->link->hits('user-report-data', $curl_data);
            $user_details = json_decode($user_details, true); 
            $response['data'] = $user_details['user_details'];
	    }else{
	    	 $response['status']='login_failure';
             $response['url']=base_url().'superadmin';
	    }
	    echo json_encode($response);
	}
	public function bonus_reports()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
             $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
	        $this->load->view('super_admin/bonus_report');
    	} else {
            redirect(base_url().'superadmin');
        }
	}
	public function display_all_bonus_report_data()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in'))
		{
	        $from_date = @$this->input->post('from_date');
	        $to_date = @$this->input->post('to_date');     
	        $curl_data = array('from_date'=>$from_date,'to_date'=>$to_date);
	      	$curl = $this->link->hits('bonus-report-data', $curl_data);
            $curl = json_decode($curl, true); 
            $response['data'] = $curl['bonus_details'];
	    }else{
	    	 $response['status']='login_failure';
             $response['url']=base_url().'superadmin';
	    }
	    echo json_encode($response);
	}
	public function user_wallet_reports()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
             $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
	        $this->load->view('super_admin/user_wallet_reports');
    	} else {
            redirect(base_url().'superadmin');
        }
	}
	public function display_all_user_wallet_report_data()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in'))
		{
	        $from_date = @$this->input->post('from_date');
	        $to_date = @$this->input->post('to_date');     
	        $curl_data = array('from_date'=>$from_date,'to_date'=>$to_date);
	      	$curl = $this->link->hits('user-wallet-report-data', $curl_data);
            $curl = json_decode($curl, true); 
            $response['data'] = $curl['user_wallet_details'];
	    }else{
	    	 $response['status']='login_failure';
             $response['url']=base_url().'superadmin';
	    }
	    echo json_encode($response);
	}

}