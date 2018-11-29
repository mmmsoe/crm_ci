<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

$(document).ready(function() {
	$("form[name='update_salesteams']").submit(function(e) {
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "<?php echo base_url('admin/salesteams/update_process'); ?>",
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
					$("#salesteams_ajax").html('<?php echo '<div class="alert alert-success">'.$this->lang->line('update_succesful').'</div>'?>');
					setTimeout(function () {
					window.location.href="<?php echo base_url('admin/salesteams/index' ); ?>";
					}, 800); //will call the function after 1 secs.
				}
				else
				{
			$('body,html').animate({ scrollTop: 0 }, 200);
            $("#salesteams_ajax").html(msg); 
			$("#salesteams_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');
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
        <div class="page-content">
        <div class="header">
            <h2><strong>Update Sales Team</strong></h2>            
          </div>
           <div class="row">
           	<div class="col-md-12">
                  <div class="panel">
                     
                     <div class="panel-content">
                   					<div id="salesteams_ajax"> 
				                          <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');}?>         
				                      </div>
				         
				           <form id="update_salesteams" name="update_salesteams" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
 
                        			<input type="hidden" name="salesteam_id" value="<?php echo $salesteam->id;?>"/>
                        				                        				 
                        				<div class="row">
                          					<div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label"style="color:red;">* Sales Team</label>
					                              <div class="append-icon">
					                                <input type="text" name="salesteam" value="<?php echo $salesteam->salesteam;?>" class="form-control">
					                                 
					                              </div>
					                            </div>
					                          </div>
					                        <div class="col-sm-6">
					                            <div class="form-group">
					                            <p><strong>&nbsp;</strong>
                             					 </p>
					                               <div class="input-group">
                           						     <div class="icheck-inline">
						                                  <label>
						                                  <input type="checkbox" name="quotations" <?php if($salesteam->quotations){?>checked<?php }?> value="1" data-checkbox="icheckbox_square-blue"> Quotations</label>
						                                  <label>
						                                  <input type="checkbox" name="leads" <?php if($salesteam->leads){?>checked<?php }?> value="1" data-checkbox="icheckbox_square-blue"> Leads</label>
						                                  <label>
						                                  <input type="checkbox" name="opportunities" <?php if($salesteam->opportunities){?>checked<?php }?> value="1" data-checkbox="icheckbox_square-blue"> Opportunities</label>
                               						 </div>
                             						</div> 
					                            </div>
					                          </div>  
					                    </div>
					                    <div class="row">
                          					<div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label"style="color:red;">* Invoice Target</label>
					                              <div class="append-icon">
					                                <input type="text" name="invoice_target" value="<?php echo $salesteam->invoice_target;?>" class="form-control numeric">
					                                  
					                              </div>
					                            </div>
					                          </div>
					                          <div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label"style="color:red;">* Invoice Forecast</label>
					                              <div class="append-icon">
					                                <input type="text" name="invoice_forecast" value="<?php echo $salesteam->invoice_forecast;?>" class="form-control numeric">
					                                  
					                              </div>
					                            </div>
					                          </div>
					                          
					                        </div> 
					                    <div class="row">
                          					 <div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label"style="color:red;">* Team Leader</label>
					                              <div class="append-icon">
					                                <select name="team_leader[]" class="form-control" id="team_leader" multiple> 
					                                <?php 
													$team = explode(",", $salesteam->team_leader);
													foreach( $staffs as $staff){ ?>
					                                <option value="<?php echo $staff->id;?>" <?php if(in_array($staff->id,$team)){?>selected<?php }?>><?php echo $staff->first_name.' '. $staff->last_name;?></option>
					                                <?php }?> 
					                                </select>
					                              </div>
					                            </div>
					                          </div>
                          					<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Active</label>
				                              <div class="append-icon">
				                                <input type="checkbox" name="status" <?php if($salesteam->status){?>checked<?php }?> value="1" checked data-checkbox="icheckbox_square-blue"/> 
				                                 
				                              </div>
				                            </div>
				                          </div>
                          					 	
					                    </div>
										
										 <ul class="nav nav-tabs">
				                        <li class="active"><a href="#tab1_1" data-toggle="tab">Team Members</a></li>
				                        <li class=""><a href="#tab1_2" data-toggle="tab">Notes</a></li>                      
				                      </ul>
					                     <div class="tab-content">
						                        <div class="tab-pane fade active in" id="tab1_1">
							                           <div class="panel-body bg-white">
							                 			 		 																						<div class="col-sm-6">
					                            <div class="form-group">
					                               
					                              <div class="append-icon">
					                                  
					                                <select name="team_members[]" class="form-control" multiple> 
					                                <?php 
					                                $team = explode(",", $salesteam->team_members);
					                                foreach( $staffs as $staff){ ?>
					                                <option value="<?php echo $staff->id;?>" <?php if(in_array($staff->id,$team)){?>selected<?php }?>><?php echo $staff->first_name.' '. $staff->last_name;?></option>
					                                <?php }?> 
					                                </select>
					                              </div>
					                            </div>
					                          </div> 
							               			   </div>
						                        </div>
											<div class="tab-pane fade" id="tab1_2">
												<div class="panel-body bg-white">	
													<div class="col-sm-8">
					                            <div class="form-group">
					                               
					                              <div class="append-icon">
					                                
					                                <textarea name="notes" rows="4" class="form-control"><?php echo $salesteam->notes;?></textarea>   
					                              </div>
					                            </div>
					                          </div>
												</div>
					                         </div> 
					                          
					                        </div>
                        				<div class="text-left  m-t-20">
                         				 <div id="salesteams_submitbutton"><button type="submit" class="btn btn-embossed btn-primary">Update</button></div>
                           
                        </div>
                      </form>    
                  				    
                  </div>
                  </div>
                </div>
           	</div>
            	
 		</div>   
  <!-- END PAGE CONTENT -->
 

 
