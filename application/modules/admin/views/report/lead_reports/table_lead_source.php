					<?php if( ! empty($leads_group) ){?>
					    <?php foreach( $leads_group as $leads_group){ ?>
	                       
	                      <tr id="leads_id_<?php echo $leads_group->id; ?>">
							<?php if ($leads_group->lead_source_id !=='') { ?>
	                        <td colspan="6" style="background:#f0f4f8"><?php echo $this->system_model->system_single_value('LEAD', $leads_group->lead_source_id)->system_value_txt .' ('.$leads_group->cnt.')'; ?></td>
							<?php }else { ?>
						    <td colspan="6" style="background:#f0f4f8"><?php echo 'No Lead Source' .' ('.$leads_group->cnt.')'; ?></td>
							<?php } ?>
	                      </tr>	
						   
						   <?php $leads = $this->leads_model->get_list_by_group_account( array('lead_source_id' => $leads_group->lead_source_id),$min,$max,'' ); ?>
							  <?php if( ! empty($leads) ){?>
								<?php foreach( $leads as $leads){ ?>
																
	                      <tr id="leads_id_<?php echo $leads->id; ?>">
						  
	                        <td></td>
	                         <td><?php echo $leads->lead_name ;?></td>
							 <td><?php echo $leads->email ;?></td>
							 <td><?php echo $leads->company_name ;?></td>
							 <td><?php echo date('Y/m/d G:i A', $leads->register_time) ;?></td>
							 <td><?php echo $this->staff_model->get_user($leads->salesperson_id)->first_name." ".$this->staff_model->get_user($leads->salesperson_id)->last_name ;?></td>
							
	                      </tr>
							 <?php } ?>
	        			   <?php } ?>
                    	 <?php } ?>
					 <?php } ?> 