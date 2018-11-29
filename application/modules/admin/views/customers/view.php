<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6 clearPad-r" style="text-align: right;">
                <!--a href="<?php echo base_url('admin/customers/download/' . $customer->company_attachment); ?>" class="edit btn btn-primary btn-embossed" title="Download">Download Attachment</a-->
            <a href="#" data-toggle="modal" data-target="#modal-activity" class="btn btn-primary btn-embossed">Create Activity</a>
            <!--<a href="<?php echo base_url('admin/logged_calls/add/' . $customer->id); ?>" class="btn btn-primary btn-embossed"> Add Logged Calls</a>
            <a href="<?php echo base_url('admin/meetings/add/' . $customer->id); ?>" class="btn btn-primary btn-embossed"> Add Meetings</a>-->
            <a href="<?php echo base_url('admin/customers/update/' . $customer->id); ?>" class="btn btn-primary btn-embossed"> Edit Account</a>
        </div>              
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel widget-member2">
                <h3 class="pad-l clearMar-t">Company Details Information</h3>
                <hr /><div class="clearfix"></div>
                <div class="row">
                    <div class="col-xs-4" style="text-align: center; float:left;">
                        <?php if ($customer->company_avatar) { ?>
                            <img src="<?php echo base_url('uploads/company') . '/' . $customer->company_avatar; ?>" alt="profil 4" style="height: auto;width:150px;">
                        <?php } else { ?>
                            <img src="<?php echo base_url(); ?>public/assets/global/images/avatars/company1.png" alt="user image" style="height: auto;width:90%; max-width: 335px; border-radius: 0;">  
                        <?php } ?>
                        <h3 style="text-align:center; font-weight: bold"  class="mar-t clearMar-b">&nbsp;<?php echo $customer->name; ?></h3>
                    </div>
                    <div class="col-xs-8" style="text-align: center;float:left">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><i class="fa fa-envelope"></i> &nbsp;Email</label>
                            <div class="col-sm-10 append-icon">
                                <p class="pad-l">&nbsp;<?php echo $customer->email; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-8" style="text-align: center;float:left">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><i class="fa fa-user"></i> &nbsp;Sales</label>
                            <div class="col-sm-10 append-icon">
                                <p class="pad-l">&nbsp;<?php echo $this->staff_model->get_user_fullname($customer->salesperson_id); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-8" style="text-align: center;float:left">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><i class="fa fa-tablet"></i> &nbsp;Mobile</label>
                            <div class="col-sm-10 append-icon">					                                 
                                <p class="pad-l"><?php echo $customer->mobile; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-8" style="text-align: center;float:left">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><i class="fa fa-map-marker"></i>&nbsp;Address</label>
                            <div class="col-sm-10 append-icon">
                                <p class="pad-l" ><?php echo $customer->address; ?>&nbsp;</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-8" style="text-align: center;float:left">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><i class="fa fa-fax"></i> &nbsp;Fax</label>
                            <div class="col-sm-10 append-icon">					                                 
                                <p class="pad-l">&nbsp;<?php echo $customer->fax; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4" style="text-align: center;float:left">

                    </div>		
                    <div class="col-xs-8" style="text-align: center;float:left">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><i class="fa fa-phone"></i> &nbsp;Phone</label>
                            <div class="col-sm-10 append-icon">					                                 
                                <p class="pad-l">&nbsp;<?php echo $customer->phone; ?></p>
                            </div>
                        </div>
                    </div>		
                    <div class="col-xs-4" style="text-align: center;float:left">

                    </div>		
                    <div class="col-xs-8" style="text-align: center;float:left">
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><i class="fa fa-globe"></i> &nbsp;Website</label>
                            <div class="col-sm-10 append-icon">					                                 
                                <p class="pad-l"><?php echo $customer->website; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4" style="text-align: center;float:left">

                    </div>							
                </div>
            </div>
        </div><div class="clearfix"></div>
    </div>
    <!--div class="row">
    <!--div class="col-md-12">
            <h3><strong>Cash</strong> information</h3>
            <div class="widget-cash-in-hand">
                    <div class="cash">
                            <div class="number c-primary">$<?php echo $total_sales; ?></div>
                            <div class="txt">TOAL SALES</div>
                    </div>
                    <div class="cash">
                            <div class="number c-green">$<?php echo $open_invoices; ?></div>
                            <div class="txt">open invoices</div>
                    </div>
                    <div class="cash">
                            <div class="number c-red">$<?php echo $overdue_invoices; ?></div>
                            <div class="txt">overdue invoices</div>
                    </div>
                    <div class="cash">
                            <div class="number c-blue">$<?php echo $paid_invoices; ?></div>
                            <div class="txt">paid invoices</div>
                    </div>
                    <div class="cash">
                            <div class="number c-blue">$<?php echo $quotations_total; ?></div>
                            <div class="txt">quotations total</div>
                    </div>
            </div>
    </div-->
    <!--div class="col-md-12">
            <h3 class="m-t-30 m-b-20"><strong>customer activities</strong></h3>
            <div class="widget-infobox">
               
               <a href="<?php echo base_url('admin/logged_calls/index/' . $customer->id); ?>"> 
                    <div class="infobox">
                            <div class="left">
                                    <i class="fa fa-phone bg-red"></i>
                            </div>
                            <div class="right">
                                    <div class="clearfix">
                                            <div>
                                                    <span class="c-red pull-left"><?php echo $calls; ?></span>
                                                    <br>
                                            </div>
                                            <div class="txt">CALLS</div>
                                    </div>
                            </div>
                    </div>
               </a>
                    
                    <a href="javascript:void(0)">
                    <div class="infobox">
                            <div class="left">
                                    <i class="icon-user bg-yellow"></i>
                            </div>
                            <div class="right">
                                    <div class="clearfix">
                                            <div>
                                                    <span class="c-yellow pull-left"><?php echo $meetings; ?></span>
                                                    <br>
                                            </div>
                                            <div class="txt">MEETINGS</div>
                                    </div>
                            </div>
                    </div>
                    
                    </a>

                    <a href="<?php echo base_url('admin/salesorder/index/' . $customer->id); ?>">
                    <div class="infobox">
                            <div class="left">
                                    <i class="fa fa-shopping-cart bg-blue"></i>
                            </div>
                            <div class="right">
                                    <div>
                                            <span class="c-primary pull-left"><?php echo $salesorder; ?></span>
                                            <br>
                                    </div>
                                    <div class="txt">SALES ORDERS</div>
                            </div>
                    </div>
                    </a>
                    
                    <a href="<?php echo base_url('admin/invoices/index/' . $customer->id); ?>">
                    
                    <div class="infobox">
                            <div class="left">
                                    <i class="icon-note bg-purple"></i>
                            </div>
                            <div class="right">
                                    <div class="clearfix">
                                            <div>
                                                    <span class="c-purple pull-left"><?php echo $invoices; ?></span>
                                                    <br>
                                            </div>
                                            <div class="txt">INVOICES</div>
                                    </div>
                            </div>
                    </div>
                    
                    </a>
               
               <a href="<?php echo base_url('admin/quotations/index/' . $customer->id); ?>">
                    <div class="infobox">
                            <div class="left">
                                    <i class="icon-tag bg-orange"></i>
                            </div>
                            <div class="right">
                                    <div class="clearfix">
                                            <div>
                                                    <span class="c-orange pull-left"><?php echo $quotations; ?></span>
                                                    <br>
                                            </div>
                                            <div class="txt">QUOTATIONS</div>
                                    </div>
                            </div>
                    </div>
                    </a>
                    
                    <a href="<?php echo base_url('admin/mailbox/index/' . $customer->id); ?>">
                    <div class="infobox">
                            <div class="left">
                                    <i class="icon-envelope bg-pink"></i>
                            </div>
                            <div class="right">
                                    <div class="clearfix">
                                            <div>
                                                    <span class="c-purple pull-left"><?php echo $emails; ?></span>
                                                    <br>
                                            </div>
                                            <div class="txt">EMAILS</div>
                                    </div>
                            </div>
                    </div>
                    </a>
                    
                     
                    <a href="<?php echo base_url('admin/contracts/index/' . $customer->id); ?>">
                    <div class="infobox">
                            <div class="left">
                                    <i class="icon-hourglass bg-dark"></i>
                            </div>
                            <div class="right">
                                    <div class="clearfix">
                                            <div>
                                                    <span class="c-dark pull-left"><?php echo $contracts; ?></span>
                                                    <br>
                                            </div>
                                            <div class="txt">CONTRACTS</div>
                                    </div>
                            </div>
                    </div>
                    </a>	
            </div>
    </div>
