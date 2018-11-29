<script>

$(document).ready(function() {
	var opsi = '<?php echo $potensial; ?>';
	
	$('#myPotensial option[value='+ opsi +']').prop("selected", true);
	
	$("#print").attr('href', '<?php echo base_url('admin/report_potensial/print_quot').'/'; ?>'+ '-' +'/'+ opsi +'/'+ '-');
	
	$("#applyFilter").click(function() {
		var x = document.getElementById("myPotensial").value;
		var min = document.getElementById("min").value;
		var max = document.getElementById("max").value;
		
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
			url: '<?php echo base_url('admin/report_potensial/get_filter');?>',
			data: {type: x, min: min, max: max},
			success: function(data){
				
				$("#tbPotensial").html(data);
				$('#loader').slideUp(200, function() {
					$(this).remove();
				});
				// $("#print").click(function() {
					$("#print").attr('href', '<?php echo base_url('admin/report_potensial/print_quot').'/'; ?>'+ mindt +'/'+ x +'/'+ maxdt);
				// });
			},
		});
	});
});
</script>
<style>
th{font-size:10px;}
</style>
        <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
        	<div class="row">
            <div>
               <?php if (check_staff_permission('quotations_write')){?>
			 	 <a  style="float:right;" href="" id="print" class="btn btn-primary" target="">Print</a>
			 	 <a   href="<?php echo base_url('admin/report/'); ?>" class="btn btn-black btn-embossed"> Back To Report</a> 	
		   	
			  <?php }?>	
            </div>
          </div>
            <div class="row">
	           <div class="panel">																				<div class="panel-content">
           			<div class="row">
					<div class="col-sm-3">
						<div class="form-group">
						  <label class="control-label">Potential</label>
						  <div class="append-icon">
						  <input type="hidden" name="typePotensial" id="typePotensial">
							<select name="myPotensial" id="myPotensial" class="form-control" data-search="false">
								<option value=""></option>
								<option value="open">Open Opportunity</option>
								<option value="lost">Lost Opportunity</option>
							</select>
						  </div>
						</div>
					</div>
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
           		<div class="panel-content table-responsive">
           	
                  <table class="table table-hover filter-between_date" id="tbPotensial">
                    <thead>
                      <tr>                        
                        <th>Potential Name</th>
                        <th>Account Name</th> 
                        <th>Potential Owner</th> 
                        <th>Closing Date</th> 
                        <th>Stage</th>     
                        <th>Amount</th>     
                      </tr>
                    </thead>
                    <tbody>
                      
                      <?php if( ! empty($opportunities) ){?>
					    <?php foreach( $opportunities as $opportunity){ ?>
	                      <tr id="quotation_id_<?php echo $opportunity->id; ?>">
	                       
	                        <td><a href="<?php echo base_url('admin/opportunities/view/'.$opportunity->id); ?>"><?php echo $opportunity->opportunity; ?></a></td>
	                        <td><a href="<?php echo base_url('admin/customers/view/'.$opportunity->id); ?>"><?php echo $this->customers_model->get_account_name($opportunity->customer_id,'name'); ?></a></td>
	         				<td><?php echo $this->staff_model->get_user_fullname($opportunity->salesperson_id); ?></td>
	                        
	                        <td><?php echo $opportunity->expected_closing; ?></td>
	                        
							<td><?php echo $this->system_model->system_single_value('OPPORTUNITIES_STAGES', $opportunity->stages_id)->system_value_txt; ?></td>
							<td class="numeric"><?php echo number_format($opportunity->amount,2,'.',','); ?></td>
	                        
	                      </tr>
	                      <div class="modal fade" id="modal-basic<?php echo $quotation->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            				<div class="modal-dialog">
              					<div class="modal-content">
					                <div class="modal-header">
					                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
					                  <h4 class="modal-title"><strong>Confirm</strong></h4>
					                </div>
					                <div class="modal-body">
					                  Are you sure you want to delete this?<br>
					                </div>
					                <div class="modal-footer">
					                  <button type="button" class="btn btn-default btn-embossed" data-dismiss="modal">Cancel</button>
					                  <button type="button" onclick="delete_quotation(<?php echo $quotation->id; ?>)" class="btn btn-primary btn-embossed" data-dismiss="modal">Delete</button>
					                </div>
             					 </div>
           					 </div>
        				  </div>
	                      
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
      