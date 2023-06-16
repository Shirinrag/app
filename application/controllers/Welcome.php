<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		// $data =  token_get();
		// echo '<pre>'; print_r($data); exit;
		$this->load->view('welcome_message');
	}
	public function add_new_data()
	{	
		 $curl = $this->link->hits('get-new-data', array(), '', 0);
         $curl = json_decode($curl, true);  
         $data['data'] = $curl['new_data'];
		$this->load->view('super_admin/add_new_data',$data);
	}
	
	public function save_new_data(){
	    $message = $this->input->post('message');
	    if(empty($message)){
	        $response['message'] = "Place Name is Required";
	        $response['status'] = 'failure';
	    }else{
	        $curl_data = array(
	            'message'=>$message
	            );
	        	$curl = $this->link->hits('add-new-data', $curl_data);
                $curl = json_decode($curl, true);
	           if ($curl['status']==1) {
                    $response['status']='success';
                } else {
                    $response['status'] = 'failure';
                     $response['error'] = array("message" => $curl['message']);
                }	            
	    }
	    echo json_encode($response);
	}
	
	public function truncate_table(){
	     $curl = $this->link->hits('truncate-table', array(), '', 0);
         $curl = json_decode($curl, true);  
         echo json_encode($curl);
	} 
	
	function drop_table()
	{
	    $forge->dropTable('tbl_new_data', true);
	}
}
