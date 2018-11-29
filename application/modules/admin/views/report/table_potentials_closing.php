
                      <?php if( ! empty($opportunities) ){?>
					    <?php foreach( $opportunities as $opportunity){ ?>
					      <tr id="quotation_id_<?php echo $opportunity->id; ?>">
							<td><?php echo $opportunity->opportunity; ?></td>
							<td><?php echo $this->customers_model->get_account_name($opportunity->customer_id,'name'); ?></td>
							<td><?php echo $this->staff_model->get_user_fullname($opportunity->salesperson_id); ?></td>
	                        <td><?php echo $this->system_model->system_single_value('OPPORTUNITIES_STAGES', $opportunity->stages_id)->system_value_txt; ?></td>
	                    	<td class="numeric"><?php echo $opportunity->probability; ?></td>
							<td><?php echo $opportunity->expected_closing; ?></td>
							</tr>
	                 	 <?php } ?>
					 <?php } ?> 
                     