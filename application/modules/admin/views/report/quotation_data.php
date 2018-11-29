                  <table class="table table-hover table-dynamic filter-between_date" id="tbquotation">
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
	                       
	                        <td><a href="<?php echo base_url('admin/report/view/'.$quotation->id); ?>"><?php echo $report->quotations_number; ?></a></td>
							<td><?php echo date('m/d/Y',$report->date); ?></td>
	                        <td><?php echo customer_name($report->customer_id)->name; ?></td>
	         				<td><?php echo $this->staff_model->get_user_fullname($report->sales_person); ?></td>
	                        
	                        <td class="numeric"><?php echo number_format($report->grand_total); ?></td>
	                        
	                        <td><?php echo $report->status; ?></td>
	                        
	                        
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
        <!-- END PAGE CONTENT -->
      