 <script>

$(document).ready(function() {
		
	$("#print").attr('href', '<?php echo base_url('admin/report/print_stage_potentila').'/'; ?>');
			
	$("#applyFilter").click(function() {
		var min = document.getElementById("min").value;
		var max = document.getElementById("max").value;
		var stat = 'stage_potential';
		
		if(min && max){
			var mindt = new Date(min);
				mindt = mindt.toLocaleFormat('%Y-%m-%d');
			var maxdt = new Date(max);
				maxdt = maxdt.toLocaleFormat('%Y-%m-%d');	
		}else{
			var mindt = '-';
			var maxdt = '-';
		}
			
		// alert(mindt+' '+maxdt);
		
		$.ajax({
			type: "POST",
			url: '<?php echo base_url('admin/report/search_period');?>',
			data: {min: min, max: max,status:stat},
			success: function(data){
				
				$("#tbstagepotential tbody").html(data);
				$('#loader').slideUp(200, function() {
					$(this).remove();
				});
				$("#print").attr('href', '<?php echo base_url('admin/report/print_stage_potentila').'/'; ?>'+ mindt +'/'+ '-' +'/'+ maxdt);
			},
		});
	});
});
</script>
 <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
             <div class="row">
             <div>
               <?php if (check_staff_permission('report_write')){?>
      			 	 <a style="float:right;" href="" id="print" class="btn btn-primary" target="">Print</a>
					 <a   href="<?php echo base_url('admin/report/'); ?>" class="btn btn-black btn-embossed"> Back To Report</a> 	
		   	
				<?php }?>
			    		
            </div>          
		</div>
            <div class="row">
	           <div class="panel">																				
			   <div class="panel-content">
           			<div class="row">
				<div class="col-sm-3">
						<div class="form-group">
						  <label class="control-label">Start Date</label>
						  <div class="append-icon">
						    <input type="text" id="min" name="min" class="date-picker form-control">
						    <i class="icon-calendar"></i>
						  </div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label class="control-label">End Date</label>
						  <div class="append-icon">
						    <input type="text" id="max" name="max" class="date-picker form-control">
						    <i class="icon-calendar"></i>
						  </div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<div style="padding-top:25px;">
								<?php if (check_staff_permission('quotations_write')){?>
									<a href="#" id="applyFilter" class="btn btn-success" target="">Apply Filter</a>
								<?php }?>	
							</div>
						</div>
					</div>
				</div>
						   
           		<div class="panel-content pagination2 table-responsive" >
            	
                  <table class="table table-hover filter-between_date" id="tbstagepotential">
                    <thead>
                      <tr>                        
                        <th>Stage</th>  						
						<th>Existing Business</th> 
                        <th>New Business</th> 
                        <th>Sum Of Amount</th> 
                         
                      </tr>
		             </thead>
                     <tbody>
					       
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
                    
                      
                    </tbody>
                  </table>
                </div>
		   		</div>
			   </div>
		 	   	
       		 </div>
        </div>
        <!-- END PAGE CONTENT -->
      