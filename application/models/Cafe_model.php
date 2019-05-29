<?php
class Cafe_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	function register($data){
		// create url-slug from cafe name and address
		$url_slug = preg_replace('/[^a-zA-Z\s]/', '', $data['address']);
		$url_slug = str_replace(' ', '-', strtolower(trim($data['name']).'-'.trim($url_slug)));
		$data['url_slug'] = $url_slug;
		if( $this->db->insert( TBL_CAFE, $data )){
			return true;
		}else{
			return false;
		}
	}
	
	public function get_cafe($where = array(), $limit = 99999){
		$this->db->select("*");
		$this->db->from(TBL_CAFE);
		if(!empty($where))
			$this->db->where($where);
		$this->db->limit($limit);
		$query = $this->db->get();
		if($limit == 1)
			return $query->row_array();
		else
			return $query->result_array();
	}
	
	public function updateCafe($cafedata, $cid, $key = array()){
		// create url-slug from cafe name and address
		$url_slug = preg_replace('/[^a-zA-Z\s]/', '', $cafedata['address']);
		$url_slug = str_replace(' ', '-', strtolower(trim($cafedata['name']).'-'.trim($url_slug)));
		$cafedata['url_slug'] = $url_slug;
		$this->db->set($cafedata);
		$this->db->where('ID', $cid);
		if($this->db->update(TBL_CAFE)){
			if(count($key) != 0){
				$get_key = $this->getKey($cid);
				if(sizeof($get_key) != 0){
					/* $newKey = array(
						'app_key' => $key
					); */
					if($this->updateKey($key, $cid))
						return true;
					else
						return false;
				}else{
					/* $keydata = array(
						'cafe_id' => $cid,
						'app_key' => $key
					); */
					$key['cafe_id'] = $cid;
					if($this->insertKey($key))
						return true;
					else
						return false;
				}
			}else
				return true;
		}
		else
			return false;
		
	}
	
	public function getKey($cid){
		$this->db->select('*');
		$this->db->where('cafe_id', $cid);
		$this->db->from(TBL_STAMP_KEY);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function insertKey($data){
		if($this->db->insert(TBL_STAMP_KEY, $data))
			return true;
		else
			return false;
		
	}
	
	public function updateKey($newKey = array(), $cid){
		$this->db->set($newKey);
		$this->db->where('cafe_id' , $cid);
		if($this->db->update(TBL_STAMP_KEY)){
			return true;
		}
		else
			return false;
	}
	
	public function get_nearbyCafe($lat, $long){
		// $lat = '-36.856987';
		// $long = '174.749345';

		$this->db->select(" * , (3956 * 2 * ASIN(SQRT( POWER(SIN(( $lat - latitude) *  pi()/180 / 2), 2) +COS( $lat * pi()/180) * COS(latitude * pi()/180) * POWER(SIN(( $long - longitude) * pi()/180 / 2), 2) ))) as distance");
		$this->db->from(TBL_CAFE);
		$this->db->where('verified', 1);
		$this->db->having('distance <= 10');
		$this->db->order_by('distance');
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	/* public function get_cafe_details($cid){
		$this->db->select('*');
		$this->db->from()
	} */
	
	public function getStampcredentials($cafeid){
		$this->db->select('app_key');
		$this->db->from(TBL_STAMP_KEY);
		$this->db->where('cafe_id', $cafeid);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function getcafeByaddress($address = array()){
		$where = '';
		foreach($address as $addr){
			$where .= 'name LIKE "%'.$addr.'%" OR ';
			$where .= 'address LIKE "%'.$addr.'%" OR ';
			$where .= 'city LIKE "%'.$addr.'%" OR ';
		}
		$where = trim(trim($where), 'OR');
		$this->db->select('*');
		$this->db->from(TBL_CAFE);
		$this->db->where($where);
		$this->db->where('verified', 1);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function getCafeids(){
		$this->db->select('ID');
		$this->db->from(TBL_CAFE);
		$query = $this->db->get()->result_array();
		$ids = array_column($query,"ID");
		return $ids;
	}
}
?>