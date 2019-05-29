<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
if ( ! function_exists('active_link'))
{
    function active_link($controller = array())
    {
        $CI = &get_instance();
         
        $class = $CI->router->fetch_class();
		// echo "CLASS :".$class;
        return (in_array(strtolower($class), $controller)) ? 'active' : '';
    }
}
?>