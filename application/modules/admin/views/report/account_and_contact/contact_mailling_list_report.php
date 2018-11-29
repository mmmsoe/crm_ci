 <script>

$(document).ready(function() {
	
	$("#print").attr('href', '<?php echo base_url('admin/report/print_contact_mailing').'/'; ?>');
				
	$("#applyFilter").click(function() {
		var min = document.getElementById("min").value;
		var max = document.getElementById("max").value;
		var stat= 'contact_mailing';
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
				
				$("#tbcontact tbody").html(data);
				$('#loader').slideUp(200, function() {
					$(this).remove();
				});
				$("#print").attr('href', '<?php echo base_url('admin/report/print_contact_mailing').'/'; ?>'+ mindt +'/'+ '-' +'/'+ maxdt);
			
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
						   
           		<div class="panel-content pagination2 table-responsive" id="atur">
            	
                  <table class="table table-hover filter-between_date" id="tbcontact">
                    <thead>
                      <tr>                        
                        <th>Full Name</th> 
                        <th>Phone</th> 
                        <th>Email</th> 
                        <th>Account Name</th> 
                        <th>Contact Created Time</th> 
                        <th>Mailling Street</th> 
                        <th>Mailling City</th> 
                        <th>Mailling State</th> 
                        <th>Mailling Country</th> 
                        <th>Mailling Zip</th> 
                       <!-- <th>First Name</th> 
                        <th>Last Name</th> --> 
                         
                      </tr>
                    </thead>
                     <tbody>
                      
                      <?php if( ! empty($contacts) ){?>
					    <?php foreach( $contacts as $contacts){ ?>
	                       <?php //if($leads_group->industry_id !== '' || $leads_group->customer_id !== '0' || $leads_group->annual_revenue !== '' || $leads_group->rating_id !== '') { ?>
						   
	                      <tr id="contact_id_<?php echo $contacts->id; ?>">
						  
							<td><?php echo $contacts->first_name.' '.$contacts->last_name; ?></td>
							<td><?php echo $contacts->phone; ?></td>
							<td><?php echo $contacts->email; ?></td>
							<td><?php echo $this->customers_model->get_account_name($contacts->company_id,'name'); ?></td>
	         			    
								<td><?php echo date('Y-m-d',$contacts->register_time); ?></td>
								<td><?php echo $contacts->address; ?></td>
								<td><?php echo $this->customers_model->get_cities_name($contacts->city_id,'name','city'); ?></td>
	         			    	<td><?php echo $this->customers_model->get_cities_name($contacts->state_id,'name','state'); ?></td>
	         			    
						    <td><?php echo $this->customers_model->get_cities_name($contacts->country_id,'name','country'); ?></td>
	         				<td><?php echo $contacts->zip_code; ?></td>
							<!--<td><?php //echo $contacts->annual_revenue; ?></td>
								<td><?php //echo $contacts->annual_revenue; ?></td> -->
						 
	                      </tr>
							   <?php //} ?>
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
      