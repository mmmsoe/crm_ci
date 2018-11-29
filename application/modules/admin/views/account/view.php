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
            <?php if (check_staff_permission('account_write')){?>
            	<a href="<?php echo base_url('admin/account/update/'.$account->id); ?>" class="btn btn-primary btn-embossed"> Edit Account</a>
             <?php }?>	            	
            </div>                
		</div>
		<div class="row">
			<div class="panel">
				<h3 class="pad-l">Account Detail Information</h3>
				<hr /><div class="clearfix"></div>
				<div class="panel-content">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-file-text-o"></i>Account Owner</label>
								<div class="col-sm-7 append-icon">
									<p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('ACC_OWNER', $account->account_owner)->system_value_txt; ?></p>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-flag"></i>Parent Account</label>
								<div class="col-sm-7 append-icon">					                                 
									<p class="pad-l">&nbsp;<?php echo $account->parent_account;?></p>
								</div>
							</div>
							</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-archive"></i>Account Name</label>
								<div class="col-sm-7 append-icon">					                                 
									<p class="pad-l">&nbsp;<?php echo $account->account_name; ?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-globe"></i>Account Site</label>
								<div class="col-sm-7 append-icon">					                                 
									<p class="pad-l">&nbsp;<?php echo $account->account_site;?></p>
								</div>
							</div>
							
						</div>
							<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-file-code-o"></i>Account Number</label>
								<div class="col-sm-7 append-icon">					                                 
									<p class="pad-l">&nbsp;<?php echo $account->account_number;?></p>
								</div>
							</div>
							
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-users"></i>Account Type</label>
								<div class="col-sm-7 append-icon">					                                 
									<p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('ACC_TYPE', $account->account_type)->system_value_txt; ?></p>
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
										<label class="col-sm-5 control-label"><i class="fa fa-building"></i>Industry</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('INDUSTRY', $account->industry)->system_value_txt; ?></p>
								</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-money"></i>Annual Revenue</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $account->annual_revenue;?></p>
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-star"></i>Rating</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('RATING', $account->rating)->system_value_txt; ?></p>
								</div>
									</div>
								</div>

								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-phone"></i>Phone</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $account->phone;?></p>
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-fax"></i>Fax</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $account->fax;?></p>
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-globe"></i></i>Website</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $account->website;?></p>
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
										<label class="col-sm-5 control-label"><i class="fa fa-rocket"></i>Ticker</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $account->ticker;?></p>
										</div>
									</div>
								</div>
							</div> 
							<div class="row">
								 <div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-lightbulb-o"></i>Ownership</label>
										<div class="col-sm-7 append-icon">
										<p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('OWNERSHIP', $account->ownership)->system_value_txt; ?></p>
									</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-paper-plane"></i>Employees</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $account->employee;?></p>
										</div>
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="col-sm-5 control-label"><i class="fa fa-file-code-o"></i></i>SIC</label>
										<div class="col-sm-7 append-icon">
											<p class="pad-l">&nbsp;<?php echo $account->sic;?></p>
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
								<label class="col-sm-5 control-label"><i class="fa fa-street-view"></i>Billing Street</label>
								<div class="col-sm-7 append-icon">
							<p class="pad-l">&nbsp;<?php echo $account->billing_street;?></p>
							</div>	
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-street-view"></i>Shipping Street</label>
								<div class="col-sm-7 append-icon">
							<p class="pad-l">&nbsp;<?php echo $account->shipping_street;?></p>
							</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-building"></i>Billing City</label>
								<div class="col-sm-7 append-icon">
								<p class="pad-l">&nbsp;<?php echo $account->billing_city;?></p>
							</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-building"></i>Shipping City</label>
								<div class="col-sm-7 append-icon">
							<p class="pad-l">&nbsp;<?php echo $account->shipping_city;?></p>
							</div>
							</div>
						</div>
					</div>
					
					
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-flag"></i>Billing State</label>
								<div class="col-sm-7 append-icon">
								<p class="pad-l">&nbsp;<?php echo $account->billing_state;?></p>
							</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-flag"></i>Shipping State</label>
								<div class="col-sm-7 append-icon">
							<p class="pad-l">&nbsp;<?php echo $account->shipping_state;?></p>
							</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-map-marker"></i>Billing Code</label>
								<div class="col-sm-7 append-icon">
							<p class="pad-l">&nbsp;<?php echo $account->billing_code;?></p>
							</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-map-marker" aria-hidden="true"></i>Shipping Code</label>
								<div class="col-sm-7 append-icon">
								<p class="pad-l">&nbsp;<?php echo $account->shipping_code;?></p>
							</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-globe"></i>Billing Country</label>
								<div class="col-sm-7 append-icon">
								<p class="pad-l">&nbsp;<?php echo $account->billing_country;?></p>
							</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="col-sm-5 control-label"><i class="fa fa-globe"></i>Shipping Country</label>
								<div class="col-sm-7 append-icon">
								<p class="pad-l">&nbsp;<?php echo $account->shipping_country;?></p>
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
									<p class="pad-l"><?php echo $account->description;?></p>
								</div>
							</div>
						</div>
					</div>		 
				</div>
			</div>
		</div>
	</div>   
<!-- END PAGE CONTENT -->
  