<?php
defined('BASEPATH') OR exit('No direct access to script allowed');

class Sitepages extends CI_Controller{
	
	protected $CI;
	public function __construct(){
		parent::__construct();
		$this->CI =& get_instance();
	}
	
	public function index(){
		$data['bg_image'] = FRNT_ASSETS.'images/card-bg-1.jpg';
		$data['contents'] = get_option('content_ourstory');

		//echo "test : ".$this->instagram_api->instagram_login();
		// $authorization_url = 'https://api.instagram.com/oauth/access_token';
		// $auth_response = $this->instagram_api->__apiCall($authorization_url, "client_id=" . $this->CI->config->item('instagram_client_id') . "&client_secret=" . $this->CI->config->item('instagram_client_secret') . "&grant_type=authorization_code");
// echo "on our story page";
// pr($auth_response);
// die;
		$this->load->page_layout('page_ourstory', $data);

	}
	
}
?>