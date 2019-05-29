<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_pass extends CI_Controller{
	public $data = array();
	// var $data['reset_pass'] = 'none';
	public function __construct(){
		parent::__construct();
		$this->load->model('admin/Login_model', 'user');
		$this->load->model('Signup_model', 'user_ac');
		$this->data['form_fp'] = 'none';
		$this->data['form_rp'] = 'none';
	}
	
	public function index(){
		$this->data['form_fp'] = 'block';
		$this->data['key'] = '';
		$this->form_validation->set_rules('email_phone', 'Email or Phone', 'trim|required|xss_clean');
		
		if($this->form_validation->run() == FALSE){
			$this->load->page_layout('page_forgotpass', $this->data);
		}else{
			$email_phone = trim($this->input->get_post('email_phone'));
			$is_phone = false;
			if(!filter_var($email_phone, FILTER_VALIDATE_EMAIL) && is_numeric(str_replace(' ', '',$email_phone))){
				// is phone number
				$is_phone = true;
				$phoneno = converttoPhone($this->input->get_post('email_phone'));
				$where = array('phoneno' => $phoneno);
				$result = $this->user_ac->userbyphone($where);
				if(sizeof($result) > 0)
					$result = $this->user->check_user_by(array('ID' => $result['userid']));
				
			}else{
				$result = $this->user->check_user($email_phone);
			}
			
			if(sizeof($result) > 0){
				if(!$is_phone){
					// $this->user_ac->send_mail($email_phone, FALSE);
					if($this->user_ac->send_mail($email_phone, FALSE)){
						$flash_msg = 'Password reset link has been sent to your registered email address. You can visit that link and reset the password. Thank you.';
						$this->session->set_flashdata('flash_success',$flash_msg);
						redirect('forgotpass/verified', 'refresh'); exit;
						// $this->load->page_layout('page_verified');
					}else{
						$flash_error = '<strong>Error !</strong> Something went wrong, please try again letter.';
						$this->session->set_flashdata('flash_error', $flash_error);
						redirect('forgotpass', 'refresh'); exit;
						// $this->load->page_layout('page_forgotpass', $this->data);
					}
				}else{
					// if phone number
					if($this->user_ac->send_otp($result['id'], $phoneno)){
						// show OTP submit screen
						$userdetails = $this->user_ac->getUserDetails($result['id']);
						$page_data['userdetails'] = $userdetails;
						$page_data['referrer'] = 'forgotpass';
						$this->load->page_layout('page_submit_otp', $page_data);
					}
				}
			}else{
				$flash_error = '<strong>Error !</strong> No user found registered with this email addres.';
				$this->session->set_flashdata('flash_error', $flash_error);
				redirect('forgotpass', 'refresh'); exit;
				// $this->load->page_layout('page_forgotpass', $this->data);
			}
		}
	}
	public function verified(){
		$this->load->page_layout('page_verified');
	}
	public function resetpassword($key = null){
		// echo "key : ".$key; die;
		if(isset($key) && !empty($key)){
			$result = $this->user_ac->check_link($key);
			if(sizeof($result) > 0){
				// loaded the reset password link, so load the reset password form
				$this->data['form_rp'] = 'block';
				$this->data['key'] = $key;
				// redirect('resetpassword/'.$key, 'refresh'); exit;
				$this->load->page_layout('page_forgotpass', $this->data);
			}else{
				$flash_error = '<strong>Error !</strong> Password reset link either expired or invalid';
				$this->session->set_flashdata('flash_error', $flash_error);
				redirect('forgotpass/verified', 'refresh'); exit;
				// $this->load->page_layout('page_verified');
			}
		}else{ //if($this->input->get_post('resetkey') !== null && !empty($this->input->get_post('resetkey'))){
			// new password submitted. reset password for user account.
			$key = $this->input->get_post('resetkey');
			$password = trim($this->input->get_post('password'));
			$data = array(
				'password' => MD5($password),
				'key' => ''
			);
			$where = array('key' => $key);
			if($this->user_ac->update_user($data,$where)){
				$flash_success = '<strong>Congratulations !</strong> Your password has been successfully reset';
				$this->session->set_flashdata('flash_success', $flash_success);
				redirect('forgotpass/verified', 'refresh'); exit;
				// $this->load->page_layout('page_verified', $this->data);
			}
			else{
				$flash_error = '<strong>Error !</strong> Could not reset password. Please try again later or contact site admin';
				$this->session->set_flashdata('flash_error', $flash_error);
				// redirect('forgotpass', 'refresh'); exit;
				$this->load->page_layout('page_forgotpass', $this->data);
			}
		}
	}
}
?>