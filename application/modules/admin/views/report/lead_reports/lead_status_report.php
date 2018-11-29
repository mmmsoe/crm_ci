 <script>

$(document).ready(function() {
		
	$("#print").attr('href', '<?php echo base_url('admin/report/print_lead_status').'/'; ?>');
			
	$("#applyFilter").click(function() {
		var min = document.getElementById("min").value;
		var max = document.getElementById("max").value;
		var stat = 'lead_status';
		
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
				
				$("#tbLeadStatus tbody").html(data);
				$('#loader').slideUp(200, function() {
					$(this).remove();
				});
				$("#print").attr('href', '<?php echo base_url('admin/report/print_lead_status').'/'; ?>'+ mindt +'/'+ '-' +'/'+ maxdt);
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
            	
                  <table class="table table-hover filter-between_date" id="tbLeadStatus">
                    <thead>
                      <tr>
                        <th>Lead Status</th>
						<th style="width: 120px;" >Full Name</th> 					
						<th>Lead Source</th> 
						<th>Company</th> 
						<th>Lead Owner</th> 
						<th>Street</th> 
						<th>City</th> 
						<th>State</th> 
						<th>Country</th> 
						<th>Zip Code</th> 
						<th>Annual Revenue</th>
                      </tr>
                    </thead>
                     <tbody>
                      
                      <?php if( ! empty($leads_group) ){?>
					    <?php foreach( $leads_group as $lead_group){ ?>
						
	                      <tr>
						  
	                        <td colspan="11" style="background:#f0f4f8"><?php echo $this->system_model->system_single_value('LEAD_STATUS', $lead_group->lead_status_id)->system_value_txt .' ('.$lead_group->cnt.')'; ?></td>

	                      </tr>
						  <?php $leads = $this->leads_model->get_list_by_group_account( array('a.lead_status_id' => $lead_group->lead_status_id),'','',''); ?>
						  <?php if( ! empty($leads) ){?>
							<?php foreach( $leads as $lead){ ?>
						  
						  <tr>
						  
	                        <td></td>
	                        <td><?php echo $lead->lead_name ;?></td>
	                        <td><?php echo $this->system_model->system_single_value('LEAD', $lead->lead_source_id)->system_value_txt ;?></td>
	                        <td><?php echo $lead->company_name ;?></td>
	                        <td><?php echo $this->staff_model->get_user_fullname($lead->salesperson_id) ;?></td>
	                        <td><?php echo $lead->address ;?></td>
	                        <td><?php echo $this->leads_model->get_city($lead->city_id, $lead->state_id)->name ;?></td>
	                        <td><?php echo $this->leads_model->get_state($lead->state_id, $lead->country_id)->name ;?></td>
	                        <td><?php echo $this->leads_model->get_country($lead->country_id)->name ;?></td>
	                        <td class='numeric'><?php echo $lead->zip_code ;?></td>
	                        <td class='numeric'><?php echo number_format($lead->annual_revenue, 2, '.', ',') ;?></td>

	                      </tr>
								<?php } ?>
							 <?php } ?>
	                      <tr>
						  
	                        <td colspan="11" style="border-top: 3px solid #ddd;" class="numeric"><?php echo number_format($lead_group->amt, 2, '.', ',');?></td>
							
	                      </tr>
                    	 <?php } ?>
					 <?php } ?> 
	                      <tr>
						  
	                        <td colspan="11" style="background:#ddd;" class="numeric"><?php echo number_format($sum_amount, 2, '.', ',');?></td>
							
	                      </tr>
                    </tbody>
                  </table>
                </div>
		   		</div>
			   </div>
		 	   	
       		 </div>
        </div>
        <!-- END PAGE CONTENT -->
      