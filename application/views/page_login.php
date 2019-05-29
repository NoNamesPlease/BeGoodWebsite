<?php
$CI = & get_instance();
$user = $CI->session->userdata('bg_user');
$controller = $CI->router->fetch_class();
?>
	<?php if($controller == 'welcome'){ ?>
	<section class="splash-wrapper test">
		<div class="splash-bg"><img src="<?=FRNT_ASSETS?>images/splash-bg.jpg" alt="Splash Screen"></div>
		<div class="logo-wrapper">
			<img src="<?=FRNT_ASSETS?>images/LOGOWHITE.png" alt="">
		</div>
	</section>
	<?php }	?>
	<section class="sign-in-up-wrap" style="display:<?= ($controller == 'welcome') ? 'none' : 'block' ?>;">
		<div class="bg-back home-wrapper">
			<div class="container">
				<div class="new-logo"><a href="#"><img src="<?=FRNT_ASSETS?>images/LOGOWHITE.png " /></a></div>
						
				<div class="row">
					<!-- Login wrapper -->
					<div class="col-md-12 col-sm-12 col-xs-12 user-login">
						<div class="sign-up-container">
							<!-- <div class="shead"></div> -->
							
					
							<div class="login-right">
								
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
								<form action="<?=BASE_URL?>login" method="post" name="form_login" id="form_login">
									<div class="in-wrap">
										<label for="email">Email or phone</label>
										<input type="text" name="email_phone" id="email" placeholder="Email or phone number" value="<?php echo set_value('email_phone') ?>">
									</div>
									<div class="in-wrap">
										<label for="password">Password</label>
										<input type="password" name="password" id="password" placeholder="Enter a password">
									</div>
								
									<input type="hidden" name="form" value="login" />
									<button type="submit" class="submit-btn">Login</button>
									<a href="<?=BASE_URL?>forgotpass" class="forgot_link"> forgot password? </a>
								</form>
									<ul class="social-login">
									<li class="google-icon">
										<a href="<?=BASE_URL?>user_authentication"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
									</li>
									<li class="fb-icon">
										<!--<a href="<?php echo (isset($authUrl)) ? $authUrl : '' ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>-->
										<a href="<?=BASE_URL?>fb_authentication"><i class="fa fa-facebook" aria-hidden="true"></i></a>
									</li>
									<li class="insta-icon">
										<a href="<?php echo $this->instagram_api->instagram_login(); ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a>
									</li>
								</ul>
								<div class="login_register">
									<a href="#" class="btn-signup register_link"> Dont have an account? Register here </a>
								</div>
							</div>
						</div>
					</div>
					
					<!-- Sign up wrapper -->
					<div class="col-md-12 col-sm-12 col-xs-12 user-signup" style="display:none;">
						<div class="sign-up-container">
							<!-- <div class="shead"></div> -->
							
							<div class="login-right">
								<div class="heading">
									<h3>Enter your details below to login</h3>
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
								<form action="<?=BASE_URL?>register" method="post" name="form_signup">
									<div class="in-wrap">
										<label for="email">Email or Phone</label>
										<input type="text" name="email_phone" id="email" placeholder="Eg +64XXXXXXXXX or example@gmail.com" value="<?php echo set_value('email_phone') ?>">
										<span class="text-danger"><?php echo form_error('email_phone'); ?></span>
									</div>
									<div class="in-wrap">
										<label for="password">Password</label>
										<input type="password" name="password" id="password" placeholder="Enter a password">
										<span class="text-danger"><?php echo form_error('password'); ?></span>
									</div>
									<input type="hidden" name="form" value="signup" />
									<button class="submit-btn">Register</button>
								</form>
								<div class="acc">
									<a href="javascript:void(0)" class="btn-login">Have an account? Login here</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<script type="text/javascript" src="<?=ASSETS?>/other/jquery.validate.min.js"></script>
<?php if($controller == 'welcome') { ?>
		<script>
		jQuery('document').ready(function(){			
			setTimeout(function(){
				jQuery( ".splash-wrapper" ).fadeOut( 2000, function(){
				});
				jQuery( ".sign-in-up-wrap" ).fadeIn( 1000, function(){
				});
				
			}, 2000);	
		});
		</script>
<?php } ?>
		<script>
		jQuery('.btn-login').click(function(){
			jQuery('.login-social').hide();
			jQuery('.user-signup').hide();
			jQuery('.user-login').show();
		});
		jQuery('.btn-signup').click(function(){
			jQuery('.login-social').hide();
			jQuery('.user-signup').show();
			jQuery('.user-login').hide();
		});
		
		//form validation 
		jQuery("#form_login").validate({
            focusInvalid: false,
            onkeyup: false,            
            onfocusout: function (element) {
                $(element).valid();
            },
            errorElement: "div",
            rules: {
                email_phone: {
                    required: true,
                },              
                password: {
                    required: true,                    
                },
            },          
            submitHandler: function(form, e) {
                e.preventDefault();
                if ($(form).valid()) {                  
                    form.submit();
                }
            },
            errorPlacement: function(error, element) {
                if(element.parent().attr("class") == "fancy-form"){
                    error.insertAfter(element.closest(".fancy-form"));
                }else{
                    error.insertAfter(element);
                }
            },
        });
		
		// for the webapp installation on mobile homescreen
		let deferredPrompt;

		window.addEventListener('beforeinstallprompt', (e) => {
		  // Prevent Chrome 67 and earlier from automatically showing the prompt
		  e.preventDefault();
		  // Stash the event so it can be triggered later.
		  deferredPrompt = e;
		});
		
	</script>
