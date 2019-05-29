<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cards extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('Cafe_model', 'cafe');
		$this->load->model('Stamp_model', 'stamp');
	}
	
	public function index(){
		// $data = 12;
		$data['cafes'] = $this->cafe->get_cafe( array(
			'verified' => 1
		));
		//print_r($data['cafes']);
		
		if(is_user_logged_in()){ // show cafe stamp progress in circle
			$user = $this->session->userdata('bg_user');
			$cafes = $this->cafe->getCafeids();
			$user_stamps = array();
			foreach($cafes as $id){
				$user_stamps[$id] = count($this->stamp->get_lastten(array('cafeid' => $id, 'userid' => $user['id'])));
			}
			// pr($user_stamps);
			// echo $this->db->last_query();
			// die;
			$data['user_stamps'] = $user_stamps;
		}
		
		$this->load->page_layout('page_cards', $data);
	}
	
	
	//search cafe
	public function search_vendor(){
		$page_data['radius_distance'] = 10;
		
		//get list of nearby cafes
		$lat = '-36.856987';
		$long = '174.749345';
		$result = $this->cafe->get_nearbyCafe($lat, $long);
		$page_data['nearby'] = $result;
		$this->load->page_layout('page_search_vendor', $page_data);
	}


	public function retrieveCafes(){
		$data['cafes'] = $this->cafe->get_cafe( array(
			'verified' => 1
		));

		echo json_encode($data);
	}
	
	// for search by address AJAX function
	public function cafebyaddress(){
		if(!isset($_POST['address']) || empty(trim($_POST['address']))){
			$status = false;
			$msg = 'Invalid call';
		}else{
			$address = trim($_POST['address']);
			$address = explode(' ', $address);
			$result = $this->cafe->getcafeByaddress($address);
			if(sizeof($result) != 0){
				ob_start();
				foreach($result as $cafe){
				?>
				<li class="result-li">
					<a href="<?php echo cafeInfo($cafe['ID'], 'cafeurl')?>">
						<span class="imp-wrap">
							<img src="<?php echo cafeInfo($cafe['ID'], 'imageurl') ?>" alt="">
						</span>
						<span class="content">
							<h4><?=$cafe['name']?></h4>
							<p class="inter"><?php echo $cafe['address'].' '.$cafe['city'].' '.$cafe['postalcode'] ?></p>
							<p class="distance">0.1km</p>
						</span>
					</a>
				</li>
				<?php
				}
				$status = true;
				$msg = ob_get_clean();
			}else{
				$status = true;
				$msg = 'no cafe found';
			}
		}
		echo json_encode(array('status' => $status, 'msg' => $msg));
	}
}
?>