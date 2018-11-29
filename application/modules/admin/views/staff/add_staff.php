<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<style>
    /* 
    Generic Styling, for Desktops/Laptops 
    */
    table { 
        width: 100%; 
        border-collapse: collapse; 
    }
    /* Zebra striping */
    tr:nth-of-type(odd) { 
        background: #eee; 
    }
    th { 
        background: #0c5aaf; 
        color: white; 
        font-weight: bold; 
    }
    td, th { 
        padding: 6px; 
        border: 1px solid #ccc; 
        text-align: left; 
    }



    /* 
    Max width before this PARTICULAR table gets nasty
    This query will take effect for any screen smaller than 760px
    and also iPads specifically.
    */
    @media 
    only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px)  {

        .responsive-table-input-matrix {
            display: block;
            position: relative;
            width: 100%;

            &:after {
                clear: both;
                content: '';
                display: block;
                font-size: 0;
                height: 0;
                visibility: hidden;
            }

            tbody {
                display: block;
                overflow-x: auto;
                position: relative;
                white-space: nowrap;
                width: auto;


                tr {
                    display: inline-block;
                    vertical-align: top;

                    td {
                        display: block;
                        text-align: center;

                        &:first-child {
                            text-align: left;
                        }
                    }
                }
            }

            thead {
                display: block;
                float: left;
                margin-right: 10px;

                &:after {
                    clear: both;
                    content: "";
                    display: block;
                    font-size: 0;
                    height: 0;
                    visibility: hidden;
                }

                th:first-of-type {
                    height: 1.4em;
                }

                th {
                    display: block;
                    text-align: right;

                    &:first-child {
                        text-align: right;
                    }
                }
            }
        }
    }
</style>

