<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Actions extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$CI = & get_instance();
		$user = $CI->session->userdata('bg_user');
		if(!isset($user['email']) || $user['user_type'] != 'admin' || $user['is_master'] != 1){
			echo "Access denied"; die;
		}
		$this->load->model('admin/Action_model', 'act');
		$this->load->model('signup_model', 'user_ac');
	}
	
	public function userdeactivate(){
		if(isset($_POST['userid']) && !empty($_POST['userid'])){
			if($this->act->suspend($_POST['userid'])){
				$status = 'Success';
				$sql = $this->db->last_query();
				// $msg = "Action performed";
				$msg = $sql;
			}
			else{
				$status = 'Failed';
				$msg = "Action failed";
			}
		}else{
			$status = 'Error';
			$msg = 'insufficient data';
		}
		echo json_encode(array( 'status' => $status, 'msg' => $msg));
		exit;
	}
	
	public function useractivate(){
		if(isset($_POST['userid']) && !empty($_POST['userid'])){
			if($this->act->activate($_POST['userid'])){
				$status = 'Success';
				$msg = "Action performed";
			}
			else{
				$status = 'Failed';
				$msg = "Action failed";
			}
		}else{
			$status = 'Error';
			$msg = 'insufficient data';
		}
		echo json_encode(array( 'status' => $status, 'msg' => $msg));
		exit;
		
	}
	
	public function activate_cafe(){
		if(isset($_POST['cafeid']) && !empty($_POST['cafeid'])){
			$cafe_key = $this->act->get_cafe_key($_POST['cafeid']);
			// if(sizeof($cafe_key) == 0 || $cafe_key['api_key'] == ''){
				// $status = 'Error';
				// $msg = 'Please save stamp key first in edit cafe screen.';
			// }else{
				$verify_result = $this->act->activatecafe($_POST['cafeid']);
				// echo "<pre>";
					// print_r($verify_result);
				// echo "</pre>";
				$status = $verify_result['status'];
				$msg = $verify_result['msg'];
				
			// }
		}else{
			$status = false;
			$msg = 'insufficient data';
		}
		echo json_encode(array( 'status' => $status, 'msg' => $msg));
		exit;
	}

	public function changeadminpass(){
		
		$ci =& get_instance();
		$user = $ci->session->userdata('bg_user');
		$status = false;
		$msg = 'Invalid access';
		$choice = $_POST['choice'];
		switch($choice){
			case 'password':
				if(isset($user['id']) && $user['user_type'] == 'admin'){
					if(isset($_POST['newpassword']) && !empty($_POST['newpassword'])){
						$password = MD5($_POST['newpassword']);
						if($this->user_ac->update_user(array('password' => $password), array('ID' => 1))){
							$status = true;
							$msg = 'Password Updated';
						}else
							$msg = 'Unable to update the password';
					}
				}
				break;
			case 'sound':
				$sound = $_POST['sound'];
				if(!empty(trim($this->input->get_post('sonicsound')))){
					$config['upload_path'] = './uploads/sounds/'.$sound;
					$config['allowed_types'] = 'ogg|mp3|wma|wav';
					$config['max_size'] = 1024 * 10;
					// $config['file_name'] = $sound;
					$filename = time().'_'.$_FILES[$sound]['name'];
					$config['file_name'] = $filename;
					
					$this->load->library('upload', $config);
					if(! $this->upload->do_upload($sound)){
						$msg = array('error' => $this->upload->display_errors());
					}else{
						$status = true;
						$msg = 'Sound file uploaded';
						update_option($sound, $filename);
					}
				}
				break;
			case 'freesound':
				break;
		}
		
		echo json_encode( array('status' => $status, 'msg' => $msg) );
	}
	
	public function verifycafe(){

	}
	
}
?>