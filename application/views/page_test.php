<section class="vendor-detail-wrap bg-back">
	<h3> Just for some testing </h3>
</section>
<script>
	jQuery(document).ready(function(){
		jQuery.ajax({
			url: 'test/checkAudio',
			complete: function(){
				// soundPlay(freecupsound);
				soundPlay(stampsound);
			}
		});
	});
</script>			