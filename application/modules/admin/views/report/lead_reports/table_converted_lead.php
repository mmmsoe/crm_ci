                      <?php if( ! empty($leads_group) ){?>
					    <?php foreach( $leads_group as $lead_group){ ?>
						
	                      <tr>
						  
	                        <td colspan="6" style="background:#f0f4f8"><?php echo $lead_group->lead_name .' ('.$lead_group->cnt.')'; ?></td>

	                      </tr>
						  <?php $leads = $this->leads_model->get_list_by_group_account( array('a.id' => $lead_group->id),$min,$max,'converted'); ?>
						  <?php if( ! empty($leads) ){?>
							<?php foreach( $leads as $lead){ ?>
						  
						  <tr>
						  
	                        <td></td>
	                        <td><?php echo $this->system_model->system_single_value('LEAD', $lead->lead_source_id)->system_value_txt ;?></td>
	                        <td><?php echo $lead->company_name ;?></td>
	                        <td><?php echo $lead->name ;?></td>
	                        <td><?php echo $lead->opportunity ;?></td>
	                        <td><?php echo $this->staff_model->get_user($lead->salesperson_id)->first_name." ".$this->staff_model->get_user($lead->salesperson_id)->last_name ;?></td>
							
	                      </tr>
								<?php } ?>
							 <?php } ?>
                    	 <?php } ?>
					 <?php } ?> 