					<?php if( ! empty($leads_group) ){?>
					    <?php foreach( $leads_group as $leads){ ?>
	                     
						 <tr id="leads_id_<?php echo $leads->id; ?>">
						  
	                         <td><?php echo $leads->lead_name ;?></td>
							 <td><?php echo $leads->email ;?></td>
							 <td><?php echo $leads->phone ;?></td>
							 <td><?php echo $this->system_model->system_single_value('LEAD', $leads->lead_source_id)->system_value_txt ;?></td>
							 <td><?php echo $this->system_model->system_single_value('LEAD_STATUS', $leads->lead_status_id)->system_value_txt ;?></td>
							 <td><?php echo $leads->company_name ;?></td>
							
	                      </tr>
							
                    	 <?php } ?>
					 <?php } ?> 
                      