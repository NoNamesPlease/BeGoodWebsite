<?php
$config['facebook_app_id']              = '2161612643956938';
$config['facebook_app_secret']          = '5168c3234bf1778bcddf871ffd4cd200';
$config['facebook_login_type']          = 'web';
$config['facebook_login_redirect_url']  = 'https://www.facebook.com/connect/login_success.html';
$config['facebook_login_redirect_url']  = '/fb_authentication';
$config['facebook_logout_redirect_url'] = '/fb_authentication/logout';
$config['facebook_permissions']         = array('email');
$config['facebook_graph_version']       = 'v2.10';
$config['facebook_auth_on_load']        = TRUE;
?>