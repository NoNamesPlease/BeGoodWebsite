<section class="sign-in-up-wrap  cafe-nt-available">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12 login-social">
					<div class="sign-in-container alert-wrapper">
						<div class="cafe-not-found">
						<?php
							if($this->session->flashdata('flash_success')){ ?>                            
							<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
								<span class="text-semibold"><?php echo $this->session->flashdata('flash_success'); ?></span>
							</div>
						<?php }
							if($this->session->flashdata('flash_error')){ ?>                            
							<div class="alert alert-danger alert-styled-left alert-arrow-left alert-bordered">
								<span class="text-semibold"><?php echo $this->session->flashdata('flash_error'); ?></span>
							</div>
						<?php }
						// unset($_SESSION['flash_error']);
						// unset($_SESSION['flash_success']);
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
</section>