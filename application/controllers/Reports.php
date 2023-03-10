<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	public function user_reports()
	{
		$this->load->view('super_admin/user_reports');
	}
	public function display_all_user_report_data()
	{
		if ($this->session->userdata('parking_adda_superadmin_logged_in'))
		{
			echo '<pre>'; print_r($_POST); exit;
			$from_date = $this->input->post('from_date');
			$to_date = $this->input->post('to_date');
			$curl_data=array(
				'from_date'=>$from_date,
				'to_date'=>$to_date
			);
			$curl = $this->link->hits('user-report-data',$curl_data);
        	$curl = json_decode($curl, true);
        	$response['data'] = $curl['user_data'];
		} else {
            $response['status']='login_failure';
            $response['url']=base_url().'superadmin';
        }
        echo json_encode($response);
	}
}