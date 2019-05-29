<link href="<?=FRNT_ASSETS?>css/snowshoe-sample.css" rel="stylesheet">
<?php
// if(isset($bg_image) && !empty($bg_image)){
	// $img_url = BASE_URL.'uploads/cafe'.$bg_image;
// }
?>
	<section class="stamp-wrapper bg-back" style="background-image:<?php echo isset($img_url) ? 'url('.$img_url.')' : '' ?>">
		<div class="container" id="stamp-wrapper">
			<div class="row">
				<div class="col-md-12">
					<div class="stamp-container">
						<!-- <div class="heading">
							<h3>Participating vendors can stamp here to get you started.</h3>
							<h3><u><?php // echo $cafe_name ?>,</u> please stamp here</h3>
						</div> -->
						<!-- Snowshoe messages -->
						<div class="new-logo"><a href="#"><img src="<?=BASE_URL?>front_assets/images/LOGOWHITE.png "></a></div>
						<div id="snowshoe-messages" >
						</div>
						<div class="stamp-content " id="stamp-here">
							<a href="#">
							<img src="<?=FRNT_ASSETS?>images/stamp_star.png" class="img-stamp" alt="Stamp">
							<span>Ask your barista to stamp here to add to your card</span>
							<span class="large-font hide-txt">Card stamped</span>
							</a>
						</div>
						<div class="stamp-content redeem-coffee hide-txt" id="stamp-here">
							<a href="#">
							<img src="<?=FRNT_ASSETS?>images/redeem-star.png" class="img-stamp" alt="Stamp">
							<span>Ask your barista to stamp here to redeem your free coffee</span>
							<span class="large-font hide-txt">Coffee Redeemed</span>
							</a>
						</div>
						<div class="stamp-content tree-plant hide-txt" id="stamp-here">
							<a href="#">
							<img src="<?=FRNT_ASSETS?>images/small-tree.png" class="img-stamp" alt="Stamp">
							<span>Tap here to plant your tree</span>
							</a>
						</div>
						<div class="stamp-content tree-planting hide-txt" id="stamp-here">
							<p>Tree planting process started.See your email for more details</p>
							<a href="#">
							<img src="<?=FRNT_ASSETS?>images/big-tree.png" class="img-stamp" alt="Stamp">
							
							</a>
						</div>
						<div class="partner-name"><p>Partner</p><h4><?php echo $cafe_name ?></h4></div>
						<!-- <form>
							<a href="<?=BASE_URL.'cafe'?>" class="submit-btn">View Vendors</a>
						</form> -->
					</div>
					<div id="snowshoe-progress-bar"></div>
				</div>
			</div>
		</div>
	</section>
	
	<div style="display: none;">
		<button class="checkaudio">Check Audio on Ajax</button>
		<button class="play">Play</button>
		<button class="pause">Pause</button>
	</div>
<script>
	var x = document.getElementById("my_audio");
	x.loop = false;

	var successurl = '<?=BASE_URL.'profile'?>';
	
	var stampsound = document.createElement('audio');
	stampsound.setAttribute('src', 'https://begood.herokuapp.com/uploads/sounds/stampsound/<?=get_option('stampsound')?>');
	var freecupsound = document.createElement('audio');
	freecupsound.setAttribute('src', 'https://begood.herokuapp.com/uploads/sounds/freesound/<?=get_option('freesound')?>');

	var stampScreenInitData = {
		"postUrl": "https://begood.herokuapp.com/stamping/stampscan",
		"stampScreenElmId": "stamp-wrapper",
		"progressBarOn": true,
		"postViaAjax": true, // post via Ajax  
		"messages": {
			"userTraining" : "<div class='show-message'>Keep holding</div>",
			"insufficientPoints" : "<div class='show-message retry'>Try again!</div>"
		},
		"success": function(response){
			jQuery('#snowshoe-progress-bar').removeClass("snowshoe-progress-bar");
			var result = JSON.parse(response);
			if(result.stamps == 9){
				soundPlay(freecupsound); //freecupsound.play();
				jQuery('.stamp-container').css('background', '#ea8859');
				jQuery('.submit-btn').css('background', '#252c3f');
				jQuery('.img-stamp').attr('src', '<?=FRNT_ASSETS?>images/free-stamp.png');
				// replace image with free stamp image
			}else{
				if(result.stamps == 0){
					jQuery('.stamp-container').css('background', '#252c3f');
					jQuery('.submit-btn').css('background', '#ea8859');
					jQuery('.img-stamp').attr('src', '<?=FRNT_ASSETS?>images/stamp.png');
				}
				soundPlay(stampsound);
			}
			//window.location.replace(successurl);
			jQuery("#snowshoe-messages").empty();
		},
		"error": function(response){
			jQuery('#snowshoe-progress-bar').removeClass("snowshoe-progress-bar");
			window.location.replace('https://begood.herokuapp.com/');
			jQuery("#snowshoe-messages").empty();
		}
	}	
</script>
<script>
	var sound = false;
	jQuery(document).ready(function(){
		jQuery('.play').click(function(){
			// x.play();
			sound = jQuery(this).data('sound');
			sound.play();
		});
		//just for checking audio play in chrome
		jQuery('.checkaudio').click(function(){
			// soundPlay(stampsound);
			jQuery.ajax({
				url: 'test/checkAudio',
				complete: function(){
					// soundPlay(freecupsound);
					soundPlay(stampsound);
				}
			});
		});
	});
	function soundPlay(sound){
		jQuery('.play').data('sound', sound).trigger('click');
	}
</script>
<script src="<?=FRNT_ASSETS?>js/jquery.snowshoe.js"></script>