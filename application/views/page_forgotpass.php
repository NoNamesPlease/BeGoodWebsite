<?php
$CI = & get_instance();
$user = $CI->session->userdata('bg_user');
$controller = $CI->router->fetch_class();
?>
	<section class="bg-back home-wrapper">
		<div class="container">
			<div class="row">
				<!-- Forgot password wrapper -->
				<div class="col-md-12 col-sm-12 col-xs-12 dv-forgot-pass" style="display:<?php echo $form_fp ?>;">
					<div class="sign-up-container forgot_container">
						<!-- <div class="shead"></div> -->
						<div class="login-left">
							<div class="new-logo"><a href="#"><img src="<?=FRNT_ASSETS?>images/LOGOWHITE.png " /></a></div>
						</div>
						<div class="login-right">
							<div class="heading">
								<h3>Please enter your registered Email or Phone number</h3>
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
							<form action="<?=BASE_URL?>forgotpass" method="post" name="form_forgot_pass" id="form_forgot_pass">
								<div class="in-wrap">
									<label for="email">Email or phone</label>
									<input type="text" name="email_phone" id="email" placeholder="Email or phone number">
									<span class="text-danger"><?php echo form_error('email_phone') ?></span>
								</div>
								<input type="hidden" name="form" value="forgot_pass" />
								<button type="submit" class="submit-btn">Submit</button>
								<div class="backto">
									<a href="<?=BASE_URL?>register">Back to Register</a>
									<a href="<?=BASE_URL?>login">Back to Login</a>
								</div>
							</form>
							<!--<div class="or">
								<p>or register by</p>
							</div>
							<button class="submit-btn btn-signup">Email or Phone</button> -->
						</div>
					</div>
				</div>
				
				<!-- New password wrapper -->
				<div class="col-md-12 col-sm-12 col-xs-12 dv-new-pass" style="display:<?php echo $form_rp ?>;">
					<div class="sign-up-container">
						<div class="shead"></div>
						<div class="heading">
							<h3>Please enter New password</h3>
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
						<form action="<?=BASE_URL?>resetpassword" method="post" name="form_reset_pass" id="form_reset_pass">
							<div class="in-wrap">
								<label for="password">Password</label>
								<input type="password" name="password" id="password" placeholder="Enter new password">
							</div>
							<div class="in-wrap">
								<label for="cpassword">Confirm Password</label>
								<input type="password" name="cpassword" id="cpassword" placeholder="Confirm new password">
							</div>
							<input type="hidden" name="resetkey" class="resetkey" value="" />
							<input type="hidden" name="form" value="reset_pass" />
							<button type="submit" class="reset-submit-btn submit-btn">Reset</button>
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
		var key = "<?php echo $key ?>";
		jQuery('#form_reset_pass').validate({
			focusInvalid: false,
			onkeyup: false,
			onfocusout: function(element){
				jQuery(element).valid();
			},
			errorElement: "div",
			rules:{
				password: {
					required: true,
					minlength: 6
				},
				cpassword: {
					equalTo: "#password"
				}
			},
			submitHandler: function(form, e){
				e.preventDefault();
				if(jQuery(form).valid()){
					jQuery('.resetkey').val(key);
					form.submit();
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
	</script>