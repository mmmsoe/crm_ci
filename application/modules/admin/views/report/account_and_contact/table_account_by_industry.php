				
				<?php if( ! empty($leads_group) ){?>
					    <?php foreach( $leads_group as $leads_group){ ?>
	                    <?php //if($leads_group->industry_id !== '' || $leads_group->customer_id !== '0' || $leads_group->annual_revenue !== '') { ?>
						 
	                     <tr>
						<?php if ($leads_group->industry_id !=='') { ?>
						<td colspan="4" style="background:#f0f4f8"><?php echo $this->system_model->system_single_value('INDUSTRY', $leads_group->industry_id)->system_value_txt .' ('.$leads_group->cnt.')'; ?></td>
						<?php }else { ?>
						    <td colspan="4" style="background:#f0f4f8"><?php echo 'No Industry' .' ('.$leads_group->cnt.')'; ?></td>
						<?php } ?>
	                    	
	                      </tr>	
						   
						   <?php $leads = $this->leads_model->get_list_by_group_account( array('industry_id' => $leads_group->industry_id), $min, $max ,'' ); ?>
							  <?php if( ! empty($leads) ){?>
								<?php foreach( $leads as $leads){ ?>
																
	                      <tr id="leads_id_<?php echo $leads->id; ?>">
						  
	                        <td></td>
	                        <td><?php echo $this->customers_model->get_account_name($leads->customer_id,'name'); ?></td>
	         			    <td><?php echo $this->system_model->system_single_value('RATING', $leads->rating_id)->system_value_txt; ?></td>
	                    	<td><?php echo number_format($leads->annual_revenue,2,'.',','); ?></td>
						 
	                      </tr>
							   <?php //} ?>
							 <?php } ?>
	        			   <?php } ?>
                    	 <?php } ?>
					 <?php } ?> 
