<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    function get_opportunities()
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/logged_calls/get_opportunities_by_comp') ?>',
            data: {company_id: '<?php echo $meeting->company_id ?>'},
            dataType: 'json',
            success: function (res) {
                $('#opportunity_id').empty();
                $('#opportunity_id').append('<option value=""></option>');
                $.each(res.data, function (i, r) {
                    if (r.id == '<?php echo $meeting->opportunity_id ?>')
                    {
                        $('#opportunity_id').append('<option value="' + r.id + '" selected="selected">' + r.opportunity + '</option>');
                    }
                    else
                    {
                        $('#opportunity_id').append('<option value="' + r.id + '">' + r.opportunity + '</option>');
                    }
                });
            },
        });
    }
    $(document).ready(function () {
    get_opportunities();
        $("form[name='edit_meeting']").submit(function (e) {
            var formData = new FormData($(this)[0]);

            $.ajax({
                url: "<?php echo base_url('admin/meetings/edit_meeting_process'); ?>",
                type: "POST",
                data: formData,
                async: false,
                success: function (msg) {

                    var str = msg.split("_");
                    var status = str[0];

                    if (status == "yes")
                    {
                        $('body,html').animate({scrollTop: 0}, 200);
                        $("#meeting_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>' ?>');
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url('admin/meetings'); ?>";
                            
                            <?php if ($this->uri->segment(5) != ""): ?>
                        window.location = '<?php echo base_url('admin/customers/view/' . $this->uri->segment(5)); ?>';
<?php else: ?>
                        window.location.href = "<?php echo base_url('admin/meetings'); ?>";
<?php endif; ?>
                        }, 800); //will call the function after 1 secs.

                    }
                    else
                    {
                        $('body,html').animate({scrollTop: 0}, 200);
                        $("#meeting_ajax").html(msg);
                        $("#meeting_submitbutton").html('<button type="submit" class="btn btn-primary btn-embossed bnt-square">Save</button>');
                        // window.location='<?php echo base_url('admin/meetings'); ?>';
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

            e.preventDefault();
        });
    });
    function getcontactdetails(id)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/meetings/ajax_contact_list') . '/'; ?>' + id,
            // data: id='cat_id',
            success: function (data) {
                $("#attendees").html(data);
                //$("#load_city").html('');
                $('#loader').slideUp(200, function () {
                    $(this).remove();
                });
                $('select').select2();
            },
        });
    }
</script>

<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="header">
        <h2><strong>Update Meeting</strong></h2>  


        <div class="breadcrumb-wrapper">


        </div>          
    </div>

    <div class="row">

        <div class="panel">

            <div class="panel-content">
                <div id="meeting_ajax"> 
                    <?php if ($this->session->flashdata('message')) {
                        echo $this->session->flashdata('message');
                    } ?>         
                </div>

                <form id="edit_meeting" name="edit_meeting" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">

                    <input  type="hidden" name="meeting_id" value="<?php echo $meeting->id; ?>"/>
                    <input type="hidden" name="meeting_type_id" value="<?php echo $meeting->meeting_type_id; ?>"/>
                    <input type="hidden" name="meeting_type" value="opportunities"/>	                        			

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="field-2" class="control-label" style="color:red;">* Meeting Subject</label>
                                    <input type="text" class="form-control" name="meeting_subject" id="meeting_subject" value="<?php echo $meeting->meeting_subject; ?>" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="field-2" class="control-label">Company Name</label>
                                    <select name="company_id" id="company_id" class="form-control" data-search="true" onchange="getcontactdetails(this.value)">
                                        <option value=""></option>
                                        <?php foreach ($companies as $company) { ?>
                                            <option value="<?php echo $company->id; ?>"  <?php if ($meeting->company_id == $company->id) { ?> selected <?php } ?>><?php echo $company->name; ?></option>
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
                                        $contacts = $this->customers_model->get_contact_list($meeting->company_id);
                                        $attendees = explode(",", $meeting->attendees);
                                        foreach ($contacts as $contact) {
                                            ?>
                                            <option value="<?php echo $contact->id; ?>" <?php if (in_array($contact->id, $attendees)) { ?>selected<?php } ?>><?php echo $contact->first_name . ' ' . $contact->last_name; ?></option>
<?php } ?> 

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="field-5" class="control-label">Responsible</label>
                                    <select name="responsible" id="responsible" class="form-control" data-search="true">
<?php foreach ($staffs as $staff) { ?>
                                            <option value="<?php echo $staff->id; ?>" <?php if ($meeting->responsible == $staff->id) { ?>selected<?php } ?>><?php echo $staff->first_name . ' ' . $staff->last_name; ?></option>
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
                            <div class="col-md-6">

                            </div>

                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1_1edit" data-toggle="tab">Meeting Details</a></li>
                            <li class=""><a href="#tab1_2edit" data-toggle="tab">Options</a></li>                      			

                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane fade active in" id="tab1_1edit">
                                <div class="panel-body bg-white">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="field-1" class="control-label"style="color:red;">* Starting at</label>
                                                <!--<input type="text" class="date-picker form-control" name="date" id="date" placeholder="" value="">-->
                                                <input type="text" name="starting_date" id="starting_date" class="datetimepicker form-control" placeholder="Choose a date..."  value="<?php echo date('m/d/Y H:i', $meeting->starting_date); ?>">

                                            </div>
                                        </div> 
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Location</label>
                                                <div class="append-icon">
                                                    <input type="text" name="location" value="<?php echo $meeting->location; ?>"  class="form-control"/> 

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label"style="color:red;">* Ending at</label>
                                                <div class="append-icon">
                                                    <input type="text" name="ending_date" id="ending_date" class="datetimepicker form-control" placeholder="Choose a date..." value="<?php echo date('m/d/Y H:i', $meeting->ending_date); ?>">

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
                                                    <input type="checkbox" name="all_day" id="all_day" value="1" <?php if ($meeting->all_day == 1) { ?>checked<?php } ?> data-checkbox="icheckbox_square-blue"/> 

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

                                                    <textarea name="meeting_description" rows="5" class="form-control" placeholder="describe the product characteristics..."><?php echo $meeting->meeting_description; ?></textarea>   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab1_2edit">
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
                                                    echo form_dropdown('privacy', $options, $meeting->privacy, 'class="form-control"');
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
                                                    echo form_dropdown('show_time_as', $options, $meeting->show_time_as, 'class="form-control"');
                                                    ?>	
                                                </div>
                                            </div>
                                        </div>	
                                    </div>
                                </div>
                            </div> 


                        </div>
                    </div>

                    <div id="meeting_submitbutton" class="modal-footer text-center"><button type="submit" class="btn btn-primary btn-embossed bnt-square">Update</button></div>

                </form>
            </div>
        </div>

    </div>			

</div>              