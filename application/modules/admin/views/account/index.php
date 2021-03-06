<script>

 function delete_account( id )
 {
     
    $.ajax({

        type: "GET",
        url: "<?php echo base_url('admin/account/delete' ); ?>/" + id,
        success: function(msg)
        {
			if( msg == 'deleted' )
            {
                $('#account_id_' + id).fadeOut('normal');
            }
        }

    });
       
 }

 </script>
        <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
        	<div class="row">
            <h2 class="col-md-6"><strong>Account</strong></h2> 
            <div style="float:right; padding-top:10px;">
               <?php if (check_staff_permission('sales_orders_write')){?>
			  <a href="<?php echo base_url('admin/account/add/'); ?>" class="btn btn-primary btn-embossed"> Create New</a> 	
			  <?php }?>
            </div>           
          </div>
            <div class="row">
	           <div class="panel">				
			   <div class="panel-content">
           
           		<div class="panel-content pagination2 table-responsive">
            	
                  <table class="table table-hover table-dynamic filter-between_date">
                    <thead>
                      <tr>                        
                        <th>Account Name</th>                             
						<th>Phone</th> 
                        <th>Website</th> 
                        <th>Account Owner</th> 
                         
                        <th><?php echo $this->lang->line('options'); ?></th>     
                      </tr>
                    </thead>
                    <tbody>
                      
                      <?php if( ! empty($account) ){?>
					    <?php foreach( $account as $account){ ?>
	                      <tr id="account_id_<?php echo $account->id; ?>">
	                       
	                       
	                        <td><a href="<?php echo base_url('admin/account/view/'.$account->id); ?>"><?php echo $account->account_name; ?></a></td>
	                        <td><?php echo $account->phone; ?></td>
	                        
	                        <td><?php echo $account->account_site; ?></td>
	                        <td><?php echo $account->system_value_txt; ?></td>
	                        
	                        <td style="width: 12%;">
	                        <?php if (check_staff_permission('accounts_write')){?>
	                        <a href="<?php echo base_url('admin/account/update/'.$account->id); ?>" class="edit btn btn-sm btn-default dlt_sm_table"><i class="icon-note"></i></a> 
	                        <?php }?>
	                       
	                       <?php if (check_staff_permission('accounts_delete')){?>
	                        <a href="javascript:void(0)" class="delete btn btn-sm btn-danger dlt_sm_table" data-toggle="modal" data-target="#modal-basic<?php echo $account->id; ?>"><i class="glyphicon glyphicon-trash"></i></a>
	                        <?php }?>
	                        </td> 
	                      </tr>
	                      <div class="modal fade" id="modal-basic<?php echo $account->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
					                  <button type="button" onclick="delete_account(<?php echo $account->id; ?>)" class="btn btn-primary btn-embossed" data-dismiss="modal">Delete</button>
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
      