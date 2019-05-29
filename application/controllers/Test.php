<?php
defined('BASEPATH') OR exit('no direct access to script allowed');
class Test extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('Cafe_model', 'cafe');
		$this->load->model('Stamp_model', 'stamp');
	}
	
	public function checkAudio(){
		echo "test";
		exit;
	}
	
	public function index(){
		// $this->load->page_layout('page_test');
	}
	
	public function seepage($cafeSlug){
		//$this->load->page_layout('page_test');
		$where = array('url_slug' => $cafeSlug);
		$cafe_details = $this->cafe->get_cafe($where, 1);
		echo "SIZE : ".sizeof($cafe_details);
		if(sizeof($cafe_details) != 0){
			
			/* echo "<pre>";
				print_r($cafe_details);
			echo "</pre>"; */
			$this->session->set_userdata('stampfor', $cafe_details['ID']);
			$page_data['cafe'] = $cafe_details;
			$user = $this->session->userdata('bg_user');
			if(!empty($user['id'])){
				$lastten = $this->stamp->get_lastten(array(
					'userid' => $user['id'],
					'cafeid' => $cafe_details['ID']
				));				
				$page_data['user_stamps'] = $lastten;
			}
			
			/* for stamp screen */
			$CI = & get_instance();
			$user = $CI->session->userdata('bg_user');
			if(isset($user['user']) && $user['user'] != ""){
				$stampfor = $CI->session->userdata('stampfor');
				if(!empty($stampfor)){
					// To put the cafe image as bg image for redeem cafe screen
					$this->load->model('Stamp_model', 'stamp');
					$this->load->model('Cafe_model', 'cafe');
					$totalinTen = $this->stamp->get_lastten(array('userid' => $user['id'], 'cafeid' => $stampfor));
					$cafe_details = $this->cafe->get_cafe(array('ID' => $stampfor), 1);
					if(count($totalinTen) == 9)
						$page_data['bg_image'] = $cafe_details['image'];

					// END: To put the cafe image as bg image for redeem cafe screen
					$page_data['stampfor'] = $stampfor;
					$page_data['cafe_name'] = $cafe_details['name'];
					$page_data['url_slug'] = $cafe_details['url_slug'];
					//$this->load->page_layout('page_home', $page_data);
				}
				// else
					// redirect(BASE_URL.'dashboard', 'refresh');
			}else{
				redirect(BASE_URL.'login', 'refresh');
			}
			/* !- for stamp screen */
			
			$this->load->page_layout('page_vendor', $page_data);
		}
		else{
			$flash_error = '<strong>Error !</strong> Cafe/restaurant could not found.';
			$this->session->set_flashdata('flash_error', $flash_error);
			$this->load->page_layout('page_verified');
		}
		
	}
}
?>