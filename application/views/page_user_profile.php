<section class="profile-wrap bg-back" >
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="profile-container">
						<div class="profile-left">
							<div class="manage-btn"><a href="<?=BASE_URL?>profile/edit">Edit Profile</a></div>
							<div class="profile-head">
								<div class="img-wrap"><a href="#"><img src="<?php echo !empty($userDetails['user_avtar']) ? $userDetails['user_avtar'] : FRNT_ASSETS.'images/def-avatar.png' ?>" alt=""></a></div>
								<?php
								if(!empty($userDetails['firstname']) || !empty($userDetails['lastname'])){
									$name = ''.$userDetails['firstname'].' '.$userDetails['lastname'];
								}else
									$name = explode('@', $userdata['email'])[0];
									// $name = $userdata['user'];
								?>
								<div class="p-name"><a href="#"><?php echo $name ?></a></div>
							</div>
							<div class="p-stack-head">
								<!--<div class="cups-save">
									<h3><?=count($cupsSaved)?></h3>
									<p>Cups Saved</p>
								</div>
								<div class="cups-claim">
									<h3><?=count($cupsClaimed)?></h3>
									<p>Coffees Claimed</p>
								</div> -->
								<ul>
									<li>
										<div class="img-profile"><img src="<?=FRNT_ASSETS?>images/co2-save.png" atl="Co2-saved"/></div>
										<h3><?=count($co2saved)?></h3>
										<p>Co<sub>2</sub><br><span>Saved</span></p>
									</li>
									<li>
										<div class="img-profile"><img src="<?=FRNT_ASSETS?>images/water-drop.png" atl="Co2-saved"/></div>
										<h3>8888</h3>
										<p>Water<br><span>Saved</span></p>
									</li>
									<li>
										<div class="img-profile"><img src="<?=FRNT_ASSETS?>images/cup-saved.png" atl="Co2-saved"/></div>
										<h3><?=count($cupsSaved)?></h3>
										<p>Cup<br><span>Saved</span></p>
									</li>
								</ul>
							</div>
						</div>
						<div class="profile-stack">
							
							<div class="p-timeline">
								<h5>Timeline</h5>
								<ul class="mCustomScrollbar" data-mcs-theme="dark">
									<?php foreach($timeline as $tline){
									echo ($tline['cup_state'] == 0) ? '<li>' : '<li class="free-coffee">';
									?>
										<a href="#">
											<span class="imp-wrap">
												<img src="<?=BASE_URL?>uploads/cafe<?=$tline['image']?>" alt="">
											</span>
											<span class="content">
												<h4><?=$tline['name']?></h4>
												<p class="inter"><?php echo ($tline['cup_state'] == 0) ? 'Received Stamp' : 'Free Coffee Claimed' ?></p>
												<div class="date-time">
													<div class="date-content">
														<p class="date"><?php echo date('d M', strtotime($tline['datetime'])) ?></p>
														<div class="star-coffee"><i class="fa fa-star" aria-hidden="true"></i></div>
														<p class="time"><?php echo date('g:i A', strtotime($tline['datetime'])) ?></p>
													</div>
												</div>
											</span>
										</a>
									</li>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</section>