<?php
defined('BASEPATH') OR exit('No direct access to script allowed');

class User_dashboard extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('Stamp_model', 'stamp');
		//$this->load->Cafe
		if(!is_user_logged_in()){
			redirect(BASE_URL.'login', 'refresh');
		}
	}
	
	public function index(){
		$userData = $this->session->userdata('bg_user');
		$cupssaved = $this->stamp->get_total(array(
			'userid' => $userData['id'],
			'cup_state' => 0
		));
		$co2saved = $this->stamp->get_total(array(
			'userid' => $userData['id'],
			'cup_state' => 2
		));
		$page_data['cupsSaved'] = $cupssaved;
		$page_data['co2saved'] = $co2saved;
		$this->load->page_layout('page_userDashboard', $page_data);
	}
}
?>