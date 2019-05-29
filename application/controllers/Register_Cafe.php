<?php
defined('BASEPATH') OR exit('No direct access to script allowed');

class Register_Cafe extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('Cafe_model', 'cafe');
		$this->load->model('Stamp_model', 'stamp');
	}
	
	public function index(){
		$this->form_validation->set_rules('cafename', 'Cafe Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('cafeemail', 'Email', 'trim|valid_email|required|xss_clean');
		$this->form_validation->set_rules('contactno', 'Contact No', 'trim|required|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
		// $this->form_validation->set_rules('cafepic', 'Cafe Image', 'required');
		// $this->form_validation->set_rules('state', 'State', 'required|xss_clean');
		
		if($this->form_validation->run() == FALSE){
			$this->load->page_layout('page_registerCafe');
		}else{
			$cafename = trim($this->input->get_post('cafename'));
			$email = trim($this->input->get_post('cafeemail'));
			$website = trim($this->input->get_post('website'));
			$contactno = trim($this->input->get_post('contactno'));	
			$address = trim($this->input->get_post('address'));
			$city = trim($this->input->get_post('city'));
			$state = trim($this->input->get_post('state'));
			$pincode = trim($this->input->get_post('pincode'));
			// echo "<pre>";
				// print_r($_FILES);
			// echo "</pre>"; die;
			$config['upload_path'] = './uploads';
			$config['allowed_types'] = 'jpg|png';
			$config['max_size'] = 1024 * 10;
			$config['file_name'] = 'cafe'.$_FILES['cafepic']['name'];
			// $config['max_width'] = '1024';
			// $config['max_height'] = '768';
			$this->load->library('upload', $config);
			
			if(! $this->upload->do_upload('cafepic')){
				$error = array('error' => $this->upload->display_errors());
				$this->load->page_layout('page_registerCafe.php', $error);
			}else{
				$image_url = BASE_URL.'uploads/'.'cafe'.$_FILES['cafepic']['name'];
				// $data = array('upload_data' => $this->upload->data());
				// $this->load->view('upload_success', $data);
			}
			
			// insert in to database 
			$cafedata = array(
				'name' => $cafename,
				'address' => $address,
				'city' => $city,
				'state' => $state,
				'postalcode' => $pincode,
				'phoneno' => $contactno,
				'image' => $_FILES['cafepic']['name'],
				'website' => $website,
				'email' => $email
			);
			
			if($this->cafe->register($cafedata)){
				//send success mail
				$mail['subject'] = 'Cafe registered and under review for verification';
				$mail['message'] = '<p>Congratulations ! Your cafe/restaurant is successfully registered with the BeGood. Please allow us some time to verify details provided and generate the unique stamp key for you so customer can start stamping at you.</p>';
				$mail['message'] .= '<p>You will receive a notification mail when your cafe/restaurant is verified and active on BeGood</p><p>Thanks,</p><p>BeGood Team</p>';
				$this->session->set_flashdata('flash_success', $mail['message']);
				send_mail($email, $mail);
				$this->load->page_layout('page_verified');
			}else{
				$this->load->page_layout('page_registerCafe.php', $error);
			}
		}
	}
	
	public function cafe_page($cafeSlug){
		// $cafe = str_replace('-',' ',$cafe);
		$where = array('url_slug' => $cafeSlug);
		$cafe_details = $this->cafe->get_cafe($where, 1);
		
		if(sizeof($cafe_details) != 0){
			
			/* echo "<pre>";
				print_r($cafe_details);
			echo "</pre>"; */
			$this->session->set_userdata('stampfor', $cafe_details['ID']);
			$page_data['cafe'] = $cafe_details;
			$user = $this->session->userdata('bg_user');
			if(!empty($user['id'])){
				$lastten = $this->stamp->get_lastten(array(
					'userid' => $user['id'],
					'cafeid' => $cafe_details['ID']
				));				
				$page_data['user_stamps'] = $lastten;
			}
			
			/* for stamp screen */
			$CI = & get_instance();
			$user = $CI->session->userdata('bg_user');
			if(isset($user['user']) && $user['user'] != ""){
				$stampfor = $CI->session->userdata('stampfor');
				if(!empty($stampfor)){
					// To put the cafe image as bg image for redeem cafe screen
					$this->load->model('Stamp_model', 'stamp');
					$this->load->model('Cafe_model', 'cafe');
					$totalinTen = $this->stamp->get_lastten(array('userid' => $user['id'], 'cafeid' => $stampfor));
					$cafe_details = $this->cafe->get_cafe(array('ID' => $stampfor), 1);
					if(count($totalinTen) == PAID_CUPS)
						$page_data['bg_image'] = $cafe_details['image'];

					// END: To put the cafe image as bg image for redeem cafe screen
					$page_data['stampfor'] = $stampfor;
					$page_data['cafe_name'] = $cafe_details['name'];
					$page_data['url_slug'] = $cafe_details['url_slug'];
					//$this->load->page_layout('page_home', $page_data);
				}
				// else
					// redirect(BASE_URL.'dashboard', 'refresh');
			}else{
				redirect(BASE_URL.'login', 'refresh');
			}
			/* !- for stamp screen */
			
			$this->load->page_layout('page_vendor', $page_data);
		}else{
			$flash_error = '<strong>Error !</strong> Cafe/restaurant could not found.';
			// $this->session->set_flashdata('flash_error', $flash_error);
			$this->load->page_layout('page_verified');
		}
	}
	
	function refresh_cafepage(){
			
		$where = array('ID' => $_POST['cafeid']);
		$cafe_details = $this->cafe->get_cafe($where, 1);
		
		$this->session->set_userdata('stampfor', $cafe_details['ID']);
		$page_data['cafe'] = $cafe_details;
		$user = $this->session->userdata('bg_user');
		if( !empty($user['id']) ){
			$user_stamps = $this->stamp->get_lastten(array(
				'userid' => $user['id'],
				'cafeid' => $cafe_details['ID']
			));
			
			$paid_cups = PAID_CUPS;
			ob_start();
			if( isset($user_stamps) ){ ?>
					<div class="h-wrapper">
						<div class="or-section">
								<?php if( count($user_stamps) == $paid_cups ){
									$ulcls = 'enable-coffee';
									$coffee_cls = 'stamp-free-coffee';
									$tree_cls = 'btn-plant-tree';
									
									$wrapper = '<a href="javascript: void(0);" class=" %s act-swipescreen btn-coffee">';
									}else{
										$ulcls = '';
										$coffee_cls = '';
										$tree_cls = '';
									
										$wrapper = '<a href="javascript: void(0);" class=""></a>';
									}
								?>
								
								<?php if(count($user_stamps) == $paid_cups){ ?>
								<ul class="enable-coffee">
									<li>
										<a href="javascript: void(0);" class="stamp-free-coffee act-swipescreen btn-coffee">
											<img src="<?=FRNT_ASSETS?>images/free-coffee.png"/>
										</a>
										<span class="or-tooltip">Free Coffee</span>
									</li>
									<li class="or-li">or</li>
									<li>
										<a href="javascript: void(0);" class="btn-plant-tree">
											<img src="<?=FRNT_ASSETS?>images/plant-tree.png"/>
										</a>
										<span class="or-tooltip">Plant Tree</span>
									</li>
								</ul>
								<?php } else{ ?>
								<ul>
									<li>
										<img src="<?=FRNT_ASSETS?>images/free-coffee.png"/>
										<span class="or-tooltip">Free Coffee</span>
									</li>
									<li class="or-li">or</li>
									<li>
										<img src="<?=FRNT_ASSETS?>images/plant-tree.png"/>
										<span class="or-tooltip">Plant Tree</span>
									</li>
								</ul>
								<?php } ?>
							
						</div>
						<div class="current-progress test">
						<?php //echo "user stamps ".$user_stamps; ?>
							<ul>
							<?php for( $i = 1; $i<=$paid_cups; $i++ ){ 
								if( $i <= count($user_stamps )){
							?>
								<li class="redeem-check <?php echo (count($user_stamps) == $paid_cups) ? 'redeem-check-all' : '' ?> <?php echo ($i == count($user_stamps)) ? 'redeem-check-last' : '' ?>"><a href="#"><?=$i?></a></li>
								<?php }else{ ?>
								<li><a href="#"><?=$i?></a></li>
								<?php } ?>
							<?php } ?>
							</ul>
						</div>
						
					</div>
					<?php if( count($user_stamps) != $paid_cups ){ ?>
					<div class="margin-left-right"><a href="javascript:void(0)" class="dash-btn white-btn act-swipescreen">Make Stamp</a></div>
					<?php } ?>
			<?php }else{
				echo '';
			}
			$result = ob_get_clean();
		}
		echo $result;
		exit;
	}
}
?>