<!-- BEGIN PAGE CONTENT -->
<div class="page-content page-thin">
    <div class="header">
        <h2><strong>Add Staff</strong></h2>            
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel">

                <div class="panel-content">
                    <div id="staff_ajax">                      	                       
                        <?php
                        if ($this->session->flashdata('message')) {
                            echo $this->session->flashdata('message');
                        }
                        ?>                     	

                    </div>

                    <form id="add_staff" name="add_staff" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">



                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label"style="color:red;">* First Name</label>
                                    <div class="append-icon">
                                        <input type="text" name="first_name" value="" class="form-control clear">
                                        <i class="icon-user"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label"style="color:red;">* Last Name</label>
                                    <div class="append-icon">
                                        <input type="text" name="last_name" value="" class="form-control clear">
                                        <i class="icon-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">				                         
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label"style="color:red;">* Phone Number</label>
                                    <div class="append-icon">
                                        <input type="text" name="phone_number" value="" class="form-control clear numeric">
                                        <i class="icon-screen-smartphone"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label"style="color:red;">* Email Address</label>
                                    <div class="append-icon">
                                        <input type="email" name="email" value="" class="form-control clear">
                                        <i class="icon-envelope"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label"style="color:red;">* Password</label>
                                    <div class="append-icon">
                                        <input type="password" name="pass1" id="password1" value="" class=" clear form-control">
                                        <i class="icon-lock"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label"style="color:red;">* Repeat Password</label>
                                    <div class="append-icon">
                                        <input type="password" name="pass2" id="password2" value="" class="clear form-control">
                                        <i class="icon-lock"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">SMTP User</label>
                                    <div class="append-icon">
                                        <input type="email" name="smtp_user" value="" class="form-control">
                                        <!--i class="icon-envelope"></i-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">SMTP Password</label>
                                    <div class="append-icon">
                                        <input type="password" name="smtp_pass" value="" class="form-control">
                                        <!--i class="icon-screen-smartphone"></i-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">SMTP Host</label>
                                    <div class="append-icon">
                                        <input type="text" name="smtp_host" value="<?php echo $setting_list->smtp_host;?>" class="form-control">
                                        <!--i class="icon-screen-smartphone"></i-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">SMTP Port</label>
                                    <div class="append-icon">
                                        <input type="smtp_port" name="smtp_port" value="<?php echo $setting_list->smtp_port;?>" class="form-control numeric">
                                        <!--i class="icon-envelope"></i-->	
                                    </div>
                                </div>
                            </div>				                          
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">IMAP Server</label>
                                    <div class="append-icon">
                                        <input type="text" name="imap_host" value="<?php echo $setting_list->imap_host;?>" class="form-control">
                                        <!--i class="icon-screen-smartphone"></i-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">IMAP Port</label>
                                    <div class="append-icon">
                                        <input type="imap_port" name="imap_port" value="<?php echo $setting_list->imap_port;?>" class="form-control numeric">
                                        <!--i class="icon-envelope"></i-->  
                                    </div>
                                </div>
                            </div>                                        
                        </div>

                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label">Upload your avatar</label>
                                    <div class="append-icon">
                                        <div class="file">
                                            <div class="option-group">
                                                <span class="file-button btn-primary">Choose File</span>
                                                <input type="file" class="custom-file" name="user_avatar" id="user_avatar" onchange="document.getElementById('uploader').value = this.value;">
                                                <input type="text" class="form-control" id="uploader" placeholder="no file selected" readonly="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" style="color:red;">* Role</label>
                                    <div class="form-group">
                                        <select name="role_id" id='role_id' class="clear form-control" style="margin-top: 3px;" onchange="javascript:on_role(this.value)">
                                            <?php if (!empty($role)) { ?>
                                                <?php foreach ($role as $r) { ?> 
                                                    <option value="<?php echo $r->role_id; ?>" ><?php echo $r->role_name; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                
                        <div class="row">

                            <div class="panel-content">
                                <div class="row">	
                                    <br/>

                                    <h3><strong>Permissions Table</strong></h3>
                                    <table class="responsive-table-input-matrix">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <h3 style="padding-left:10px;"><label><input type="checkbox" id="permission_check" name="permission_check" value="1" data-checkbox="icheckbox_square-blue"><strong>permissions</strong></label></h3>  
                                                </th>
                                                <th style='width:10%;text-align: center'>
                                                    <h3><label>Read</label></h3>
                                                </th>
                                                <th style='width:10%;text-align: center'>
                                                    <h3><label>Write</label></h3>
                                                </th>
                                                <th style='width:10%;text-align: center'>
                                                    <h3><label>Delete</label></h3>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="padding-top:1%">
                                                    <p style="padding-left:10px;"><label><input type="checkbox" class="permission_check" name="sales" id="sales" value="1" data-checkbox="icheckbox_square-blue"><strong>SALES</strong></label></p>
                                                </td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check sales" name="leads" id="leads" value="1" data-checkbox="icheckbox_square-blue"><strong>Leads</strong></label></p>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check leads sales" name="lead_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'lead_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check leads sales" name="lead_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'lead_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check leads sales" name="lead_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'lead_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check sales" name="opportunities" id="opportunities" value="1" data-checkbox="icheckbox_square-blue"><strong>Opportunities</strong></label></p>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check opportunities sales" name="opportunities_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'opportunities_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check opportunities sales" name="opportunities_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'opportunities_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check opportunities sales" name="opportunities_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'opportunities_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check sales" name="quotations" id="quotations" value="1" data-checkbox="icheckbox_square-blue"><strong>Quotations</strong></label></p>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check quotations sales" name="quotations_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'quotations_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check quotations sales" name="quotations_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'quotations_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check quotations sales" name="quotations_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'quotations_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check sales" name="sales_orders" id="sales_orders" value="1" data-checkbox="icheckbox_square-blue"><strong>Sales Orders</strong></label></p>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check sales_orders sales" name="sales_orders_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'sales_orders_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check sales_orders sales" name="sales_orders_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'sales_orders_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check sales_orders sales" name="sales_orders_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'sales_orders_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
											<!--
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
													<input type="checkbox" class="permission_check sales" name="invoices" id="invoices" value="1" data-checkbox="icheckbox_square-blue"><strong>Invoices</strong></label></p>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check invoices sales" name="invoices_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'invoices_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check invoices sales" name="invoices_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'invoices_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check invoices sales" name="invoices_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'invoices_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check sales" name="payment_log" id="payment_log" value="1" data-checkbox="icheckbox_square-blue"><strong>Payment Log</strong></label></p>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check payment_log sales" name="payment_log_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'payment_log_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check payment_log sales" name="payment_log_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'payment_log_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check payment_log sales" name="payment_log_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'payment_log_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
											-->
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check sales" name="analytics" id="analytics" value="1" data-checkbox="icheckbox_square-blue"><strong>Analytics</strong></label></p>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check analytics sales" name="analytics_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'analytics_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check analytics sales" name="analytics_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'analytics_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check analytics sales" name="analytics_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'analytics_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check sales" name="sales_team" id="sales_team" value="1" data-checkbox="icheckbox_square-blue"><strong>Sales Teams</strong></label>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check sales_team sales" name="sales_team_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'sales_team_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check sales_team sales" name="sales_team_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'sales_team_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check sales_team sales" name="sales_team_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'sales_team_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%">
                                                    <p style="padding-left:10px;"><label><input type="checkbox" class="permission_check" name="activities" id="activities" value="1" data-checkbox="icheckbox_square-blue"><strong>ACTIVITIES</strong></label></p>
                                                </td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check activities" name="email_auth" id="email_auth" value="1" data-checkbox="icheckbox_square-blue"><strong>E-Mail</strong></label></p>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check email_auth activities" name="email_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'email_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check email_auth activities" name="email_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'email_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check email_auth activities" name="email_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'email_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check activities" name="activity_entry" id="activity_entry" value="1" data-checkbox="icheckbox_square-blue"><strong>Activity Entry</strong></label></p>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check activity_entry activities" name="activity_entry_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'activity_entry_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check activity_entry activities" name="activity_entry_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'activity_entry_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check activity_entry activities" name="activity_entry_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'activity_entry_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check activities" name="calendar" id="calendar" value="1" data-checkbox="icheckbox_square-blue"><strong>Calendar</strong></label></p>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check calendar activities" name="calendar_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'calendar_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check calendar activities" name="calendar_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'calendar_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check calendar activities" name="calendar_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'calendar_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check activities" name="logged_calls" id="logged_calls" value="1" data-checkbox="icheckbox_square-blue"><strong>Logged Calls</strong></label></td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check logged_calls activities" name="logged_calls_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'logged_calls_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check logged_calls activities" name="logged_calls_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'logged_calls_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check logged_calls activities" name="logged_calls_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'logged_calls_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check activities" name="meetings" id="meetings" value="1" data-checkbox="icheckbox_square-blue"><strong>Meetings</strong></label></p></td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check meetings activities" name="meetings_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'meetings_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check meetings activities" name="meetings_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'meetings_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check meetings activities" name="meetings_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'meetings_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%">
                                                    <p style="padding-left:10px;"><label><input type="checkbox" class="permission_check" name="customer" id="customer" value="1" data-checkbox="icheckbox_square-blue"><strong>CUSTOMER</strong></label></p>
                                                </td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check customer" name="account" id="account" value="1" data-checkbox="icheckbox_square-blue"><strong>Account</strong></label></p>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check account customer" name="account_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'account_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check account customer" name="account_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'account_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check account customer" name="account_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'account_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check customer" name="contacts" id="contacts" value="1" data-checkbox="icheckbox_square-blue"><strong>Contacts</strong></label></p>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check contacts customer" name="contacts_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'contacts_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check contacts customer" name="contacts_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'contacts_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check contacts customer" name="contacts_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'contacts_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%">
                                                    <p style="padding-left:10px;"><label><input type="checkbox" class="permission_check" name="support" id="support" value="1" data-checkbox="icheckbox_square-blue"><strong>SUPPORT</strong></label></p>
                                                </td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check support" name="tickets" id="tickets" value="1" data-checkbox="icheckbox_square-blue"><strong>Tickets</strong></label>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check tickets support" name="tickets_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'tickets_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check tickets support" name="tickets_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'tikets_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check tickets support" name="tickets_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'tikets_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check support" name="knowledge_base" id="knowledge_base" value="1" data-checkbox="icheckbox_square-blue"><strong>Knowledge Base</strong></label></p>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check knowledge_base support" name="knowledge_base_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'knowledge_base_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check knowledge_base support" name="knowledge_base_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'knowledge_base_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check knowledge_base support" name="knowledge_base_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'knowledge_base_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%">
                                                    <p style="padding-left:10px;"><label><input type="checkbox" class="permission_check" name="marketing" id="marketing" value="1" data-checkbox="icheckbox_square-blue"><strong>MARKETING</strong></label></p>
                                                </td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check marketing" name="campaign_listing" id="campaign_listing" value="1" data-checkbox="icheckbox_square-blue"><strong>Campaign Listing</strong></label></td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check campaign_listing marketing" name="campaign_listing_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'campaign_listing_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check campaign_listing marketing" name="campaign_listing_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'campaign_listing_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check campaign_listing marketing" name="campaign_listing_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'campaign_listing_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%">
                                                    <p style="padding-left:10px;"><label><input type="checkbox" class="permission_check" name="setting" id="setting" value="1" data-checkbox="icheckbox_square-blue"><strong>SETTING</strong></label></p>
                                                </td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
											
											<!--
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check setting" name="update_application" id="update_application" value="1" data-checkbox="icheckbox_square-blue"><strong>Update Application</strong></label>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check update_application setting" name="update_application_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'update_application_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check update_application setting" name="update_application_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'update_application_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check update_application setting" name="update_application_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'update_application_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
											-->
											
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check setting" name="people_listing" id="people_listing" value="1" data-checkbox="icheckbox_square-blue"><strong>People Listing</strong></label>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check people_listing setting" name="people_listing_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'people_listing_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check people_listing setting" name="people_listing_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'people_listing_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check people_listing setting" name="people_listing_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'people_listing_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check setting" name="product_setting" id="product_setting" value="1" data-checkbox="icheckbox_square-blue"><strong>Product Setting</strong></label></td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check product_setting setting" name="product_setting_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'product_setting_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check product_setting setting" name="product_setting_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'product_setting_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check product_setting setting" name="product_setting_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'product_setting_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check setting" name="system_setting" id="system_setting" value="1" data-checkbox="icheckbox_square-blue"><strong>System Setting</strong></label></td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check system_setting setting" name="system_setting_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'system_setting_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check system_setting setting" name="system_setting_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'system_setting_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check system_setting setting" name="system_setting_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'system_setting_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
											<!--
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check setting" name="master_system" id="master_system" value="1" data-checkbox="icheckbox_square-blue"><strong>Master System</strong></label></td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check master_system setting" name="master_system_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'master_system_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check master_system setting" name="master_system_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'master_system_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check master_system setting" name="master_system_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'master_system_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
											-->
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check setting" name="products" id="products" value="1" data-checkbox="icheckbox_square-blue"><strong>Products</strong></label></td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check products setting" name="products_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'products_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check products setting" name="products_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'products_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check products setting" name="products_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'products_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top:1%"><p  class="icheck-list" style="padding-left:30px;"><label>
                                                            <input type="checkbox" class="permission_check setting" name="staff" id="staff" value="1" data-checkbox="icheckbox_square-blue"><strong>Staff</strong></label></td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check staff setting" name="staff_read" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'staff_read')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check staff setting" name="staff_write" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'staff_write')) echo 'checked'; ?>>
                                                </td>
                                                <td style='width:10%;text-align: center'>
                                                    <input type="checkbox" class="permission_check staff setting" name="staff_delete" value="1" data-checkbox="icheckbox_square-blue" <?php if (get_permission_value($staff->id, 'staff_delete')) echo 'checked'; ?>>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="text-left  m-t-20">
                            <div id="staff_submitbutton"><button type="submit" class="btn btn-embossed btn-primary">Create</button></div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>   

