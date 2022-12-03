<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superadmin extends CI_Controller {

	public function index()
	{
		$this->load->view('super_admin/login');
	}
	public function dashboard()
	{
		$this->load->view('super_admin/dashboard');
	}
	public function profile()
	{
		$this->load->view('super_admin/profile');
	}
	public function add_roles()
	{
		$this->load->view('super_admin/add_role');
	}
	public function user()
	{
		$this->load->view('super_admin/add_user');
	}
	public function add_admin()
	{
		$this->load->view('super_admin/add_admin');
	}
	public function booking_history()
	{
		$this->load->view('super_admin/booking_history');
	}
}