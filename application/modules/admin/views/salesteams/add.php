<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

$(document).ready(function() {
	$("form[name='add_salesteams']").submit(function(e) {
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "<?php echo base_url('admin/salesteams/add_process'); ?>",
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
					$("#salesteams_ajax").html('<?php echo '<div class="alert alert-success">'.$this->lang->line('create_succesful').'</div>'?>');
					setTimeout(function () {
					window.location.href="<?php echo base_url('admin/salesteams/index' ); ?>";
					}, 800); //will call the function after 1 secs.
				}
				else
				{
			$('body,html').animate({ scrollTop: 0 }, 200);
            $("#salesteams_ajax").html(msg); 
			$("#salesteams_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');
			
			$("form[name='add_opportunities']").find("input[type=text], textarea").val("");
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
            <h2><strong>Create Sales Team</strong></h2>            
          </div>
           <div class="row">
           	<div class="col-md-12">
                  <div class="panel">
                     
                     <div class="panel-content">
                   					<div id="salesteams_ajax"> 
				                          <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');}?>         
				                      </div>
				         
				            <form id="add_salesteams" name="add_salesteams" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
 
                        				                        				 
                        				<div class="row">
                          					<div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label"style="color:red;">* Sales Team</label>
					                              <div class="append-icon">
					                                <input type="text" name="salesteam" value="" class="form-control">
					                                 
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
						                                  <input type="checkbox" name="quotations" value="1" data-checkbox="icheckbox_square-blue"> Quotations</label>
						                                  <label>
						                                  <input type="checkbox" name="leads" value="1" data-checkbox="icheckbox_square-blue"> Leads</label>
						                                  <label>
						                                  <input type="checkbox" name="opportunities" value="1" data-checkbox="icheckbox_square-blue"> Opportunities</label>
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
					                                <input type="text" name="invoice_target" value="" class="form-control numeric">
					                                  
					                              </div>
					                            </div>
					                          </div>
					                          <div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label"style="color:red;">* Invoice Forecast</label>
					                              <div class="append-icon">
					                                <input type="text" name="invoice_forecast" value="" class="form-control numeric">
					                                  
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
					                                <?php foreach( $staffs as $staff){ ?>
					                                <option value="<?php echo $staff->id;?>"><?php echo $staff->first_name.' '. $staff->last_name;?></option>
					                                <?php }?> 
					                                </select>
					                              </div>
					                            </div>
					                          </div>
                          					<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Active</label>
				                              <div class="append-icon">
				                                <input type="checkbox" name="status" value="1" checked data-checkbox="icheckbox_square-blue"/> 
				                                 
				                              </div>
				                            </div>
				                          </div>
                          					 	
					                    </div>
										
										 <ul class="nav nav-tabs">
				                        <li class="active"><a href="#tab1_1" data-toggle="tab"style="color:red;">* Team Members</a></li>
				                        <li class=""><a href="#tab1_2" data-toggle="tab">Notes</a></li>                      
				                      </ul>
					                     <div class="tab-content">
						                        <div class="tab-pane fade active in" id="tab1_1">
							                           <div class="panel-body bg-white">
							                 			 		 																						<div class="col-sm-6">
					                            <div class="form-group">
					                               
					                              <div class="append-icon">
					                                  
					                                <select name="team_members[]" class="form-control" multiple> 
					                                <?php foreach( $staffs as $staff){ ?>
					                                <option value="<?php echo $staff->id;?>"><?php echo $staff->first_name.' '. $staff->last_name;?></option>
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
					                                
					                                <textarea name="notes" rows="4" class="form-control"></textarea>   
					                              </div>
					                            </div>
					                          </div>
												</div>
					                         </div> 
					                          
					                        </div>
                        				<div class="text-left  m-t-20">
                         				 <div id="salesteams_submitbutton"><button type="submit" class="btn btn-embossed btn-primary">Create</button></div>
                           
                        </div>
                      </form>             
                  				    
                  </div>
                  </div>
                </div>
           	</div>
            	
 		</div>   
  <!-- END PAGE CONTENT -->
 
