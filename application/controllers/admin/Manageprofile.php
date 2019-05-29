<?php
defined('BASEPATH') OR exit('No direct access to script allowed');

class Manageprofile extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->load->layout('admin/manage_profile');
	}
}
?>