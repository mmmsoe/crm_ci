<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>
    /**Add Call**/

    $(document).ready(function () {
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
                            window.location.href = "<?php echo base_url('admin/opportunities/view'); ?>/<?php echo $this->uri->segment(4) ?>";
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
                                });

                                function delete_calls(call_id)
                                {
                                    var confir = confirm('Are you sure you want to delete this?');

                                    if (confir == true)
                                    {
                                        $.ajax({
                                            type: "GET",
                                            url: "<?php echo base_url('admin/opportunities/call_delete'); ?>/" + call_id,
                                            success: function (msg)
                                            {
                                                if (msg == 'deleted')
                                                {
                                                    $('#call_id_' + call_id).fadeOut('normal');
                                                }
                                            }

                                        });
                                    }
                                }

                                //Date class changes
                                /*$(function(){
                                 
                                 $('#all_day').on('ifChecked',function(event) {
                                 
                                 if($(this).is(':checked')) 
                                 { 
                                 $('#starting_date').addClass('date-picker');
                                 $('#starting_date').removeClass('datetimepicker');
                                 
                                 }
                                 });
                                 });*/

                                /**Add Meting**/

                                $(document).ready(function () {
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

//
                                                if (status == "yes")
                                                {
                                                    $('body,html').animate({scrollTop: 0}, 200);
                                                    $("#meeting_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('create_succesful') . '</div>' ?>');
                                                    setTimeout(function () {
                                                        window.location.href = "<?php echo base_url('admin/opportunities/view'); ?>/<?php echo $this->uri->segment(4) ?>";
                                                    }, 800); //will call the function after 1 secs.

                                                } else {
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

                                function delete_meeting(meeting_id){
                                    var confir = confirm('Are you sure you want to delete this?');

                                    if (confir == true)
                                        {
                                            $.ajax({
                                                type: "GET",
                                                url: "<?php echo base_url('admin/opportunities/meeting_delete'); ?>/" + meeting_id,
                                                success: function (msg)
                                                {
                                                    if (msg == 'deleted')
                                                    {
                                                        $('#meeting_id_' + meeting_id).fadeOut('normal');
                                                    }
                                                }
                                            });
                                        }
                                    }

                                                            //Modal Open and Close
                                    function model_hide_show(name)
                                    {
                                        if (name == "calls")
                                        {
                                            $("#modal-all_calls").removeClass("fade").modal("hide");
                                            $("#modal-create_calls").modal("show").addClass("fade");
                                        }
                                        if (name == "meetings")
                                        {
                                            $("#modal-all_meetings").removeClass("fade").modal("hide");
                                            $("#modal-create_meetings").modal("show").addClass("fade");
                                        }
                                        if (name == "activity")
                                        {
                                            // $("#modal-all_meetings").removeClass("fade").modal("hide");
                                            $("#modal-activity").modal("show").addClass("fade");
                                        }
                                    }

                                    function getcontactdetails(id)
                                    {
                                        $.ajax({
                                            type: "POST",
                                            url: '<?php echo base_url('admin/meetings/ajax_contact_list') . '/'; ?>' + id,
                                            // data: id='cat_id',
                                            success: function (data) {
                                                //  $("#attendees").html(data);
                                                //$("#load_city").html('');
                                                $('#loader').slideUp(200, function () {
                                                   $(this).remove();
                                                });
                                                $('select').select2();
                                            },
                                        });
                                    }

                                    function contactName(id)
                                    {
                                        $.ajax({
                                            type: "POST",
                                            url: '<?php echo base_url('admin/opportunities/ajax_get_contact') . '/'; ?>' + id,
                                            success: function (data) {
                                                $("#contact_id").html(data);
                                                $('#loader').slideUp(200, function () {
                                                    $(this).remove();
                                                });
                                            },
                                        });
                                    }
                                                            //$(function () {
                                                            //    var temp = "";
                                                            //$("#customer_id").val(temp);
                                                            //});
                                                            //alert($("#s2id_customer_id").select2("val"));

                                                            $(document).ready(function () {
                                                                getcontactdetails(<?php echo $opportunity->customer_id; ?>);
                                                            });
</script>
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="row">
        <div style="float:right; padding-top:10px;">
            <?php if (check_staff_permission('opportunities_write')) { ?>
                <?php if ($opportunity->closed_status == 0) { ?>
                    <a href="<?php echo base_url('admin/opportunities/convert_to_quotation/' . $opportunity->id); ?>" class="btn btn-success btn-embossed" target="">Convert to Quotation</a> 
                <?php } ?>
                <?php if (check_staff_permission('activity_entry_read') == true){?><a href="#" data-toggle="modal" data-target="#modal-activity" class="btn btn-primary btn-embossed">Create Activity</a><?php } ?>
                <a href="<?php echo base_url('admin/opportunities/update/' . $opportunity->id . '/' . $opportunity->lead_id); ?>" class="btn btn-primary btn-embossed"> Edit Opportunity</a>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="panel">
            <h3 class="pad-l">Opportunities Detail Information</h3>
            <hr /><div class="clearfix"></div>
            <div class="panel-content">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-sm-5 control-label"><i class="fa fa-file-text-o"></i>Opportunity</label>
                            <div class="col-sm-7 append-icon">
                                <p class="pad-l">&nbsp;<?php echo $opportunity->opportunity; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-sm-5 control-label"><i class="fa fa-money"></i>Amount</label>
                            <div class="col-sm-7 append-icon">
                                <p class="pad-l">&nbsp;<?php ($opportunity->amount != "" ? number_format($opportunity->amount, 2, '.', ',') : '') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-sm-5 control-label"><i class="fa fa-tag"></i>Stages</label>
                            <div class="col-sm-7 append-icon">
                                <!--MM-->
                                <!--<p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('OPPORTUNITIES_STAGES', $opportunity->stages_id)->system_value_txt; ?></p>-->
                                <p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value_stage('OPPORTUNITIES_STAGES', $opportunity->stages_id)->system_value_txt; ?></p>
                                <!--MM-->
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-sm-5 control-label"><i class="fa fa-close"></i>Expected Closing</label>
                            <div class="col-sm-7 append-icon">
                                <p class="pad-l"><?php echo $opportunity->expected_closing; ?></p>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-sm-5 control-label"><i class="fa fa-filter"></i>Type</label>
                            <div class="col-sm-7 append-icon">
                                <p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('OPPORTUNITIES_TYPE', $opportunity->type_id)->system_value_txt; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            &nbsp;
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-sm-5 control-label"><i class="fa fa-user-plus"></i>Sales</label>
                            <div class="col-sm-7 append-icon">					                                 
                                <p class="pad-l">&nbsp;<?php echo $this->staff_model->get_user($opportunity->salesperson_id)->first_name . ' ' . $this->staff_model->get_user($opportunity->salesperson_id)->last_name; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label"><i class="fa fa-users"></i>Sales Team</label>
                            <div class="col-sm-7 append-icon">					                                 
                                <p class="pad-l">&nbsp;<?php echo $this->salesteams_model->get_salesteam($opportunity->sales_team_id)->salesteam; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-sm-5 control-label"><i class="fa fa-circle-o"></i>Probability</label>
                            <div class="col-sm-7 append-icon">
                                <p class="pad-l">&nbsp;<?= ($opportunity->probability != null && $opportunity->probability != '' ? $opportunity->probability . '%' : '0%' ); ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-5 control-label"><i class="fa fa-money"></i>Expected Revenue</label>
                            <div class="col-sm-7 append-icon">
                                <p class="pad-l">&nbsp;<?= ($opportunity->expected_revenue != null && $opportunity->expected_revenue != '' ? number_format($opportunity->expected_revenue, 2, '.', ',') : '' ); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">

                    </div>
                </div>

                <div class="row">
                    <hr /><div class="clearfix"></div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label"><i class="fa fa-user"></i>Customer</label>
                                    <div class="col-sm-7 append-icon">					                                 
                                        <p class="pad-l">&nbsp;<?php echo customer_name($opportunity->customer_id)->name; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label"><i class="fa fa-phone"></i>Contact Name</label>
                                    <div class="col-sm-7 append-icon">					                                 
                                        <p class="pad-l">&nbsp;<?php echo $this->contact_persons_model->get_contact_persons($opportunity->contact_id)->first_name; ?>
                                            <?php echo ' ' . $this->contact_persons_model->get_contact_persons($opportunity->contact_id)->last_name; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label"><i class="fa fa-file-text"></i>Campaign</label>
                                    <div class="col-sm-7 append-icon">					                                 
                                        <p class="pad-l">&nbsp;<?php echo $this->opportunities_model->get_campaign($opportunity->campaign_source_id)->campaign_name; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label"><i class="fa fa-file-text"></i>Lead Source</label>
                                    <div class="col-sm-7 append-icon">					                                 
                                        <p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('LEAD', $opportunity->lead_source_id)->system_value_txt; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>

                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label"><i class="fa fa-clock-o"></i>Next Action</label>
                                    <div class="col-sm-7 append-icon">
                                        <p class="pad-l">&nbsp;<?php echo date('m/d/Y', strtotime($opportunity->next_action)); ?></p>
                                        <p class="pad-l">&nbsp;<?php echo $opportunity->next_action_title; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row"><div class="form-group">&nbsp;</div></div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label"><i class="fa fa-thumbs-o-up"></i>Priority</label>
                                    <div class="col-sm-7 append-icon">
                                        <p class="pad-l">&nbsp;<?php echo $this->system_model->system_single_value('PRIORITY', $opportunity->priority_id)->system_value_txt; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>    
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-sm-5 control-label"><i class="fa fa-pencil"></i>Created By</label>
                            <div class="col-sm-7 append-icon">
                                <p class="pad-l">&nbsp;<?php echo $opportunity->create_by; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-sm-5 control-label"><i class="fa fa-calendar-o"></i>Created Date</label>
                            <div class="col-sm-7 append-icon">
                                <p class="pad-l"><?php echo $opportunity->create_date; ?></p>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="row">
                    <hr /><div class="clearfix"></div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label"><i class="fa fa-clipboard"></i>Description</label>
                            <div class="append-icon">
                                <p class="pad-l"><?php echo $opportunity->description; ?></p>
                            </div>
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

    <!-- END PAGE CONTENT -->

    <!-- START MODAL ACTIVITY CONTENT -->
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
                                <input type="hidden" name="opportunity_id" value="<?php echo $opportunity->id; ?>"/>
                                <input type="hidden" name="meeting_type_id" value="<?php echo $opportunity->id; ?>"/>
<!--                                <input type="hidden" name="meeting_type" value="opportunities"/>-->	                        			 
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
                                                <label for="field-2" class="control-label" style="color:red;">*Meeting Type</label>
                                                <select name="meeting_type" id="meeting_type" class="form-control" data-search="true" onchange="getcontactdetails(this.value); get_opportunities(this.value)">
                                                    <option></option>
                                                    <?php foreach ($meeting_type as $type) { ?>
                                                    <!--MM-->
                                                    <!--<option value="<?php echo $type->system_code; ?>" selected="selected"><?php echo $type->system_value_txt; ?></option>-->
                                                    <option value="<?php echo $type->system_value_num; ?>" selected="selected"><?php echo $type->system_value_txt; ?></option>
                                                    <!--MM-->
                                                    <?php } ?> 
                                                </select> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-2" class="control-label">Company Name</label>
                                                <select name="company_id" id="company_id" class="form-control" data-search="true" onchange="getcontactdetails(this.value)">
                                                    <option></option>
                                                    <?php foreach ($companies as $company) { ?>
                                                        <option value="<?php echo $company->id; ?>" <?php if ($company->id == $opportunity->customer_id) { ?> selected <?php } ?>><?php echo $company->name; ?></option>
                                                    <?php } ?> 
                                                </select> 
                                            </div>
                                        </div>
										
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

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">

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
                                                        <div class="form-group">
                                                            <label class="control-label">All Day</label>
                                                            <div class="append-icon">
                                                                <input type="checkbox" name="all_day" id="all_day" value="1" data-checkbox="icheckbox_square-blue"/> 

                                                            </div>
                                                        </div>
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
									<div class="row">
										<div id="meeting_submitbutton" style="float:left;" class="modal-footer"><button type="submit" class="btn btn-primary btn-embossed bnt-square">Create</button></div>
									</div>
                                </div>
                                
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
                                <input type="hidden" name="opportunity_id" value="<?php echo $opportunity->id; ?>"/>
                                <input type="hidden" name="call_type_id" value="<?php echo $opportunity->id; ?>"/>
                                <input type="hidden" name="call_type_id" value="<?php echo $opportunity->id; ?>"/>
                                <input type="hidden" name="company_id" value="<?php echo $opportunity->customer_id; ?>"/>	                        	
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-1" class="control-label">Date</label>
                                                <input type="text" class="date-picker form-control" name="date" id="date" placeholder="" value="<?php echo date('m/d/Y'); ?>">
                                            </div>
                                            <label for="field-4" class="control-label">Contact Information</label>
                                            <div class="form-group">                                                                                  
                                                <select id="customer_id" name="customer_id" class="form-control" data-search="true" onChange="contactName(this.value)">
                                                    <option value="">Choose Customer</option>
                                                    <?php foreach ($companies as $company) { ?>
                                                        <option value="<?php echo $company->id; ?>" <?php if ($opportunity->customer_id == $company->id) { ?> selected<?php } ?>><?php echo $company->name; ?></option>
                                                    <?php } ?> 
                                                </select>                                                                                              
<!--                                                <select name="company_id" id="company_id" class="form-control" data-search="true">
                                                <option value=""></option>
                                                <?php foreach ($companies as $company) { ?>
                                                                        <option value="<?php echo $company->id; ?>" <?php if ($company->id == $opportunity->customer_id) { ?>selected <?php } ?>><?php echo $company->name; ?></option>
                                                <?php } ?> 
                                                </select>-->
                                            </div>
                                            <div class="form-group">                                                
                                                <select name="contact_id" id="contact_id" class="form-control" data-search="true">
                                                    <option value="">Choose Contact</option>
                                                    <?php foreach ($contacts as $contact) { ?>
                                                        <option value="<?php echo $contact->id; ?>" <?php if ($opportunity->contact_id == $contact->id) { ?> selected<?php } ?>><?php echo $contact->first_name; ?><?php echo ' ' . $contact->last_name; ?></option>
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
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-2" class="control-label">Call	Summary</label>
                                             <!--   <input type="textarea" class="form-control" name="call_summary" id="call_summary" rows="5" placeholder=""> -->
                                                <textarea name="call_summary" rows="12" class="form-control" ></textarea>   
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
    <!-- END MODAL ACTIVITY CONTENT -->


    <div class="modal fade" id="modal-all_calls" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                    <h4 class="modal-title"><strong>Opportunities</strong> Calls</h4>
                    <div class="m-t-20">
                        <div class="btn-group">
                            <a href="#" class="btn btn-sm btn-dark" onclick="model_hide_show('calls')"><i class="fa fa-plus"></i> Create New</a>
                        </div>
                    </div>
                    <div class="panel-content pagination2 table-responsive">
                        <table class="table table-hover table-dynamic ">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Call Summary</th>
                                    <th>Contact</th>
                                    <th>Responsible</th>                         
                                    <th><?php echo $this->lang->line('options'); ?></th>     
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($calls)) { ?>
                                    <?php foreach ($calls as $call) { ?>
                                        <tr id="call_id_<?php echo $call->id; ?>">
                                            <td><?php echo date('m/d/Y', $call->date); ?></td>
                                            <td><?php echo $call->call_summary; ?></td>
                                            <td><?php echo $this->customers_model->get_company($call->company_id)->name; ?></td>
                                            <td><?php echo $this->staff_model->get_user_fullname($call->resp_staff_id); ?></td>      	                        
                                            <td style="width: 13%;">
                                                <a href="<?php echo base_url('admin/opportunities/edit_call/' . $call->id); ?>" class="edit btn btn-sm btn-default"><i class="icon-note"></i></a>
                                                <a href="javascript:void(0)" class="delete btn btn-sm btn-danger" onclick="delete_calls(<?php echo $call->id; ?>)"><i class="icons-office-52"></i></a></td> 
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
    <!-- END MODAL CALLS CONTENT -->

	<!--
    <?php
    $options = array(
        '' => '',
        'Everyone' => 'Everyone',
        'Only me' => 'Only me',
        'Only internal users' => 'Only internal users',
    );
    echo form_dropdown('privacy', $options, '', 'class="form-control"');
    ?>
	-->
</div>
<!--
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
-->
<!--
<div id="meeting_submitbutton" class="modal-footer text-center"><button type="submit" class="btn btn-primary btn-embossed bnt-square">Create</button></div>
-->

<div class="modal fade" id="modal-all_meetings" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                <h4 class="modal-title"><strong>Opportunities</strong> Meetings</h4>
                <div class="m-t-20">
                    <div class="btn-group">
                        <a href="#" class="btn btn-sm btn-dark" onclick="model_hide_show('meetings')"><i class="fa fa-plus"></i> Create New</a>
                    </div>
                </div>
                <div class="panel-content pagination2 table-responsive">
                    <table class="table table-hover table-dynamic ">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Date</th>
                                <th>Responsible</th>    
                                <th>Location</th>
                                <th>Show Time as</th>
                                <th>Privacy</th>
                                <th>Duration</th>
                                <th><?php echo $this->lang->line('options'); ?></th>     
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($meetings)) { ?>
                                <?php foreach ($meetings as $meeting) { ?>
                                    <tr id="meeting_id_<?php echo $meeting->id; ?>">
                                        <td><?php echo $meeting->meeting_subject; ?></td>
                                        <td><?php
                                            if ($meeting->all_day == '1') {
                                                echo date('m/d/Y', $meeting->starting_date);
                                            }
                                            ?></td>
                                        <td><?php
                                            if ($meeting->all_day == '0') {
                                                echo date('m/d/Y g:i a', $meeting->starting_date);
                                            }
                                            ?></td>
                                        <td><?php echo $this->staff_model->get_user($meeting->responsible)->first_name . ' ' . $this->staff_model->get_user($meeting->responsible)->last_name; ?></td>
                                        <td><?php echo $meeting->location; ?></td>
                                        <td><?php echo $meeting->privacy; ?></td>
                                        <td><?php echo $meeting->show_time_as; ?></td>
                                        <td><?php echo $meeting->duration; ?></td>               
                                        <td style="width: 13%;">
                                            <a href="<?php echo base_url('admin/opportunities/edit_meeting/' . $meeting->id); ?>" class="edit btn btn-sm btn-default" onclick="edit_meeting(<?php echo $meeting->id; ?>)" ><i class="icon-note"></i></a>
                                            <a href="javascript:void(0)" class="delete btn btn-sm btn-danger" onclick="delete_meeting(<?php echo $meeting->id; ?>)"><i class="icons-office-52"></i></a>
                                        </td> 
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
<!-- END MODAL MEETINGS CONTENT -->

<!--div class="modal fade" id="modal-convert_to_customer" aria-hidden="true">
        <div class="modal-dialog">
                <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                          <h4 class="modal-title"><strong>Convert</strong> to customer</h4>
                        </div>
                        <form action="<?php echo base_url('admin/opportunities/convert_to_customer'); ?>" id="convert_to_customer_form" name="convert_to_customer_form" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                                <input type="hidden" name="convert_opport_id" value="<?php echo $opportunity->id; ?>"/>
                                <div class="modal-body">
                                        <div class="row text-center">                    
                                                <div class="col-md-12">
                                                        <div class="form-group">
                                                                <label for="field-5" class="control-label">Customer Name</label>
                                                                <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="" required="">
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <div id="convert_to_oppo_submitbutton" class="modal-footer"><button type="submit" class="btn btn-primary btn-embossed bnt-square">Convert to Customer</button></div>
                        </form>
                </div>
        </div>
</div-->


<script>
    var datatable;
    $(document).ready(function ()
    {
        $("#s2id_customer_id").select2("val", "230");
        datatable = $('#tbactivities').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo base_url('admin/opportunities/get_activities') . '/'; ?>',
                type: "POST",
                data: function (d) {
                    d.opportunity_id = '<?php echo $this->uri->segment(4) ?>',
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


    });

    function filter_activity() {
        datatable.api().ajax.reload();
    }
</script>