<?php

class MY_Loader extends CI_Loader{
	public function layout($template_name, $vars = array(), $return = FALSE){
		// $CI =& get_instance();
		// $controller = strtolower($CI->router->fetch_class());
		// $routes = $CI->router->routes;
		// $vars['controller'] = $controller;
		
		if($return){
			$content = $this->view('admin/admin_header', $vars, $return);
			$content .= $this->view('admin/admin_sidebar', $vars, $return);
			$content .= $this->view('admin/maincontent-top', $vars, $return);
			$content .= $this->view($template_name, $vars, $return);
			$content .= $this->view('admin/admin_footer', $vars, $return);
			return $content;
		}else{
			$this->view('admin/admin_header', $vars);
			$this->view('admin/admin_sidebar', $vars);
			$this->view('admin/maincontent-top', $vars);
			$this->view($template_name, $vars);
			$this->view('admin/admin_footer', $vars);
		}
	}
	public function page_layout($template_name, $vars = array(), $return = FALSE){
		// $CI =& get_instance();
		// $controller = strtolower($CI->router->fetch_class());
		// $routes = $CI->router->routes;
		// $vars['controller'] = $controller;
		// $vars['page'] = $template_name;
		
		if(!isset($vars['menu_head']))
			$vars['menu_head'] = TRUE;
		if($return){
			$content = $this->view('page_header', $vars, $return);
			$content .= $this->view($template_name, $vars, $return);
			$content .= $this->view('page_footer', $vars, $return);
			return $content;
		}else{
			$this->view('page_header', $vars, $return);
			$this->view($template_name, $vars, $return);
			$this->view('page_footer', $vars, $return);
			unset($_SESSION['flash_error']);
			unset($_SESSION['flash_success']);
		}
	}
}
?>