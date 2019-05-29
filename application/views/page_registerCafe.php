<div class="sign-in-up-wrap cafe-signup"></div>
<section class="bg-back cafe-signup">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="register-container">
						<form method="POST" action="<?=BASE_URL?>register-cafe" name="frm_cafe_register" id="frm_cafe_register" enctype="multipart/form-data" >
							<div class="reg-wrapper">
								<div class="reg-left">
									<div class="up-wrap">
										<div class="in-wrap upload-image">
											<input type="file" name="cafepic" accept="image/*" class="file-inpt">
											<div class="del-btn"><a href="#"><i class="fa fa-times" aria-hidden="true"></i></a></div>
										</div>
									</div>
								</div>
								<div class="reg-right">
									<div class="address-wrap">
										<div class="in-wrap">
											<label for="cafename">Cafe Name *</label>
											<input type="text" name="cafename" id="cafename" placeholder="Enter your Cafe Name" value="<?php echo set_value('cafename') ?>">
											<span class="text-danger"><?php echo form_error('cafename'); ?></span>
										</div>
										<div class="in-wrap">
											<label for="cafeemail">Email Address *</label>
											<input type="email" name="cafeemail" id="cafeemail" placeholder="Enter your Email Address" value="<?php echo set_value('cafeemail') ?>">
											<span class="text-danger"><?php echo form_error('cafeemail'); ?></span>
										</div>
									</div>
									<div class="address-wrap">
										<div class="in-wrap">
											<label for="website">Website</label>
											<input type="text" name="website" id="website" placeholder="Enter your Website Name" value="<?php echo set_value('website') ?>">
											<span class="text-danger"><?php echo form_error('website'); ?></span>
										</div>
										<div class="in-wrap">
											<label for="contactno">Contact Number *</label>
											<input type="number" name="contactno" id="contactno" placeholder="Enter your Contact Number" value="<?php echo set_value('contactno') ?>">
											<span class="text-danger"><?php echo form_error('contactno'); ?></span>
										</div>
									</div>
									<div class="address-wrap">
										<div class="in-wrap">
											<label for="address">Address</label>
											<input type="text" name="address" id="address" placeholder="Enter your Address" value="<?php echo set_value('address') ?>">
											<span class="text-danger"><?php echo form_error('address'); ?></span>
										</div>
										<div class="in-wrap">
											<label for="city">City *</label>
											<input type="text" name="city" id="city" placeholder="Enter your City" value="<?php echo set_value('city') ?>">
											<span class="text-danger"><?php echo form_error('city'); ?></span>
										</div>
									</div>
									<div class="address-wrap">
										<div class="in-wrap">
											<label for="pincode">Pincode</label>
											<input type="text" name="pincode" id="pincode" placeholder="Enter your Pincode" value="<?php echo set_value('pincode') ?>">
											<span class="text-danger"><?php echo form_error('pincode'); ?></span>
										</div>
									</div>
									<div class="register-button-group">
										<div class="btn-left"><button class="submit-btn">Register</button></div>
										<div class="btn-right"><a href="javascript:void(0)" class="register-cafe-instagram"><i class="fa fa-instagram" aria-hidden="true"></i> Register</a></div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
<script type="text/javascript" src="<?=ASSETS?>/other/jquery.validate.min.js"></script>	
<script>
	jQuery(document).ready(function(){
		//image upload
		jQuery("input[name='cafepic']").change(function (){
			var fileName = jQuery(this).val();
			if(fileName != ''){
				jQuery(this).parent().removeClass('upload-required');
				readImgURL(this);
			}
		});
		
		//remove selected image
		jQuery('.del-btn').click(function(){
			jQuery("input[name='cafepic']").val('');
			jQuery('.upload-image').css('background-image', '');
			jQuery('.cafe-signup').removeAttr("style");
		});
		
		//form validation 
		jQuery("#frm_cafe_register").validate({
			errorClass: "error error-msg",
            focusInvalid: false,
            onkeyup: false,            
            onfocusout: function (element) {
                $(element).valid();
            },
            errorElement: "div",
            rules: {
                cafename: {
                    required: true,
                },
				email:{
					required: true,
					email: true
				},
				contactno:{
					required: true
				},
				city:{
					required: true
				},
				cafepic:{
					required: true
				}			
            },
			messages: {
				cafename: {
					required: 'required'
				},
				email: {
					required: 'required',
				},
				contactno:{
					required: 'required'
				},
				city: {
					required: 'required'
				}
			},
            submitHandler: function(form, e) {
                e.preventDefault();
                if ($(form).valid()) {                  
                    form.submit();
                }
            },
            errorPlacement: function(error, element) {
				//error.insertAfter(element.parent().parent().find('.fancy-form'));
				//error.insertBefore(element);
                if(element.parent().attr("class") == "fancy-form"){
                    error.insertAfter(element.closest(".fancy-form"));
                }else if(element.parent().hasClass('upload-image')){
					element.parent().addClass('upload-required');
				}else{
                    error.insertAfter(element.parent().find("label"));
                }
            },
        });
	});
	
function readImgURL(input) {
	var imgdata;
	if (input.files && input.files[0]){
		var reader = new FileReader();
		reader.onload = function (e) {
			console.log("url('"+e.target.result+"')");
			jQuery(input).parent().css('background-image', "url('"+e.target.result+"')");
			jQuery('.cafe-signup').css('background-image', "url('"+e.target.result+"')");
			jQuery('.cafe-signup').css('opacity', '0.6');
		}
		reader.readAsDataURL(input.files[0]);
	}
}
</script>