<?php
defined('BASEPATH') OR exit("No Direct Access to script allowed");

class Manageuser extends CI_Controller{
	public function __construct(){
		parent::__construct();
		// $this->load->model('Manage_user');
		$this->load->model('Common_model', 'user');
	}
	
	public function index(){
		$data = 12;
		$result = $this->user->get_users();
		// echo "<pre>";
			// print_r($result);
		// echo "</pre>"; die;
		$users['users'] = (array)$result;
		$this->load->layout('admin/manage_user', $users);
	}
}
?>