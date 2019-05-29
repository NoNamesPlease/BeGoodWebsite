<?php
//require APPPATH.'libraries/twilio-php-master/Twilio/autoload.php';
use Twilio\Rest\Client;

class Signup_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	public function register_user($data, $email){
		//$data['key'] = md5($this->generate_key());
		// return $this->db->insert(TBL_USERS, $data);
		
		if($this->db->insert(TBL_USERS, $data)){
			$inserted_uid = $this->db->insert_id();
			if($this->db->insert(TBL_USER_DETAILS, array('userid' => $inserted_uid))){
			// if($this->db->insert(TBL_USERS, $data)){
				$uid = $inserted_uid;
				if(!isset($data['verified'])){
					if($this->send_mail($email)){
						$status = true;
						$msg = 'Inserted and email sent';
						// return true;
					}
					else{
						$status = false;
						$msg = 'Could not send the email on provided email, Please check the email is correct';
						$this->deleteUser($uid);
						// return false;
					}
				}else{
					$status = true;
					$msg = 'inserted';
					// return $this->db->insert_id();
				}
			}else{
				$uid = null;
				$status = false;
				$msg = 'Unable to create a user. Please try again later';
				$this->db->where('userid', $inserted_uid);
				$this->db->delete(TBL_USER_DETAILS);
				// return false;
			}
		}else{
			$uid = null;
			$status = false;
			$msg = 'Unable to create a user. Please try again later';
			// return false;
		}
		return json_encode(array('uid' => $uid, 'status' => $status, 'msg' => $msg));
	}

	public function generate_key($length = 10){
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}
	
	public function register_userby_phone($data, $phone){
		/* if(isset($data['phpneno'])){
			$phone = $data['phoneno'];
			unset($data['phoneno']);
		}else
			$phone = ''; */
		if($this->db->insert(TBL_USERS, $data)){
			$inserted_uid = $this->db->insert_id();
			if($this->db->insert(TBL_USER_DETAILS, array('userid' => $inserted_uid, 'phoneno' => $phone))){
			// if($this->db->insert(TBL_USERS, $data)){
				if(!isset($data['verified'])){
					$opt_status = $this->send_otp($inserted_uid, $phone);
					if($opt_status == $inserted_uid){
						$uid = $inserted_uid;
						$status = true;
						$msg = 'Inserted OTP sent';
						// return $inserted_uid;
					}
					else{
						$uid = $inserted_uid;
						$status = false;
						$msg = 'Failed to send SMS on given number. Make sure you have provided number with countrycode';
						$this->deleteUser($uid);
						// return $opt_status;
					}
				}else{					
					$uid = $this->db->insert_id();
					$status = true;
					$msg = 'Inserted';
					// return $this->db->insert_id();
				}
			}else{
				$uid = null;
				$status = false;
				$msg = 'Unable to register user.';
				$this->db->where('userid', $inserted_uid);
				$this->db->delete(TBL_USER_DETAILS);
				// return false;
			}
		}
		else{
			$uid = null;
			$status = false;
			$msg = 'Unable to register user.';
			// return false;
		}
		return json_encode(array('uid' => $uid, 'status' => $status, 'msg' => $msg));
	}
	
	public function send_mail($email, $register = TRUE){
		$key = MD5($this->generate_key());
		$this->db->set('key', $key);
		$this->db->where('email', $email);
		if($this->db->update(TBL_USERS)){
			$from = 'admin@begood.com';
			
			// get Key for user
			// $query = $this->db->query('SELECT `key` FROM '.TBL_USERS.' WHERE email = "'.$email.'" LIMIT 1');
			// $row = $query->row();
			// $key = $row->key;
			
			if($register){
				$maildata['subject'] = 'Verify your email address';
				$maildata['message'] = 'Dear User,<br><br> Please click on the below activation link to verify your email address<br><br>
				<a href="'.BASE_URL.'confirm_email/'.$key.'">'.BASE_URL.'confirm_email/'.$key.'</a><br><br>Thanks';
			}else{
				$maildata['subject'] = 'Password reset link';
				$maildata['message'] = 'Dear customer,<br><br> Please click on the below link to reset your password for the account registered with email : '.$email.'<br><br>
				<a href="'.BASE_URL.'resetpassword/'.$key.'">'.BASE_URL.'resetpassword/'.$key.'</a><br><br>Thanks';
			}
			
			//config email settings

			if(send_mail($email, $maildata)){
				return true;
			}else{
				return false;
			}
		}else{
			$flash_error = '<strong>Error !</strong> No user found with the given email address';
			$this->session->set_flashdata('flash_error', $flash_error);
			return false;
		}
	}
	
	public function send_otp($uid, $phone){
		$otp = get_new_otp(6);
		//echo "OTP sent is : ".$otp;
		$otpmail['subject'] = 'Your SMS OTP is '.$otp;
		$otpmail['message'] = 'submit your OTP to form and activate your account';
		
		// need to replace email with Twilio sms status
		
		$key = MD5($otp);
		$this->db->set('key', $key);
		$this->db->where('ID', $uid);
		if($this->db->update(TBL_USERS)){
			
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
						'body' => "Your one time password for Be Good account is ".$otp
					)
				);
				// if($sms->status == 'sent'){
				//if(send_mail('lp@narola.email', $otpmail) || 1==1){
				return $uid;
			}catch(Exception $e){
				return $e->getMessage();
			}
		}else{
			return false;
		}
	}
	
	public function verify_user($key){
		$data = array(
			'verified' => 1,
			'key' => ''
		);
		$this->db->set($data);
		$this->db->where('key', $key);
		if($this->db->update(TBL_USERS)){
			return true;
		}else{
			return false;
		}
	}
	
	public function update_user($set, $where = array()){
		$this->db->set($set);
		$this->db->where($where);
		if($this->db->update(TBL_USERS)){
			return true;
		}else{
			return false;
		}
	}
	
	public function check_link($key){
		$this->db->select('key');
		$this->db->from(TBL_USERS);
		$this->db->where('key' , $key);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function add_userDetails($data){
		$this->db->insert(TBL_USER_DETAILS, $data);
	}
	
	// Get user by phone number from user details table
	public function userbyphone($where = array('1' => '1')){
		$this->db->select('*');
		$this->db->from(TBL_USER_DETAILS);
		$this->db->where($where);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	// Get user details by user id
	public function getUserDetails($uid){
		$this->db->select('*');
		$this->db->from(TBL_USER_DETAILS);
		$this->db->where('userid', $uid);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	// delete garbage user
	public function deleteUser($uid){
		$this->db->where('userid', $uid);
		if($this->db->delete(TBL_USER_DETAILS)){
			$this->db->where('ID', $uid);
			$this->db->delete(TBL_USERS);
		}
	}
}
?>
