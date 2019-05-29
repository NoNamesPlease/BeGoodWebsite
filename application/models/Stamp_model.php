<?php

class Stamp_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	
	public function make_stamp($data, $plant_tree = false){
		// if this one is free or not
		$curr_count = $this->get_lastten($data);
		
		if($plant_tree && count($curr_count) == PAID_CUPS)
			$data['cup_state'] = 2;
		else if($plant_tree && count($curr_count) != PAID_CUPS)
			return false;
		else if(!$plant_tree && count($curr_count) == PAID_CUPS)
			$data['cup_state'] = 1;
		else
			$data['cup_state'] = 0;

		if($this->db->insert(TBL_STAMP, $data))
			return true;
		else
			return false;
	}
	
	// returns userid and cafeid of the cups stamped after last free redeemed cup
	public function get_lastten($where = array()){
		$lastfree = $this->get_lastfree($where);
/* 		echo "<pre>";
			print_r($lastfree);
		echo "</pre>"; */
		// echo "last free : ".$lastfree['datetime']; die;
		if(isset($lastfree) && sizeof($lastfree) > 0){
			$where2 = 'datetime > "'.$lastfree['datetime'].'"';
		}else
			$where2 = "1 = 1";
		
		$this->db->select('userid, cafeid');
		$this->db->from(TBL_STAMP);
		if(!empty($where))
			$this->db->where($where);
		$this->db->where($where2);
		$query = $this->db->get();
		// example query : SELECT `userid`, `cafeid` FROM `cup_scan` WHERE `userid` = '37' AND `cafeid` = '2' AND `datetime` > `2019-01-07` `18:25:05`
		// OR  SELECT `userid`, `cafeid` FROM `cup_scan` WHERE `userid` = '37' AND `cafeid` = '2' AND 1 = 1 
		
		return $query->result_array();
	}
	
	// returns the datetime of last free redeemed cup
	public function get_lastfree($where = array()){
		if(!empty($where)){
			$this->db->select('datetime');
			$this->db->from(TBL_STAMP);
			$this->db->where($where);
			$this->db->where( '(cup_state = 1 OR cup_state = 2)' );
			// $this->db->or_where('cup_state', 2);
			$this->db->order_by("datetime", "desc");
			$this->db->limit(1);
			//SELECT `datetime` FROM `cup_scan` WHERE `userid` = '37' AND `cafeid` = 2 AND `cup_state` = 0 AND `cup_state` = 1 ORDER BY `datetime` DESC LIMIT 1
			$query = $this->db->get();
			return $query->row_array();
		}
	}
	
	public function get_total($where = array()){
		$this->db->select('userid, cafeid');
		$this->db->where($where);
		$this->db->from(TBL_STAMP);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_timeline($uid){
		$this->db->select('cs.cafeid, cs.datetime, cs.cup_state, c.*');
		$this->db->from(TBL_STAMP. ' cs');
		$this->db->join(TBL_CAFE." c", "cs.cafeid = c.ID");
		$this->db->where('cs.userid', $uid);
		$this->db->order_by('cs.ID', 'desc');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	/* public function get_stamps(){
		
	} */
	
	/* public function free_check($uid, $cid){
		
	} */
}
?>