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
			$data[] = $_POST;
	        $from_date = $data[0]['from_date'];
	        $to_date = $data[0]['to_date'];     
	        $curl_data = array('from_date'=>$from_date,'to_date'=>$to_date);
	      	$user_details = $this->link->hits('user-report-data', $curl_data);
            $user_details = json_decode($user_details, true); 
            $data2 = array();
        	$no = @$_POST['start'];
	            foreach ($user_details['user_details'] as $user_details_key => $user_details_row) {  
	            	$no++;
	                $sub_array = array();
	                $sub_array[] = $no;
	                $sub_array[] = $user_details_row['firstName']." ".$user_details_row['lastName'];
	                $sub_array[] = $user_details_row['userName'];
	                $sub_array[] = $user_details_row['email'];
	                $sub_array[] = $user_details_row['phoneNo'];
	                $sub_array[] = $user_details_row['car_number'];                
	               
	                $data2[] = $sub_array;
	            }
	          $output = array("draw" => @$_POST['draw'], "recordsTotal" => $user_details['count'], "recordsFiltered" => $user_details['count_filtered'], "data" => $data2);
	        echo json_encode($output);
	    }
	}

}