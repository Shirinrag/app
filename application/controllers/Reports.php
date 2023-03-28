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
	public function verifier_attendance_reports()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
            $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
            $curl = $this->link->hits('get-all-data-report', array(), '', 0);
            $curl = json_decode($curl, true); 
	        $response['place_details'] = $curl['place_details'];
	        $response['verifier_details'] = $curl['verifier_details'];
	        $this->load->view('super_admin/verifier_attendance_reports',$response);
    	} else {
            redirect(base_url().'superadmin');
        }
	}
	public function display_all_verifier_attendance_report_data()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in'))
		{
	        $from_date = @$this->input->post('from_date');
	        $to_date = @$this->input->post('to_date');     
	        $fk_place_id = @$this->input->post('fk_place_id');     
	        $fk_verifier_id = @$this->input->post('fk_verifier_id');     
	        $curl_data = array('from_date'=>$from_date,'to_date'=>$to_date,'fk_place_id'=>$fk_place_id,'fk_verifier_id'=>$fk_verifier_id);
	      	$curl = $this->link->hits('verifier-attendance-report-data', $curl_data);
	      	// echo '<pre>'; print_r($curl); exit;
            $curl = json_decode($curl, true); 
            $response['data'] = $curl['verifier_attendance_details'];
	    }else{
	    	 $response['status']='login_failure';
             $response['url']=base_url().'superadmin';
	    }
	    echo json_encode($response);
	}
	public function transcation_reports()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
             $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
	        $this->load->view('super_admin/transcation_reports');
    	} else {
            redirect(base_url().'superadmin');
        }
	}
	public function display_all_user_transcation_report_data()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in'))
		{
	        $from_date = @$this->input->post('from_date');
	        $to_date = @$this->input->post('to_date');     
	        $curl_data = array('from_date'=>$from_date,'to_date'=>$to_date);
	      	$curl = $this->link->hits('user-transcation-report-data', $curl_data);
            $curl = json_decode($curl, true); 
            $response['data'] = $curl['user_transcation_details'];
	    }else{
	    	 $response['status']='login_failure';
             $response['url']=base_url().'superadmin';
	    }
	    echo json_encode($response);
	}
	public function booking_reports()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in')) {
             $session_data = $this->session->userdata('parking_adda_superadmin_logged_in');
	        $this->load->view('super_admin/booking_reports');
    	} else {
            redirect(base_url().'superadmin');
        }
	}
	public function display_all_booking_report_data()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in'))
		{
	        $from_date = @$this->input->post('from_date');
	        $to_date = @$this->input->post('to_date');     
	        $curl_data = array('from_date'=>$from_date,'to_date'=>$to_date);
	      	$curl = $this->link->hits('booking-report-data', $curl_data);
            $curl = json_decode($curl, true);
             
            $response['data'] = $curl['booking_reports'];
	    }else{
	    	 $response['status']='login_failure';
             $response['url']=base_url().'superadmin';
	    }
	    echo json_encode($response);
	}
}