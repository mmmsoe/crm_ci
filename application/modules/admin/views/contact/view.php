<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>
	

	//Modal Open and Close
	 function model_hide_show(name)
	 {  
		if(name=="calls")
		{
			$("#modal-all_calls").removeClass("fade").modal("hide");
			$("#modal-create_calls").modal("show").addClass("fade");
		}
	 }
	 
	
</script>
 
 <!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
        <div class="row">
             <div style="float:right; padding-top:10px;">
            <?php if (check_staff_permission('contact_write')){?>
            	<a href="<?php echo base_url('admin/contact/update/'.$contact->id); ?>" class="btn btn-primary btn-embossed"> Edit Contact</a>
             <?php }?>	            	
            </div>                
		</div>
		<div class="row">
			<div class="panel">
				<h3 class="pad-l">Contact Detail Information</h3>
				<hr /><div class="clearfix"></div>
				<div class="panel-content">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-file-text-o"></i>Contact Owner</label>
								<div class="col-sm-7 append-icon">
									<p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('ACC_OWNER', $contact->contact_owner)->system_value_txt; ?></p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-archive"></i>Contact Name</label>
								<div class="col-sm-7 append-icon">					                                 
									<p class="pad-l">&nbsp;<?php echo $contact->first_name.' '.$contact->last_name; ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-user"></i>Account Name</label>
								<div class="col-sm-7 append-icon">					                                 
									<p class="pad-l">&nbsp;<?php echo $contact->account_name;?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-birthday-cake"></i>Date Birth</label>
								<div class="col-sm-7 append-icon">					                                 
									<p class="pad-l">&nbsp;<?php echo date('m-d-Y',$contact->date_birth);?></p>
								</div>
							</div>
						</div>
							<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-money"></i>Lead Source</label>
								<div class="col-sm-7 append-icon">
									<p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('LEAD', $contact->lead_source)->system_value_txt; ?></p>
								</div>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-building"></i>Title</label>
								<div class="col-sm-7 append-icon">					                                 
								<p class="pad-l">&nbsp;<?php echo $contact->title;?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-users"></i>Email</label>
								<div class="col-sm-7 append-icon">					                                 
								<p class="pad-l">&nbsp;<?php echo $contact->email;?></p>
								</div>
							</div>
						</div>
					</div>  
					<div class="row">
						<hr /><div class="clearfix"></div>
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-building"></i>Department</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $contact->department;?></p>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-phone"></i>Phone</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $contact->phone;?></p>
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-tablet"></i>Mobile</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $contact->mobile;?></p>
										</div>
									</div>
								</div>

								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-tablet"></i>Home Phone</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $contact->home_phone;?></p>
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-tty"></i>Other Phone</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $contact->other_phone;?></p>
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-fax"></i>Fax</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $contact->fax;?></p>
										</div>
									</div>
								</div>
															</div>
						</div>
						<div class="col-sm-6">
							<!--div class="widget-infobox">
								<a href="#" data-toggle="modal" data-target="#modal-all_calls">
									<div class="infobox">
											<div class="left">
											<i class="fa fa-phone bg-red"></i>
										</div>
										<div class="right">
											<div class="clearfix">
												<div>
													<span class="c-red pull-left"><?php echo count($calls);?></span>
													<br>
												</div>
												<div class="txt">CALLS</div>
											</div>
										</div>
									</div>
								</a>
							</div-->
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-users"></i>Assistant</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $contact->assistant;?></p>
										</div>
									</div>
								</div>
							</div> 
							<div class="row">
								 <div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-phone"></i>Assistant Phone</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $contact->asst_phone;?></p>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-paper-plane" aria-hidden="true"></i>Reports To</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $contact->reports_to;?></p>
										</div>
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-skype"></i>Skype</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $contact->skype_id;?></p>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-twitter"></i>Twitter</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $contact->twitter;?></p>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-envelope"></i>Secondary Email</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $contact->secondary_email;?></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					<div class="col-sm-6">
							
						</div>
					</div>  
					<div class="row">
						<hr /><div class="clearfix"></div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-street-view"></i>Mailling Street</label>
								<div class="col-sm-7 append-icon">
							<p class="pad-l">&nbsp;<?php echo $contact->mailling_street;?></p>
							</div>	
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-street-view"></i>Other Street</label>
								<div class="col-sm-7 append-icon">
							<p class="pad-l">&nbsp;<?php echo $contact->other_street;?></p>
							</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-building"></i>Mailling City</label>
								<div class="col-sm-7 append-icon">
								<p class="pad-l">&nbsp;<?php echo $contact->mailling_city;?></p>
							</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-building"></i>Other City</label>
								<div class="col-sm-7 append-icon">
							<p class="pad-l">&nbsp;<?php echo $contact->other_city;?></p>
							</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-map-marker"></i>Mailling State</label>
								<div class="col-sm-7 append-icon">
							<p class="pad-l">&nbsp;<?php echo $contact->mailling_state;?></p>
							</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-map-marker" aria-hidden="true"></i>Other State</label>
								<div class="col-sm-7 append-icon">
								<p class="pad-l">&nbsp;<?php echo $contact->other_state;?></p>
							</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-star"></i>Mailling Zip</label>
								<div class="col-sm-7 append-icon">
								<p class="pad-l">&nbsp;<?php echo $contact->mailling_zip;?></p>
							</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-star"></i>Other Zip</label>
								<div class="col-sm-7 append-icon">
								<p class="pad-l">&nbsp;<?php echo $contact->other_zip;?></p>
							</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-globe"></i>Mailling Country</label>
								<div class="col-sm-7 append-icon">
								<p class="pad-l">&nbsp;<?php echo $contact->mailling_country;?></p>
							</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-globe"></i>Other Country</label>
								<div class="col-sm-7 append-icon">
								<p class="pad-l">&nbsp;<?php echo $contact->other_country;?></p>
							</div>
							</div>
						</div>
					</div>
					<div class="row">
						<hr /><div class="clearfix"></div>
						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label"><i class="fa fa-clipboard"></i>Description</label>
								<div class="append-icon">
									<p class="pad-l"><?php echo $contact->description;?></p>
								</div>
							</div>
						</div>
					</div>		 
				</div>
			</div>
		</div>
	</div>   
