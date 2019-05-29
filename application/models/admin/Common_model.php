<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Common_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	
	public function is_user_active($user_id){
		$this->db->select("id");
        $this->db->where("id",$user_id);
        $this->db->limit(1);
        $query = $this->db->get(TBL_USERS);
        return $query->row('id');
	}
	
	public function get_users($where = array()){
		$this->db->select("u.id as uid, u.user, u.email, u.is_active, u.verified, u.profile_link, ud.* ");
		$this->db->from(TBL_USERS." u");
		$this->db->join(TBL_USER_DETAILS." ud", 'u.id = ud.userid');
		$where['user_type'] = 'user';
		if(!empty($where))
			$this->db->where($where);
		$query = $this->db->get();
		return $query->result_array();
	}

}
?>