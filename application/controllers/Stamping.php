<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include APPPATH.'libraries/snowshoe_inc/OAuthSimple.php';
class Stamping extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('Stamp_model', 'stamp');
		$this->load->model('Cafe_model', 'cafe');
		// $app_key = "606a1d4f4ba846bf793c"; // put your app key here
		// header("Location: https://beta.snowshoestamp.com/applications/client/".$app_key."/");
	}
	
	public function index(){
		$CI =& get_instance();
		$user = $CI->session->userdata('bg_user');
		if(empty($user) || !isset($user['id']) || empty($user['id']) || empty($_POST['cid'])){
			$status = false;
			$msg = 'Invalid stamp call';
		}else{
			$cid = $_POST['cid'];
			$stamp_data = array(
				'userid' => $user['id'],
				'cafeid' => $cid,
				'scan_count' => 1,
			);
			// $this->stamp->make_stamp();
		}
	}
	
	public function stampscan(){
		
		if(!isset($_POST['data']) || empty($_POST['data'])){
			echo json_encode(array('status' => false, 'msg' => 'Access unauthenticated'));
			exit;
		}
		$stampfor = $this->session->userdata('stampfor'); // returns cafe id
		$appkeys = $this->cafe->getKey($stampfor);
		if(empty($appkeys['app_key']) || empty($appkeys['app_secret'])){
			redirect(BASE_URL.'cafe', 'redirect'); exit;
		}	


	
			
		// Get APP key and App secret for the cafe
		$app_key = $appkeys['app_key']; // put app key here
		$app_secret = $appkeys['app_secret']; // put app secret here
		$data = $_POST['data'];
		
		$JSONResponse = $this->processData($data, $app_key, $app_secret);
		$response = json_decode($JSONResponse, true);

		if(isset($response) && is_array($response) && array_key_exists("stamp", $response))
			$serial = $response['stamp']['serial'];
		else
			$serial = false;
				
		if($serial){
			$user = $this->session->userdata('bg_user');
			$uid = $user['id'];
			// $cid = 2;
			$cid = $this->session->userdata('stampfor');
			$stamp_data = array(
				'userid' => $uid,
				'cafeid' => $cid
			);
			if($this->stamp->make_stamp($stamp_data)){
				$status = true;
				$stamps = count($nostamps = $this->stamp->get_lastten($stamp_data));
				$msg = 'Successfully stamped';
			}
			else{
				$status = false;
				$stamps = false;
				$msg = 'Please put the stamp again and hold it for while';
			}
		}else{
			$status = false;
			$stamps = false;
			$msg = "Stamp not found";
		}
		// echo $JSONResponse;
		echo json_encode(array('status' => $status, 'stamps' => $stamps, 'msg' => $msg));
	}
	
	public function processData($data, $app_key, $app_secret) {
        $data = array("data" => $data);
        // $app_key = $this->app_key;
        // $app_secret = $this->app_secret;

        $oauth = new OAuthSimple();
        $result = $oauth->sign(
            Array("path" => "http://beta.snowshoestamp.com/api/v2/stamp",
                  "parameters" => $data,
                  "action" => "POST",
                  "signatures" => Array("consumer_key" => $app_key,
                                        "shared_secret" => $app_secret)));

        $header = $oauth->getHeaderString();
        $ch = curl_init($result['signed_url']);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: ".$header));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

        $return = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return $return;
    }
	
	// Ajax call when user choose to plant the tree 
	public function plantTree(){
		// echo "done"; exit;
		$user = $this->session->userdata('bg_user');
		$uid = $user['id'];
		$cid = $this->session->userdata('stampfor');
		$stamp_data = array(
			'userid' => $uid,
			'cafeid' => $cid
		);
		if($this->stamp->make_stamp($stamp_data, true)){
			$status = true;
			// $stamps = count($nostamps = $this->stamp->get_lastten($stamp_data));
			$msg = 'Tree planting process started. See your email for more details.';
			// send mail to user and cafe admin
			$mail['subject'] = 'Tree Planting process started';
			$mail['message'] = '<br>Your tree planting process has been started. Thanks for helping us in saving CO2 and making better tomorrow. Also thanks for being a part of BeGood Team <br><br> Thanks,<br>BeGood Team';
			// check if user is registered with email or phone and send message accordingly.
			send_mailOrsms($uid, $mail);			
		}
		else{
			$status = false;
			// $stamps = false;
			$msg = 'Please check if you reached to the free redeem';
		}
		echo json_encode(array('status' => $status, 'msg' => $msg));
		exit;
	}
}
?>