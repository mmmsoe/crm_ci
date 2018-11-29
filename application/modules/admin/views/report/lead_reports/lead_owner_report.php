 <script>

$(document).ready(function() {
		
	$("#print").attr('href', '<?php echo base_url('admin/report/print_lead_owner').'/'; ?>');
			
	$("#applyFilter").click(function() {
		var min = document.getElementById("min").value;
		var max = document.getElementById("max").value;
		var stat = 'lead_owner';
		
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
				
				$("#tbLeadOwner tbody").html(data);
				$('#loader').slideUp(200, function() {
					$(this).remove();
				});
				$("#print").attr('href', '<?php echo base_url('admin/report/print_lead_owner').'/'; ?>'+ mindt +'/'+ '-' +'/'+ maxdt);
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
            	
                  <table class="table table-hover filter-between_date" id="tbLeadOwner">
                    <thead>
                      <tr>
                        <th>Lead Owner</th>
						<th style="width: 120px;" >Full Name</th> 					
						<th>Email</th> 
						<th>Phone</th> 
						<th>Company</th> 
						<th style="width: 120px;">Lead Created Time</th> 
                      </tr>
                    </thead>
                     <tbody>
                      
                      <?php if( ! empty($leads_group) ){?>
					    <?php foreach( $leads_group as $lead_group){ ?>
						
	                      <tr>
						  
	                        <td colspan="6" style="background:#f0f4f8"><?php echo $this->staff_model->get_user_fullname($lead_group->salesperson_id) .' ('.$lead_group->cnt.')'; ?></td>

	                      </tr>
						  <?php $leads = $this->leads_model->get_list_by_group_account( array('a.salesperson_id' => $lead_group->salesperson_id),'','',''); ?>
						  <?php if( ! empty($leads) ){?>
							<?php foreach( $leads as $lead){ ?>
						  
						  <tr>
						  
	                        <td></td>
	                        <td><?php echo $lead->lead_name ;?></td>
	                        <td><?php echo $lead->email ;?></td>
	                        <td><?php echo $lead->phone ;?></td>
	                        <td><?php echo $lead->company_name ;?></td>
	                        <td><?php echo date('Y/m/d G:i A', $lead->register_time) ;?></td>

							
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
      