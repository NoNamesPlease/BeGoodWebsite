<!-- Main sidebar -->
<div class="sidebar sidebar-main">
	<div class="sidebar-content">
<?php
// $CI = & get_instance();
// echo $CI->router->fetch_class(); die;
?>
		<!-- Main navigation -->
		<div class="sidebar-category sidebar-category-visible">
			<div class="category-content no-padding">
				<ul class="navigation navigation-main navigation-accordion">
					<li class="<?php echo active_link(array('dashboard')) ?>"><a href="<?=BASE_URL?>admin/dashboard"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
					<li class="<?php echo active_link(array('manageuser')) ?>"><a href="<?=BASE_URL?>admin/manageuser"> <i class="icon-people"></i> <span>Manage Users</span></a></li>
					<li class="<?php echo active_link(array('managecafe')) ?>"><a href="<?=BASE_URL?>admin/managecafe"> <i class="icon-stack"></i> <span>Manage Cafes</span></a></li>
					<li class="<?php echo active_link(array('managecontent')) ?>"><a href="<?=BASE_URL?>admin/editcontent"> <i class="icon-puzzle2"></i> <span>Edit Content</span></a></li>
					<li class="<?php echo active_link(array('manageprofile')) ?>"><a href="<?=BASE_URL?>admin/manageprofile">  <i class="icon-grid6"></i> <span>Manage Profile</span></a></li>
				</ul>
			</div>
		</div>
		<!-- /main navigation -->

	</div>
</div>
<!-- /main sidebar -->