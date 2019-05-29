<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Limitless - Responsive Web Application Kit by Eugene Kopyov</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?=ASSETS?>css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?=ASSETS?>css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?=ASSETS?>css/core.css" rel="stylesheet" type="text/css">
	<link href="<?=ASSETS?>css/components.css" rel="stylesheet" type="text/css">
	<link href="<?=ASSETS?>css/colors.css" rel="stylesheet" type="text/css">
	<link href="<?=ASSETS?>css/admin-style.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="<?=ASSETS?>js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?=ASSETS?>js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?=ASSETS?>js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=ASSETS?>js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="<?=ASSETS?>js/plugins/visualization/d3/d3.min.js"></script>
	<script type="text/javascript" src="<?=ASSETS?>js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script type="text/javascript" src="<?=ASSETS?>js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="<?=ASSETS?>js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="<?=ASSETS?>js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="<?=ASSETS?>js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="<?=ASSETS?>js/plugins/pickers/daterangepicker.js"></script>

	<script type="text/javascript" src="<?=ASSETS?>js/core/app.js"></script>
	<!--<script type="text/javascript" src="<?=ASSETS?>js/pages/dashboard.js"></script>-->
	<script type="text/javascript" src="<?=ASSETS?>js/custom.js"></script>
	<!-- /theme JS files -->

</head>

<body>
	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.html"><img src="<?=ASSETS?>images/logo_light.png" alt=""></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>

			</ul>

			<ul class="nav navbar-nav navbar-right">
				
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?=ASSETS?>images/placeholder.jpg" alt="">
						<span>Admin</span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="<?=BASE_URL?>admin/manageprofile"><i class="icon-user-plus"></i> My profile</a></li>
						<li class="divider"></li>
						<!--<li><a href="#"><i class="icon-cog5"></i> Account settings</a></li>-->
						<li><a href="<?=BASE_URL?>admin/dashboard/logout"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->
	
	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">