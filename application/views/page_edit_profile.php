<script src="<?=FRNT_ASSETS?>js/AjaxFileUpload.js"></script>
<section class="profile-wrap bg-back" >
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="edit-profile-container">
						<div class="loader-overlay"><img src="<?=FRNT_ASSETS?>images/loader1.gif" /></div>
						<div class="col-md-3 pa-left">
							<div class="p-left-image"></div>
						</div>
						<div class="col-md-6 col-xs-12 pr-wrapper-login" style="background-color:#fff;">
							<form method="POST" name="frm_edit_profile" action="#" id="frm_edit_profile">
								<div class="edit-left">
									<div class="up-wrap">
										<div class="in-wrap upload-image" style="background-image: url(<?php echo !empty($userDetails['user_avtar']) ? $userDetails['user_avtar'] : '../images/upload.png' ?>); background-size: 100%;">
											<input type="file" name="profile_image" id="profile_image" accept="image/*" class="file-inpt" onchange="readImgURL(this);">
											<div class="del-btn"><a href="javascript:void(0)" class="clear-img"><i class="fa fa-times" aria-hidden="true"></i></a></div>
										</div>

									</div>
								</div>
								<div class="edit-right">
									<div class="d-flex">
										<div class="in-wrap">
											<label for="firstname">First Name</label>
											<input type="text" name="firstname" id="firstname" placeholder="Enter your First Name" value="<?php echo $userDetails['firstname'] ?>" />
										</div>
										<div class="in-wrap">
											<label for="lastname">Last Name</label>
											<input type="text" name="lastname" id="lastname" placeholder="Enter your Last Name" value="<?php echo $userDetails['lastname'] ?>">
										</div>
									</div>
									<div class="in-wrap">
										<label for="contactno">Contact Number</label>
										<input type="number" name="contactno" id="contactno" placeholder="Enter your Contact Number" value="<?php echo $userDetails['phoneno'] ?>">
										<!-- For Phone number verification -->
										<div style="display:none;">
											<span>verified/not verified</span>
											<span class="verify-phone">Please verify</span>
											<input type="text" name="smsotp" id="smsotp" class="smsotp" />
										</div>
										<!-- END For Phone number verification -->
									</div>
									<div class="d-flex">
										<button class="submit-btn btn-submit-prof">Update</button>
										<a href="<?=BASE_URL?>profile" class="submit-btn btn-cancel-edit">Cancel</a>
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-3 pa-right">
							<div class="p-right-image"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</section>
<script type="text/javascript" src="<?=ASSETS?>/other/jquery.validate.min.js"></script>
<script type="text/javascript">
jQuery('document').ready(function(){
	
	var curr_avtar = jQuery('.upload-image').css('background-image');
	
	jQuery('.clear-img').click(function(){
		jQuery("input[name='profile_image']").val(null);
		jQuery('.upload-image').css('background-image', curr_avtar);
	});
	
	jQuery("input[name='profile_image']").change(function (){
		var fileName = jQuery(this).val();
		if(fileName != ''){
			jQuery(this).parent().removeClass('upload-required');
			readImgURL(this);
		}
	});
	
	//phone verification
	jQuery('.verify-phone').click(function(){
		
	});
	
	//form validation 
	jQuery("#frm_edit_profile").validate({
		errorClass: "error error-msg",
		focusInvalid: false,
		onkeyup: false,            
		onfocusout: function (element) {
			$(element).valid();
		},
		errorElement: "div",
		rules: {
			/* profile_image:{
				required: true
			}, */
			firstname: {
				required: true
			},
			lastname:{
				required: true				
			},
			contactno:{
				required: true
			}
		},
		messages: {
			firstname:{
				required: 'required'
			},
			lastname:{
				required: 'required',
			},
			contactno:{
				required: 'required'
			}
		},
		submitHandler: function(form, e) {
			e.preventDefault();
			if ($(form).valid()) {                  
				// form.submit();
				submit_form();
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
			jQuery(input).parent().css('background-size', "100%");
		}
		reader.readAsDataURL(input.files[0]);
	}
}

function submit_form(){
	jQuery('.loader-overlay').show();
	jQuery.ajaxFileUpload({
		url 			: '../profile/update', 
		secureuri		: false,
		method			: 'POST',
		fileElementId	: 'profile_image',
		dataType		: 'json',
		data			: {
			'firstname'	: jQuery('#firstname').val(),
			'lastname'  : jQuery('#lastname').val(),
			'phoneno' 	: jQuery('#contactno').val()
		},
		success	: function (data, status){
			if(data.status != 'error')
			{
				jQuery('#files').html('<p>Reloading files...</p>');
				//console.log(data['url']);
				jQuery('.prof-img').attr('src', data['url']);
				// $("#prof-img").load(location.href + "#prof-img");
				// refresh_files();
			}
			// alert(data.msg);
		},
		complete: function(){
			jQuery('.loader-overlay').hide();
		}
	});
}

</script>