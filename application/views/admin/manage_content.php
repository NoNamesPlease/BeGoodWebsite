<script type="text/javascript" src="<?=ASSETS?>ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=ASSETS?>js/pages/editor_ckeditor.js"></script>
<!-- Content area -->
	<div class="content">

		<!-- CKEditor default -->
		<div class="panel panel-flat">
			<div class="panel-heading">
				<h5 class="panel-title">Out story page content</h5>
				<div class="heading-elements">
					<ul class="icons-list">
						<li><a data-action="collapse"></a></li>
						<li><a data-action="reload"></a></li>
						<li><a data-action="close"></a></li>
					</ul>
				</div>
			</div>

			<div class="panel-body">
				<p class="content-group">You can simply edit the content of Our Story page showing at the frontend. Just edit the contents below and save the changes. Look the Our Story page. Hurree....</p>
				<form action="<?=BASE_URL?>admin/editcontent" method="POST" name="frm-editcontent">
					<div class="content-group">
						<textarea name="editor-full" id="editor-full" rows="4" cols="4">
							<?php echo $content_ourstory; ?>
						</textarea>
					</div>

					<div class="text-right">
						<button type="submit" class="btn bg-teal-400">Submit form <i class="icon-arrow-right14 position-right"></i></button>
					</div>
				</form>
			</div>
		</div>
		<!-- /CKEditor default -->

		<!-- Footer -->
		<div class="footer text-muted">
			&copy; 2019. <a href="#">Be Good</a>
		</div>
		<!-- /footer -->

	</div>
	<!-- /content area -->

</div>
<!-- /main content -->