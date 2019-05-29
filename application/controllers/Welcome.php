<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data['social'] = 'block';
		$data['signup'] = 'none';
		$data['login'] = 'none';
		// $data['authUrl'] = $authUrl;
		$CI = & get_instance();
		$user = $CI->session->userdata('bg_user');
		if(isset($user['user']) && $user['user'] != ""){
			// $stampfor = $CI->session->userdata('stampfor');
			// if(!empty($stampfor)){
				// To put the cafe image as bg image for redeem cafe screen
				/*
				$this->load->model('Stamp_model', 'stamp');
				$this->load->model('Cafe_model', 'cafe');
				$totalinTen = $this->stamp->get_lastten(array('userid' => $user['id'], 'cafeid' => $stampfor));
				$cafe_details = $this->cafe->get_cafe(array('ID' => $stampfor), 1);
				if(count($totalinTen) == PAID_CUPS)
					$page_data['bg_image'] = $cafe_details['image'];

				// END: To put the cafe image as bg image for redeem cafe screen
				$page_data['stampfor'] = $stampfor;
				$page_data['cafe_name'] = $cafe_details['name'];
				$page_data['url_slug'] = $cafe_details['url_slug'];
				// $this->load->page_layout('page_userDashboard', $page_data);
				*/
				redirect(BASE_URL.'cafe', 'refresh');
			// }
			// else
				// redirect(BASE_URL.'cafe', 'refresh');
		}else{
			$this->load->page_layout('page_login', $data);
		}
	}
}