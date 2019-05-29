<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map extends CI_Controller{
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
		$this->load->page_layout('page_map', $data);
	}
}
?>