<!-- END PAGE CONTENT -->
  
<!-- START MODAL CONTENT -->
	<div class="modal fade" id="modal-create_calls" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
				  <h4 class="modal-title"><strong>Leads</strong> Calls</h4>
				</div>
				<div id="call_ajax"> 
					<?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');}?>         
				</div>
					 
				<form id="add_call" name="add_call" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
					<input type="hidden" name="call_type_id" value="<?php echo $lead->id;?>"/>
					<input type="hidden" name="call_type" value="leads"/>	                        	
					<div class="modal-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="field-1" class="control-label">Date</label>
									<input type="text" class="date-picker form-control" name="date" id="date" placeholder="" value="<?php echo date('m/d/Y'); ?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="field-2" class="control-label">Call	Summary</label>
									<input type="text" class="form-control" name="call_summary" id="call_summary" placeholder="">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="field-4" class="control-label">Contact</label>
									<select name="company_id" id="company_id" class="form-control" data-search="true">
										<option value=""></option>
										<?php foreach( $companies as $company){ ?>
											<option value="<?php echo $company->id;?>"><?php echo $company->name;?></option>
										<?php }?> 
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="field-5" class="control-label">Responsible</label>
									<select name="resp_staff_id" id="resp_staff_id" class="form-control" data-search="true">
										<?php foreach( $staffs as $staff){ ?>
											<option value="<?php echo $staff->id;?>"><?php echo $staff->first_name.' '.$staff->last_name;?></option>
										<?php }?> 
									</select>
								</div>
							</div>
						</div>
					</div>
					<div id="call_submitbutton" class="modal-footer text-center"><button type="submit" class="btn btn-primary btn-embossed bnt-square">Create</button></div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-all_calls" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
					<h4 class="modal-title"><strong>Leads</strong> Calls</h4>
					<div class="m-t-20">
						<div class="btn-group">
							<a href="#" class="btn btn-sm btn-dark" onclick="model_hide_show('calls')"><i class="fa fa-plus"></i> Create New</a>
						</div>
					</div>
					<div class="panel-content pagination2 table-responsive">
						<table class="table table-hover table-dynamic ">
							<thead>
								<tr>
									<th>Date</th>
									<th>Call Summary</th>
									<th>Contact</th>
									<th>Responsible</th>                         
									<th><?php echo $this->lang->line('options'); ?></th>     
								</tr>
							</thead>
							<tbody>
								<?php if( ! empty($calls) ){?>
									<?php foreach( $calls as $call){ ?>
										<tr id="call_id_<?php echo $call->id; ?>">
											<td><?php echo date('m/d/Y',$call->date); ?></td>
											<td><?php echo $call->call_summary; ?></td>
											<td><?php echo $this->customers_model->get_company($call->company_id)->name;?></td>
											<td><?php echo $this->staff_model->get_user_fullname($call->resp_staff_id); ?></td>      	                        
											<td style="width: 13%;">
											<a href="<?php echo base_url('admin/leads/edit_call/'.$call->id); ?>" class="edit btn btn-sm btn-default"><i class="icon-note"></i></a>
											<a href="javascript:void(0)" class="delete btn btn-sm btn-danger" onclick="delete_calls(<?php echo $call->id; ?>)"><i class="icons-office-52"></i></a></td> 
										</tr> 
									<?php } ?>
								<?php } ?> 
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>       

	<div class="modal fade" id="modal-convert_to_opportunity" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                  <h4 class="modal-title"><strong>Convert</strong> to opportunity</h4>
                </div>
               	<div id="convert_to_oppo_ajax"> 
					<?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');}?>         
				</div>
				<form id="add_convert_to_opportunity" name="add_convert_to_opportunity" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
					<input type="hidden" name="convert_opport_lead_id" value="<?php echo $lead->id;?>"/>
					<div class="modal-body">
						<h3>Assign opportunities to</h3>
						<div class="row">                    
							<div class="col-md-6">
							  <div class="form-group">
									<label for="field-5" class="control-label">Salesperson</label>
									<select name="salesperson_id" id="salesperson_id" class="form-control" data-search="true">
										<?php foreach( $staffs as $staff){ ?>
											<option value="<?php echo $staff->id;?>" <?php if($lead->salesperson_id==$staff->id){?> selected="selected"<?php }?>><?php echo $staff->first_name.' '.$staff->last_name;?></option>
										<?php }?> 
									</select>
							  </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="field-4" class="control-label">Sales Team</label>
									<select name="sales_team_id" id="sales_team_id" class="form-control" data-search="true">
										<option value="" selected="selected"></option>
										<?php foreach( $salesteams as $salesteam){ ?>
											<option value="<?php echo $salesteam->id;?>" <?php if($lead->sales_team_id==$salesteam->id){?> selected="selected"<?php }?>><?php echo $salesteam->salesteam;?></option>
										<?php }?> 
									</select>
								</div>
							</div> 
						</div>
					</div>
					<div id="convert_to_oppo_submitbutton" class="modal-footer text-center"><button type="submit" class="btn btn-primary btn-embossed bnt-square">Create Opportunity</button></div>
                </form>
			</div>
		</div>
	</div>