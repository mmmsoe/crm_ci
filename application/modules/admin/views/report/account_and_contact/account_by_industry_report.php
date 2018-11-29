 <script>

$(document).ready(function() {
	
	$("#print").attr('href', '<?php echo base_url('admin/report/print_account_industry').'/'; ?>');
				
	$("#applyFilter").click(function() {
		var min = document.getElementById("min").value;
		var max = document.getElementById("max").value;
		var stat= 'account_industry';
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
				
				$("#tbaccount tbody").html(data);
				$('#loader').slideUp(200, function() {
					$(this).remove();
				});
				$("#print").attr('href', '<?php echo base_url('admin/report/print_account_industry').'/'; ?>'+ mindt +'/'+ '-' +'/'+ maxdt);
			
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
            	
                  <table class="table table-hover filter-between_date" id="tbaccount">
                    <thead>
                      <tr>                        
                        <th>Industry</th> 
                        <th>Account Name</th> 
                        <th>Rating</th> 
                        <th>Annual Revenue</th> 
                         
                      </tr>
                    </thead>
                     <tbody>
                      
                      <?php if( ! empty($leads_group) ){?>
					    <?php foreach( $leads_group as $leads_group){ ?>
	                       <?php //if($leads_group->industry_id !== '' || $leads_group->customer_id !== '0' || $leads_group->annual_revenue !== '' || $leads_group->rating_id !== '') { ?>
						   
	                      <tr id="leads_id_<?php echo $leads_group->id; ?>">
							<?php if ($leads_group->industry_id !=='') { ?>
	                        <td colspan="4" style="background:#f0f4f8"><?php echo $this->system_model->system_single_value('INDUSTRY', $leads_group->industry_id)->system_value_txt .' ('.$leads_group->cnt.')'; ?></td>
							<?php }else { ?>
						    <td colspan="4" style="background:#f0f4f8"><?php echo 'No Industry' .' ('.$leads_group->cnt.')'; ?></td>
							<?php } ?>
	                      </tr>	
						   
						   <?php $leads = $this->leads_model->get_list_by_group_account( array('industry_id' => $leads_group->industry_id) ); ?>
							  <?php if( ! empty($leads) ){?>
								<?php foreach( $leads as $leads){ ?>
																
	                      <tr id="leads_id_<?php echo $leads->id; ?>">
						  
	                        <td></td>
	                        <td><?php echo $this->customers_model->get_account_name($leads->customer_id,'name'); ?></td>
	         			    <td><?php echo $this->system_model->system_single_value('RATING', $leads->rating_id)->system_value_txt; ?></td>
	                    	<td><?php echo number_format($leads->annual_revenue,2,'.',','); ?></td>
						 
	                      </tr>
							   <?php //} ?>
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
      