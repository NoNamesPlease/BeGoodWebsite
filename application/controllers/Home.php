<?php
defined('BASEPATH') OR exit('No direct access to script allowed');
class Home extends CI_Controller{
	public function __construct(){
		parent::__construct();
		// $this->load->model('Home');
	}
	
	public function index(){
		$this->load->view('Home');
	}
}
?>