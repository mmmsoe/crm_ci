                      <?php if( ! empty($opportunities_group) ){?>
					    <?php foreach( $opportunities_group as $opportunity_group){ ?>
						   
	                      <tr>
						  
	                        <td colspan="5" style="background:#f0f4f8"><?php echo $this->staff_model->get_user_fullname($opportunity_group->salesperson_id).' ('.$opportunity_group->cnt.')'; ?></td>
							
	                      </tr>
						   
						   <?php $opportunities = $this->opportunities_model->get_list_by_group( array('salesperson_id' => $opportunity_group->salesperson_id), $min, $max,'leads'); ?>
							  <?php if( ! empty($opportunities) ){?>
								<?php foreach( $opportunities as $opportunity){ ?>
																
	                      <tr>
						  
	                        <td></td>
							<td><?php echo $this->customers_model->get_account_name($opportunity->customer_id,'name'); ?></td>
	                        <td><?php echo $opportunity->opportunity; ?></td>
	                    	<td class="numeric"><?php echo number_format($this->leads_model->get_lead_single( $opportunity->lead_id )->annual_revenue, 2, '.', ','); ?></td>
	                    	<td class="numeric"><?php echo number_format($opportunity->amount, 2, '.', ','); ?></td>
							
	                      </tr>
							   <?php } ?>
							 <?php } ?>
	                      <tr>
						  
	                        <td colspan="5" style="border-top: 3px solid #ddd;" class="numeric"><?php echo number_format($opportunity_group->amt, 2, '.', ',');?></td>
							
	                      </tr>
                    	 <?php } ?>
					 <?php } ?> 
	                      <tr>
						  
	                        <td colspan="5" style="background:#ddd;" class="numeric"><?php echo number_format($sum_amount, 2, '.', ',');?></td>
							
	                      </tr>