<section class="search-wrap bg-back">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="search-container">
					<div class="search-left">
						<div class="back-btn"><a href="#"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>Back</a></div>
						<div class="new-logo"><a href="#"><img src="<?=BASE_URL?>front_assets/images/LOGOWHITE.png "></a></div>
						<div class="manual-srh">
							<!--<form>-->
								<div class="in-wrap">
									<label for="vendor">Search for vendors manually</label>
									<input type="text" name="searchbyaddr" class="search-by-addr" placeholder="Enter an address">
									<button type="submit" class="submit-btn">Search Nearby</button>
								</div>
							<!--</form>-->
							<div class="auto-srh">
								<ul class="addr-result">
									<img class="search-loader" src="<?=FRNT_ASSETS?>images/cafe-search-loader.gif">
								</ul>
							</div>
						</div>
					</div>
					<div class="search-right ">
						<div class="search">
							
							<!-- <div class="or">
								<p>or view nearby</p>
							</div> -->
							<div class="auto-srh">
								<ul>
									<?php
										if(isset($nearby) && !empty($nearby)){
											// echo "<pre>";
												// print_r($nearby);
											// echo "</pre>";
											foreach($nearby as $cafe){					
											?>
											<li>
												<a href="<?php echo cafeInfo($cafe['ID'], 'cafeurl')?>">
													<span class="imp-wrap">
														<img src="<?php echo cafeInfo($cafe['ID'], 'imageurl') ?>" alt="">
													</span>
													<span class="content">
														<h4><?=$cafe['name']?></h4>
														<p class="inter"><?php echo $cafe['address'].' '.$cafe['city'].' '.$cafe['postalcode'] ?></p>
														<p class="distance">0.1km</p>
													</span>
												</a>
											</li>
											<?php
											}
										}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	
	var _changeInterval = null;

	jQuery(".search-by-addr").keyup(function() {
		// wait untill user type in something
		// Don't let call setInterval - clear it, user is still typing
		clearInterval(_changeInterval)
		_changeInterval = setInterval(function() {
			// Typing finished, now you can Do whatever after 2 sec
			//call for search function
			search_by_address(jQuery('.search-by-addr').val());
			clearInterval(_changeInterval)
		}, 1500);

	});

	function search_by_address(addr){
		addr = jQuery.trim(addr);
		if(addr.length != 0){
			jQuery.ajax({
				url: 'cafebyaddress',
				method: 'POST',
				dataType: 'JSON',
				data: {
					'address': addr
				},
				beforeSend: function(){ 
					jQuery('.result-li').remove();
					jQuery('.search-loader').show();
				},
				success: function(data){
					if(data.status)
						jQuery('.addr-result').html(data.msg);
				},
				complete: function(){jQuery('.search-loader').hide();}
			});
		}else
			return false;
	}
</script>