jQuery(document).ready(function(){

	jQuery(".mobile-nav a").click(function(){
		jQuery(this).closest(".custom-header").find(".navigation ul").toggleClass("open-menu");
		
	});
	
	jQuery(".close-menu a").click(function(){	
		jQuery(".navigation ul").removeClass("open-menu");
	});

	//backgroundHeight()
	equal_height();	
	jQuery('.carousel').carousel();
	//slickClassAdd();
	profileTimeLineHeight();
	addScrollCafeRegister();
	registerRightHeight();
	searchRightHeight();
	stampHeight();
	

	jQuery(window).resize(function(){
		equal_height();
		
		//backgroundHeight();
		//slickClassAdd();
		profileTimeLineHeight();
		addScrollCafeRegister();
		registerRightHeight();
		searchRightHeight();
		stampHeight();
		
	});
	jQuery(document).resize(function(){
		equal_height();
		
		//backgroundHeight();
		slickClassAdd();
		profileTimeLineHeight();
		addScrollCafeRegister();
		registerRightHeight();
		searchRightHeight();
		stampHeight();
		
	});

	
	// jQuery(".redeem-wrap .dash-btn, .stamp-free-coffee").click(function(){
	jQuery(document).on('click', ".act-swipescreen, .btn-plant-tree", function(){
		jQuery(".slide-stamp").addClass("swipeUp");
		jQuery(".v-container").addClass("hide-now");
	});
	jQuery('.backtocafe').click(function(){
		jQuery(".slide-stamp").removeClass("swipeUp");
		jQuery(".v-container").removeClass("hide-now");
		jQuery(".tree-plant-done").addClass("hide-txt");
		isReadingStamp = false;
	}); 
	var val;
	var r,c, pct;
	jQuery('.svg-cont').each(function(){
		val = jQuery(this).find(".pro-count").html();
		console.log(val)
		var $circle = jQuery(this).find('.svg .bar');

		if (isNaN(val)) {
			val = 10; 

		}
		else{
			r = $circle.attr('r');
			c = Math.PI*(r*2);

			if (val < 0) { val = 0;}
			if (val > 10) { val = 10;}

			pct = ((10-val)/10)*c;

			$circle.css({"stroke-dashoffset": pct});

			//$('#cont').attr('data-pct',val);
		}
	});
	
	if(jQuery(".navigation ul li").hasClass("logout-li")){
		jQuery(".navigation ul li").addClass("width-20");
	}
	
	/*jQuery('.mobile-slick').slick({
			centerMode: true,
			centerPadding: '60px',
			slidesToShow: 3,
			horizontal:true,
			responsive: [
				{
				breakpoint: 768,
				settings: {
					arrows: false,
					centerMode: true,
					centerPadding: '0px',
					slidesToShow: 1,
					slidesToScroll:1
				}
				},
				{
				breakpoint: 480,
				settings: {
					arrows: false,
					centerMode: true,
					centerPadding: '0px',
					slidesToShow: 1,
					slidesToScroll:1
				}
				}
			]
		});*/
	
	jQuery.ajax({
		url: './stamping',
		method: 'POST',
		dataType: 'json',
		data: {
			'cid' : 2
		},
		success: function(){
			
		},
		complete: function(){
			
		}
	});
	
	//back button
	jQuery('.back-btn').click(function(){
		window.history.back();
	});
		
/*	var type = 1, //circle type - 1 whole, 0.5 half, 0.25 quarter
	radius = "100px", //distance from center
	start = -90, //shift start from 0
	$elements = jQuery(".current-progress ul li"),
	numberOfElements = type === 1 ? $elements.length : $elements.length - 1, //adj for even distro of elements when not full circle
	slice = 360 * type / numberOfElements;

	$elements.each(function(i) {
	  var $self = jQuery(this),
		rotate = slice * i + start,
		rotateReverse = rotate * -1;
	  	$self.css({transform: "rotate(" +rotate + "deg) translate(" + radius + ") rotate(" + rotateReverse + "deg)" });
	});
*/
	

	
		
	

});
function addScrollCafeRegister(){
	var registerWidth = jQuery(window).width();
	if(registerWidth < 768){
		jQuery(".reg-right").addClass("mCustomScrollbar");
		jQuery(".reg-right").attr("data-mcs-theme","dark");

		jQuery(".search-right ").addClass("mCustomScrollbar");
		jQuery(".search-right ").attr("data-mcs-theme","dark");

		jQuery(".edit-right ").addClass("mCustomScrollbar");
		jQuery(".edit-right ").attr("data-mcs-theme","dark");
	}
	else{
		jQuery(".search-right ").removeClass("mCustomScrollbar");
		jQuery(".search-right ").attr("data-mcs-theme"," ");


		jQuery(".search-right ").removeClass("mCustomScrollbar");
		jQuery(".search-right ").attr("data-mcs-theme"," ");

		jQuery(".edit-right ").removeClass("mCustomScrollbar");
		jQuery(".edit-right ").attr("data-mcs-theme"," ");
	}
}

