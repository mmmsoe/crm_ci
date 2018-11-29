								<?php if( ! empty($opportunities_group) ){?>
							<?php foreach( $opportunities_group as $opportunities_group){ ?>
						<?php if ($opportunities_group->stages_id !=='' || $opportunities_group->stages_id !=='0'){ ?>
					
						<tr id="opportunities_id_<?php echo $opportunities_group->id; ?>">
						    
							<td><?php echo $this->system_model->system_single_value('OPPORTUNITIES_STAGES', $opportunities_group->stages_id)->system_value_txt .' ('.$opportunities_group->cnt.')'; ?></td>
							<td class="numeric"><?php echo number_format($opportunities_group->existing_bussines,2,'.',','); ?></td>
							<td class="numeric"><?php echo number_format($opportunities_group->new_bussines,2,'.',','); ?></td>
				        	<td class="numeric"><?php echo number_format($opportunities_group->amt,2,'.',','); ?></td>
	                    	
	                    </tr>
								
								<?php } ?>
							<?php } ?>
						 <?php } ?>
						      
							  <tr id="opportunities_id_<?php echo $opportunity->id; ?>">
						  
						  <td style="background:#ddd;"><b>Sum Of Amount</b></td>
						  <td style="background:#ddd;" class="numeric"><?php echo number_format($typetwo, 2, '.', ',');?></td>
						  <td  style="background:#ddd;" class="numeric"><?php echo number_format($typeone, 2, '.', ',');?></td>
	                      <td  style="background:#ddd;" class="numeric"><?php echo number_format($sum_amount, 2, '.', ',');?></td>
	                        
	                      </tr>