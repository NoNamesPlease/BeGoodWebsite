<script src="<?=FRNT_ASSETS?>js/AjaxFileUpload.js"></script>
				<!-- Content area -->
				<div class="content">
					<form class="form-horizontal" method="POST" action=""> 						
						<!-- Basic datatable -->
						<div class="panel panel-flat">
							<div class="panel-body dashboard-profile">
								<div class="form-group col-lg-12">
									<label for="adminpass" class="control-label col-lg-3">Change admin password</label>
									<div class="dashboard-flex">
										<div class="input-wrapper">
											<input type="password" class="form-control width-300" name="adminpass" id="adminpass" />
											
										</div>
										<a href="javascript:void(0)"  class="btn btn-primary updatepass">Update <i class="icon-arrow-right14 position-right"></i></a>
										<span class="update-status"></span>
									</div>
									<img class="pass-loader" src="<?=BASE_URL?>assets/images/ajax-loader.gif" style="display: none; width: 35px;">
								</div>
								<!-- normal Stamp sound -->
								<div class="form-group col-lg-12">
									<label for="stampsound" class="control-label col-lg-3">Select sound for Single stamp</label>
									<div class="dashboard-flex">
										<div class="input-wrapper">
											<input type="file" class="form-control soundfile width-300" name="stampsound" id="stampsound" />
											<div class="audio-loader loader-stampsound" style="display:none;"><img src="<?=BASE_URL?>assets/images/black-audio-wave.gif" /></div>
											<audio id="data-stampsound" controls>
											  <source src="" type="audio/ogg">
											  <source src="<?=BASE_URL?>uploads/sounds/stampsound/<?php echo get_option('stampsound') ?>" type="audio/mpeg">
											  Your browser does not support the audio tag.
											</audio>
										</div>
										<a href="javascript:void(0)" data-sound="stampsound" class="btn btn-primary save_sound">Upload<i class="icon-arrow-right14 position-right"></i></a>
										<input type="checkbox" class="form-input-switchery enable-stampsound" checked="" data-fouc="" data-switchery="true" style="display: none;">
									</div>
								</div>
								<!-- free Stamp sound -->
								<div class="form-group col-lg-12">
									<label for="freesound" class="control-label col-lg-3">Select sound to be played when free cup is redeemable</label>
									<div class="dashboard-flex">
										<div class="input-wrapper">
											<input type="file" class="form-control soundfile width-300" name="freesound" id="freesound" />
											<audio id="data-freesound" controls src="<?=BASE_URL?>uploads/sounds/freesound/<?php echo get_option('freesound') ?>">
											  <!--<source src="<?=BASE_URL?>uploads/sounds/stampsound/<?php echo get_option('freesound') ?>" type="audio/mpeg"> -->
										</div>
										<a href="javascript:void(0)" data-sound="freesound" class="btn btn-primary save_sound">Upload<i class="icon-arrow-right14 position-right"></i></a>
									</div>
								</div>
								<!--<button type="button" class="btn update_settings" id="update_settings" name="update_settings">Save</button>-->
							</div>
						</div>
						<!-- /basic datatable -->
					</form>
					
					<!-- Footer -->
					<div class="footer text-muted">
						&copy; 2015. <a href="#">Be Good</a>
					</div>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->
<style>
.page-header-content{ display: none;}
</style>
<script>
var newpassword;
var ajx_class;
jQuery(document).ready(function(){
		
	jQuery('.updatepass').click(function(){		
		if(jQuery.trim(jQuery('#adminpass').val()).length != 0){
			newpassword = jQuery.trim(jQuery('#adminpass').val());
			jQuery('#adminpass').val('');
			jQuery.ajax({
				url: 'changeadminpass',
				method : 'POST',
				dataType: 'json',
				data: {
					'newpassword': newpassword,
					'choice': 'password'
				},
				beforeSend: function(){
					jQuery('.pass-loader').show();
				},
				success: function(data){
					jQuery('.updatepass').parent('.dashboard-flex').after('<span class="ajx-result ajx-'+data.status+'"> '+data.msg+' </span>');
					setTimeout(function(){ jQuery( ".ajx-result" ).fadeOut(2000); }, 3000);
				},
				complete: function(){
					jQuery('.pass-loader').hide();
				}
			});
		}
	});
});
</script>			