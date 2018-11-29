<script>

    function delete_user(staff_id)
    {
        //return confirm('Are you sure?');

        $.ajax({
            type: "GET",
            url: "<?php echo base_url('admin/staff/delete'); ?>/" + staff_id,
            success: function (msg)
            {
                if (msg == 'deleted')
                {
                    $('#staff_id_' + staff_id).fadeOut('normal');
                }
            }

        });

    }
    function clone_user(staff_id, new_first_name, new_last_name, new_email, new_password)
    {
        //return confirm('Are you sure?');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/staff/cloning'); ?>/",
            data: { staff_id : staff_id, new_first_name : new_first_name, new_last_name : new_last_name, new_email : new_email, new_password : new_password },
            success: function (msg)
            {
                if (msg == 'cloned')
                {
                    location.reload();
                }
            }

        });

    }
</script>

<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="row">
        <div>
            <?php if (check_staff_permission('staff_write')) { ?> 
                <a  style="float:right;" href="<?php echo base_url('admin/staff/add/'); ?>" class="btn btn-primary btn-embossed"> Create New</a>
                <a href="<?php echo base_url('admin/staff/'); ?>" class="btn btn-black btn-embossed"> Manage Staff</a> 
                <?php if (check_staff_permission('sales_team_read')){?> 
                <a href="<?php echo base_url('admin/salesteams'); ?>" class="btn btn-gray btn-embossed"> Manage Sales Team</a> 	
                <?php } ?>
            <?php } ?>
        </div>           
    </div>
    <div class="row">
        <div class="panel">
            <div class="panel-content"> 
                <div class="panel-content pagination2 table-responsive">
                    <table class="table table-hover table-dynamic">
                        <thead>
                            <tr>
                                  <!--<th>&nbsp;</th>-->
                                <th><?php echo $this->lang->line('name'); ?></th>
                                <th><?php echo $this->lang->line('email'); ?></th>
                                <th><?php echo $this->lang->line('register_time'); ?></th>
                                <th><?php echo $this->lang->line('options'); ?></th>     
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (!empty($staffs)) { ?>
                                <?php foreach ($staffs as $staff) { ?>
                                    <tr id="staff_id_<?php echo $staff->id; ?>">
                                        <!--<td style="width:15px;"><input type="checkbox" name="clone[]" value="<?php echo $staff->id ?>"></td>-->
                                        <td><a href="<?php echo base_url('admin/staff/view/' . $staff->id); ?>"><?php echo $staff->first_name . ' ' . $staff->last_name; ?></a></td>
                                        <td><?php echo $staff->email; ?></td>
                                        <td><?php echo date('d F Y g:i a', $staff->register_time); ?></td>
                                        <td>
                                            <?php if (check_staff_permission('staff_write')) { ?>
                                                <a href="<?php
                                                if ($this->user_model->get_role(userdata('id'))[0]->role_id == $staff->id) {
                                                    echo base_url('admin/account_settings/');
                                                } else {
                                                    echo base_url('admin/staff/update/' . $staff->id);
                                                }
                                                ?>" class="edit btn btn-sm btn-default dlt_sm_table" title="Edit"><i class="icon-note"></i></a> 
                                               <?php } ?>
                                            
                                               <?php if (check_staff_permission('staff_write')) { ?>
                                                <a href="javascript:void(0)" class="edit btn btn-sm btn-default dlt_sm_table" title="Clone" data-toggle="modal" data-target="#modal-clone<?php echo $staff->id; ?>"><i class="icons-socialmedia-02"></i></a> 
                                               <?php } ?>
                                                
                                               <?php if (check_staff_permission('staff_delete')) { ?>
                                                <a href="javascript:void(0)" class="delete btn btn-sm btn-danger dlt_sm_table" data-toggle="modal" data-target="#modal-basic<?php echo $staff->id; ?>"><i class="glyphicon glyphicon-trash" title="Delete"></i></a>
                                            <?php } ?>
                                        </td> 
                                    </tr>
                                <div class="modal fade" id="modal-basic<?php echo $staff->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                <button type="button" onclick="delete_user(<?php echo $staff->id; ?>)" class="btn btn-primary btn-embossed" data-dismiss="modal">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="modal-clone<?php echo $staff->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                                                <h4 class="modal-title"><strong>Confirm</strong></h4>
                                            </div>
                                            <div class="modal-body">
                                             <!--   Set new name for the clone : <br>
                                                First Name&nbsp;:&nbsp;<input type="text" name="new_first_name" id="new_first_name<?php echo $staff->id; ?>">&nbsp;&nbsp;&nbsp;Last Name&nbsp;:&nbsp;<input type="text" name="new_last_name" id="new_last_name<?php echo $staff->id; ?>"><br/>
                                                <br>
                                                Email&nbsp;:&nbsp;<input type="text" name="new_email" id="new_email<?php echo $staff->id; ?>">&nbsp;&nbsp;&nbsp;Password&nbsp;:&nbsp;<input type="password" name="new_password" id="new_password<?php echo $staff->id; ?>"><br/>
                                          --> 
										  <h4 class="modal-title"><strong> Set new name for the clone : </strong></h4>
											<div class="row">
					                          <div class="col-sm-12">
					                            <div class="form-group">
					                              <label class="control-label">First Name</label>
					                              <div class="append-icon">
					                                <input type="text" name="new_first_name" id="new_first_name<?php echo $staff->id; ?>" class="form-control">
					                                 <i class="icon-fa-user"></i>
				                             
					                              </div>
					                            </div>
					                          </div>
					                         </div>
											 <div class="row">
											  <div class="col-sm-12">
					                            <div class="form-group">
					                              <label class="control-label">Last Name</label>
					                              <div class="append-icon">
					                                 <input type="text" name="new_last_name" id="new_last_name<?php echo $staff->id; ?>" class="form-control">
					                              </div>
					                            </div>
					                          </div>
											</div>
											<div class="row">
					                          <div class="col-sm-12">
					                            <div class="form-group">
					                              <label class="control-label">Email</label>
					                              <div class="append-icon">
					                                <input type="text" name="new_email" id="new_email<?php echo $staff->id; ?>" class="form-control">
					                                 <i class="icon-envelope"></i>
				                             
					                              </div>
					                            </div>
					                          </div>
					                         </div>
											 <div class="row">
											  <div class="col-sm-12">
					                            <div class="form-group">
					                              <label class="control-label">Password</label>
					                              <div class="append-icon">
					                                 <input type="password" name="new_password" id="new_password<?php echo $staff->id; ?>" class="form-control">
					                                  <i class="icon-lock"></i>
				                             	   </div>
					                            </div>
					                          </div>
											</div>
										  </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default btn-embossed" data-dismiss="modal">Cancel</button>
                                                <button type="button" onclick="clone_user(<?php echo $staff->id; ?>, $('#new_first_name<?php echo $staff->id; ?>').val(), $('#new_last_name<?php echo $staff->id; ?>').val(), $('#new_email<?php echo $staff->id; ?>').val(), $('#new_password<?php echo $staff->id; ?>').val())" class="btn btn-primary btn-embossed" data-dismiss="modal">Clone</button>
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
