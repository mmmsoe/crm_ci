<table class="table table-hover table-dynamic filter-between_date">
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