function searchRightHeight(){
	var register_window_width = jQuery(window).width();

	if( register_window_width < 768){
		if(jQuery(window).innerHeight() < jQuery(window).innerWidth()){
			//alert("hi")
		    var registerLeftHeight = jQuery(".reg-left").outerHeight();
			//console.log(registerLeftHeight)
			var register_window_width = jQuery(window).height();
			//console.log(register_window_width)
			var register_cafe = register_window_width - registerLeftHeight - 150;
			jQuery(".search-right").css({"height":register_cafe});
		}else{
			var registerLeftHeight = jQuery(".reg-left").outerHeight();
			//console.log(registerLeftHeight)
			var register_window_width = jQuery(window).height();
			//console.log(register_window_width)
			var register_cafe = register_window_width - registerLeftHeight - 330;
			jQuery(".search-right").css({"height":register_cafe});
		}
	}
	else{
		jQuery(".search-right").css({"height":""});
	}
}
function registerRightHeight(){
	var register_window_width = jQuery(window).width();

	if( register_window_width < 768){
		if(jQuery(window).innerHeight() < jQuery(window).innerWidth()){
			//alert("hi")
		    var registerLeftHeight = jQuery(".reg-left").outerHeight();
			//console.log(registerLeftHeight)
			var register_window_width = jQuery(window).height();
			//console.log(register_window_width)
			var register_cafe = register_window_width - registerLeftHeight - 120;
			jQuery(".reg-right").css({"height":register_cafe});
			jQuery(".edit-right").css({"height":register_cafe});
		}else{
			var registerLeftHeight = jQuery(".reg-left").outerHeight();
			//console.log(registerLeftHeight)
			var register_window_width = jQuery(window).height();
			//console.log(register_window_width)
			var register_cafe = register_window_width - registerLeftHeight - 150;
			jQuery(".reg-right").css({"height":register_cafe});
			jQuery(".edit-right").css({"height":register_cafe});
		}
	}
	else{
		jQuery(".reg-right").css({"height":"auto"});
		jQuery(".edit-right").css({"height":"auto"});
	}
}
function stampHeight(){
	
	var register_window_width = jQuery(window).width();

	
		if(jQuery(window).innerHeight() < jQuery(window).innerWidth()){
			var stampTopHeight = jQuery(".card-image-bg").outerHeight();
			// console.log(stampTopHeight);
			var stamp_window_height = jQuery(window).height();
			// console.log(stamp_window_height);
			var profile_timeline = stamp_window_height - stampTopHeight + 150;
			jQuery(".card-content-block .h-wrapper").css({"height":profile_timeline});
			
		}else{
			var stampTopHeight = jQuery(".card-image-bg").outerHeight();
			// console.log(stampTopHeight);
			var stamp_window_height = jQuery(window).height();
			// console.log(stamp_window_height);
			var profile_timeline = stamp_window_height - stampTopHeight - 150;
			jQuery(".card-content-block .h-wrapper").css({"height":profile_timeline});
		}
	
}
function profileTimeLineHeight(){
	var profile_window_width = jQuery(window).width();

	if( profile_window_width > 768){

		var profileLeftHeight = jQuery(".profile-left").height();
		jQuery(".p-timeline ul").css({"height":profileLeftHeight});
	}
	else{
		var profileLeftHeight = jQuery(".profile-left").outerHeight();
		//console.log(profileLeftHeight)
		var profile_window_height = jQuery(window).height();
		//console.log(profile_window_height)
		var profile_timeline = profile_window_height - profileLeftHeight - 100;
		jQuery(".p-timeline ul").css({"height":profile_timeline});
	}
}
/*function slickClassAdd(){
	var slick_window_width = jQuery(window).width();
	if( slick_window_width < 768){
		
		jQuery('#animatingCards').addClass('mobile-slick');	
		jQuery('#animatingCards').removeClass('desktop-slick');	
	}
	else{
		jQuery('#animatingCards').removeClass('mobile-slick');	
		jQuery('#animatingCards').addClass('desktop-slick');	
	}
}*/
function backgroundHeight(){
	var windHeight = jQuery( window ).height();
	var screenWidth = jQuery( window ).width();
	var totalHeight = windHeight - 153;

	if(screenWidth > 767){
		jQuery(".background-bg").css({"height": totalHeight});
		jQuery(".bg-back").css({"height": totalHeight});
		jQuery(".cafe-nt-available").css({"height": totalHeight});
		
	}
	else{
		jQuery(".background-bg").css({"height": windHeight});
		jQuery(".bg-back").css({"height": windHeight});
		jQuery(".cafe-nt-available").css({"height": windHeight});
	}
	
}
function equal_height(){
	var colHeight = $(".edit-profile-container form").outerHeight();
	jQuery(".p-left-image,.p-right-image").css({"height":colHeight});
}

function refresh_files(){
	jQuery.get('./upload/files/')
	.success(function (data){
		jQuery('#files').html(data);
	});
}

function readURLtest(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			jQuery(input).parent().css('background-image', "url('"+e.target.result+"')");
			jQuery('.cafe-signup').css('background-image', "url('"+e.target.result+"')");
			jQuery('.cafe-signup').css('opacity', '0.6');
		}

		reader.readAsDataURL(input.files[0]);
	}
}
function readImgURL(input, in_bg = true) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			if(in_bg){
				jQuery(input).parent().css('background-image', "url('"+e.target.result+"')");
				jQuery('.cafe-signup').css('background-image', "url('"+e.target.result+"')");
				jQuery('.cafe-signup').css('opacity', '0.6');
			}else{
				jQuery(input).attr('src', "url('"+e.target.result+"')");
			}
			return e.target.result;
		}
		reader.readAsDataURL(input.files[0]);
	}
}
/*** For add to home screen ***/
/*if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('/sw.js').then(function(registration) {
      // Registration was successful
      console.log('ServiceWorker registration successful with scope: ', registration.scope);
    }, function(err) {
      // registration failed :(
      console.log('ServiceWorker registration failed: ', err);
    });
  });
}*/

/*** !- For add to home screen ***/