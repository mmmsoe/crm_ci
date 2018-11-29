 
<script>
$(document).ready(function() {
	var opsi = '<?php echo $customer_id; ?>';
	
	$('#quotation option[value='+ opsi +']').prop("selected", true);
	$("#print").attr('href', '<?php echo base_url('admin/report/print_quot').'/'; ?>'+opsi);
		 
	$("#applyFilter").click(function() {
		var x = document.getElementById("quotation").value;
		var min = document.getElementById("min").value;
		var max = document.getElementById("max").value;
		var mindt = new Date(min);
			mindt = mindt.toLocaleFormat('%Y-%m-%d');
		var maxdt = new Date(max);
			maxdt = maxdt.toLocaleFormat('%Y-%m-%d');
		// alert(mindt.toLocaleFormat('%Y-%m-%d'));
		
$.ajax({
		  type: "POST",
		  url: '<?php echo base_url('admin/report/get_filter').'/';?>',     
			data: {type: x},
			success: function(data){
			 
		   $("#tbquotation").html(data);
		   
		   $('#loader').slideUp(200, function() {
			$(this).remove();
		   });
		 $("#print").attr('href', '<?php echo base_url('admin/report/print_quot').'/'; ?>'+x);
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
						  <label class="control-label">Filter</label>
						  <div class="append-icon">
						  <input type="hidden" name="typePotensial" id="typePotensial">
							 <select name="type" id="quotation" class="form-control" data-search="true">
					                                <option value=""></option>
					                                <option value="todays">Todays Sales</option>
					                                <option value="month">This Month Sales</option>
					                                </select></div>
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
					<div class="col-sm-3">
						<div class="form-group">
							<div style="padding-top:25px;">
							  <input type="hidden" id="min" name="min" class="date-picker form-control">
						  </div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<div style="padding-top:25px;">
					  <input type="hidden" id="max" name="max" class="date-picker form-control">
						  </div>
						</div>
					</div>
				</div>
						   
           		<div class="panel-content pagination2 table-responsive" >
            	
                  <table class="table table-hover filter-between_date" id="tbquotation">
                    <thead>
                      <tr>                        
                        <th>Quotations Number</th>  						
						<th>Date</th> 
                        <th>Customer</th> 
                        <th>Salesperson</th> 
                        <th>Total</th> 
                        <th>Status</th> 
                         
                      </tr>
                    </thead>
                    <tbody>
                      
                      <?php if( ! empty($report) ){?>
					    <?php foreach( $report as $report){ ?>
	                      <tr id="quotation_id_<?php echo $report->id; ?>">
	                       
	                        <td><a href="<?php echo base_url('admin/report/view/'.$report->id); ?>"><?php echo $report->quotations_number; ?></a></td>
							<td><?php echo date('m/d/Y',$report->date); ?></td>
	                        <td><?php echo customer_name($report->customer_id)->name; ?></td>
	         				<td><?php echo $this->staff_model->get_user_fullname($report->sales_person); ?></td>
	                        
	                        <td class="numeric"><?php echo number_format($report->grand_total,2,'.',','); ?></td>
	                        
	                        <td><?php echo $report->status; ?></td>
	                        
	                        
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
      