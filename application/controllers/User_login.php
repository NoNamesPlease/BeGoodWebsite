<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_login extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('admin/Login_model', 'user');
		$this->load->model('Signup_model', 'user_register');
		// $this->output->delete_cache();
	}
	
	public function index(){
/* 		if(!empty($_POST)){
 		echo "<pre>";
			print_r($_POST);
		echo "</pre>";
		} */
		redirectIfLoggedin();
		
		$this->form_validation->set_rules('email_phone', 'Email or Phone', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$data['social'] = 'none';
		$data['signup'] = 'none';
		$data['login'] = 'none';
		if($this->input->get_post('form'))
			$data[$this->input->get_post('form')] = 'block';
		else
			$data['social'] = 'social';	
		if($this->form_validation->run() == FALSE){
			// if(!empty($_POST)){ echo "in if"; exit; }
			$this->load->page_layout('page_login',$data);
		}else{
			// if(!empty($_POST)){ echo "in else"; exit; }
			$email_phone = trim($this->input->get_post('email_phone'));
			$password = trim($this->input->get_post('password'));
			
			if(!filter_var($email_phone, FILTER_VALIDATE_EMAIL) && is_numeric(str_replace(' ', '',$email_phone))){
				$phoneno = converttoPhone($this->input->get_post('email_phone'));
				// get user from details table
				// enable user login with email then phone no
				/* $user_details = $this->user_register->userbyphone(array('phoneno' => $phoneno));
				if(sizeof($user_details) != 0)
					$result = $this->user->check_user_by(array('ID' => $user_details['userid'])); */
				// END: enable user login with email then phone no
				$result = $this->user->check_user_by(array('user' => $phoneno));
			}else{			
				$result = $this->user->check_user($email_phone);
			}

			if(is_array($result) && sizeof($result) > 0)
			{	
				if($result['password'] == MD5($password))
				{
					if($result['verified'] == 1){
						if($result['is_active'] == 1){
							$this->session->set_userdata('bg_user', $result);
							redirect(BASE_URL, 'refresh');
							exit;
						}else{
							$flash_error = '<strong>Error !</strong> Your account is temporarily disabled. Please contact site admin to get it resolved. Thank you';
							$this->session->set_flashdata('flash_error', $flash_error);
							$this->load->page_layout('page_login', $data);
						}
					}else{
						$flash_error = '<strong>Error !</strong> Please verify your email account. You may have received the activation link in your email on the day of account creation';
						$this->session->set_flashdata('flash_error', $flash_error);
						$this->load->page_layout('page_login', $data);
					}
				}else{
					$flash_error = "<strong>Error ! </strong>Invalid Email Id and Password.";
					$this->session->set_flashdata('flash_error',$flash_error);					
					// redirect(BASE_URL.'login');
					$this->load->page_layout('page_login',$data);
				}	

			}else{
				$flash_error = "<strong>Error ! </strong> User is not registered or inactive.";
				$this->session->set_flashdata('flash_error',$flash_error);
				// redirect(BASE_URL.'login');
				$this->load->page_layout('page_login',$data);
			}
		}
	}
	
	public function signup(){
		redirectIfLoggedin();
		
		$data['social'] = 'none';
		$data['signup'] = 'block';
		$data['login'] = 'none';
		
		$this->form_validation->set_rules('email_phone', 'Email or Phone', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		if($this->form_validation->run() == FALSE){
			$this->load->page_layout('page_login', $data);
		}else{
			$is_phone = false;
			$is_email = false;
			$user_data = array(
				'email' => trim($this->input->get_post('email_phone')),
				'password' => md5($this->input->get_post('password')),
				'user' => trim($this->input->get_post('email_phone')),
				'user_type' => 'user'
			);
			$email = trim($this->input->get_post('email_phone'));
			$where = array('email' => $email);
			if(!filter_var($email, FILTER_VALIDATE_EMAIL) && is_numeric(str_replace(' ', '',$email))){
				// submitted is not an email, its a mobile number.
				unset($user_data['email']);
				$phoneno = converttoPhone($this->input->get_post('email_phone'));
				$where = array('phoneno' => $phoneno);
				$is_phone = true;
			}else if(filter_var($email, FILTER_VALIDATE_EMAIL))
				$is_email = true;
			
			if(!$is_phone && !$is_email){
				$flash_error = "<strong>Error ! </strong> Please enter valid email or phone number.";
				$this->session->set_flashdata('flash_error', $flash_error);
				$this->load->page_layout('page_login', $data);
			}else{
				// $pass = trim($this->input->get_post('password'));
				
				// $result = $this->user->check_user($email);
				if(!$is_phone){
					$result = $this->user->check_user_by($where);
				}
				else{
					$result = $this->user_register->userbyphone($where);
					if(sizeof($result) > 0)
						$result = $this->user->check_user_by(array('ID' => $result['userid']));
				}
				
				if(sizeof($result) > 0){
					if($result['verified'] == 0){ // registered but not verified
						if($is_phone){
							$result_details = $this->user_register->userbyphone($where);
							$page_data['userdetails'] = $result_details;
							$this->load->page_layout('page_submit_otp', $page_data);
						}else{
							$flash_error = '<strong>Error ! </strong> User with phone number already exists.';
							$this->session->set_flashdata('flash_error',$flash_error);
							$this->load->page_layout('page_login', $data);
						}
					}else{ //registered and verified
						$flash_error = '<strong>Error ! </strong> User with phone number already exists.';
						$this->session->set_flashdata('flash_error',$flash_error);
						$this->load->page_layout('page_login', $data);
					}
				}else{
					if($is_phone){
						$result = json_decode($this->user_register->register_userby_phone($user_data, $phoneno));
						if($result->status){
							$userdetails = $this->user_register->getUserDetails($result->uid);
							$page_data['userdetails'] = $userdetails;
							$page_data['referrer'] = 'register';
							$this->load->page_layout('page_submit_otp', $page_data);
						}else{
							$this->session->set_flashdata('flash_error',$result->msg);
							$this->load->page_layout('page_login', $data);
						}
						/*
						if($uid && is_numeric($uid)){
							//$page_data['uid'] = $uid;
							$userdetails = $this->user_register->getUserDetails($uid);
							$page_data['userdetails'] = $userdetails;
							$page_data['referrer'] = 'register';
							$this->load->page_layout('page_submit_otp', $page_data);
						}else if($uid && !is_numeric($uid)){
							// Error from twilio so delete the user
							// $this->user_register->deleteUser()
							$this->session->set_flashdata('flash_error',$uid);
							$this->load->page_layout('page_login', $data);
						}else{
							$flash_error = '<strong>Error ! </strong> Unable to register user.';
							$this->session->set_flashdata('flash_error',$flash_error);
							$this->load->page_layout('page_login', $data);
						}*/
						// create 6 digit OTP and send it to phone number
						// register user with OTP stored in key field with MD5 and provide user field to enter OTP
						// Check OTP along with the phone number and activate user according to check result.
					}else{
						$result = json_decode($this->user_register->register_user($user_data, $email));
						if($result->status){
							$flash_success = '<strong>Success !</strong> Successfully registered. Verification link has been sent to your email address. Please verify to start using BeGood service. Thank You';
							$this->session->set_flashdata('flash_success', $flash_success);
							$this->load->page_layout('page_login', $data);
						}else{
							$this->session->set_flashdata('flash_error', $result->msg);
							$this->load->page_layout('page_login', $data);
						}
						/*
						if($this->user_register->register_user($user_data, $email)){
							if($this->user_register->send_mail($email)){
								$flash_success = '<strong>Success !</strong> Successfully registered. Verification link has been sent to your email address. Please verify to start using BeGood service. Thank You';
								$this->session->set_flashdata('flash_success', $flash_success);
								$this->load->page_layout('page_login', $data);
							}else{
								$flash_error = '<strong>Error !</strong> Could not send mail this time, please try back later. Thank You';
								$this->session->set_flashdata('flash_success', $flash_success);
								$this->load->page_layout('page_login', $data);
							}
						}*/
					}
				}
			}// invalid number or email
		}
	}
	
	public function confirm_email($key = null){
		if(!empty($key) && null !== $key){
			if($this->user_register->verify_user($key)){
				$flash_msg = '<h3><strong>Congratulations !</strong> Your email address is successfully verified. Now you can redeem free coffee after every 10 cup of coffee on individual coffee bar.</h3>';
				$flash_msg .= '<h3><a href="'.BASE_URL.'/login">Click here</a> to login</h3>';
				$this->session->set_flashdata('flash_success', $flash_msg);
				$this->load->page_layout('page_verified');
			}else{
				$flash_msg = '<h3><strong>OOPS... </strong> It seems that the verification link has been expired. Please contact BeGood admin to get this resolved.. Sorry for this trouble.. </h3>';
				$this->session->set_flashdata('flash_error', $flash_msg);
				$this->load->page_layout('page_verified');
			}
		}
	}
	
	public function verifyotp($key = null){
		// OTP verification via ajax call 
		$userid = !empty($_POST['uid']) ? $_POST['uid'] : false;
		if(!$userid){
			$status = false;
			$msg = 'Unauthenticated request';
		}else{
			// process OTP check
			$otp = $_POST['smsotp'];
			$userdata = $this->user->check_user_by(array('ID' => $userid));
			if(MD5($otp) == $userdata['key']){
				//OTP verified
				if($_POST['referrer'] == 'register'){
					$set = array(
						'verified' => 1,
						'key' => ''
					);
					
					if($verify_user = $this->user_register->update_user($set, array('key' => MD5($otp)))){
						$status = true;
						$msg = 'Successfully verified';
						//verified success
					}else{
						$status = false;
						$msg = 'Unable to verify at the moment, please try again later';
						//not able to update record please try again later
					}
				}else{
					// redirect to forgot password link 
					redirect(BASE_URL.'resetpassword/'.$userdata['key'], 'refresh');
					exit;
				}
			}else{
				$status = false;
				$msg = 'OTP mismatch';
			}
		}
		echo json_encode(array('status' => $status, 'msg' => $msg));
	}
	
	public function sendnewotp(){
		$uid = $_POST['userid'];
		if(empty($uid)){
			$status = false;
			$msg = 'Unauthenticate access';
		}else{
			// send new OTP
			$userdata = $this->user_register->getUserDetails($uid);
			if(sizeof($userdata) > 0){
				$response = $this->user_register->send_otp($uid, $userdata['phoneno']);
				if($response && is_numeric($response)){
					$status = true;
					$msg = 'New OTP has been sent to your registered mobile number';
				}else{
					$status = false;
					$msg = 'OTP send failed, please try again later.';
				}

			}else{
				$status = false;
				$msg = 'Record not found';
			}
		}
		echo json_encode(array( 'status' => $status, 'msg' => $msg));
	}
}
?>