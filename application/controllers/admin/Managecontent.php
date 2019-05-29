<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Managecontent extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		// $this->load->model();
		
	}
	
	public function index(){
		
		if(count($_POST) != 0){
			if(isset($_POST['editor-full']) && !empty($_POST['editor-full'])){
				//echo htmlspecialchars($_POST['editor-full']); 
				update_option('content_ourstory', $_POST['editor-full']);
			}
		}
		//$content = get_option('content_ourstory');
		
		$data['content_ourstory'] = get_option('content_ourstory');
		$this->load->layout('admin/manage_content', $data);
		
	}
}
?>