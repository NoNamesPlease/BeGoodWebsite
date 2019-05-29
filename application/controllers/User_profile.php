<?php
defined('BASEPATH') OR exit('NO direct script access allowed');

class User_profile extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		
		if(empty($this->session->userdata('bg_user'))){
			redirect(BASE_URL.'login'); exit;
		}			
		$this->load->model('Profile_model', 'profile');
		$this->load->model('admin/Login_model', 'user');
		$this->load->model('Stamp_model', 'stamp');
	}
	
	public function index(){
		//check if user is logged in
		//print_r($this->session->userdata('bg_user')); die;
		if(!empty($this->session->userdata('bg_user'))){
			//get profile data from model
			$userData = $this->session->userdata('bg_user');
			$data['userdata'] = $userData;
			
			$userDetails = $this->profile->get_userdetails_by(array('u.email' => $userData['email']));
			$cupssaved = $this->stamp->get_total(array(
				'userid' => $userData['id'],
				'cup_state' => 0
			));
			$cupsclaimed = $this->stamp->get_total(array(
				'userid' => $userData['id'],
				'cup_state' => 1
			));
			$co2saved = $this->stamp->get_total(array(
				'userid' => $userData['id'],
				'cup_state' => 2
			));
			$timeline = $this->stamp->get_timeline($userData['id']);

			//if(sizeof($userDetails) > 0){
			$data['userDetails'] = $userDetails;
			$data['cupsSaved'] = $cupssaved;
			$data['cupsClaimed'] = $cupsclaimed;
			$data['timeline'] = $timeline;
			$data['co2saved'] = $co2saved;
			
			$this->load->page_layout('page_user_profile', $data);
			//}
		}else{
			redirect(BASE_URL.'login'); exit;
		}
	}
	
	public function edit_profile(){
		$userData = $this->session->userdata('bg_user');
		$data['userdata'] = $userData;
		$userDetails = $this->profile->get_userdetails_by(array('u.email' => $userData['email']));

		if(sizeof($userDetails) == 0){ // user details is not there so insert it first.
			$details = array(
				'userid' => $userData['id']
			);
			$this->profile->add_userDetails($details);
			$this->edit_profile();
		}else{
			$data['userDetails'] = $userDetails;
			$this->load->page_layout('page_edit_profile', $data);
		}
	}
	
	public function update_profile(){
		$status = "";
		$msg = "";
		$file_element_name = "profile_image";
		$CI = &get_instance();
		$userdata = $CI->session->userdata('bg_user');
		$imgUrl = '';
		$imgData = '';
		$updated_data = array();
		$update_data = array('firstname', 'lastname', 'phoneno');
		$status = 'success';
		$msg = 'Profile updated';
		foreach($update_data as $updata){
			if(empty($_POST[$updata])){
				$status = 'error';
				$msg = 'Please enter '.$updata;
			}else
				$updated_data[$updata] = trim($_POST[$updata]);
		}
		
		// if($status != 'error'){
		if(!empty($_FILES['profile_image']['name'])){
			$config['upload_path'] = './uploads';
			$config['allowed_types'] = 'jpg|png';
			$config['max_size'] = 1024 * 5;
			// $config['encrypt_name'] = TRUE;
			$config['file_name'] = 'avatar'.MD5($userdata['id']);
			$imgExt = explode('.', $_FILES['profile_image']['name'])[count(explode('.', $_FILES['profile_image']['name'])) - 1];
			
			$this->load->library('upload', $config);
			$imgpath = './uploads/';
			$imgname = 'avatar'.MD5($userdata['id']).'.'.$imgExt;
			$imaUrl = '';
			if(file_exists( $imgpath.$imgname ))
				rename($imgpath.$imgname, $imgpath.'temp/'.$imgname);
			// else
				// echo "not exit"; die;
			if(!$this->upload->do_upload($file_element_name)){
				$status = 'error';
				$msg = $this->upload->display_errors();
			}else{
				$data = $this->upload->data();
				// $file_id = $this->file_model->insert_file($data['file_name'], $_POST['title']);
				if($data['file_name']){
					$status = 'success';
					$msg = 'Uploaded...';
					
					$imgData = file_get_contents($_FILES['profile_image']['tmp_name']);
					
					$imgUrl = BASE_URL.'uploads/'.$imgname;
					$imgData = "data:image/png;base64,".base64_encode($imgData);
					unlink($imgpath.'temp/'.$imgname);
					
				}else{
					//unlink($data['full_path']);
					rename($imgpath.'temp/'.$imgname, $imgpath.$imgname);
					$status = 'error';
					$msg = 'Something went wrong, please try again later';
				}
			}
			@unlink($_FILES[$file_element_name]);
		}
		if(!empty($imgUrl))
		$updated_data['user_avtar'] = $imgUrl;
		if($this->profile->update_profile($userdata['id'], $updated_data))
			echo json_encode(array('status' => $status, 'msg' => $msg, 'url' => $imgData));
		else
			echo json_encode(array('status' => 'error', 'msg' => 'Failed to update data'));
		exit;
	}
	
	public function logout(){
		$this->session->unset_userdata('bg_user');
		unset($_SESSION['access_token']);
		redirect(BASE_URL); exit;
	}
}
?>