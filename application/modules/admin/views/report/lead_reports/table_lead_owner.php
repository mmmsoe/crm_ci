                      <?php if( ! empty($leads_group) ){?>
					    <?php foreach( $leads_group as $lead_group){ ?>
						
	                      <tr>
						  
	                        <td colspan="6" style="background:#f0f4f8"><?php echo $this->staff_model->get_user_fullname($lead_group->salesperson_id) .' ('.$lead_group->cnt.')'; ?></td>

	                      </tr>
						  <?php $leads = $this->leads_model->get_list_by_group_account( array('a.salesperson_id' => $lead_group->salesperson_id),$min,$max,''); ?>
						  <?php if( ! empty($leads) ){?>
							<?php foreach( $leads as $lead){ ?>
						  
						  <tr>
						  
	                        <td></td>
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