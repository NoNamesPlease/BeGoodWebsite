<?php

class Admin_user{
	
	function adminSession(){
		$CI = & get_instance();
		/* echo "<pre>";
			print_r($CI);
		echo "</pre>";
		die; */
		$user = $CI->session->userdata('bg_user');
		$controller = strtolower($CI->router->fetch_class());
		// echo $controller; die;
		$action = $CI->router->fetch_method();
		// echo $action; die;
		$directory = $CI->router->directory;
		// echo $directory; die;
		$admin_controller = array("logout");
		$cur_controller = array("login");
		
		if($directory == 'admin/' && $controller != 'login' && !$user){
			redirect('admin/login');
			exit;
		}
		if($directory == 'admin/' && isset($user) && $user['user_type'] != 'admin' ){
			// redirect('user/dashboard');
			redirect(BASE_URL);
			exit;
		}
		if($directory =="admin/" && isset($user['email']) && $user['email']!="" && $controller == "login"){
			redirect('admin/dashboard');
			exit;
		}
		if($directory =="admin/" && !in_array($action, $admin_controller) && !in_array($controller, $cur_controller))
        { 
			if( isset($user['email']) && !empty($user['email']) && $user['id'] > 0 ){
				$admin_user_id = $CI->common->is_user_active($user['id']);
				if($admin_user_id == ''){
					$flash_info = "<strong>Error !</strong> Login session may expire";
					$CI->session->set_flashdata('flash_info', $flash_info);
					$CI->session->unset_userdata('bg_user');
					redirect(BASE_URL.'admin/login');
					exit;
				}
			}
			else{
				$flash_info = "<strong>Info ! </strong> Login session may expired.";
                $CI->session->set_flashdata('flash_info',$flash_info);
                redirect(BASE_URL."admin/login");
                exit;
			}
		}
		
	}
}
?>