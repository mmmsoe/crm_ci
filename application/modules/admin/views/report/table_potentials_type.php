 <?php if( ! empty($opportunities_group) ){?>
					  <?php foreach( $opportunities_group as $opportunity_group){ ?>
	                  <?php if ($opportunity_group->type_id !==''){ ?>
							   
	                      <tr id="opportunities_id_<?php echo $opportunity->id; ?>">
						  
	                        <td colspan="8" style="background:#f0f4f8"><?php echo $this->system_model->system_single_value('OPPORTUNITIES_TYPE', $opportunity_group->type_id)->system_value_txt .' ('.$opportunity_group->cnt.')'; ?></td>
							
	                      </tr>
					<?php $opportunities = $this->opportunities_model->get_list_by_group( array('type_id' => $opportunity_group->type_id),$min,$max ); ?>
				      <?php if( ! empty($opportunities) ){?>
					    <?php foreach( $opportunities as $opportunity){ ?>
					      <tr id="quotation_id_<?php echo $opportunity->id; ?>">
							<td> </td>
							<td><?php echo $opportunity->opportunity; ?></td>
							<td><?php echo $this->customers_model->get_account_name($opportunity->customer_id,'name'); ?></td>
							<td><?php echo $this->staff_model->get_user_fullname($opportunity->salesperson_id); ?></td>
	                        <td><?php echo $opportunity->expected_closing; ?></td>
	                    	<td><?php echo $this->system_model->system_single_value('OPPORTUNITIES_STAGES', $opportunity->stages_id)->system_value_txt; ?></td>
	                    	<td class="numeric"><?php echo $opportunity->probability; ?></td>
							<td><?php echo $this->system_model->system_single_value('LEAD', $opportunity->lead_source_id)->system_value_txt; ?></td>
						     
	                      </tr>
	                	 <?php } ?>
					 <?php } ?> 
                      <?php } ?>
                      <?php } ?>
                      <?php } ?>