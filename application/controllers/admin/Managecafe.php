<?php
defined('BASEPATH') OR exit('No Direct Access to script allowed');
class Managecafe extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('Cafe_model', 'cafe');
		$this->load->model('admin/Action_model', 'act');
		
	}
	public function index(){
		// $data = 12;
	
		$result = $this->cafe->get_cafe();
		// echo "<pre>";
			// print_r($result);
		// echo "</pre>"; die;
		$data['cafes'] = (array)$result;
		$this->load->layout('admin/Manage_cafe', $data);
	}
	
	public function edit_cafe($cid){
		// print_r($_POST);
		$CI = & get_instance();
		$user = $CI->session->userdata('bg_user');
		if(!isset($user['email']) || $user['user_type'] != 'admin' || $user['is_master'] != 1){
			redirect(BASE_URL, 'refresh'); exit;
		}else{
			$where = array('ID' => $cid);
			$cafe_details = $this->cafe->get_cafe($where);
			$data['cafe'] = $cafe_details[0];
			$stampKey = $this->cafe->getKey($cafe_details[0]['ID']);
			$data['stampkey'] = $stampKey['app_key'];
			$data['appsecret'] = $stampKey['app_secret'];
			
			/* echo "<pre>";
				print_r($data);
			echo "</pre>"; die; */
			
			$this->load->layout('admin/edit_cafe', $data);
		}
	}
	
	public function updateCafe(){
		// echo '<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyA-fiziZ98SYg88tsX-wGBEc7EYBv9KUTA"></script>';
		$CI = & get_instance();
		$user = $CI->session->userdata('bg_user');
		if(!isset($user['email']) || $user['user_type'] != 'admin' || $user['is_master'] != 1){
			$status = 'Error';
			$msg = "You do not have access to update cafe details";
			exit;
		}
		
		$cafename = trim($this->input->get_post('cafename'));
		$email = trim($this->input->get_post('email'));
		$website = trim($this->input->get_post('website'));
		$contactno = trim($this->input->get_post('phoneno'));	
		$address = trim($this->input->get_post('address'));
		$city = trim($this->input->get_post('city'));
		$state = trim($this->input->get_post('state'));
		$pincode = trim($this->input->get_post('pincode'));
		$cid = $this->input->get_post('cid');
		$verify = $this->input->get_post('verify');
		
		// Get latitude/longitude from the address
		$gaddress = urlencode($address.' '.$city.' '.$state.' '.$pincode.' new zealand');
		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$gaddress."&key=AIzaSyA-fiziZ98SYg88tsX-wGBEc7EYBv9KUTA";
 
		// get the json response
		$resp_json = file_get_contents($url);
     
		// decode the json
		$resp = json_decode($resp_json, true);
		// response status will be 'OK', if able to geocode given address 
		if($resp['status']=='OK'){
			// get the important data
			$lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
			$longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
			$formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";	
		}
		// ENd get latlong
		
		// echo "<pre>";
			// print_r($_FILES);
		// echo "</pre>"; die;
		if(!empty(trim($this->input->get_post('cafeimage')))){
			$config['upload_path'] = './uploads';
			$config['allowed_types'] = 'jpg|png';
			$config['max_size'] = 1024 * 10;
			$config['file_name'] = 'cafe'.$_FILES['cafepic']['name'];
			// $config['max_width'] = '1024';
			// $config['max_height'] = '768';
			$this->load->library('upload', $config);
			
			if(! $this->upload->do_upload('cafepic')){
				$error = array('error' => $this->upload->display_errors());
				$this->load->page_layout('page_registerCafe.php', $error);
			}else{
				$image_url = BASE_URL.'uploads/'.'cafe'.$_FILES['cafepic']['name'];
				$img_name = $_FILES['cafepic']['name'];
				// $data = array('upload_data' => $this->upload->data());
				// $this->load->view('upload_success', $data);
			}
		}
		// insert in to database 
		$cafedata = array(
			'name' => $cafename,
			'address' => $address,
			'city' => $city,
			'state' => $state,
			'postalcode' => $pincode,
			'phoneno' => $contactno,
			'website' => $website,
			'email' => $email
		);
		if( isset($img_name) )
			$cafedata['image'] = $img_name;
		
		$cafedata['latitude'] = isset($lati) && !empty($lati) ? $lati : '';
		$cafedata['longitude'] = isset($longi) && !empty($longi) ? $longi : '';
		
		//update cafe details
		$key = trim($this->input->get_post('app_key'));
		$appsecret = trim($this->input->get_post('app_secret'));
		$keydata = array(
			'app_key' => $key,
			'app_secret' => $appsecret
		);
		if($this->cafe->updateCafe($cafedata, $cid, $keydata)){
			//if($this->act->activatecafe($cid)){
				$status = 'Success';
				$msg = 'Cafe details updated';
			//}
			if($verify == 1){
				$verify_result = $this->act->activatecafe($cid);
				if($verify_result['status']){
					$status = 'Success';
					$msg .= 'and marked as verified';
				}else{
					$status = 'Error';
					$msg .= 'but could not marked as verified';
				}
			}
		}else{
			$status = 'Error';
			$msg = 'Could not save cafe details';
		}
		echo json_encode(array('status' => $status, 'msg' => $msg));
		exit;
	}
	
}
?>