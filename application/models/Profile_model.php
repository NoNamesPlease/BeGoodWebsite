<?php
class Profile_model extends CI_Model{
	public function get_userdetails_by($field = array()){
		$this->db->select("u.id as uid, u.user, u.email, u.is_active, ud.*");
		$this->db->from(TBL_USERS." u");
		$this->db->join(TBL_USER_DETAILS." ud", 'u.id = ud.userid');
		$this->db->where($field);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function update_profile($uid, $update_data){
		$this->db->set($update_data);
		$this->db->where('userid', $uid);
		if($this->db->update(TBL_USER_DETAILS))
			return true;
		else
			return false;
	}
	
	public function add_userDetails($details){
		if($this->db->insert( TBL_USER_DETAILS, $details ))
			return true;
		else
			return false;
	}
	
}
?>