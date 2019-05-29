<?php
class Action_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Cafe_model', 'cafe');
	}
	
	public function suspend($uid){
		$this->db->set('is_active', 0);
		$this->db->where('ID', $uid);
		if($this->db->update(TBL_USERS))
			return true;
		else
			return false;
	}
	
	public function activate($uid){
		$this->db->set('is_active', 1);
		$this->db->where('ID', $uid);
		if($this->db->update(TBL_USERS))
			return true;
		else
			return false;
	}
	
	public function get_cafe_key($cid){
		$this->db->select('app_key, app_secret');
		$this->db->from(TBL_STAMP_KEY);
		$this->db->where('cafe_id', $cid);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function activatecafe($cid){
		$cafe_key = $this->get_cafe_key($cid);
		if(sizeof($cafe_key) == 0 || $cafe_key['app_key'] == '' || $cafe_key['app_secret'] == ''){
			$result['status'] = false;
			$result['msg'] = 'Please save stamp key first in edit cafe screen.';
		}else{
			$this->db->set('verified', 1);
			$this->db->where('ID', $cid);
			if($this->db->update(TBL_CAFE)){
				$where = array('ID' => $cid);
				$cafe_email = $this->cafe->get_cafe($where, 1);
				
				$mail['subject'] = 'Your cafe/restaurant has been verified';
				$mail['message'] = '<p> Congratulations! Your Cafe has been successfully verified.</p>';
				$mail['message'] .= '<p> We have assigned the uniqye stamp key to your account and now you are ready start stamping</p> <p> Please contact site admin for any further inquiry</p>';
				send_mail($cafe_email['email'],$mail);
				$result['status'] = true;
				$result['msg'] = 'Cafe account successfully verified and activated';
			}
			else{
				$result['status'] = false;
				$result['msg'] = 'Could not mark as verified please try again';
			}
		}
		return $result;
	}
	
}
?>