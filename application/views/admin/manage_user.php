				<!-- Content area -->
				<div class="content">

					<!-- Basic datatable -->
					<div class="panel panel-flat">
										
						<div class="panel-heading">
							<h5 class="panel-title">List of registered users</h5>
							<div class="heading-elements">
								<ul class="icons-list">
									<li><a data-action="collapse"></a></li>
									<li><a data-action="reload"></a></li>
									<li><a data-action="close"></a></li>
								</ul>
							</div>
						</div>
						<div class="panel-body">
						</div>
						<div class="table-responsive">
							<table class="table datatable-basic table-relative">
								<thead>
									<tr>
										<th>First Name</th>
										<th>Last Name</th>
										<th>Email</th>									
										<th>Status</th>
										<th class="text-center">Actions</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								<?php
								if(!empty($users)) {
								foreach($users as $user) { ?>
									<tr data-userid="<?php echo $user['uid'] ?>">
										<td><?= ucfirst($user['firstname'])?></td>
										<td><?= ucfirst($user['lastname'])?></td>
										<td><?= $user['email']?></td>
										<?php
										if($user['verified'] == 0){ ?>
											<td> <span class="label label-info">Pending verification</span></td>
										<?php }else{ ?>
										<td><span data-status-<?php echo $user['uid'] ?> class="label <?php echo $user['is_active'] == 1 ? 'label-success' : 'label-danger' ?>"><?php echo $user['is_active'] == 1 ? 'Active' : 'Suspended' ?></span></td>
										<?php } ?>
										<td class="text-center">
											<ul class="icons-list">
												<li class="dropdown">
													<a href="#" class="dropdown-toggle" data-toggle="dropdown">
														<i class="icon-menu9"></i>
													</a>

													<ul class="dropdown-menu dropdown-menu-right" data-userid="<?php echo $user['uid'] ?>">
														<?php if($user['is_active'] == 1){ ?>
														<li><a href="javascript:void(0)" class="deactivate"><i class="icon-blocked"></i>Suspend</a></li>
														<?php }else{ ?>
														<li><a href="javascript:void(0)" class="activate"><i class="icon-checkmark"></i>Make Active</a></li>
														<?php } ?>
														<!--<li><a href="#"><i class="icon-file-word"></i> Export to .doc</a></li> -->
													</ul>
												</li>
											</ul>
										</td>
										<td></td>
									</tr>
								<?php } } ?>
								<tr class="overlay-wrap" style="display:none;"><td><div class="table-overlay"><img src="../assets/images/white-loader.gif"/></div></td><td></td><td></td><td></td><td></td><td></td></tr>
								</tbody>
								
							</table>
						</div>
					</div>
					<!-- /basic datatable -->

					<!-- Footer -->
					<div class="footer text-muted">
						&copy; 2015. <a href="#">Be Good</a>
					</div>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->
<script>
jQuery(document).ready(function(){
	console.log('test');
});
</script>			