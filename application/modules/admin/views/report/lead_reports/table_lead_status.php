                      <?php if( ! empty($leads_group) ){?>
					    <?php foreach( $leads_group as $lead_group){ ?>
						
	                      <tr>
						  
	                        <td colspan="11" style="background:#f0f4f8"><?php echo $this->system_model->system_single_value('LEAD_STATUS', $lead_group->lead_status_id)->system_value_txt .' ('.$lead_group->cnt.')'; ?></td>

	                      </tr>
						  <?php $leads = $this->leads_model->get_list_by_group_account( array('a.lead_status_id' => $lead_group->lead_status_id),$min,$max,''); ?>
						  <?php if( ! empty($leads) ){?>
							<?php foreach( $leads as $lead){ ?>
						  
						  <tr>
						  
	                        <td></td>
	                        <td><?php echo $lead->lead_name ;?></td>
	                        <td><?php echo $this->system_model->system_single_value('LEAD', $lead->lead_source_id)->system_value_txt ;?></td>
	                        <td><?php echo $lead->company_name ;?></td>
	                        <td><?php echo $this->staff_model->get_user_fullname($lead->salesperson_id) ;?></td>
	                        <td><?php echo $lead->address ;?></td>
	                        <td><?php echo $this->leads_model->get_city($lead->city_id, $lead->state_id)->name ;?></td>
	                        <td><?php echo $this->leads_model->get_state($lead->state_id, $lead->country_id)->name ;?></td>
	                        <td><?php echo $this->leads_model->get_country($lead->country_id)->name ;?></td>
	                        <td class='numeric'><?php echo $lead->zip_code ;?></td>
	                        <td class='numeric'><?php echo number_format($lead->annual_revenue, 2, '.', ',') ;?></td>

	                      </tr>
								<?php } ?>
							 <?php } ?>
	                      <tr>
						  
	                        <td colspan="11" style="border-top: 3px solid #ddd;" class="numeric"><?php echo number_format($lead_group->amt, 2, '.', ',');?></td>
							
	                      </tr>
                    	 <?php } ?>
					 <?php } ?> 
	                      <tr>
						  
	                        <td colspan="11" style="background:#ddd;" class="numeric"><?php echo number_format($sum_amount, 2, '.', ',');?></td>
							
	                      </tr>