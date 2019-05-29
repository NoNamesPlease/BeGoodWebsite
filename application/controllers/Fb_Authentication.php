<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Fb_Authentication extends CI_Controller
{
    function __construct() {
        parent::__construct();
        
        // Load facebook library
        $this->load->library('facebook');
        
        //Load user model
        $this->load->model('admin/Login_model', 'user');
		$this->load->model('Signup_model', 'user_ac');
    }
    
    public function index(){
        $userData = array();
        
        // Check if user is logged in
        if($this->facebook->is_authenticated()){
            // Get user facebook profile details
            $fbUserProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,locale,cover,picture');
        
			//$user = $this->user->check_user_by(array('user' => $auth_response->user->username));
            $user = $this->user->check_user_by(array('user' => $fbUserProfile["email"]));
            
			if(!is_array($user) || sizeof($user) == 0){
				// user logged in for first time, so insert into database.
				$user_data = array(
					'user' => $fbUserProfile['email'],
					'email' => $fbUserProfile['email'],
					'user_type' => 'user',
					'verified' => 1,
					'oauth_provider' => 'Facebook',
					'oauth_uid' => $fbUserProfile['id'],
                    'created' => (new DateTime())->format('c')
					///'profile_link' => $fbUserProfile['link']
				);
				$result = json_decode($this->user_ac->register_user($user_data, $fbUserProfile['email']));
				if($result->status){
					$profile_data = array(
						'userid' => $result->uid,
						'firstname' => $fbUserProfile['first_name'],
						'lastname' => $fbUserProfile['last_name'],
						'user_avtar' => $fbUserProfile['picture']['data']['url']
					);
					$this->user_ac->add_userDetails($profile_data);
					$user = $this->user->check_user_by(array('email' => $fbUserProfile['email']));
					$this->session->set_userdata('bg_user', $user);
				}
			}else{
				$this->session->set_userdata('bg_user', $user);
			}
			
            // Preparing data for database insertion
            /* $userData['oauth_provider'] = 'facebook';
            $userData['oauth_uid'] = $fbUserProfile['id'];
            $userData['first_name'] = $fbUserProfile['first_name'];
            $userData['last_name'] = $fbUserProfile['last_name'];
            $userData['email'] = $fbUserProfile['email'];
            $userData['gender'] = $fbUserProfile['gender'];
            $userData['locale'] = $fbUserProfile['locale'];
            $userData['cover'] = $fbUserProfile['cover']['source'];
            $userData['picture'] = $fbUserProfile['picture']['data']['url'];
            $userData['link'] = $fbUserProfile['link']; */
            
            // Insert or update user data
//$userID = $this->user->check_user($userData['email']);

            // Get logout URL
            $data['logoutURL'] = $this->facebook->logout_url();
        }else{
            // Get login URL
            $data['authURL'] =  $this->facebook->login_url();
			redirect($data['authURL'], 'refresh');
        }
		redirect(BASE_URL, 'refresh'); exit;
        // Load login & profile view
        // $this->load->view('user_authentication/index',$data);
    }

    public function logout() {
        // Remove local Facebook session
        $this->facebook->destroy_session();
        // Remove user data from session
        $this->session->unset_userdata('bg_user');
        // Redirect to login page
        redirect('/user_authentication');
    }
}