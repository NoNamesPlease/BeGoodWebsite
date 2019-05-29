<script src="<?=FRNT_ASSETS?>js/AjaxFileUpload.js"></script>
<div class="panel custom-panel">
	<form class="form-horizontal" method="POST" action=""> 
		<div class="row">
				<div class="col-md-3">
				<fieldset class="content-group">
						<div class="form-group upload-profile" style="background-image: url('<?php echo !empty($cafe['image']) ? BASE_URL.'uploads/cafe'.$cafe['image'] : FRNT_ASSETS.'images/upload.png' ?>'); background-size: 100%;">
							<label class="control-label col-lg-12">Upload Image</label>
							<input type="file" name="cafepic" id="cafepic" class="form-control file-inpt">
							<div class="del-btn"><a href="javascript:void(0)" class="clear-img"><i class="fa fa-times" aria-hidden="true"></i></a></div>
						</div>
					</fieldset>
				</div>
				<div class="col-md-9">
					<fieldset class="content-group">
						<div class="row">
							<div class="col-md-6">
								<input type="hidden" name="cid" id="cid" value="<?=$cafe['ID']?>" />
								<div class="form-group">
									<label for="cafename" class="control-label col-lg-12">Cafe Name</label>
									<div class="col-lg-12">
										<input type="text" id="cafename" name="cafename" class="form-control" value="<?=$cafe['name']?>">
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="control-label col-lg-12">Email</label>
									<div class="col-lg-12">
										<input type="text" id="email" name="email" class="form-control" value="<?=$cafe['email']?>">
									</div>
								</div>
								
								<div class="form-group">
									<label for="address" class="control-label col-lg-12">Address</label>
									<div class="col-lg-12">
										<input type="text" id="address" name="address" class="form-control" value="<?=$cafe['address']?>">
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="phoneno" class="control-label col-lg-12">Contact Number</label>
									<div class="col-lg-12">
										<input type="text" name="phoneno" id="phoneno" class="form-control" value="<?=$cafe['phoneno']?>">
									</div>
								</div>
								<div class="form-group">
									<label for="website" class="control-label col-lg-12">Website</label>
									<div class="col-lg-12">
										<input type="text" name="website" id="website" class="form-control" value="<?=$cafe['website']?>">
									</div>
								</div>
								<div class="form-group">
									<label for="city" class="control-label col-lg-12">City</label>
									<div class="col-lg-12">
										<input type="text" id="city" name="city" class="form-control" value="<?=$cafe['city']?>">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-12">Zip Code</label>
									<div class="col-lg-12">
										<input type="text" id="zipcode" name="zipcode" class="form-control" value="<?=$cafe['postalcode']?>">
									</div>
								</div>
							</div>
							<!-- for full width -->
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label col-lg-12">APP Key</label>
									<div class="col-lg-12">
										<input type="text" id="apikey" name="apikey" class="form-control" value="<?php echo !empty($stampkey) ? $stampkey : '' ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-lg-12">APP Secret</label>
									<div class="col-lg-12">
										<input type="text" id="appsecret" name="appsecret" class="form-control" value="<?php echo !empty($appsecret) ? $appsecret : '' ?>">
									</div>
								</div>
							</div>
						</div>
					</fieldset>
					
				</div>
				</div>
				<div class="text-right">
					<a href="<?=BASE_URL?>admin/managecafe" class="btn btn-primary">Cancel</a>
					<a href="javascript:void(0)" class="btn btn-primary update-cafe">Save <i class="icon-arrow-right14 position-right"></i></a>
					<?php if( $cafe['verified'] == 0 ){ ?>
					<a href="javascript:void(0)" data-verify="1" class="btn btn-primary update-cafe update-verify">Save & mark verified <i class="icon-checkmark position-right"></i></a>
					<?php } ?>
				</div>
				
			</form>
			<div class="overlay-wrap" style="display:none;"><div class="table-overlay"><img src="../../assets/images/white-loader.gif"/></div></div>
			</div>