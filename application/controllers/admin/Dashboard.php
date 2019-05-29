<?php
class Dashboard extends CI_Controller{
	public function __construct(){
		parent::__construct();
		// $this->load->model('admin/Dashboard_model', 'dash');
	}
	public function index(){
		$data = 12;
		$this->load->layout('admin/dashboard_page', $data);
	}
	
	// Admin Logout
	public function logout(){
		//clear session
		$this->session->unset_userdata('bg_user');
		$this->session->unset_userdata('user_tab');
		redirect(BASE_URL.'admin'); exit;
	}
}
?>