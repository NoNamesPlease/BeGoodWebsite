<link href="<?=FRNT_ASSETS?>css/snowshoe-sample.css" rel="stylesheet">
<section class="vendor-detail-wrap bg-back">
	<!-- <div class="v-bg-img"><img src="img/re-bg.jpg" alt="Background-image"></div> -->
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="v-container">
					<div class="v-content">
						<div class="card-image-bg">
							<div class="back-btn"><a href="javascript:void(0)" class=""><img src="<?=FRNT_ASSETS?>images/back-arrow.png" />Back</a></div>
							<div class="cafe-img-wrap"><img src="<?=BASE_URL?>uploads/<?=$cafe['image']?>" /></div>
						</div>
						
						<div class="card-content-block">
							<h3><?=$cafe['name']?></h3>
							<?php if(isset($user_stamps)){ ?>
							<div class="coffee-loader hide"><img src="<?=ASSETS?>images/loader.gif" /></div>
							<div class="redeem-wrap">
								<!-- contents loaded with AJAX here -->
							</div>
							<?php }else{ ?>
								<h2> No stamps...</h2>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- stamp screen -->
<section class="stamp-wrapper bg-back slide-stamp">
	<div class="backtocafe"><img src="<?=FRNT_ASSETS?>images/back-arrow.png"> Back </div>
	<div class="container" id="stamp-Screen">
	<div class="disable-stamp hide"></div>
	<div class="treeplant-loader hide"><img src="<?=FRNT_ASSETS?>images/planting_loader.gif" /></div>
		<div class="row">
			<div class="col-md-12">
				<div class="stamp-container">
					
					<!-- Snowshoe messages -->
					
					<div class="new-logo"><a href="#"><img src="<?=BASE_URL?>front_assets/images/LOGOWHITE.png "></a></div>
					<div id="snowshoe-messages" >
					</div>
					<?php if(count($user_stamps) == PAID_CUPS){
						$cls = 'redeem-coffee';
						// $img = FRNT_ASSETS.'images/redeem-star.png';
						// $txt = 'Ask your barista to stamp here to redeem your free coffee';
					}else{
						$cls = '';
						// $img = FRNT_ASSETS.'images/star.png';
						// $txt = 'Ask your barista to stamp here to add to your card';
					}
					?>
					<div class="coffee-wrapper">
						<div class="stamp-content <?= $cls ?>" id="stamp-here">
							<a href="#">
								<img src="" class="img-stamp" alt="Stamp">
								<span class="ask"></span>
								<span class="large-font hide-txt done"></span>
							</a>
						</div>
					</div>
					<div class="stamp-content tree-plant hide-txt act-plant-tree" id="plant-here">
						<a href="javascript: void(0);">
						<img src="<?=FRNT_ASSETS?>images/small-tree.png" class="img-stamp" alt="Stamp">
						<span class="ask">Tap here to plant your tree</span>
						</a>
					</div>
					<div class="stamp-content tree-planting hide-txt tree-plant-done">
						<p>Tree planting process started. See your email for more details.</p>
						<img src="<?=FRNT_ASSETS?>images/big-tree.png" class="img-stamp" alt="Stamp">
					</div>
					<div class="partner-name"><p>Partner</p><h4><?php echo ucwords($cafe_name) ?></h4></div>
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
	var cafe_id = <?=$cafe['ID']?>;
	var successurl = '<?=BASE_URL.'profile'?>';
	var userstamps = <?=count($user_stamps)?>;
	var cups_paid = <?=PAID_CUPS?>;
	var curr_stamp_img;
	var curr_stamp_text;
	var stamp_props = {
		paid : {
			ask : 'Ask your barista to stamp here to add to your card',
			done: 'Card stamped',
			img : '<?=FRNT_ASSETS?>images/stamp_star.png'
		},
		free : {
			ask : 'Ask your barista to stamp here to redeem your free coffee',
			done: 'Coffee Redeemed',
			img : '<?=FRNT_ASSETS?>images/redeem-star.png'
		},
		tree : {
			ask : 'Tap here to plant your tree',
			ask_img : '<?=FRNT_ASSETS?>images/small-tree.png',
			done: 'Tree planting process started. See your email for more details.',
			done_img : '<?=FRNT_ASSETS?>images/big-tree.png'
		},
		err : {
			ask : 'Ask your barista to stamp here to add to your card',
			done: 'Error !',
			img : '<?=FRNT_ASSETS?>images/stamp-failed-small.png'
		}
	};
	
	if(userstamps == cups_paid){
		curr_stamp_text = stamp_props.free.ask;
		curr_stamp_img = stamp_props.free.img;
	}else{
		curr_stamp_text = stamp_props.paid.ask;
		curr_stamp_img = stamp_props.paid.img;
	}
	
	var stampsound = document.createElement('audio');
	stampsound.setAttribute('src', '<?=BASE_URL?>uploads/sounds/stampsound/<?=get_option('stampsound')?>');
	var freecupsound = document.createElement('audio');
	freecupsound.setAttribute('src', '<?=BASE_URL?>uploads/sounds/freesound/<?=get_option('freesound')?>');

	var stampScreenInitData = {
		"postUrl": "<?=BASE_URL?>stamping/stampscan",
		"stampScreenElmId": "stamp-Screen",
		"progressBarOn": true,
		"postViaAjax": true, // post via Ajax  
		"messages": {
			"userTraining" : "<div class='show-message'>Keep holding</div>",
			"insufficientPoints" : "<div class='show-message retry'>Try again!</div>"
		},
		"success": function(response){
			var result = JSON.parse(response);
			if(result.status){
				jQuery('.disable-stamp').removeClass('hide');
				refresh_cafe(); // refresh stamp showing circle
				jQuery('#snowshoe-progress-bar').removeClass("snowshoe-progress-bar");
				
				jQuery('.coffee-wrapper').find('.ask').text(stamp_props.paid.ask).hide();
				jQuery('.coffee-wrapper').find('.done').text(stamp_props.paid.done).show();
				jQuery('.img-stamp').attr('src', stamp_props.free.img);
			
				if(result.stamps == 9){
					soundPlay(freecupsound); //freecupsound.play();
					jQuery('.coffee-wrapper').find('.done').text(stamp_props.paid.done).show();
					jQuery('.coffee-wrapper').find('.ask').text(stamp_props.free.ask).hide();
					jQuery('.img-stamp').attr('src', stamp_props.paid.img);
					curr_stamp_img = stamp_props.free.img;
					curr_stamp_text = stamp_props.free.ask;
				}else{
					if(result.stamps == 0){
						jQuery('.coffee-wrapper').find('.done').text(stamp_props.free.done).show();
						jQuery('.coffee-wrapper').find('.ask').text(stamp_props.paid.ask).hide();
						jQuery('.img-stamp').attr('src', stamp_props.free.img);
						curr_stamp_img = stamp_props.paid.img;
						curr_stamp_text = stamp_props.free.ask;
					}
					soundPlay(stampsound);
				}
			}else{
				jQuery('.coffee-wrapper').find('.ask').hide();
				jQuery('#snowshoe-progress-bar').removeClass("snowshoe-progress-bar");
				jQuery('.coffee-wrapper').find('.done').text('Error !!').show();
				jQuery('.coffee-wrapper').find('.stamp-content').addClass('failed');
				jQuery('.img-stamp').attr('src', '<?=FRNT_ASSETS?>images/stamp-failed-small.png');
			}
			jQuery("#snowshoe-messages").empty();
		},
		"error": function(response){
			jQuery('.coffee-wrapper').find('.ask').hide();
			jQuery('#snowshoe-progress-bar').removeClass("snowshoe-progress-bar");
			jQuery('.coffee-wrapper').find('.done').text('Error !!').show();
			jQuery('.coffee-wrapper').find('.stamp-content').addClass('failed');
			jQuery('.img-stamp').attr('src', '<?=FRNT_ASSETS?>images/stamp-failed-small.png');
			jQuery("#snowshoe-messages").empty();
		}
	}	
</script>
<script>
	var sound = false;
	jQuery(document).ready(function(){
		refresh_cafe();
		// put initial texts and image
		jQuery('.coffee-wrapper').find('.img-stamp').attr('src', curr_stamp_img);
		jQuery('.coffee-wrapper').find('.ask').text(curr_stamp_text);
		
		jQuery('.play').click(function(){
			sound = jQuery(this).data('sound');
			sound.play();
		});
		
		//call tree planting function
		jQuery('.act-plant-tree').click(function(){
			plant_tree();
		});
		
		//when tree plant button clicked
		jQuery(document).on('click', '.btn-plant-tree', function(){
			jQuery('.disable-stamp').addClass('hide');
			
			jQuery('.coffee-wrapper').addClass('hide');
			jQuery('.tree-plant').removeClass('hide-txt');
		});
		
		jQuery(document).on('click', '.act-swipescreen', function(){
			jQuery('.disable-stamp').addClass('hide');
			
			jQuery('.tree-plant').addClass('hide-txt');
			jQuery('.coffee-wrapper').removeClass('hide');
			
			jQuery('.coffee-wrapper').find('.stamp-content').removeClass('failed');
			jQuery('.img-stamp').attr('src', '<?=FRNT_ASSETS?>images/stamp_star.png');
			
			jQuery('.coffee-wrapper').find('.ask').show();
			jQuery('.coffee-wrapper').find('.done').hide();
			// jQuery('.stamp-wrapper').attr('id', 'stamp-wrapper');
		});
		
		//just for checking audio play in chrome
		jQuery('.checkaudio').click(function(){
			// soundPlay(stampsound);
			jQuery.ajax({
				url: '../test/checkAudio',
				complete: function(){
					console.log('complete');
				}
			});
		});
	});
	function soundPlay(sound){
		jQuery('.play').data('sound', sound).trigger('click');
	}
	
	//update cafe page when stamped successfully
	function refresh_cafe(){
		jQuery.ajax({
			url: '<?=BASE_URL?>refreshcafe',
			method: 'POST',		
			data: {
				cafeid: cafe_id
			},
			beforeSend: function(){
				jQuery('.redeem-wrap').empty();
				jQuery('.coffee-loader').removeClass('hide');
			},
			success: function(data){
				// console.log(data);
				jQuery('.redeem-wrap').html(data);
				stampHeight();
			},
			complete: function(){ jQuery('.coffee-loader').addClass('hide'); }
		});
	}
	
	function plant_tree(){
		jQuery.ajax({
			url: '../stamping/plantTree',
			method: 'POST',
			dataType: 'json',
			beforeSend: function(){
				jQuery('.tree-plant').addClass('hide-txt');
				jQuery('.treeplant-loader').removeClass('hide');
			},
			data: {
				cafeid: cafe_id,
			},
			success: function(data){
				if(data.status){
					jQuery('.tree-plant-done').removeClass('hide-txt');
					// jQuery('.tree-plant').removeClass('hide-txt');
				}
			},
			complete: function(){
				jQuery('.treeplant-loader').addClass('hide');
				refresh_cafe();
			}
		});
	}
</script>
<script src="<?=FRNT_ASSETS?>js/jquery.snowshoe.js"></script>