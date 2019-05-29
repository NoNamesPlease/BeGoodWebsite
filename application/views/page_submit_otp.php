<?php
$CI = & get_instance();
$user = $CI->session->userdata('bg_user');
$controller = $CI->router->fetch_class();
?>
	<section class="sign-in-up-wrap">
		<div class="container">
			<div class="row">
				<!-- Forgot password wrapper -->
				<div class="col-md-12 col-sm-12 col-xs-12 dv-submit-otp">
					<div class="sign-up-container">
						<div class="shead"></div>
						<div class="heading">
							<h3>Please enter 6 digit OTP sent on your phone number XXXXXX<?php echo substr($userdetails['phoneno'], -4); ?> </h3>
						</div>
						<?php if($this->session->flashdata('flash_success')){ ?>                            
						<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
									<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
									<span class="text-semibold"><?php echo $this->session->flashdata('flash_success'); ?></span>
						</div>
						<?php } ?>

						<?php if($this->session->flashdata('flash_error')){ ?>
						<div class="alert alert-danger alert-styled-left alert-bordered">
									<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
									<span class="text-semibold"><?php echo $this->session->flashdata('flash_error'); ?></span>
						</div>
						<?php } ?>
						<form action="<?=BASE_URL?>verifyotp" method="post" name="form_verify_otp" id="form_verify_otp">
							<div class="in-wrap otp-wrapper">
								<label for="smsotp">Enter 6 digit OTP</label>
								<input type="text" name="smsotp" id="smsotp" placeholder="XXXXXX" />
								
								<input type="hidden" name="uid" id="uid" value="" />
								<span class="text-danger"><?php echo form_error('email_phone') ?></span>
							</div>
							<!--<input type="hidden" name="form" value="forgot_pass" />-->
							<input type="submit" class="submit-btn" value="Submit" />
							<div class="new-otp-wrapper">
								<span class="new-otp-msg"></span> 
								<span class="new-otp">Send New OTP</span>
							</div>
						</form>
						<!--<div class="or">
							<p>or register by</p>
						</div>
						<button class="submit-btn btn-signup">Email or Phone</button> -->
					</div>
				</div>
				
				<?php
					// unset($_SESSION['flash_error']);
					// unset($_SESSION['flash_success']);
				?>
			</div>
		</div>
	</section>
	<script type="text/javascript" src="<?=ASSETS?>/other/jquery.validate.min.js"></script>
	<script>
		var userid = '<?php echo $userdetails['userid']?>';
		var login_url = '<?php echo BASE_URL.'login' ?>';
		var referrer = '<?=$referrer?>';
		jQuery(document).ready(function(){
			jQuery('.new-otp').click(function(){
				if(!jQuery(this).hasClass('disable')){
					jQuery.ajax({
						url: 'sendnewotp',
						method: 'POST',
						dataType: 'JSON',
						data: {
							'userid': userid
						},
						beforeSend: function(){
							jQuery('.new-otp').addClass('disable');
						},
						success: function(data){
							jQuery('.new-otp-msg').text(data.msg);
						},
						complete: function(){
							jQuery('.new-otp').removeClass('disable');
						}
					});
				}else
					return false;
			});
		});
	</script>
	
	<script>
		
		jQuery('#form_verify_otp').validate({
			focusInvalid: false,
			onkeyup: false,
			onfocusout: function(element){
				jQuery(element).valid();
			},
			errorElement: "div",
			rules:{
				smsotp: {
					required: true,
					minlength: 6
				}
			},
			submitHandler: function(form, e){
				e.preventDefault();
				if(jQuery(form).valid()){
					jQuery('#uid').val(userid);
					if(referrer == 'register')
						verifyotp(jQuery('#smsotp').val());
					else
						form.submit();
					// submit ajax call
				}
			},
			errorPlacement: function(error, element){
				if(element.parent().attr("class") == "fancy-form"){
                    error.insertAfter(element.closest(".fancy-form"));
                }else{
                    error.insertAfter(element);
                }
			}
		});
		
		function verifyotp(otp){
			jQuery.ajax({
				url: 'verifyotp',
				method: 'POST',
				dataType: 'JSON',
				beforeSend: function(){},
				data: {
					'smsotp': otp,
					'uid': userid,
					'referrer': referrer
				},
				success: function(data){
					if(data.status){
						jQuery('.new-otp-wrapper').remove();
						jQuery('.otp-wrapper').remove();
						jQuery('.heading').find('h3').text(data.msg);
						window.location.replace(login_url);
					}
				},
				complete: function(){}
			});
		}
	</script>