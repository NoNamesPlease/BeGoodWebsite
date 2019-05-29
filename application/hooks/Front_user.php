<?php

class Front_user{
	
	function userSession(){
		
		$CI = & get_instance();
		$user = $CI->session->userdata('bg_user');
		$controller = $CI->router->fetch_class();
		$action = $CI->router->fetch_method();
		$directory = $CI->router->directory;
	
		if($controller == 'User_profile' && !isset($user)){
			redirect(BASE_URL.'login'); exit;
		}
	}
	
}

?>