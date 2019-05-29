jQuery(document).ready(function(){
		
	jQuery(document).on('change', "input[name='cafepic']", function (){
		var fileName = jQuery(this).val();
		if(fileName != ''){
			jQuery(this).parent().removeClass('upload-required');
			readImgURL(this);
		}
	});
	
	jQuery(document).on('change', ".soundfile", function (){
		console.log(jQuery(this).val());
		var audioFile = jQuery(this).prop('files')[0];
		var fileEle = jQuery(this);
		console.log(audioFile);
		if(audioFile != ''){
			var audData = jQuery(this);
			if (this.files && this.files[0]){
				var reader = new FileReader();
				reader.onload = function (e) {
					console.log(e.target.result);
					jQuery('#'+fileEle.attr('id')).parent().find('#data-'+fileEle.attr('id')).attr('src', e.target.result);
				}
				reader.readAsDataURL(this.files[0]);
			}
		}
	});
	
	//ADMIN Action : suspend frontend user from backend
	jQuery(document).on('click', '.deactivate',function(){
		var userid = jQuery(this).parent().parent().data('userid');
		var elem = jQuery(this);
		jQuery.ajax({
			url: './action/deactivate',
			method: 'POST',
			data:{
				'userid': jQuery(this).parent().parent().data('userid')
			},
			dataType: 'json',
			beforeSend: function(){
				jQuery('.overlay-wrap').show();
			},
			success: function(data){
				console.log("Action status : " + data.status + 'ID : '+userid);
				if(data.status == 'Success'){
					jQuery('[data-status-'+userid+']').addClass('label-danger').removeClass('label-success').text('Suspended');
					elem.removeClass('deactivate').addClass('activate').html('<i class="icon-checkmark"></i>Make Active');
				}
			},
			complete: function(){
				jQuery('.overlay-wrap').hide();
			}
		});
	});
	
	//ADMIN Action : Activatre user frontend user from backend
	jQuery(document).on('click', '.activate' ,function(){
		var userid = jQuery(this).parent().parent().data('userid');
		var elem = jQuery(this);
		jQuery.ajax({
			url: './action/activate',
			method: 'POST',
			data:{
				'userid': userid
			},
			dataType: 'json',
			beforeSend: function(){
				jQuery('.overlay-wrap').show();
			},
			success: function(data){
				if(data.status == 'Success'){
					jQuery('[data-status-'+userid+']').removeClass('label-danger').addClass('label-success').text('Active');
					elem.removeClass('activate').addClass('deactivate').html('<i class="icon-blocked"></i>Suspend');
				}
			},
			complete: function(){
				jQuery('.overlay-wrap').hide();
			}
		});
	});
	
	//ADMIN Action : verify and activate the cafe
	jQuery('.verify').click(function(){
		var cafeid = jQuery(this).data('cafeid');
		var elem = jQuery(this);
		jQuery.ajax({
			url: './action/activate_cafe',
			method: 'POST',
			data:{
				'cafeid' : cafeid
			},
			dataType: 'json',
			beforeSend: function(){
				jQuery('.overlay-wrap').show();
			},
			success: function(data){
				if(data.status){
					jQuery('[data-status-'+cafeid+']').removeClass('label-info').addClass('label-success').text('Active');
					elem.parent('li').remove();
					jQuery('.alert-cust').html('<strong>Success !</strong> '+ data.msg).removeClass('alert-danger').addClass('alert-success').show();
				}else{
					jQuery('.alert-cust').html('<strong>Error!</strong> '+ data.msg).removeClass('alert-success').addClass('alert-danger').show();
				}
			},
			complete: function(){
				jQuery('.overlay-wrap').hide();
			}
		});
		
	});
	
	jQuery('.save_sound').click(function(){
		var sound = jQuery(this).data('sound');
		var btn = jQuery(this);
		jQuery.ajaxFileUpload({
			url: './changeadminpass',
			method: 'POST',
			fileElementId	:sound,
			dataType: 'json',
			beforeSend: function(){
				btn.parent('.dashboard-flex').find('audio').hide();
				jQuery('.audio-loader').show();
			},
			data:{
				'choice': 'sound',
				'sonicsound': jQuery('#'+sound).val(),
				'sound': sound,
			},
			success: function(data){
				btn.parent('.dashboard-flex').after('<span class="ajx-result ajx-'+data.status+'"> '+data.msg+' </span>');
				setTimeout(function(){ jQuery( ".ajx-result" ).fadeOut(2000); }, 3000);
			},
			complete: function(){
				jQuery('.audio-loader').hide();
				btn.parent('.dashboard-flex').find('audio').show();
			}
		});
	});	
	
	//ADMIN Action : Update cafe details
	jQuery('.update-cafe').click(function(){
		jQuery('.overlay-wrap').show();
		jQuery.ajaxFileUpload({
			url: './updateCafe',
			method: 'POST',
			fileElementId	:'cafepic',
			dataType: 'json',
			beforeSend: function(){
				jQuery('.overlay-wrap').show();
			},
			data:{
				'cafename': jQuery('#cafename').val(),
				'email': jQuery('#email').val(),
				'phoneno': jQuery('#phoneno').val(),
				'address': jQuery('#address').val(),
				'city': jQuery('#city').val(),
				'state': jQuery('#state').val(),
				'pincode': jQuery('#zipcode').val(),
				'website': jQuery('#website').val(),
				'app_key': jQuery('#apikey').val(),
				'app_secret': jQuery('#appsecret').val(),
				'cafeimage': jQuery('#cafepic').val(),
				'cid': jQuery('#cid').val(),
				'verify': jQuery(this).data('verify')
			},
			success: function(data){
				console.log(data);
			},
			complete: function(){
				jQuery('.overlay-wrap').hide();
			}
		});
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