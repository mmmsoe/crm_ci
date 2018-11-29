<script>

 function delete_salesteams( campaign_id )
 {
     
    $.ajax({

        type: "GET",
        url: "<?php echo base_url('admin/campaign/delete' ); ?>/" + campaign_id,
        success: function(msg)
        {
			if( msg == 'deleted' )
            {
                $('#campaign_id_' + campaign_id).fadeOut('normal');
            }
        }

    });
       
 }

 </script>
        <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
        	<div class="row">
            <!--h2 class="col-md-6"><strong>Campaign Managements</strong></h2--> 
            <div>
				<?php if (check_staff_permission('sales_team_write')){?> 
					<a style="float:right;" href="<?php echo base_url('admin/campaign/add/'); ?>" class="btn btn-primary btn-embossed" id="btnCreate"> Create Campaign</a> 
					<a href="" class="btn btn-black btn-embossed"> Manage Campaign</a> 	
					<a href="" class="btn btn-gray btn-embossed"> Update Campaign</a> 	
				<?php }?> 
            </div>           
          </div>
            

            <div class="row">
	           <div class="panel">																				<div class="panel-content">
           
           		<div class="panel-content pagination2 table-responsive">
            	
                  <table class="table table-hover table-dynamic ">
                    <thead>
                      <tr>                        
                        <th>Campaign Name</th>                         
                        <th>Type</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Campaign Owner</th>
                        <th><?php echo $this->lang->line('options'); ?></th>     
                      </tr>
                    </thead>
                    <tbody>
                      
                      <?php if( ! empty($campaign) ){?>
					    <?php foreach( $campaign as $campaign){ ?>
	                      <tr id="campaign_id_<?php echo $campaign->id; ?>">	                        
	                        <td><a href="<?php echo base_url('admin/campaign/update/'.$campaign->id); ?>"><?php echo $campaign->campaign_name; ?></a></td>
	                        <td><?php echo $campaign->type;?></td>
	                        <td><?php echo $campaign->status;?></td>
	                        <td><?php echo date('m/d/Y',$campaign->start_date);?></td>	                        
	                        <td><?php echo date('m/d/Y',$campaign->end_date);?></td>	                        
	                        <td><?php echo $campaign->first_name." ".$campaign->last_name;?></td>	                        
	                                                
	                        <td style="width: 12%;">
	                        <?php if (check_staff_permission('campaign_write')){?>
	                        <a href="<?php echo base_url('admin/campaign/update/'.$campaign->id); ?>" class="edit btn btn-sm btn-default dlt_sm_table"><i class="icon-note"></i></a> 
	                        <?php }?>
	                        
	                        <?php if (check_staff_permission('campaign_delete')){?>
	                        <a href="javascript:void(0)" class="delete btn btn-sm btn-danger dlt_sm_table" data-toggle="modal" data-target="#modal-basic<?php echo $campaign->id; ?>"><i class="glyphicon glyphicon-trash"></i></a>
	                        <?php }?>
	                        
	                        </td> 
	                      </tr>
	                      <div class="modal fade" id="modal-basic<?php echo $campaign->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
					                  <button type="button" onclick="delete_salesteams(<?php echo $campaign->id; ?>)" class="btn btn-primary btn-embossed" data-dismiss="modal">Delete</button>
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
      