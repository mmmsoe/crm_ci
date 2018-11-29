 <script>

$(document).ready(function() {
	
	$("#print").attr('href', '<?php echo base_url('admin/report/print_potentials_type').'/'; ?>');
				
	$("#applyFilter").click(function() {
		var min = document.getElementById("min").value;
		var max = document.getElementById("max").value;
		var stat= 'type';
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
				
				$("#tbType tbody").html(data);
				$('#loader').slideUp(200, function() {
					$(this).remove();
				});
				$("#print").attr('href', '<?php echo base_url('admin/report/print_potentials_type').'/'; ?>'+ mindt +'/'+ '-' +'/'+ maxdt);
			
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
            	
                  <table class="table table-hover filter-between_date" id="tbType">
                    <thead>
                      <tr>                        
                        <th>Type</th>  						
						<th>Potential Name</th> 
                        <th>Account Name</th> 
                        <th>Potential Owner</th> 
                        <th>Closing Date</th> 
                        <th>Stage</th> 
                        <th>Probability(%)</th> 
                        <th>Lead Source</th> 
                         
                      </tr>
                    </thead>
                     <tbody>
                      <?php if( ! empty($opportunities_group) ){?>
					  <?php foreach( $opportunities_group as $opportunity_group){ ?>
	                  <?php if ($opportunity_group->type_id !==''){ ?>
							   
	                      <tr id="opportunities_id_<?php echo $opportunity->id; ?>">
						  
	                        <td colspan="8" style="background:#f0f4f8"><?php echo $this->system_model->system_single_value('OPPORTUNITIES_TYPE', $opportunity_group->type_id)->system_value_txt .' ('.$opportunity_group->cnt.')'; ?></td>
							
	                      </tr>
					<?php $opportunities = $this->opportunities_model->get_list_by_group( array('type_id' => $opportunity_group->type_id) ); ?>
				      <?php if( ! empty($opportunities) ){?>
					    <?php foreach( $opportunities as $opportunity){ ?>
					      <tr id="quotation_id_<?php echo $opportunity->id; ?>">
							<td> </td>
							<td><?php echo $opportunity->opportunity; ?></td>
							<td><?php echo $this->customers_model->get_account_name($opportunity->customer_id,'name'); ?></td>
							<td><?php echo $this->staff_model->get_user_fullname($opportunity->salesperson_id); ?></td>
	                        <td><?php echo $opportunity->expected_closing; ?></td>
	                    	<td><?php echo $this->system_model->system_single_value('OPPORTUNITIES_STAGES', $opportunity->stages_id)->system_value_txt; ?></td>
	                    	<td class="numeric"><?php echo $opportunity->probability; ?></td>
							<td><?php echo $this->system_model->system_single_value('LEAD', $opportunity->lead_source_id)->system_value_txt; ?></td>
						     
	                      </tr>
	                	 <?php } ?>
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
      