                      <?php if( ! empty($leads_group) ){?>
					    <?php foreach( $leads_group as $lead_group){ ?>
						
	                      <tr>
						  
	                        <td colspan="7" style="background:#f0f4f8"><?php echo $this->system_model->system_single_value('INDUSTRY', $lead_group->industry_id)->system_value_txt .' ('.$lead_group->cnt.')'; ?></td>

	                      </tr>
						  <?php $leads = $this->leads_model->get_list_by_group_account( array('a.industry_id' => $lead_group->industry_id),$min,$max,''); ?>
						  <?php if( ! empty($leads) ){?>
							<?php foreach( $leads as $lead){ ?>
						  
						  <tr>
						  
	                        <td></td>
	                        <td><?php echo $this->system_model->system_single_value('LEAD', $lead->lead_source_id)->system_value_txt ;?></td>
	                        <td><?php echo $lead->lead_name ;?></td>
	                        <td><?php echo $lead->email ;?></td>
	                        <td><?php echo $lead->phone ;?></td>
	                        <td><?php echo $lead->company_name ;?></td>
	                        <td><?php echo date('Y/m/d G:i A', $lead->register_time) ;?></td>

							
	                      </tr>
								<?php } ?>
							 <?php } ?>
                    	 <?php } ?>
					 <?php } ?> 