<script>

    $(document).ready(function () {
        $('#s2id_role_id').select2('val',2);
        $('.clear').val('');
        $("form[name='add_staff']").submit(function (e) {
            var formData = new FormData($(this)[0]);

            $.ajax({
                url: "<?php echo base_url('admin/staff/add_process'); ?>",
                type: "POST",
                data: formData,
                async: false,
                success: function (msg) {

                    var str = msg.split("_");
                    var id = str[1];
                    var status = str[0];

                    if (status == "yes")
                    {
                        $('body,html').animate({scrollTop: 0}, 200);
                        $("#staff_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('create_succesful') . '</div>' ?>');
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url('admin/staff/index'); ?>/";
                        }, 800); //will call the function after 1 secs.
                    } else
                    {
                        $('body,html').animate({scrollTop: 0}, 200);
                        $("#staff_ajax").html(msg);
                        $("#staff_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');

                        // $("form[name='add_staff']").find("input[type=text], input[type=checkbox]").val("");
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

            e.preventDefault();
        });

        $('#permission_check').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.permission_check').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.permission_check').iCheck('uncheck');
            });
        });

        $('#sales').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.sales').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.sales').iCheck('uncheck');
            });
        });

        $('#activities').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.activities').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.activities').iCheck('uncheck');
            });
        });

        $('#customer').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.customer').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.customer').iCheck('uncheck');
            });
        });

        $('#support').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.support').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.support').iCheck('uncheck');
            });
        });

        $('#marketing').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.marketing').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.marketing').iCheck('uncheck');
            });
        });

        $('#setting').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.setting').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.setting').iCheck('uncheck');
            });
        });

        $('#payment_log').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.payment_log').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.payment_log').iCheck('uncheck');
            });
        });

        $('#analytics').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.analytics').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.analytics').iCheck('uncheck');
            });
        });

        $('#analytics').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.analytics').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.analytics').iCheck('uncheck');
            });
        });

        $('#sales_team').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.sales_team').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.sales_team').iCheck('uncheck');
            });
        });

        $('#email_auth').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.email_auth').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.email_auth').iCheck('uncheck');
            });
        });

        $('#activity_entry').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.activity_entry').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.activity_entry').iCheck('uncheck');
            });
        });

        $('#calendar').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.calendar').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.calendar').iCheck('uncheck');
            });
        });

        $('#calendar').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.calendar').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.calendar').iCheck('uncheck');
            });
        });

        $('#account').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.account').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.account').iCheck('uncheck');
            });
        });

        $('#contacts').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.contacts').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.contacts').iCheck('uncheck');
            });
        });

        $('#campaign_listing').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.campaign_listing').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.campaign_listing').iCheck('uncheck');
            });
        });

        $('#product_setting').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.product_setting').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.product_setting').iCheck('uncheck');
            });
        });

        $('#system_setting').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.system_setting').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.system_setting').iCheck('uncheck');
            });
        });

        $('#master_system').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.master_system').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.master_system').iCheck('uncheck');
            });
        });

        $('#people_listing').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.people_listing').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.people_listing').iCheck('uncheck');
            });
        });

        $('#update_application').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.update_application').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.update_application').iCheck('uncheck');
            });
        });

        $('#leads').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.leads').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.leads').iCheck('uncheck');
            });
        });

        $('#opportunities').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.opportunities').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.opportunities').iCheck('uncheck');
            });
        });


        $('#logged_calls').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.logged_calls').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.logged_calls').iCheck('uncheck');
            });
        });

        $('#meetings').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.meetings').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.meetings').iCheck('uncheck');
            });
        });

        $('#products').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.products').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.products').iCheck('uncheck');
            });
        });

        $('#quotations').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.quotations').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.quotations').iCheck('uncheck');
            });
        });

        $('#sales_orders').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.sales_orders').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.sales_orders').iCheck('uncheck');
            });
        });

        $('#invoices').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.invoices').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.invoices').iCheck('uncheck');
            });
        });

        $('#tickets').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.tickets').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.tickets').iCheck('uncheck');
            });
        });

        $('#knowledge_base').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.knowledge_base').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.knowledge_base').iCheck('uncheck');
            });
        });

        $('#staff').on('ifChanged', function (event) {
            $(this).on('ifChecked', function (event) {
                $('.staff').iCheck('check');
            });
            $(this).on('ifUnchecked', function (event) {
                $('.staff').iCheck('uncheck');
            });
        });
    });

    function on_role(val) {
        if (val == 1) {
            $('.permission_check').iCheck('check');            
            $('#permission_check').iCheck('check');
        } else {
            $('.permission_check').iCheck('uncheck');
            $('#permission_check').iCheck('uncheck');
        }
    }


</script>
<!-- END PAGE CONTENT -->

