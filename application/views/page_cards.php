<section class="card-wrap bg-back">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-xs-12" style="padding:0px;">
				<div class="card-container ">
					<!-- c <div class="manage-btn"><a href="<?=BASE_URL?>search-vendor">Manage</a></div> -->
					<div class="new-logo"><a href="#"><img src="<?=BASE_URL?>front_assets/images/LOGOWHITE.png "></a></div>
					<div class="card-list carousel">
						
							<?php foreach($cafes as $cafe){
								$cafe_url = BASE_URL.'cafe/'.$cafe['url_slug'];
							?>
	
									<a class="carousel-item" href="<?php echo $cafe_url ?>">
										<img class="carousel-image" src="<?=BASE_URL?>uploads/<?=$cafe['image']?>" alt="Card">
										<span class="v-content">
											<h3><?=$cafe['name']?></h3>
										<?php if(is_user_logged_in()){ ?>	
											<div class="p-bar">
												<span class="stamp-count"><?=$user_stamps[$cafe['ID']]?>/10</span>
												<div  class="svg-cont">
													<svg class="svg" width="28" height="28" viewPort="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg">
													  <circle r="10" cx="17" cy="17" fill="transparent" stroke-dasharray="65" stroke-dashoffset="0"></circle>
													  <circle r="10" cx="11" cy="17" fill="transparent" stroke-dasharray="65" stroke-dashoffset="0" class="bar" style=" transform:rotate(-90deg); transform-origin: center;"></circle>
													  <p class="pro-count" style="display: none;"><?=$user_stamps[$cafe['ID']]?></p>
													</svg>
												</div>
											</div>
										<?php } ?>
										</span>
									</a>
							<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	function getLocationlatlong(){
		navigator.geolocation.getCurrentPosition(function(location) {
			alert(location.coords.latitude);
			alert(location.coords.longitude);
			alert(location.coords.accuracy);
		});
	}
	
	jQuery(document).ready(function(){
		jQuery('.nearby-btn').click(function(){
			getLocationlatlong();
		});
	});
</script>