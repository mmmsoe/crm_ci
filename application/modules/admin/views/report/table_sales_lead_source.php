                      <?php if( ! empty($opportunities_group) ){?>
					    <?php foreach( $opportunities_group as $opportunity_group){ ?>
						   
	                      <tr>
						  
	                        <td colspan="6" style="background:#f0f4f8"><?php echo $this->system_model->system_single_value('LEAD', $opportunity_group->lead_source_id)->system_value_txt .' ('.$opportunity_group->cnt.')'; ?></td>
							
	                      </tr>

						   <?php $opportunities = $this->opportunities_model->get_list_by_group( array('lead_source_id' => $opportunity_group->lead_source_id), $min, $max, 'quotations_salesorder' ); ?>
							  <?php if( ! empty($opportunities) ){?>
								<?php foreach( $opportunities as $opportunity){ ?>
																
	                      <tr>
						  
	                        <td></td>
	                        <td><?php echo $opportunity->opportunity; ?></td>
							<td><?php echo $this->customers_model->get_account_name($opportunity->customer_id,'name'); ?></td>
	         			    <td><?php echo $opportunity->expected_closing; ?></td>
	                    	<td><?php echo $this->system_model->system_single_value('OPPORTUNITIES_STAGES', $opportunity_group->stages_id)->system_value_txt; ?></td>
	                    	<td class="numeric"><?php echo number_format($opportunity->amount, 2, '.', ','); ?></td>
							
	                      </tr>
							   <?php } ?>
							 <?php } ?>
	                      <tr>
						  
	                        <td colspan="6" style="border-top: 3px solid #ddd;" class="numeric"><?php echo number_format($opportunity_group->amt, 2, '.', ',');?></td>
							
	                      </tr>
                    	 <?php } ?>
					 <?php } ?> 
	                      <tr>
						  
	                        <td colspan="6" style="background:#ddd;" class="numeric"><?php echo number_format($sum_amount, 2, '.', ',');?></td>
							
	                      </tr>