</div>
</div-->
    <div class="row">
        <div class="col-md-12 clearPad">
            <?php
            $seq = 3;
            foreach ($contacts as $contact) {
                ?>
                <div class="col-sm-6">
                    <div class="panel widget-member2">
                        <div class="row">
                            <div class="col-lg-3 col-xs-3">
                                <?php if ($contact->customer_avatar) { ?>
                                    <img src="<?php echo base_url('uploads/contacts') . '/' . $contact->customer_avatar; ?>" alt="profil 4" class="pull-left img-responsive" style="height: 81px;width:81px;">
                                    <?php
                                } else {
                                    $seq++;
                                    if ($seq == 12) {
                                        $seq = 1;
                                    }
                                    ?>

                                    <img src="<?php echo base_url(); ?>public/assets/global/images/avatars/avatar<?= $seq ?>@2x.png" alt="user image" class="pull-left img-responsive" style="height: 81px;width:81px;">  
                                <?php } ?>
                            </div>
                            <div class="col-lg-9 col-xs-9">
                                <div class="clearfix">
                                    <h3 class="m-t-0 member-name"><strong><?php echo $contact->first_name; ?><?php echo ' ' . $contact->last_name; ?></strong></h3>
                                </div>
                                <div class="row">

                                    <div class="col-sm-12">

                                        <p> <i class="fa fa-map-marker c-gray-light p-r-10"></i><?php echo $contact->address; ?></p>
                                    </div>
                                    <div class="col-sm-12">
                                        <p><i class="fa fa-globe c-gray-light p-r-10"></i> <?php echo $contact->website; ?></p>
                                    </div>

                                    <div class="col-sm-12">
                                        <p><i class="icon-envelope  c-gray-light p-r-10"></i> <?php echo $contact->email; ?></p>
                                    </div> 

                                    <div class="col-sm-12">
                                        <p><i class="fa fa-phone c-gray-light p-r-10"></i> <?php echo $contact->phone; ?></p>
                                    </div>

                                    <div class="col-sm-12">
                                        <p><i class="fa fa-fax c-gray-light p-r-10"></i> <?php echo $contact->fax; ?></p>
                                    </div>
                                    
                                    <div class="col-sm-12">
                                        <p>Contact Owner :  <?php echo $this->system_model->system_single_value('ACC_OWNER', $contact->contact_owner)->system_value_txt; ?></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <!--div class="col-md-4">
                <!--h3 class="m-t-30"><strong>Calendar</strong></h3> 
                <div class="widget widget_calendar bg-red">
                        <div class="multidatepicker"></div>
                </div>
        </div-->
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel" style="margin-top: 15px;">
                <div class="panel-content">
                    <div class="row">
                        <div class="panel-content">
                            <label class="control-label"><i class="fa fa-cubes"></i>Opportunity</label> 
                            <table class="table">
                                <thead>
                                    <tr style="font-size: 12px;">                         
                                        <th>Opportunity</th>
                                        <th>Lead Name</th>
                                        <th>Amount</th>
                                        <th>Stages</th>
                                        <!--<th>Sales Person</th>
                                        <th>Account name</th> -->
                                    </tr>
                                </thead>
                                <tbody id="InputsWrapper">
                                    <?php if (!empty($opportunities)) { ?>
                                        <?php foreach ($opportunities as $opportunity) { ?> 
                                            <tr>
                                                <td><a href="<?php echo base_url('admin/opportunities/view/' . $opportunity->id); ?>"><?php echo $opportunity->opportunity; ?></a></td>
                                                <td><?php echo $this->leads_model->get_lead_single($opportunity->lead_id)->lead_name; ?></td>
                                                <td class="numeric"><?= ($opportunity->amount != null && $opportunity->amount != '' ? number_format($opportunity->amount, 2, '.', ',') : '') ?></td>
                                                <td><?php echo $this->system_model->system_single_value('OPPORTUNITIES_STAGES', $opportunity->stages_id)->system_value_txt; ?></td>
                                                <!--<td><?php //echo $this->staff_model->get_user($opportunity->salesperson_id)->first_name . " " . $this->staff_model->get_user($opportunity->salesperson_id)->last_name;            ?></td>
                                                <td><?php //echo $this->customers_model->get_company($opportunity->customer_id)->name;            ?> </td>-->
                                            </tr>	

                                        <?php } ?>
                                    <?php } ?> 

                                </tbody>
                            </table>

                        </div>							
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel" style="margin-top: 15px;">
                <div class="panel-content pagination2 table-responsive">
                    <label class="control-label"><i class="fa fa-cubes"></i>Activities : </label>
                    <select name="activity_type" id="activity_type" style="width:200px;" onChange="filter_activity();">
                        <option value="0">All</option>
                        <option value="1">Logged Calls</option>
                        <option value="2">Meetings</option>
                        <option value="3">E-Mail</option>
                    </select>
                    <table class="table table-hover" id="tbactivities">
                        <thead>
                            <tr>
                                <th>Activity</th>
                                <th>Date Updated</th>
                                <th>Remarks</th>
                                <th>Entered By</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>   
        </div>
    </div>
</div>

<div class="modal fade" id="modal-activity" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
            </div>
            <ul class="nav nav-tabs" style="text-transform:uppercase;">
                <li class="active"><a href="#tab2_1" data-toggle="tab">Meetings</a></li>
                <li class=""><a href="#tab2_2" data-toggle="tab">Logged Calls</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="tab2_1">
                    <div class="panel-body bg-white">
                        <div id="meeting_ajax"> 
                            <?php
                            if ($this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                            }
                            ?>         
                        </div>
                        <form id="add_meeting" name="add_meeting" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="meeting_type_id" value="<?php echo $opportunity->id; ?>"/>
                            <input type="hidden" name="meeting_type" value="opportunities"/>	                        			 
                            <div class="modal-body">


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-2" class="control-label" style="color:red;">* Meeting Subject</label>
                                            <input type="text" class="form-control" name="meeting_subject" id="meeting_subject" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-2" class="control-label">Company Name</label>
                                            <select name="company_id" id="company_id" class="form-control" data-search="true" onchange="getcontactdetails(this.value)">
                                                <option></option>
                                                <?php foreach ($companies as $company) { ?>
                                                    <option value="<?php echo $company->id; ?>" <?php if ($company->id == $this->uri->segment(4)) { ?> selected <?php } ?>><?php echo $company->name; ?></option>
                                                <?php } ?> 
                                            </select> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-4" class="control-label">Attendees</label>

                                            <select name="attendees[]" id="attendees" class="form-control" data-search="true" multiple>
                                                <option value=""></option>
                                                <?php
                                                $attendees = explode(",", $meeting->attendees);
                                                foreach ($contacts as $contact) {
                                                    ?>
                                                    <option value="<?php echo $contact->id; ?>" <?php if ($contact->company_id == $opportunity->customer_id) { ?> selected <?php } ?>><?php echo $contact->first_name . ' ' . $contact->last_name; ?></option>
                                                <?php } ?> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-5" class="control-label">Responsible</label>
                                            <select name="responsible" id="responsible" class="form-control" data-search="true">
                                                <?php foreach ($staffs as $staff) { ?>
                                                    <option value="<?php echo $staff->id; ?>" <?php if ($staff->id == $opportunity->salesperson_id) { ?> selected <?php } ?>><?php echo $staff->first_name . ' ' . $staff->last_name; ?></option>
                                                <?php } ?> 
                                            </select>
                                        </div>
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-4" class="control-label">Opportunity</label>
                                            <select name="opportunity_id" id="opportunity_id" class="form-control" data-search="true">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>


                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab1_1" data-toggle="tab">Meeting Details</a></li>
                                    <li class=""><a href="#tab1_2" data-toggle="tab">Options</a></li>                      			

                                </ul>
                                <div class="tab-content">

                                    <div class="tab-pane fade active in" id="tab1_1">
                                        <div class="panel-body bg-white">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label"style="color:red;">* Starting at</label>
                                                        <!--<input type="text" class="date-picker form-control" name="date" id="date" placeholder="" value="">-->
                                                        <input type="text" name="starting_date" id="starting_date" class="datetimepicker form-control" placeholder="Choose a date..." id="">

                                                    </div>
                                                </div> 
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Location</label>
                                                        <div class="append-icon">
                                                            <input type="text" name="location" value=""  class="form-control"/> 

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label"style="color:red;">* Ending at</label>
                                                        <div class="append-icon">
                                                            <input type="text" name="ending_date" id="ending_date" class="datetimepicker form-control" placeholder="Choose a date..." id="">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">

                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">All Day</label>
                                                        <div class="append-icon">
                                                            <input type="checkbox" name="all_day" id="all_day" value="1" data-checkbox="icheckbox_square-blue"/> 

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">

                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Description</label>
                                                        <div class="append-icon">

                                                            <textarea name="meeting_description" rows="5" class="form-control" placeholder="describe the product characteristics..."></textarea>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="tab1_2">
                                        <div class="panel-body bg-white">	
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Privacy</label>
                                                        <div class="append-icon">

                                                            <?php
                                                            $options = array(
                                                                '' => '',
                                                                'Everyone' => 'Everyone',
                                                                'Only me' => 'Only me',
                                                                'Only internal users' => 'Only internal users',
                                                            );
                                                            echo form_dropdown('privacy', $options, '', 'class="form-control"');
                                                            ?>	
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Show Time as</label>
                                                        <div class="append-icon">

                                                            <?php
                                                            $options = array(
                                                                '' => '',
                                                                'Available' => 'Available',
                                                                'Busy' => 'Busy',
                                                            );
                                                            echo form_dropdown('show_time_as', $options, '', 'class="form-control"');
                                                            ?>	
                                                        </div>
                                                    </div>
                                                </div>	
                                            </div>
                                        </div>
                                    </div> 


                                </div>
                            </div>
                            <div id="meeting_submitbutton" class="modal-footer text-center"><button type="submit" class="btn btn-primary btn-embossed bnt-square">Create</button></div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab2_2">
                    <div class="panel-body bg-white">
                        <div id="call_ajax"> 
                            <?php
                            if ($this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                            }
                            ?>         
                        </div>
                        <form id="add_call" name="add_call" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">

                            <input type="hidden" name="call_type_id" value="<?php echo $opportunity->id; ?>"/>
                            <input type="hidden" name="call_type" value="opportunities"/>	                        	
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-1" class="control-label">Date</label>
                                            <input type="text" class="date-picker form-control" name="date" id="date" placeholder="" value="<?php echo date('m/d/Y'); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="field-4" class="control-label">Contact</label>
                                            <select name="company_id" id="company_id" class="form-control" data-search="true">
                                                <option value=""></option>
                                                <?php foreach ($companies as $company) { ?>
                                                    <option value="<?php echo $company->id; ?>" <?php if ($company->id == $this->uri->segment(4)) { ?>selected <?php } ?>><?php echo $company->name; ?></option>
                                                <?php } ?> 
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="field-5" class="control-label">Responsible</label>
                                            <select name="resp_staff_id" id="resp_staff_id" class="form-control" data-search="true">
                                                <?php foreach ($staffs as $staff) { ?>
                                                    <option value="<?php echo $staff->id; ?>" <?php if ($staff->id == $opportunity->salesperson_id) { ?>selected <?php } ?>><?php echo $staff->first_name . ' ' . $staff->last_name; ?></option>
                                                <?php } ?> 
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="field-4" class="control-label">Opportunity</label>
                                            <select name="opportunity_id" id="opportunity_id2" class="form-control" data-search="true">
                                                <option value=""></option>
                                            </select>
                                        </div>


                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="field-2" class="control-label">Call	Summary</label>
                                         <!--   <input type="textarea" class="form-control" name="call_summary" id="call_summary" rows="5" placeholder=""> -->
                                            <textarea name="call_summary" rows="9" class="form-control" ></textarea>   
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="call_submitbutton" class="modal-footer text-center"><button type="submit" class="btn btn-primary btn-embossed bnt-square">Create</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var datatable;
    $(document).ready(function ()
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/logged_calls/get_opportunities_by_comp') ?>',
            data: {company_id: '<?php echo $this->uri->segment(4) ?>'},
            dataType: 'json',
            success: function (res) {
                $('#opportunity_id').empty();
                $('#opportunity_id').append('<option value=""></option>');
                $('#opportunity_id2').empty();
                $('#opportunity_id2').append('<option value=""></option>');
                $.each(res.data, function (i, r) {
                    $('#opportunity_id').append('<option value="' + r.id + '">' + r.opportunity + '</option>');
                    $('#opportunity_id2').append('<option value="' + r.id + '">' + r.opportunity + '</option>');
                });
            },
        });

        datatable = $('#tbactivities').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo base_url('admin/customers/get_activities') . '/'; ?>',
                type: "POST",
                data: function (d) {
                    d.company_id = '<?php echo $this->uri->segment(4) ?>',
                            d.activity_type = $('#activity_type').val()
                }

            },
            columns: [
                {
                    data: "activity"
                },
                {
                    data: "created_dt"
                },
                {
                    data: "remarks"
                },
                {
                    data: "created_by"
                }
            ]
        });


        $("form[name='add_call']").submit(function (e) {
            var formData = new FormData($(this)[0]);

            $.ajax({
                url: "<?php echo base_url('admin/opportunities/add_call'); ?>",
                type: "POST",
                data: formData,
                async: false,
                success: function (msg) {

                    var str = msg.split("_");
                    var status = str[0];


                    if (status == "yes")
                    {
                        $('body,html').animate({scrollTop: 0}, 200);
                        $("#call_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('create_succesful') . '</div>' ?>');
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url('admin/customers/view'); ?>/<?php echo $this->uri->segment(4) ?>";
                                                    }, 800); //will call the function after 1 secs.

                                                } else
                                                {
                                                    $('body,html').animate({scrollTop: 0}, 200);
                                                    $("#call_ajax").html(msg);
                                                    $("#call_submitbutton").html('<button type="submit" class="btn btn-primary btn-embossed bnt-square">Save</button>');

                                                    $("form[name='add_call']").find("input[type=text]").val("");
                                                }

                                            },
                                            cache: false,
                                            contentType: false,
                                            processData: false
                                        });

                                        e.preventDefault();
                                    });

                                    $("form[name='add_meeting']").submit(function (e) {
                                        var formData = new FormData($(this)[0]);

                                        $.ajax({
                                            url: "<?php echo base_url('admin/opportunities/add_meeting'); ?>",
                                            type: "POST",
                                            data: formData,
                                            async: false,
                                            success: function (msg) {


                                                var str = msg.split("_");
                                                var status = str[0];


                                                if (status == "yes")
                                                {
                                                    $('body,html').animate({scrollTop: 0}, 200);
                                                    $("#meeting_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('create_succesful') . '</div>' ?>');
                                                    setTimeout(function () {
                                                        window.location.href = "<?php echo base_url('admin/customers/view'); ?>/<?php echo $this->uri->segment(4) ?>";
                                                                                }, 800); //will call the function after 1 secs.

                                                                            } else
                                                                            {
                                                                                $('body,html').animate({scrollTop: 0}, 200);
                                                                                $("#meeting_ajax").html(msg);
                                                                                $("#meeting_submitbutton").html('<button type="submit" class="btn btn-primary btn-embossed bnt-square">Save</button>');

                                                                                $("form[name='add_meeting']").find("input[type=text]").val("");
                                                                            }
                                                                        },
                                                                        cache: false,
                                                                        contentType: false,
                                                                        processData: false
                                                                    });

                                                                    e.preventDefault();
                                                                });


                                                            });

                                                            function filter_activity() {
                                                                datatable.api().ajax.reload();
                                                            }


</script>
<!-- END PAGE CONTENT -->


