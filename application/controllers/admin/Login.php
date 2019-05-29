<?php
defined('BASEPATH') OR exit("No direct script access allowed");

class Login extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('admin/Login_model', 'user');
	}
	
	public function index(){
		// echo "hello";
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE){
			$this->load->view('admin/login_page');
		}else{
			$email = trim($this->input->get_post('email'));
			$password = trim($this->input->get_post('password'));
			
			$result = $this->user->check_admin($email);
			/* echo "<pre>";
				print_r($result);
			echo "</pre>"; die; */
			if(sizeof($result) > 0){
				if($result['password'] == MD5($password)){
					$this->session->set_userdata('bg_user', $result);
					//echo "Login success";
					redirect(BASE_URL.$result['user_type'].'/dashboard', 'refresh');
					exit;
				}else{
					$flash_error = "<strong>Error !</strong> Invalid Email id and Password.";
					$this->session->set_flashdata('flash_error', $flash_error);
					
					redirect('admin/login');
				}
			}else{
				$flash_error = "<strong>Error !</strong> Invalid Admin user";
				$this->session->set_flashdata('flash_error', $flash_error);
				
				redirect('admin/login');
			}
		}
	}
}
?>