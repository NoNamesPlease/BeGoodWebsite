<?php
require APPPATH.'libraries/twilio-php-master/Twilio/autoload.php';
use Twilio\Rest\Client;

/* function isAdminLoggedIn(){
	$CI =& get_instance();
	
	if(isset($CI->session->userdata['fz_admin_user']['fz_admin_logged_in'])){
		$admin = $CI->session->userdata['fz_admin_user']['fz_admin_logged_in'];
		
	}
} */
function send_mail($to = '', $data = []) {
    if (empty($to) || empty($data)) {
        return false;
    }
    $ci = &get_instance();
    $ci->load->library('email');

    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.gmail.com';
    $config['smtp_port'] = '465';
	$config['smtp_user'] = 'example@gmail.com'; // Please change the email with your live email
	$config['smtp_pass'] = 'example123'; // Please change the password with above gmail account password
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['mailtype'] = 'html';
    $config['validation'] = TRUE;

    $ci->email->initialize($config);

    $ci->email->to($to);
    $ci->email->from('noreply@begood.com', 'Team BeGood');
    $ci->email->subject($data['subject']);
    $ci->email->message($data['message']);
    if($ci->email->send())
		return true;
	else
		return false;
}

/*
 * name : option name to be updated
 * value: New value to be updated
 */
function update_option($name, $value){
	$CI =& get_instance();
	$CI->db->select('value as option_value');
	$CI->db->from(TBL_OPTION);
	$CI->db->where('name', $name);
	$query = $CI->db->get();
	$query = $query->row_array();
	if(count($query) == 0){
		$option_data = array(
			'name' => $name,
			'value' => $value
		);
		if($CI->db->insert(TBL_OPTION, $option_data))
			return true;
		else
			return false;
	}else{
		$CI->db->set('value', $value);
		$CI->db->where('name', $name);
		if($CI->db->update(TBL_OPTION))
			return true;
		else
			return false;
	}
}

function get_option($name){
	$CI =& get_instance();
	$CI->db->select('value as option_value');
	$CI->db->from(TBL_OPTION);
	$CI->db->where('name', $name);
	$query = $CI->db->get();
	$query = $query->row_array();

	if(count($query) != 0)
		return $query['option_value'];
	else
		return false;
	/* echo "<pre>";
		print_r($query);
	echo "</pre>"; */
	// return $query->value;
	// return $query->row_array();
}

function redirectIfLoggedin(){
	$CI = & get_instance();
	$user = $CI->session->userdata('bg_user');
	if(isset($user['user']) && $user['user'] != ""){
		redirect(BASE_URL, 'refresh');
		exit;
	}
}

//generate SMS OTP
function get_new_otp($length = 10){
	return substr(str_shuffle(str_repeat($x='0123456789', ceil($length/strlen($x)) )),1,$length);
}

function converttoPhone($str){
	return trim(str_replace(' ', '', str_replace('+', '', str_replace('-', '', $str))));
}

function cafeInfo($cid, $info = 'name'){
	$ci = &get_instance();
	$ci->db->select('*');
	$ci->db->from(TBL_CAFE);
	$ci->db->where('ID', $cid);
	$query = $ci->db->get();
	$result = $query->row_array();
	
	if(sizeof($result) != 0){
		switch($info){
			case 'name':
				$value = $result['name'];
				break;
			case 'imageurl':
				$value = BASE_URL.'uploads/cafe'.$result['image'];
				break;
			case 'cafeurl':
				$value = BASE_URL.'cafe/'.$result['url_slug'];
				break;
			case 'address':
				$value = $result['address'].' '.$result['city'].' '.$result['postalcode'];
				break;
			default:
				$value = $result['name'];
		}
		return $value;
	}else
		return false;
}

function pr($arr){
	echo "<pre>";
		print_r($arr);
	echo "</pre>";
}

function rudr_instagram_api_curl_connect( $api_url ){
	$connection_c = curl_init(); // initializing
	curl_setopt( $connection_c, CURLOPT_URL, $api_url ); // API URL to connect
	curl_setopt( $connection_c, CURLOPT_RETURNTRANSFER, 1 ); // return the result, do not print
	curl_setopt( $connection_c, CURLOPT_TIMEOUT, 20 );
	$json_return = curl_exec( $connection_c ); // connect and get json data
	curl_close( $connection_c ); // close connection
	return json_decode( $json_return ); // decode and return
}

function is_user_logged_in(){
	$CI = & get_instance();
	$user = $CI->session->userdata('bg_user');
	if(isset($user['user']) && $user['user'] != "")
		return true;
	else
		return false;
}

function send_mailOrsms($uid, $msg){
	$CI =& get_instance();
	$CI->load->model('admin/Common_model', 'db_model');
	$user = $CI->db_model->get_users(array('u.id' => $uid))[0];
	
	if(filter_var($user['email'], FILTER_VALIDATE_EMAIL)){
		$msg['message'] = 'Dear '.$user['firstname'].',<br>'.$msg['message'];
		send_mail($user['email'], $msg);
	}else if(!empty($user['phoneno'])){
		send_sms($user['phoneno'], $msg['message']);
	}
	//pr($user);
}

function send_sms($phone, $msg){
	$sid = 'ACf1146d6a44c6b661b264555dab5d22d1';
	$token = '218d957280e53121cf5d6acb7bc002b6';
	$client = new Client($sid, $token);

	// Use the client to do fun stuff like send text messages!
	try{
		$sms = $client->messages->create(
			// the number you'd like to send the message to
			'+'.$phone,
			array(
				// A Twilio phone number you purchased at twilio.com/console
				'from' => '+17752772032',
				// the body of the text message you'd like to send
				'body' => $msg
			)
		);
		return true;
	}catch(Exception $e){
		return $e->getMessage();
	}
}

?>