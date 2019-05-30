<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, height=device-height,  minimum-scale=1.0, maximum-scale=1.0">

	<!--<meta name="application-name" content="Begood">-->

	<title>Home Page</title>
	<!---<link rel="manifest" href="manifest.json">-->
	<link href="<?=FRNT_ASSETS?>css/font-awesome.min.css" rel="stylesheet"><!--bootstrap css-->
	
	<link href="<?=FRNT_ASSETS?>css/fonts.css" rel="stylesheet"><!--font css-->
	<link href="<?=FRNT_ASSETS?>css/jquery.mCustomScrollbar.min.css" rel="stylesheet"><!--mscrollbar css-->

	<link href="<?=FRNT_ASSETS?>css/slick.css" rel="stylesheet"><!-- slick -->
	<link href="<?=FRNT_ASSETS?>css/slick-theme.css" rel="stylesheet"><!-- slick -->
	<link href="<?=FRNT_ASSETS?>css/owl.theme.default.min.css" rel="stylesheet"><!--owl.theme.default.min  css-->
	<link href="<?=FRNT_ASSETS?>css/owl.carousel.min.css" rel="stylesheet"><!--owl.carousel.min  css-->
	<link href="<?=FRNT_ASSETS?>css/jquery.bxslider.css" rel="stylesheet"><!--owl.carousel.min  css-->
    <link href="<?=FRNT_ASSETS?>css/materialize.min.css" rel="stylesheet">
	<link href="<?=FRNT_ASSETS?>css/style.css" rel="stylesheet"><!--style css-->
	<link href="<?=FRNT_ASSETS?>css/responsive.css" rel="stylesheet"><!--responsive css-->
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800,900" rel="stylesheet">


	<script src="<?=FRNT_ASSETS?>js/jquery.min.js"></script><!--jquery js-->
	<script src="<?=FRNT_ASSETS?>js/bootstrap.min.js"></script><!--bootstrap js-->
	<script src="<?=FRNT_ASSETS?>js/jquery.parallax.min.js"></script><!--parallax js-->
	<script src="<?=FRNT_ASSETS?>js/jquery.mCustomScrollbar.concat.min.js"></script><!--mscroll js-->
	<script src="<?=FRNT_ASSETS?>js/slick.min.js"></script><!--slick js-->
	<script src="<?=FRNT_ASSETS?>js/jquery.waterwheelCarousel.min.js"></script><!--slick js-->
	<script src="<?=FRNT_ASSETS?>js/materialize.min.js"></script>
</head>
<body>
<?php
$CI =& get_instance();
$controller = $CI->router->fetch_class();
?>
<?php if($menu_head){ ?>
	<header class="custom-header">
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-sm-3 col-xs-12">
				<?php if($controller != 'welcome' && $controller != 'User_login' && $controller != 'Forgot_pass'){ ?>
					<div class="new-logo"><a href="<?=BASE_URL?>"><img src="<?=BASE_URL?>front_assets/images/brown-logo.png "></a></div>
				<?php } ?>
				</div>
<?php
if( ($controller == 'welcome' && !is_user_logged_in()) || $controller == 'User_login' ){
}
else { //( $controller != 'welcome' && $controller != 'User_login' && is_user_logged_in() ){
?>				
				<div class="col-md-9 col-sm-9 col-xs-12">
					<!-- <div class="mobile-nav"><a href="javascript:void(0)"><img src="<?=FRNT_ASSETS?>images/mobile-menu.png" alt=""></a></div> -->
					<nav class="navigation">
						<ul>
							<li class="<?php echo active_link(array('cards')) ?>">
								<i class="fa fa-coffee nav-icon"></i>
								<a href="<?=BASE_URL?>cafe">Cafes</a>
							</li>
							<li class="<?php echo active_link(array('map')) ?>">
								<i class="fa fa-map nav-icon"></i>
								<a href="<?=BASE_URL?>map">Nearby</a>
							</li>
							<li class="<?php echo active_link(array('user_profile')) ?>">
								<i class="fa fa-user nav-icon"></i>
								<a href="<?=BASE_URL?>profile">Profile</a>
							</li>
							<li class="<?php echo active_link(array('about')) ?>">							
								<i class="fa fa-square nav-icon"></i>
								<a href="<?=BASE_URL?>ourstory">About</a>
							</li>
							<li class="<?php echo active_link(array('logout')) ?>">							
								<i class="fa fa-square nav-icon"></i>
								<a href="<?=BASE_URL?>logout">Logout</a>
							</li>
							<?php
							/*if($this->session->userdata('bg_user')){*/
							?>
							<!--<li class="logout-li"><a href="<?=BASE_URL?>logout">Logout</a></li>-->
							<?php /*} */
							?>
							<div class='close-menu'><a href='javascript:void(0)''><i class='fa fa-times' aria-hidden='true'></i></a></div>
						</ul>
					</nav>
				</div>
<?php } ?>
			</div>
		</div>
	</header>
<?php } ?>