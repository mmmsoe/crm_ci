				
				<?php if( ! empty($contacts) ){?>
					    <?php foreach( $contacts as $contacts){ ?>
	                       <?php //if($leads_group->industry_id !== '' || $leads_group->customer_id !== '0' || $leads_group->annual_revenue !== '' || $leads_group->rating_id !== '') { ?>
						   
	                      <tr id="contact_id_<?php echo $contacts->id; ?>">
						  
							<td><?php echo $contacts->first_name.' '.$contacts->last_name; ?></td>
							<td><?php echo $contacts->phone; ?></td>
							<td><?php echo $contacts->email; ?></td>
							<td><?php echo $this->customers_model->get_account_name($contacts->company_id,'name'); ?></td>
	         			    
								<td><?php echo date('Y-m-d',$contacts->register_time); ?></td>
								<td><?php echo $contacts->address; ?></td>
								<td><?php echo $this->customers_model->get_cities_name($contacts->city_id,'name','city'); ?></td>
	         			    	<td><?php echo $this->customers_model->get_cities_name($contacts->state_id,'name','state'); ?></td>
	         			    
						    <td><?php echo $this->customers_model->get_cities_name($contacts->country_id,'name','country'); ?></td>
	         				<td><?php echo $contacts->zip_code; ?></td>
							<!--<td><?php //echo $contacts->annual_revenue; ?></td>
								<td><?php //echo $contacts->annual_revenue; ?></td> -->
						 
	                      </tr>
							   <?php //} ?>
							 <?php } ?>
							<?php } ?> 
