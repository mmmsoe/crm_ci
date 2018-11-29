<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

//Contact Person
$(document).ready(function() {
	
	$("form[name='add_contact_person']").submit(function(e) {
        var formData = new FormData($(this)[0]);
		$.ajax({
			url: "<?php echo base_url('admin/opportunities/add_process_ajax'); ?>",
            type: "POST",
            data: formData,
            async: false,
            success: function (msg) {
				var str=msg.split("_");
				var id=str[1].split("{");
				var status=str[0]; 
				
				$("#main_contact_person option:first").after($('<option>', {
					value: msg.co_person_id,
					text: msg.co_person_name,
					selected: true
				}));
				
				
				if(status=="yes")
				{
					$('#modal-create_customer').animate({ scrollTop: 0 }, 200);
					$("#contact_person_ajax").html('<?php echo '<div class="alert alert-success">'.$this->lang->line('create_succesful').'</div>'?>');
					setTimeout(function () {
						$('#modal-create_customer').modal('hide');
						contactName($("#acc_customer_id").val(),id[0]);
					}, 800);  //will call the function after 1 secs.
					$("form[name='add_contact_person']").find("input[type=text],select, textarea,input[type=email],input[type=password]").val("");		
				}
				else
				{
					$('#modal-create_customer').animate({ scrollTop: 0 }, 200);
					$("#contact_person_ajax").html(msg); 
					$("#contact_person_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');
					
					// $("form[name='add_customer']").find("input[type=text], textarea").val("");
				}
			
        },
            cache: false,
            contentType: false,
            processData: false
        });

        e.preventDefault();
    });
});
 
 </script>
 
 <!-- BEGIN PAGE CONTENT -->
 <div class="modal fade" id="modal-create_customer" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
				<h2 class="col-md-6"><strong>Add Contact</strong></h2>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="page-content">
						 <div class="panel">
							 <div class="panel-content">
								<div id="customer_ajax"> 
									<?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');}?>         
								</div>
										 
								<form id="add_contact_person" name="add_contact_person" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">			 
									<div class="row">
										<input type="hidden" name="company_id" id="acc_customer_id" class="form-control" >
										<div class="col-sm-6">
												<label class="control-label"style="color:red;">* First Name</label>
												<div class="form-group">
													<div class="form-group col-xs-4 clearPad-lr clearRad-r-box">
														<select name="title_id" id="title_id" class="form-control full" data-search="true">
															<option value="" selected="selected">None</option>
															<?php foreach ($titles as $title) { ?>
																<option value="<?php echo $title->system_code; ?>" <?php if ($contact_persons->title_id == $title->system_code) { ?> selected="selected"<?php } ?>><?php echo $title->system_value_txt; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="form-group col-xs-8 clearPad-lr bord-l">		
														<div class="append-icon">
															<input type="text" name="first_name" value="<?php echo $contact_persons->first_name; ?>" class="form-control full-break clearRad-l" >
															<i class="icon-user"></i>
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label"style="color:red;">* Last Name</label>
													<div class="append-icon">
														<input type="text" name="last_name" value="<?php echo $contact_persons->last_name; ?>" class="form-control" >
														<i class="icon-user"></i>
													</div>
												</div>
											</div>
										</div>
									
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">Date Of Birth</label>
													<div class="append-icon">
														<input type="text" id="min" name="date_birth" value="" class="date-picker form-control">
														<i class="icon-calendar"></i>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label"style="color:red;">* Email</label>
													<div class="append-icon">
														<input type="email" name="email" value="<?php echo $contact_persons->email;?>" class="form-control" >
														<i class="icon-envelope"></i>
													</div>
												</div>
											</div>
										</div>
											
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">Phone</label>
													<div class="append-icon">
														<input type="text" name="phone" value="<?php echo $contact_persons->phone;?>" class="form-control numeric">
														<i class="fa fa-phone"></i>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">Mobile</label>
													<div class="append-icon">
														<input type="text" name="mobile" value="<?php echo $contact_persons->mobile;?>" class="form-control numeric">
														<i class="icon-screen-smartphone"></i>
													</div>
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">Website</label>
													<div class="append-icon">
														<input type="text" name="website" value="<?php echo $contact_persons->website;?>" class="form-control">
														<i class="icon-globe"></i>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">Fax</label>
													<div class="append-icon">
														<input type="text" name="fax" value="<?php echo $contact_persons->fax;?>" class="form-control numeric">
														<i class=" fa fa-fax"></i>
													</div>
												</div>
											</div>
										</div>
										
										<div class="row">
											<h3 class="pad-l">Other Information</h3>
											<hr /><div class="clearfix"></div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">Twitter</label>
													<div class="append-icon">
														<div class="input-group">
															<div class="input-group-addon">@</div>
															<input type="text" name="twitter" value="<?php echo $contact_persons->twitter;?>" class="form-control">
															<div class="input-group-addon"><i class="fa fa-twitter"></i></div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">Skype ID</label>
													<div class="append-icon">
														<input type="text" name="skype_id" value="<?php echo $contact_persons->skype_id;?>" class="form-control">
														<i class="fa fa-skype"></i>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">Secondary Email</label>
													<div class="append-icon">
														<input type="email" name="secondary_email" value="<?php echo $contact_persons->secondary_email;?>" class="form-control">
														<i class="icon-envelope"></i>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<div class="form-group col-xs-6 clearPad-lr">
														<label class="control-label">Main Contact Person</label>
														<div class="append-icon">
															<input type="checkbox" name="main_contact_person" value="1" data-checkbox="icheckbox_square-blue" <?=($contact_persons->main_contact_person == 1 ? 'checked = "checked"' : '' ) ?> /> 
														</div>
													</div>
													<div class="form-group col-xs-6 clearPad-lr clearRad-r-box">
														<label class="control-label">Email Opt Out</label>
														<div class="append-icon">
															<input type="checkbox" name="email_opt_out" value="1" data-checkbox="icheckbox_square-blue"  <?=($contact_persons->email_opt_out == 1 ? 'checked = "checked"' : '' ) ?>/> 
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">Upload your avatar</label>
													<div class="append-icon">
														<div class="file">
															<div class="option-group">
																<span class="file-button btn-primary">Choose File</span>
																<input type="file" class="custom-file" name="customer_avatar" id="customer_avatar" onchange="document.getElementById('upload').value = this.value;">
																<input type="text" class="form-control" id="upload" placeholder="no file selected" readonly="">
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												
											</div>	
										</div>
										<div class="row">
											<h3 class="pad-l">Address Information</h3>
											<hr /><div class="clearfix"></div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">Address</label>
													<div class="append-icon">
														<textarea name="address" rows="4" class="form-control height-row-2"><?php echo $contact_persons->address;?></textarea> 
														<i class="fa fa-map-marker"></i>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label">Zip Code</label>
													<div class="append-icon">
														<input type="text" name="zip_code" value="<?php echo $contact_persons->zip_code;?>" class="form-control">
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="control-label">Select Country</label>
													<div class="col-sm-12 clearPad-lr">
														<select name="country_id" id="country_id" class="form-control reHeight" data-search="true" onChange="getstatedetails(this.value)">
															<option value="" selected="selected">Choose one</option>
															<?php foreach( $countries as $country){ ?>
																<option value="<?php echo $country->id;?>" <?php if($contact_persons->country_id==$country->id){?> selected="selected"<?php }?>><?php echo $country->name;?></option>
															<?php }?> 
														</select>
													</div>
													<div class="clearfix"></div>
												</div>
												<div class="form-group">
													<label class="control-label">State & City</label>
													<div class="form-group">
														<div class="form-group col-xs-6 clearPad-lr clearRad-r-box" id="load_state">
															<!--input type="text" value="" class="form-control" readOnly="readOnly"-->
															<select name="state_id" id="state_id" class="form-control reHeight" onChange="getcitydetails(this.value)">
																<option value="" selected="selected">Select State</option>
																<?php $states=$this->contact_persons_model->state_list($contact_persons->country_id);?>
																<?php foreach($states as $state){ ?>
																	<option value="<?php echo $state->id; ?>" <?php if($contact_persons->state_id==$state->id){?> selected="selected"<?php }?>><?php echo $state->name; ?></option>
																<?php }?>
															</select>
														</div>
														<div class="form-group col-xs-6 clearPad-lr bord-l  clearRad-l-box" id="load_city">
															<!--input type="text" value="" class="form-control" readOnly="readOnly"-->
															<select name="city_id" id="city_id" class="form-control">
																<option value="" selected="selected">Select City</option>
																<?php $cities=$this->contact_persons_model->city_list($contact_persons->state_id);?>
																<?php foreach($cities as $city){ ?>
																	<option value="<?php echo $city->id; ?>" <?php if($contact_persons->city_id==$city->id){?> selected="selected"<?php }?>><?php echo $city->name; ?></option>
																<?php }?>
															</select>
														</div>
														<div class="clearfix"></div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<h3 class="pad-l">Description Information</h3>
											<hr /><div class="clearfix"></div>
											<div class="col-sm-12">
												<div class="form-group">
													<div class="append-icon">
														<textarea name="description" rows="4" class="form-control"><?php echo $contact_persons->description;?></textarea> 
														<i class="fa fa-clipboard"></i>
													</div>
												</div>
											</div>
										</div>
									<div class="row">
										<div id="contact_person_submitbutton" class="modal-footer" style="float: left;"><button type="submit" class="btn btn-primary btn-embossed bnt-square">Create</button></div>
									</div>
								</form>  				    
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>   
<!-- END PAGE CONTENT -->