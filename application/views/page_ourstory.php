<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyA-fiziZ98SYg88tsX-wGBEc7EYBv9KUTA"></script>
<?php
	// google map geocode api url
    /* $url = "https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyA-fiziZ98SYg88tsX-wGBEc7EYBv9KUTA";
 
    // get the json response
    $resp_json = file_get_contents($url);
     
    // decode the json
    $resp = json_decode($resp_json, true);
 
    // response status will be 'OK', if able to geocode given address 
    if($resp['status']=='OK'){
        // get the important data
        $lati = isset($resp['results'][0]['geometry']['location']['lat']) ? $resp['results'][0]['geometry']['location']['lat'] : "";
        $longi = isset($resp['results'][0]['geometry']['location']['lng']) ? $resp['results'][0]['geometry']['location']['lng'] : "";
        $formatted_address = isset($resp['results'][0]['formatted_address']) ? $resp['results'][0]['formatted_address'] : "";		
	} */
?>
<section class="card-wrap bg-back our-story">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-content story-cotent">
					<div class="story-head">
					     <div class="story-bg">
							<img src="<?=FRNT_ASSETS?>images/story-bg.png" alt="story-bg.png">
						</div>
						<div class="story-head-content">
							<div class="new-logo">
							<a href="#"><img src="<?=BASE_URL?>front_assets/images/LOGOWHITE.png "></a></div>
							<h2>Our Story</div>
						</div>
					
						<!-- <blockquote class="embedly-card insta-follow"><h4><a href="https://www.instagram.com/demo.narola/">FOLLOW US</a></h4></blockquote> -->
						<!-- <script async src="//cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script> -->
						<div class="story-text mCustomScrollbar" data-mcs-theme="dark">
							<?php
								echo $contents;
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>