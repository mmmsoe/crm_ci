 <script>

$(document).ready(function() {
	
	$("#print").attr('href', '<?php echo base_url('admin/report/print_lead_source').'/'; ?>');
				
	$("#applyFilter").click(function() {
		var min = document.getElementById("min").value;
		var max = document.getElementById("max").value;
		var stat= 'lead_by_source';
		if(min && max){
			var mindt = new Date(min);
				mindt = mindt.toLocaleFormat('%Y-%m-%d');
			var maxdt = new Date(max);
				maxdt = maxdt.toLocaleFormat('%Y-%m-%d');	
		}else{
			var mindt = '-';
			var maxdt = '-';
		}
	
		// alert(mindt.toLocaleFormat('%Y-%m-%d'));
		
		$.ajax({
			type: "POST",
			url: '<?php echo base_url('admin/report/search_period');?>',
			data: {min: min, max: max,status:stat},
			success: function(data){
				
				$("#tbsource tbody").html(data);
				$('#loader').slideUp(200, function() {
					$(this).remove();
				});
				$("#print").attr('href', '<?php echo base_url('admin/report/print_lead_source').'/'; ?>'+ mindt +'/'+ '-' +'/'+ maxdt);
			
			},
		});
	});
});
</script>
 <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
             <div class="row">
             <div>
               <?php if (check_staff_permission('report_write')){?>
      			 	 <a style="float:right;" href="" id="print" class="btn btn-primary" target="">Print</a>
					 <a   href="<?php echo base_url('admin/report/'); ?>" class="btn btn-black btn-embossed"> Back To Report</a> 	
		   	
				<?php }?>
			    		
            </div>          
		</div>
            <div class="row">
	           <div class="panel">																				
			   <div class="panel-content">
           			<div class="row">
				<div class="col-sm-3">
						<div class="form-group">
						  <label class="control-label">Start Date</label>
						  <div class="append-icon">
						    <input type="text" id="min" name="min" class="date-picker form-control">
						    <i class="icon-calendar"></i>
						  </div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label class="control-label">End Date</label>
						  <div class="append-icon">
						    <input type="text" id="max" name="max" class="date-picker form-control">
						    <i class="icon-calendar"></i>
						  </div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<div style="padding-top:25px;">
								<?php if (check_staff_permission('quotations_write')){?>
									<a href="#" id="applyFilter" class="btn btn-success" target="">Apply Filter</a>
								<?php }?>	
							</div>
						</div>
					</div>
				</div>
						   
           		<div class="panel-content pagination2 table-responsive" >
            	
                  <table class="table table-hover filter-between_date" id="tbsource">
                    <thead>
                      <tr>                        
                        <th>Lead Source</th> 
                        <th>Full Name</th> 
                        <th>Email</th> 
                        <th>Company</th> 
                        <th>Lead Created Time</th> 
                        <th>Lead Owner</th> 
                        
                      </tr>
                    </thead>
                     <tbody>
                      
                      <?php if( ! empty($leads_group) ){?>
					    <?php foreach( $leads_group as $leads_group){ ?>
	                       
	                      <tr id="leads_id_<?php echo $leads_group->id; ?>">
							<?php if ($leads_group->lead_source_id !=='') { ?>
	                        <td colspan="6" style="background:#f0f4f8"><?php echo $this->system_model->system_single_value('LEAD', $leads_group->lead_source_id)->system_value_txt .' ('.$leads_group->cnt.')'; ?></td>
							<?php }else { ?>
						    <td colspan="6" style="background:#f0f4f8"><?php echo 'No Lead Source' .' ('.$leads_group->cnt.')'; ?></td>
							<?php } ?>
	                      </tr>	
						   
						   <?php $leads = $this->leads_model->get_list_by_group_account( array('lead_source_id' => $leads_group->lead_source_id) ); ?>
							  <?php if( ! empty($leads) ){?>
								<?php foreach( $leads as $leads){ ?>
																
	                      <tr id="leads_id_<?php echo $leads->id; ?>">
						  
	                        <td></td>
	                         <td><?php echo $leads->lead_name ;?></td>
							 <td><?php echo $leads->email ;?></td>
							 <td><?php echo $leads->company_name ;?></td>
							 <td><?php echo date('Y/m/d G:i A', $leads->register_time) ;?></td>
							 <td><?php echo $this->staff_model->get_user($leads->salesperson_id)->first_name." ".$this->staff_model->get_user($leads->salesperson_id)->last_name ;?></td>
							
	                      </tr>
							 <?php } ?>
	        			   <?php } ?>
                    	 <?php } ?>
					 <?php } ?> 
                      
                      
                    </tbody>
                  </table>
                </div>
		   		</div>
			   </div>
		 	   	
       		 </div>
        </div>
        <!-- END PAGE CONTENT -->
      