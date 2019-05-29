				<!-- Content area -->
				<div class="content">

					<!-- Default ordering -->
					<div class="panel panel-flat">
						<div class="panel-heading">
							<h5 class="panel-title">List of registered cafes</h5>
							<div class="heading-elements">
								<ul class="icons-list">
			                		<li><a data-action="collapse"></a></li>
			                		<li><a data-action="reload"></a></li>
			                		<li><a data-action="close"></a></li>
			                	</ul>
		                	</div>
							<div class="alert alert-success alert-cust" style="display: none;">
							  <strong>Success!</strong> Indicates a successful or positive action.
							</div>
						</div>
		
						<div class="panel-body">
						</div>
						
						<div class="table-responsive">
							<table class="table datatable-sorting">
								<thead>
									<tr>
										<th>Cafe</th>
										<th>City</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Website</th>
										<th>Status</th>
										<th class="text-center">Actions</th>
									</tr>
								</thead>
								<tbody>
								<?php if(!empty($cafes)){
									// echo "<pre>";
										// print_r($cafes);
									// echo "</pre>"; die;
									foreach($cafes as $cafe){
										?>
										<tr>
											<td><?= $cafe['name'] ?></td>
											<td><?= $cafe['city'] ?></td>
											<td><?= $cafe['email'] ?></td>
											<td><?= $cafe['phoneno'] ?></td>
											<td><?= $cafe['website'] ?></td>
											<td><span class="label <?php echo ($cafe['verified'] == 1) ? "label-success" : "label-info" ?>" data-status-<?=$cafe['ID']?>><?php echo ($cafe['verified'] == 1) ? "Active" : "Under verification" ?></span></td>
											<td class="text-center">
												<ul class="icons-list">
													<li class="dropdown">
														<a href="#" class="dropdown-toggle" data-toggle="dropdown">
															<i class="icon-menu9"></i>
														</a>

														<ul class="dropdown-menu dropdown-menu-right">
															<?php if($cafe['verified'] != 1){ ?>
															<li><a href="javascript:void(0)" class="verify" data-cafeid="<?=$cafe['ID']?>"><i class="icon-checkmark"></i>Activate</a></li>
															<?php } ?>
															<li><a href="./managecafe/<?=$cafe['ID']?>"><i class="icon-pencil"></i> Edit</a></li>
														</ul>
													</li>
												</ul>
											</td>
										</tr>
										<?php
									}
								}
								?>
								<tr class="overlay-wrap" style="display:none;"><td><div class="table-overlay"><img src="../assets/images/white-loader.gif"/></div></td></tr>
								</tbody>
							</table>
						</div> <!-- /Responsice -->
					</div>
					<!-- /default ordering -->

					<!-- Footer -->
					<div class="footer text-muted">
						&copy; 2015. <a href="#">Be Good</a>
					</div>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->