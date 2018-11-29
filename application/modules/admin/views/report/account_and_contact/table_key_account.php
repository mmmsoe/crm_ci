					<?php if( ! empty($opportunities_group) ){?>
					    <?php foreach( $opportunities_group as $opportunity_group){ ?>
	                       <?php if($opportunity_group->customer_id !== '0' && $opportunity_group->customer_id !== '') { ?>
						   
	                      <tr id="opportunities_id_<?php echo $opportunity->id; ?>">
						  
							<td colspan="5" style="background:#f0f4f8"><?php echo $this->customers_model->get_account_name($opportunity_group->customer_id,'name') .' ('.$opportunity_group->cnt.')'; ?></td>
	                      </tr>
						   
						   <?php $opportunities = $this->opportunities_model->get_list_by_group( array('customer_id' => $opportunity_group->customer_id), $min, $max, 'customer' ); ?>
							  <?php if( ! empty($opportunities) ){?>
								<?php foreach( $opportunities as $opportunity){ ?>
																
	                      <tr id="opportunities_id_<?php echo $opportunity->id; ?>">
						  
	                        <td></td>
	                        <td><?php echo $opportunity->opportunity; ?></td>
							<td><?php echo $opportunity->expected_closing; ?></td>
							<td><?php echo $this->system_model->system_single_value('OPPORTUNITIES_STAGES', $opportunity->stages_id)->system_value_txt; ?></td>
	                    	<td class="numeric"><?php echo number_format($opportunity->amount, 2, '.', ','); ?></td>
							
	                      </tr>
							   <?php } ?>
							 <?php } ?>
	                      <tr id="opportunities_id_<?php echo $opportunity->id; ?>">
						  
	                        <td colspan="5" style="border-top: 3px solid #ddd;" class="numeric"><?php echo number_format($opportunity_group->amt, 2, '.', ',');?></td>
							
	                      </tr>
						   <?php } ?>
                    	 <?php } ?>
					 <?php } ?> 
	                      <tr id="opportunities_id_<?php echo $opportunity->id; ?>">
						  
	                  <td colspan="5" style="background:#ddd;" class="numeric"><?php echo number_format($sum_amount, 2, '.', ',');?></td>
									
	                      </tr>