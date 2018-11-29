<script>

 function delete_contact( id )
 {
     
    $.ajax({

        type: "GET",
        url: "<?php echo base_url('admin/contact/delete' ); ?>/" + id,
        success: function(msg)
        {
			if( msg == 'deleted' )
            {
                $('#contact_id_' + id).fadeOut('normal');
            }
        }

    });
       
 }

 </script>
        <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
        	<div class="row">
            <h2 class="col-md-6"><strong>Contact Group</strong></h2> 
            <div style="float:right; padding-top:10px;">
               <?php if (check_staff_permission('sales_orders_write')){?>
			  <a href="<?php echo base_url('admin/contact/add/'); ?>" class="btn btn-primary btn-embossed"> New Contact</a> 	
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
                        <th>Contact Name</th>                             
						<th>Account Name</th> 
                        <th>Email</th> 
                        <th>Phone</th> 
                        <th>Contact Owner</th> 
                         
                        <th><?php echo $this->lang->line('options'); ?></th>     
                      </tr>
                    </thead>
                    <tbody>
                      
                      <?php if( ! empty($contact) ){?>
					    <?php foreach( $contact as $contact){ ?>
	                      <tr id="contact_id_<?php echo $contact->id; ?>">
	                       
	                       
	                        <td><?php echo $contact->first_name; ?> <?php echo $contact->last_name; ?> </td>
	                        <td><?php echo $contact->account_name; ?></td>
	                        
	                        <td><?php echo $contact->email; ?></td>
	                        <td><?php echo $contact->phone; ?></td>
	                        <td><?php echo $contact->contact_owner; ?></td>
	                        
	                        <td style="width: 12%;">
	                        <?php if (check_staff_permission('contacts_write')){?>
	                        <a href="<?php echo base_url('admin/contact/update/'.$contact->id); ?>" class="edit btn btn-sm btn-default dlt_sm_table"><i class="icon-note"></i></a> 
	                        <?php }?>
	                       
	                       <?php if (check_staff_permission('contacts_delete')){?>
	                        <a href="javascript:void(0)" class="delete btn btn-sm btn-danger dlt_sm_table" data-toggle="modal" data-target="#modal-basic<?php echo $contact->id; ?>"><i class="glyphicon glyphicon-trash"></i></a>
	                        <?php }?>
	                        </td> 
	                      </tr>
	                      <div class="modal fade" id="modal-basic<?php echo $contact->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
					                  <button type="button" onclick="delete_contact(<?php echo $contact->id; ?>)" class="btn btn-primary btn-embossed" data-dismiss="modal">Delete</button>
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
      