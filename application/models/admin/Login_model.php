<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	
	//Check admin login
	function check_admin($email){
		$this->db->select("id, user, email, password, user_type, is_master, is_active, verified ");
		$this->db->from(TBL_USERS);
		$this->db->where('email', $email);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function check_user($email){
		$this->db->select("id, user, email, password, user_type, is_active, verified ");
		$this->db->from(TBL_USERS);
		$this->db->where('email', $email);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function check_user_by($field = array()){
		$this->db->select("id, user, email, password, user_type, is_active, key, verified");
		$this->db->from(TBL_USERS);
		$this->db->where($field);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}
}

?>