<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insta_Authentication extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('admin/Login_model', 'user');
		$this->load->model('Signup_model', 'user_ac');
	}
	
	public function index(){
		if(isset($_GET['code']) && $_GET['code'] != '') {
			
			$auth_response = $this->instagram_api->authorize($_GET['code']);
/* pr($auth_response);
$this->instagram_api->access_token = $auth_response->access_token;
// $auth_response1 = $this->instagram_api->get_user_recent();
// $auth_response1 = $this->instagram_api->user_search($auth_response->user->username);
$auth_response1 = $this->instagram_api->get_user_recent($auth_response->user->id);
pr($auth_response1);
die; */
			if($auth_response){
				$user = $this->user->check_user_by(array('user' => $auth_response->user->username));
				if(sizeof($user) == 0){
					// user logged in for first time, so insert into database.
					$user_data = array(
						'user' => $auth_response->user->username,
						'email' => $auth_response->user->username.'@instagram.com',
						'user_type' => 'user',
						'verified' => 1,
						'oauth_provider' => 'Instagram',
						'oauth_uid' => $auth_response->user->id,
						'profile_link' => 'https://www.instagram.com/'.$auth_response->user->username
					);
					$result = json_decode($this->user_ac->register_user($user_data, $auth_response->user->username));
					if($result->status){
						$profile_data = array(
							'userid' => $result->uid,
							'firstname' => $auth_response->user->full_name,
							'user_avtar' => $auth_response->user->profile_picture
						);
						$this->user_ac->add_userDetails($profile_data);
						$user = $this->user->check_user_by(array('user' => $auth_response->user->username));
						$this->session->set_userdata('bg_user', $user);
					}
				}else{
					$this->session->set_userdata('bg_user', $user);
				}
				// Set up session variables containing some useful Instagram data
				$this->session->set_userdata('instagram-token', $auth_response->access_token);
				$this->session->set_userdata('instagram-username', $auth_response->user->username);
				$this->session->set_userdata('instagram-profile-picture', $auth_response->user->profile_picture);
				$this->session->set_userdata('instagram-user-id', $auth_response->user->id);
				$this->session->set_userdata('instagram-full-name', $auth_response->user->full_name);
				
				redirect(BASE_URL, 'refresh'); exit;
			}else{
				$flash_error = '<Strong>Error !</strong> Sorry but could not recognize this instagram account. Could you please try back after few mins?';
				$this->session->set_flashdata('flash_error', $flash_error);
				redirect(BASE_URL.'verified', 'refresh'); exit;
			}
			
		} else {
			
			// There was no GET variable so redirect back to the homepage
			redirect(BASE_URL, 'refresh'); exit;
			
		}
	}
}
?>