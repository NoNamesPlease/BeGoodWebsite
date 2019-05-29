<section class="profile-wrap bg-back" >
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="profile-container dashboard-container">
						<div class="new-logo"><a href="#"><img src="<?=BASE_URL?>front_assets/images/LOGOWHITE.png "></a></div>
						<div class="dashboard-wrapper">
							<div class="profile-left">
								<div class="p-stack-head">
									<ul>
										<li>
											<div class="img-profile"><img src="<?=FRNT_ASSETS?>images/co2-save.png" atl="Co2-saved"/></div>
											<h3><?=count($co2saved)?></h3>
											<p>Co<sub>2</sub><br>Saved</p>
										</li>
										<li>
											<div class="img-profile"><img src="<?=FRNT_ASSETS?>images/water-drop.png" atl="Co2-saved"/></div>
											<h3>8888</h3>
											<p>Water<br>Saved</p>
										</li>
										<li>
											<div class="img-profile"><img src="<?=FRNT_ASSETS?>images/cup-saved.png" atl="Co2-saved"/></div>
											<h3><?= count($cupsSaved) ?></h3>
											<p>Cup<br>Saved</p>
										</li>
									</ul>
								</div>
							</div>
							<div class="dashboard-button-group">
								<div style="width:100%;">
									<a href="<?=BASE_URL?>cards" class="dash-btn white-btn">Stamp my card</a>
									<a href="<?=BASE_URL?>search-vendor" class="dash-btn">Find a Cafe</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>