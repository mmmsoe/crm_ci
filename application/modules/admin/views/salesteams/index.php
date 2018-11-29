<script>

 function delete_salesteams( salesteam_id )
 {
     
    $.ajax({

        type: "GET",
        url: "<?php echo base_url('admin/salesteams/delete' ); ?>/" + salesteam_id,
        success: function(msg)
        {
			if( msg == 'deleted' )
            {
                $('#salesteam_id_' + salesteam_id).fadeOut('normal');
            }
        }

    });
       
 }

 </script>
        <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
		
			<div class="row">
				<!--h2 class="col-md-6"><strong>Leads</strong></h2--> 
				<div>
					<?php if (check_staff_permission('sales_team_write')){?> 
						<a style="float:right" href="<?php echo base_url('admin/salesteams/add/'); ?>" class="btn btn-primary btn-embossed"> Create New</a> 
						<a href="<?php echo base_url('admin/salesteams/'); ?>" class="btn btn-black btn-embossed"> Manage Sales Team</a> 	
						<a href="<?php echo base_url('admin/staff'); ?>" class="btn btn-gray btn-embossed"> Manage Staff</a>
					<?php }?>
				</div>           
			</div>        

            <div class="row">
				<div class="panel">
					<div class="panel-content">
						<div class="panel-content pagination2 table-responsive">
			
						  <table class="table table-hover table-dynamic ">
							<thead>
							  <tr>                        
								<th>Sales Team Name</th>                         
								<th>Invoice Target</th>
								<th>Invoice Forecast</th>
								<th>Actual Invoiced</th>
								<th><?php echo $this->lang->line('options'); ?></th>     
							  </tr>
							</thead>
							<tbody>
							  
							  <?php if( ! empty($salesteams) ){?>
								<?php foreach( $salesteams as $salesteam){ ?>
								  <tr id="salesteam_id_<?php echo $salesteam->id; ?>">	                        
									<td><a href="<?php echo base_url('admin/salesteams/update/'.$salesteam->id); ?>"><?php echo $salesteam->salesteam; ?></a></td>
									<td class="numeric"><?php echo number_format($salesteam->invoice_target,2,'.',',');?></td>
									<td class="numeric"><?php echo number_format($salesteam->invoice_forecast,2,'.',',');?></td>
									<td class="numeric"><?php echo number_format($salesteam->actual_invoice,2,'.',',');?></td>	                        
															
									<td style="width: 12%;">
									<?php if (check_staff_permission('sales_team_write')){?>
									<a href="<?php echo base_url('admin/salesteams/update/'.$salesteam->id); ?>" class="edit btn btn-sm btn-default dlt_sm_table"><i class="icon-note"></i></a> 
									<?php }?>
									
									<?php if (check_staff_permission('sales_team_delete')){?>
									<a href="javascript:void(0)" class="delete btn btn-sm btn-danger dlt_sm_table" data-toggle="modal" data-target="#modal-basic<?php echo $salesteam->id; ?>"><i class="glyphicon glyphicon-trash"></i></a>
									<?php }?>
									
									</td> 
								  </tr>
								  <div class="modal fade" id="modal-basic<?php echo $salesteam->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
											  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
											  <h4 class="modal-title"><strong>Confirm</strong></h4>
											</div>
											<div class="modal-body">
											  Are you sure you want to delete this?<br>
											</div>
											<div class="modal-footer">
											  <button type="button" class="btn btn-default btn-embossed" data-dismiss="modal">Cancel</button>
											  <button type="button" onclick="delete_salesteams(<?php echo $salesteam->id; ?>)" class="btn btn-primary btn-embossed" data-dismiss="modal">Delete</button>
											</div>
										 </div>
									 </div>
								  </div>
								  
								 <?php } ?>
							 <?php } ?> 
							  
							  
							</tbody>
						  </table>
						</div>
					</div>
				</div>
       		</div>
        </div>
        <!-- END PAGE CONTENT -->
      