 <script>

$(document).ready(function() {
	
	$("#print").attr('href', '<?php echo base_url('admin/report/print_today_lead').'/'; ?>');
				
	$("#applyFilter").click(function() {
		var min = document.getElementById("min").value;
		var max = document.getElementById("max").value;
		var stat= 'today_lead';
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
				
				$("#tbtoday tbody").html(data);
				$('#loader').slideUp(200, function() {
					$(this).remove();
				});
				$("#print").attr('href', '<?php echo base_url('admin/report/print_today_lead').'/'; ?>'+ mindt +'/'+ '-' +'/'+ maxdt);
			
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
            	
                  <table class="table table-hover filter-between_date" id="tbtoday">
                    <thead>
                      <tr>                        
                        <th>Full Name</th> 
                        <th>Email</th> 
                        <th>Phone</th> 
                        <th>Lead Source</th> 
                        <th>Lead Status</th> 
                        <th>Company</th> 
                        
                      </tr>
                    </thead>
                     <tbody>
                      
                      <?php if( ! empty($leads_group) ){?>
					    <?php foreach( $leads_group as $leads){ ?>
	                     
						 <tr id="leads_id_<?php echo $leads->id; ?>">
						  
	                        
	                         <td><?php echo $leads->lead_name ;?></td>
							 <td><?php echo $leads->email ;?></td>
							 <td><?php echo $leads->phone ;?></td>
							 <td><?php echo $this->system_model->system_single_value('LEAD', $leads->lead_source_id)->system_value_txt ;?></td>
							 <td><?php echo $this->system_model->system_single_value('LEAD_STATUS', $leads->lead_status_id)->system_value_txt ;?></td>
							 <td><?php echo $leads->company_name ;?></td>
							
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
        <!-- END PAGE CONTENT -->
      