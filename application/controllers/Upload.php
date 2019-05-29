<?php
defined('BASEPATH') OR exit('No direct access to script allowed');
class Upload extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('Profile_model', 'profile');
	}
	
	public function index(){
		
	}
	
	public function upload_prof_img(){
		$status = "";
		$msg = "";
		$file_element_name = "profile_image";
		$CI = &get_instance();
		$userdata = $CI->session->userdata('bg_user');
		
		if(empty($_POST['title'])){
			$status = 'error';
			$msg = 'Please enter title';
		}
		
		if($status != 'error'){
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
					$this->profile->update_profileImg($userdata['id'], $imgUrl);
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
		echo json_encode(array('status' => $status, 'msg' => $msg, 'url' => $imgData));
	}
	
	public function files(){
		$files = $this->files_model->get_files();
		$this->load->view('files', array('files' => $files));
	}
}
?>