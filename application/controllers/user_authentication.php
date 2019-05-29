<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_Authentication extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('admin/Login_model', 'user');
		$this->load->model('Signup_model', 'user_ac');
		$this->load->library('facebook');
	}

	public function index() {

		// Include two files from google-php-client library in controller
		include_once APPPATH . "libraries/google-api-php-client-2.2.2/vendor/autoload.php";

		// Store values in variables from project created in Google Developer Console
		$client_id = '999173610916-6n1g1r3br9ojmr4o5idr8j67nuej4f1b.apps.googleusercontent.com';
		$client_secret = 'pctN1BuuRkjBetW10UFSKz-f';
		$redirect_uri = BASE_URL.'user_authentication';
		$simple_api_key = 'AIzaSyA-fiziZ98SYg88tsX-wGBEc7EYBv9KUTA';

		// Create Client Request to access Google API
		$client = new Google_Client();
		$client->setApplicationName("BeGood");
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($redirect_uri);
		$client->setDeveloperKey($simple_api_key);
		$client->addScope("https://www.googleapis.com/auth/userinfo.email");

		// Send Client Request
		$objOAuthService = new Google_Service_Oauth2($client);

		// Add Access Token to Session
		if (isset($_GET['code'])) {
			$client->authenticate($_GET['code']);
			$_SESSION['access_token'] = $client->getAccessToken();
			header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
		}

		// Set Access Token to make Request
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
			$client->setAccessToken($_SESSION['access_token']);
		}

		// Get User Data from Google and store them in $data
		if ($client->getAccessToken()) {
			$userData = $objOAuthService->userinfo->get();
			$data['userData'] = $userData;
			$_SESSION['access_token'] = $client->getAccessToken();
			// echo "user email : ".$userData->email;
			$user = $this->user->check_user(trim($userData->email));
			// echo "size : ".sizeof($result); die;
			if(sizeof($user) == 0){
				$user_data = array(
					'user' => $userData->email,
					'email' => $userData->email,
					'user_type' => 'user',
					'verified' => 1,
					'oauth_provider' => 'GooglePlus',
					'oauth_uid' => $userData->id,
					'profile_link' => $userData->link
				);
				$result = json_decode($this->user_ac->register_user($user_data, $userData->email));
				if($result->status){
					// $this->session->set_userdata('bg_user', $user_data);
					$user_details = array(
						'userid' => $result->uid,
						'firstname' => $userData->given_name,
						'lastname' => $userData->family_name,
						'user_avtar' => $userData->picture
					);
					$this->user_ac->add_userDetails($user_details);
					$user = $this->user->check_user(trim($userData->email));
					$this->session->set_userdata('bg_user', $user);
					// redirect(BASE_URL, 'refresh');
				}
			}else{
				$this->session->set_userdata('bg_user', $user);
			}
		} else {
			$authUrl = $client->createAuthUrl();
			$data['authUrl'] = $authUrl;
			redirect($authUrl, 'refresh');
		}
		// Load view and send values stored in $data
		redirect(BASE_URL, 'refresh'); exit;
		// $this->load->view('google_authentication', $data);
	}

	public function fb_authentication(){
		$this->facebook->login();
	}
	
	// Unset session and logout
	public function logout() {
		unset($_SESSION['access_token']);
		redirect(base_url());
	}
}
?>