<?php

/*
|--------------------------------------------------------------------------
| Instagram
|--------------------------------------------------------------------------
|
| Instagram client details
|
*/

$config['instagram_client_name']	= 'BeGood';
$config['instagram_client_id']		= '421f82c6270149f4b7af070db141ac8b';
$config['instagram_client_secret']	= '57d7c3418d8d4421bbf99207b503b429';
$config['instagram_callback_url']	= BASE_URL.'insta_authentication';//e.g. http://yourwebsite.com/authorize/get_code/
$config['instagram_website']		= BASE_URL;
$config['instagram_description']	= 'BeGood coffee cafe website.';
	
/**
 * Instagram provides the following scope permissions which can be combined as likes+comments
 * 
 * basic - to read any and all data related to a user (e.g. following/followed-by lists, photos, etc.) (granted by default)
 * comments - to create or delete comments on a user’s behalf
 * relationships - to follow and unfollow users on a user’s behalf
 * likes - to like and unlike items on a user’s behalf
 * 
 */
$config['instagram_scope'] = 'public_content';

// There was issues with some servers not being able to retrieve the data through https
// If you have this problem set the following to FALSE 

$config['instagram_ssl_verify']		= FALSE;
