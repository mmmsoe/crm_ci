<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>
	/**Add Call**/ 
	$(document).ready(function() {
		$("form[name='add_call']").submit(function(e) {
			var formData = new FormData($(this)[0]);

			$.ajax({
				url: "<?php echo base_url('admin/leads/add_call'); ?>",
				type: "POST",
				data: formData,
				async: false,
				success: function (msg) {
				$('body,html').animate({ scrollTop: 0 }, 200);
				$("#call_ajax").html(msg); 
				
				if(msg=='yes')
				{	
					$("#modal-create_calls").removeClass("fade").modal("hide");			
					location.reload();	
				} 
				
				$("#call_submitbutton").html('<button type="submit" class="btn btn-primary btn-embossed bnt-square">Save</button>');
				
				 $("form[name='add_call']").find("input[type=text]").val(""); 
			},
				cache: false,
				contentType: false,
				processData: false
			});

			e.preventDefault();
		});
	});

	function delete_calls( call_id )
	 {
		var confir=confirm('Are you sure you want to delete this?');
		
		if(confir==true)
		{
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('admin/leads/call_delete' ); ?>/" + call_id,
				success: function(msg)
				{
					if( msg == 'deleted' )
					{
						$('#call_id_' + call_id).fadeOut('normal');
					}
				}

			});
		}
	 }

	//Modal Open and Close
	 function model_hide_show(name)
	 {  
		if(name=="calls")
		{
			$("#modal-all_calls").removeClass("fade").modal("hide");
			$("#modal-create_calls").modal("show").addClass("fade");
		}
	 }
	 
	 
	function getsalesteamdetails(id)
	{
		$.ajax({
			type: "POST",
			url: '<?php echo base_url('admin/salesteams/ajax_sales_team_list').'/';?>'+id,
			// data: id='cat_id',
			success: function(data){
				$("#load_sales").html(data);
				//$("#load_city").html('');
				$('#loader').slideUp(200, function() {
					$(this).remove();
				});
				$('select').select2();
			},
		});
	}
	 
	/**Add Opportunity**/ 

	$(document).ready(function() {
		$("form[name='add_convert_to_opportunity']").submit(function(e) {
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: "<?php echo base_url('admin/leads/convert_to_opportunity'); ?>",
				type: "POST",
				data: formData,
				async: false,
				success: function (msg) {
					var str=msg.split("_");
					var id=str[1];
					var status=str[0]; 
					
					if(status=="yes")
					{
						
						$('body,html').animate({ scrollTop: 0 }, 200);
						$("#convert_to_oppo_ajax").html('<?php echo '<div class="alert alert-success">'.$this->lang->line('create_succesful').'</div>'?>');
						
						setTimeout(function () {
						window.location.href="<?php echo base_url('admin/opportunities/view' ); ?>/"+id;
						}, 800); //will call the function after 2 secs.
						
					}
					else
					{
						
					$('body,html').animate({ scrollTop: 0 }, 200);
					$("#convert_to_oppo_ajax").html(msg); 
					$("#convert_to_oppo_submitbutton").html('<button type="submit" class="btn btn-primary btn-embossed bnt-square">Save</button>');
					
					 $("form[name='add_convert_to_opportunity']").find("input[type=text]").val(""); 
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
 <style>
.btn-success[disabled],.btn-warning[disabled] {
	 background-color: #807D7A;
 }
 </style>
 <!-- BEGIN PAGE CONTENT -->
	<div class="page-content">
         <div class="row">
            <h2 class="col-md-6"><strong><?php echo $lead->opportunity;?></strong></h2> 
            <div style="float:right; padding-top:10px;">
            <?php if (check_staff_permission('lead_write')){?>
				<?php if ($lead->customer_id==0 || $this->leads_model->get_id($lead->customer_id)==0){ ?>
					<!--<a href="<?php echo base_url('admin/leads/convert_to_customer/'.$lead->id); ?>" class="btn btn-warning btn-embossed">Convert to Account</a>-->
                                        <a href="<?php echo base_url('admin/customers/add_from_leads/'.$lead->id); ?>" class="btn btn-warning btn-embossed">Convert to Account</a>
					<a href="<?php echo base_url('admin/leads/update/'.$lead->id); ?>" class="btn btn-primary btn-embossed"> Edit Lead</a>
				<?php }else if ($this->leads_model->exists_leads($lead->id)==0){ ?>
					<a href="#" data-toggle="modal" data-target="#modal-convert_to_opportunity" class="btn btn-success btn-embossed">Convert to opportunity</a>
					<a href="<?php echo base_url('admin/leads/update/'.$lead->id); ?>" class="btn btn-primary btn-embossed"> Edit Lead</a>
				<?php } ?>
             <?php }?>	            	
            </div>                
		</div>
		<div class="row">
			<?php
				echo $check_leader_lead;
			?>
			<div class="panel">
				<h3 class="pad-l">Lead Detail Information</h3>
				<hr /><div class="clearfix"></div>
				<div class="panel-content">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-file-text-o"></i>Lead Name</label>
								<div class="col-sm-7 append-icon">
									<p class="pad-l">&nbsp;<?php echo $lead->lead_name;?></p>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-money"></i>Annual Revenue</label>
								<div class="col-sm-7 append-icon">
									<p class="pad-l">&nbsp;<?=($lead->annual_revenue != "" ? number_format($lead->annual_revenue,2,'.',',') : '')?></p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-archive"></i>Campaign Source</label>
								<div class="col-sm-7 append-icon">					                                 
									<p class="pad-l">&nbsp;<?php echo $this->campaign_model->get_campaign($lead->campaign_id)->campaign_name; ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-spinner"></i>Lead Status</label>
								<div class="col-sm-7 append-icon">					                                 
									<p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('LEAD_STATUS', $lead->lead_status_id)->system_value_txt; ?></p>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-user-plus"></i>Sales</label>
								<div class="col-sm-7 append-icon">					                                 
									<p class="pad-l">&nbsp;<?php echo $this->staff_model->get_user($lead->salesperson_id)->first_name.' '.$this->staff_model->get_user($lead->salesperson_id)->last_name; ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-users"></i>Sales Team</label>
								<div class="col-sm-7 append-icon">					                                 
									<p class="pad-l">&nbsp;<?php echo $this->salesteams_model->get_salesteam($lead->sales_team_id)->salesteam; ?></p>
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
										<label class="col-sm-5 control-label"><i class="fa fa-building"></i>Company Name</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php if($lead->customer_id == 0){ ?> <?php echo $lead->company_name;?> <?php }else{ ?> <a href="<?php echo base_url('admin/customers/view/'.$lead->customer_id); ?>"><?php echo $lead->company_name;?></a>	<?php } ?>
											</p>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-map-marker"></i>Address</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $lead->address;?></p>
											<p class="pad-l">&nbsp;<?php echo city_name($lead->city_id)->name; ?></p>
											<p class="pad-l">&nbsp;<?php echo state_name($lead->state_id)->name; ?><?=(state_name($lead->state_id)->name != "" && country_name($lead->country_id)->name != "" ? ", " : '')?><?php echo country_name($lead->country_id)->name; ?></p>
											<p class="pad-l">&nbsp;<?php echo $lead->zip_code; ?></p>
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
										<label class="col-sm-5 control-label"><i class="fa fa-user"></i>Contact Name</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $lead->contact_name;?></p>
										</div>
									</div>
								</div>
							</div> 
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-envelope"></i>Email</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $lead->email;?></p>
										</div>
									</div>
								</div>
							</div> 
							<div class="row">
								 <div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-phone"></i>Phone</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $lead->phone;?></p>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-tablet"></i>Mobile</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $lead->mobile;?></p>
										</div>
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-fax"></i>Fax</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $lead->fax;?></p>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-globe"></i>Website</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $lead->website;?></p>
										</div>
									</div>
								</div>
							</div>
							<!--<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-globe"></i>Tags</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('LEAD', implode(',',$lead->tags_id))->system_value_txt; ?></p>
							
					</div>
									</div>
								</div>
							</div>-->
						</div>
					</div>
					<div class="row">
						<div class="clearfix mar-t"></div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-envelope"></i>Secondary Email</label>
								<div class="col-sm-7 append-icon">					                                 
									<p class="pad-l">&nbsp;<?php echo $lead->secondary_email; ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-skype"></i>Skype id</label>
								<div class="col-sm-7 append-icon">					                                 
									<p class="pad-l">&nbsp;<?php echo $lead->skype_id; ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-twitter"></i>twitter</label>
								<div class="col-sm-7 append-icon">					                                 
									<p class="pad-l">&nbsp;<?=($lead->twitter != "" ? '@'.$lead->twitter : '')?></p>
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
								<label class="col-sm-5 control-label"><i class="fa fa-group"></i>No of Employees</label>
								<div class="col-sm-7 append-icon">
									<p class="pad-l">&nbsp;<?php echo $lead->no_of_employees;?></p>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-briefcase"></i>Industry</label>
								<div class="col-sm-7 append-icon">
									<p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('INDUSTRY', $lead->industry_id)->system_value_txt;?></p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-star"></i>Rating</label>
								<div class="col-sm-7 append-icon">
									<p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('RATING', $lead->rating_id)->system_value_txt; ?></p>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-thumbs-o-up"></i>Priority</label>
								<div class="col-sm-7 append-icon">
									<p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('PRIORITY', $lead->priority_id)->system_value_txt;?></p>
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
									<p class="pad-l"><?php echo $lead->description;?></p>
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
					<div class="modal-body clearPad-tb">
						<div class="row">                    
							<div class="col-md-6">
							  <div class="form-group">
									<label class="control-label">Opportunity Owner</label>
									<div class="form-group">
										<div class="form-group col-xs-4 clearPad-lr clearRad-r-box">
											<select name="sales_team_id" id="sales_team_id" class="form-control full" data-search="true" onChange="getsalesteamdetails(this.value)">
												<option value="" selected="selected">Choose Team</option>
												<?php foreach( $salesteams as $salesteam){ ?>
													<option value="<?php echo $salesteam->id;?>" <?php if($lead->sales_team_id==$salesteam->id){?> selected="selected"<?php }?>><?php echo $salesteam->salesteam;?></option>
												<?php }?> 
											</select>
										</div>
										<div class="form-group col-xs-8 clearPad-lr bord-l clearRad-l-box" id="load_sales">
											<select name="salesperson_id" id="salesperson_id" class="form-control full clearRad-r" data-search="true">
												<option value="" selected="selected">Choose Sales</option>
												<?php 
												$salesteams = $this->salesteams_model->get_salesteam($lead->sales_team_id);
												$team = explode(',', $salesteams->team_members);
												foreach( $staffs as $staff){ ?>
													<?php if(in_array($staff->id,$team)){?>
														<option value="<?php echo $staff->id;?>" <?php if($lead->salesperson_id == $staff->id){?> selected <?php }?> ><?php echo $staff->first_name.' '. $staff->last_name;?></option>
													<?php }?> 
												<?php }?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label" style="color:red">* Opportunity</label>
									<div class="append-icon">
										<input type="text" name="opportunity" value="<?php echo $lead->lead_name;?>" class="form-control">
										<i class="fa fa-file-text-o"></i>
									</div>
								</div>
								
							</div> 
						</div>
						<div class="row">                    
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Probability</label>
									<div class="append-icon">
									<input type="text" name="probability" id="probability" value="" class="form-control numeric">
										<i class="">%</i>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Amount</label>
									<div class="append-icon">
										<div class="input-group">
											<div class="input-group-addon">$</div>
											<input type="text" name="amount" value="" class="form-control numeric">
										</div>
									</div>
								</div>							
							</div> 
						</div>
						<div class="row">                    
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label" style="color:red">* Expected Closing</label>
									<div class="append-icon">
										<input type="text" name="expected_closing" value="" class="date-picker form-control" >
										<i class="icon-calendar"></i>    
									</div>
								</div>	
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Expected Revenue</label>
									<div class="append-icon">
										<!--<div class="input-group">-->
											<input type="text" name="expected_revenue" value="<?php echo $lead->annual_revenue;?>" class="form-control numeric">
										<!--</div>-->
									</div>
								</div>
							</div> 
						</div>
						<div class="row">                    
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Campaign Source</label>
									<div class="append-icon">
										<select name="campaign_source_id" id="campaign_source_id" class="form-control" data-search="true">
											<option value="" selected="selected">Choose Source</option>
											<?php foreach( $campaigns as $campaign){ ?>
												<option value="<?php echo $campaign->id;?>" <?php if ($lead->campaign_id == $campaign->id) { ?> selected="selected"<?php } ?>><?php echo $campaign->campaign_name;?></option>
											<?php }?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Type</label>
									<div class="append-icon">
										<select name="type_id" id="type_id" class="form-control" data-search="true">
											<option value="" selected="selected">Choose Type</option>
											<?php foreach( $types as $type){ ?>
												<option value="<?php echo $type->system_code;?>"><?php echo $type->system_value_txt;?></option>
											<?php }?>
										</select>
									</div>
								</div>	
							</div> 
						</div>
						<div class="row">                    
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Next Action Date</label>
									<div class="append-icon">
										<input type="text" name="next_action" value="" class="date-picker form-control">
										<i class="icon-calendar"></i>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Next Action</label>
									<div class="append-icon">
										<input type="text" name="next_action_title" value="" class="form-control">
									</div>
								</div>
							</div> 
						</div>
					</div>
					<hr/>
					<div id="convert_to_oppo_submitbutton" class="modal-footer clearPad-t"><button type="submit" class="btn btn-primary btn-embossed bnt-square">Create Opportunity</button></div>
                </form>
			</div>
		</div>
	</div>