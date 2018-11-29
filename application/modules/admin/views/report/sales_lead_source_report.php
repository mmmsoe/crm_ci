 <script>

$(document).ready(function() {
		
	$("#print").attr('href', '<?php echo base_url('admin/report/print_sales_lead_source').'/'; ?>');
			
	$("#applyFilter").click(function() {
		var min = document.getElementById("min").value;
		var max = document.getElementById("max").value;
		var stat = 'lead_source';
		
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
				
				$("#tbSalesLeads tbody").html(data);
				$('#loader').slideUp(200, function() {
					$(this).remove();
				});
				$("#print").attr('href', '<?php echo base_url('admin/report/print_sales_lead_source').'/'; ?>'+ mindt +'/'+ '-' +'/'+ maxdt);
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
            	
                  <table class="table table-hover filter-between_date" id="tbSalesLeads">
                    <thead>
                      <tr>                        
                        <th>Lead Source</th>  		
                        <th>Account Name</th> 					
						<th>Potential Name</th> 
                        <th>Closing Date</th> 
                        <th>Stage</th> 
                        <th>Amount</th> 
                         
                      </tr>
                    </thead>
                     <tbody>
                      
                      <?php if( ! empty($opportunities_group) ){?>
					    <?php foreach( $opportunities_group as $opportunity_group){ ?>
						   
	                      <tr>
						  
	                        <td colspan="6" style="background:#f0f4f8"><?php echo $this->system_model->system_single_value('LEAD', $opportunity_group->lead_source_id)->system_value_txt .' ('.$opportunity_group->cnt.')'; ?></td>
							
	                      </tr>
						   
						   <?php $opportunities = $this->opportunities_model->get_list_by_group( array('lead_source_id' => $opportunity_group->lead_source_id), '', '', 'quotations_salesorder' ); ?>
							  <?php if( ! empty($opportunities) ){?>
								<?php foreach( $opportunities as $opportunity){ ?>
																
	                      <tr>
						  
	                        <td></td>
	                        <td><?php echo $opportunity->opportunity; ?></td>
							<td><?php echo $this->customers_model->get_account_name($opportunity->customer_id,'name'); ?></td>
	         			    <td><?php echo $opportunity->expected_closing; ?></td>
	                    	<td><?php echo $this->system_model->system_single_value('OPPORTUNITIES_STAGES', $opportunity_group->stages_id)->system_value_txt; ?></td>
	                    	<td class="numeric"><?php echo number_format($opportunity->amount, 2, '.', ','); ?></td>
							
	                      </tr>
							   <?php } ?>
							 <?php } ?>
	                      <tr>
						  
	                        <td colspan="6" style="border-top: 3px solid #ddd;" class="numeric"><?php echo number_format($opportunity_group->amt, 2, '.', ',');?></td>
							
	                      </tr>
                    	 <?php } ?>
					 <?php } ?> 
	                      <tr>
						  
	                        <td colspan="6" style="background:#ddd;" class="numeric"><?php echo number_format($sum_amount, 2, '.', ',');?></td>
							
	                      </tr>
                      
                    </tbody>
                  </table>
                </div>
		   		</div>
			   </div>
		 	   	
       		 </div>
        </div>
        <!-- END PAGE CONTENT -->
      