<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

    $(document).ready(function () {
        $("form[name='add_customer']").submit(function (e) {
            var formData = new FormData($(this)[0]);

            $.ajax({
                url: "<?php echo base_url('admin/customers/add_process_from_leads'); ?>",
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
                        $("#customer_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('create_succesful') . '</div>' ?>');
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url('admin/leads/view'); ?>/" + id;
                        }, 800); //will call the function after 1 secs.
                    }
                    else
                    {
                        $('body,html').animate({scrollTop: 0}, 200);
                        $("#customer_ajax").html(msg);
                        $("#customer_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');
                        // $("form[name='add_customer']").find("input[type=text], textarea").val("");
                    }

                },
                cache: false,
                contentType: false,
                processData: false
            });

            e.preventDefault();
        });
    });

//Contact Person
    $(document).ready(function () {
        $("form[name='add_contact_person']").submit(function (e) {
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "<?php echo base_url('admin/contact_persons/add_process_ajax'); ?>",
                type: "POST",
                data: formData,
                async: false,
                success: function (msg) {

                    var str = msg.split("_");
                    var id = str[1];
                    var status = str[0];

                    $("#main_contact_person option:first").after($('<option>', {
                        value: msg.co_person_id,
                        text: msg.co_person_name,
                        selected: true
                    }));


                    if (status == "yes")
                    {
                        $('#modal-create_contact_person').animate({scrollTop: 0}, 200);
                        $("#contact_person_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('create_succesful') . '</div>' ?>');
                        /* setTimeout(function () {
                         window.location.href="<?php echo base_url('admin/customers/add'); ?>/";
                         }, 800);  *///will call the function after 1 secs.
                        $("form[name='add_contact_person']").find("input[type=text],select, textarea,input[type=email],input[type=password]").val("");
                    }
                    else
                    {
                        $('#modal-create_contact_person').animate({scrollTop: 0}, 200);
                        $("#contact_person_ajax").html(msg);
                        $("#contact_person_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');

                        // $("form[name='add_customer']").find("input[type=text], textarea").val("");
                    }

                },
                cache: false,
                contentType: false,
                processData: false
            });

            e.preventDefault();
        });
    });

</script>
<script type="text/javascript">
    function getsalesdetails(id)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/salesteams/ajax_sales_team_list') . '/'; ?>' + id,
            // data: id='cat_id',
            success: function (data) {
                $("#load_sales").html(data);
                //$("#load_city").html('');
                $('#loader').slideUp(200, function () {
                    $(this).remove();
                });
                $('select').select2();
            },
        });
    }
    function getstatedetails(id)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/leads/ajax_state_list') . '/'; ?>' + id,
            data: id = 'cat_id',
            success: function (data) {
                $("#load_state").html(data);
                //$("#load_city").html('');
                $('#loader').slideUp(200, function () {
                    $(this).remove();
                });
                $('select').select2();
            },
        });
    }

    function getcitydetails(id)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/leads/ajax_city_list') . '/'; ?>' + id,
            data: id = 'cat_id',
            success: function (data) {
                $("#load_city").html(data);
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
    <div class="row">
        <h2 class="col-md-6"><strong>Add Account</strong></h2>
        <div style="float:right; padding-top:10px;">

            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-create_contact_person" onclick="">New Contact Person</a>

        </div>              
    </div>
    <div class="row">

        <div class="panel">

            <div class="panel-content">
                <div id="customer_ajax"> 
                    <?php if ($this->session->flashdata('message')) {
                        echo $this->session->flashdata('message');
                    } ?>         
                </div>

                <form id="add_customer" name="add_customer" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                    <input type="hidden" id="contact_owner" name="contact_owner" value="<?php echo $lead->contact_owner?>">
                    <input type="hidden" name="lead_id" value="<?php echo $lead->id?>">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" style="color:red;">* Company Name</label>
                                <div class="append-icon">
                                    <input type="text" name="name" value="<?php echo $lead->company_name; ?>" class="form-control">

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">				                         
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Address</label>
                                <div class="append-icon">

                                    <textarea name="address" rows="4" class="form-control"><?php echo $lead->address; ?></textarea> 
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Website</label>
                                <div class="append-icon">
                                    <input type="text" name="website" value="<?php echo $lead->website; ?>" class="form-control">
                                    <i class="icon-globe"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Phone</label>
                                <div class="append-icon">
                                    <input type="text" name="phone" value="<?php echo $lead->phone; ?>" class="form-control numeric">
                                    <i class="icon-screen-smartphone"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Mobile</label>
                                <div class="append-icon">
                                    <input type="text" name="mobile" value="<?php echo $lead->mobile; ?>" class="form-control numeric">
                                    <i class="icon-screen-smartphone"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Fax</label>
                                <div class="append-icon">
                                    <input type="text" name="fax" value="<?php echo $lead->fax; ?>" class="form-control numeric">
                                    <i class="icon-screen-smartphone"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label"style="color:red;">* Email</label>
                                <div class="append-icon">
                                    <input type="email" name="email" value="<?php echo $lead->email; ?>" class="form-control">
                                    <i class="icon-envelope"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Main Contact Person</label>
                                <div class="append-icon">
                                  <!--<select name="main_contact_person" id="main_contact_person" class="form-control" data-search="true">
                                  <option value=""></option>
                                    <?php foreach ($contact_persons as $contact_person) { ?>
                                        <?php if ($contact_person->company_id == "0" || $contact_person->company_id == $customer->id) { ?>
                                          <option value="<?php echo $contact_person->id; ?>"><?php echo $contact_person->first_name . ' ' . $contact_person->last_name; ?></option>
    <?php } ?> 
<?php } ?> 
                                  
                                  </select>-->
                                    <input type="text" name="main_contact_person" value="<?php echo $lead->contact_name; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label"> Sales Owner</label>
                                <div class="form-group">
                                    <div class="form-group col-xs-4 clearPad-lr clearRad-r-box">
                                        <select name="sales_team_id" id="sales_team_id" class="form-control full" data-search="true" onChange="getsalesdetails(this.value)">
                                            <option value="" selected="selected">Choose Team</option>
                                            <?php foreach ($salesteams as $salesteam) { ?>
                                                <option value="<?php echo $salesteam->id; ?>" <?php if ($lead->sales_team_id == $salesteam->id) { ?> selected="selected"<?php } ?>><?php echo $salesteam->salesteam; ?></option>
<?php } ?> 
                                        </select>
                                    </div>
                                    <div class="form-group col-xs-8 clearPad-lr bord-l  clearRad-l-box" id="load_sales">
                                        <select name="salesperson_id" id="salesperson_id" class="form-control full clearRad-r" data-search="true">
                                            <option value="" selected="selected">Choose Sales</option>
                                            <?php foreach ($staffs as $staff) { ?>
                                                <option value="<?php echo $staff->id; ?>" <?php if ($lead->salesperson_id == $staff->id) { ?> selected="selected"<?php } ?>><?php echo $staff->first_name . ' ' . $staff->last_name; ?></option>
<?php } ?> 
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Upload Your Avatar</label>
                                <div class="append-icon">
                                    <div class="file">
                                        <div class="option-group">
                                            <span class="file-button btn-primary">Choose File</span>
                                            <input type="file" class="custom-file" name="company_avatar" id="company_avatar" onchange="document.getElementById('uploader').value = this.value;">
                                            <input type="text" class="form-control" id="uploader" placeholder="no file selected" readonly="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Upload Attachment (.Pdf)</label>
                                <div class="append-icon">
                                    <div class="file">
                                        <div class="option-group">
                                            <span class="file-button btn-primary">Choose File</span>
                                            <input type="file" class="custom-file" name="company_attachment" id="company_attachment" onchange="document.getElementById('uploader_attach').value = this.value;">
                                            <input type="text" class="form-control" id="uploader_attach" placeholder="no file selected" readonly="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-left  m-t-20">
                        <div id="customer_submitbutton"><button type="submit" class="btn btn-embossed btn-primary">Create</button></div>

                    </div>
                </form>             

            </div>
        </div>

    </div>

</div>   
<!-- END PAGE CONTENT -->

<!-- START MODAL CONTENT -->
<div class="modal fade" id="modal-create_contact_person" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                <h4 class="modal-title"><strong>Add</strong> Contact Person</h4>
            </div>
            <div id="contact_person_ajax"> 
<?php if ($this->session->flashdata('message')) {
    echo $this->session->flashdata('message');
} ?>         
            </div>

            <form id="add_contact_person" name="add_contact_person" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                <input type="hidden" name="company" value="<?php echo $customer->id; ?>"/>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-6">
                            <label class="control-label"style="color:red;">* First Name</label>
                            <div class="form-group">
                                <div class="form-group col-xs-4 clearPad-lr clearRad-r-box">
                                    <select name="title_id" id="title_id" class="form-control full" data-search="true">
                                        <option value="" selected="selected">None</option>
<?php foreach ($titles as $title) { ?>
                                            <option value="<?php echo $title->system_code; ?>" <?php if ($contact_persons->title_id == $title->system_code) { ?> selected="selected"<?php } ?>><?php echo $title->system_value_txt; ?></option>
<?php } ?> 
                                    </select>
                                </div>
                                <div class="form-group col-xs-8 clearPad-lr bord-l">		
                                    <div class="append-icon">
                                        <input type="text" name="first_name" value="<?php echo $contact_persons->first_name; ?>" class="form-control full-break clearRad-l" >
                                        <i class="icon-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label"style="color:red;">* Last Name</label>
                                <div class="append-icon">
                                    <input type="text" name="last_name" value="<?php echo $contact_persons->last_name; ?>" class="form-control" >
                                    <i class="icon-user"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Date Of Birth</label>
                                <div class="append-icon">
                                    <input type="text" id="min" name="date_birth" value="" class="date-picker form-control">
                                    <i class="icon-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label"style="color:red;">* Email</label>
                                <div class="append-icon">
                                    <input type="email" name="email" value="<?php echo $contact_persons->email; ?>" class="form-control" >
                                    <i class="icon-envelope"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Phone</label>
                                <div class="append-icon">
                                    <input type="text" name="phone" value="<?php echo $contact_persons->phone; ?>" class="form-control numeric">
                                    <i class="fa fa-phone"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Mobile</label>
                                <div class="append-icon">
                                    <input type="text" name="mobile" value="<?php echo $contact_persons->mobile; ?>" class="form-control numeric">
                                    <i class="icon-screen-smartphone"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Website</label>
                                <div class="append-icon">
                                    <input type="text" name="website" value="<?php echo $contact_persons->website; ?>" class="form-control">
                                    <i class="icon-globe"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Fax</label>
                                <div class="append-icon">
                                    <input type="text" name="fax" value="<?php echo $contact_persons->fax; ?>" class="form-control numeric">
                                    <i class=" fa fa-fax"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="row">
                            <h3 class="pad-l">Company Information</h3>
                            <hr /><div class="clearfix"></div>
                            <div class="col-sm-6">
                                    <div class="form-group">
                                            <label class="control-label">Company</label>
                                            <div class="append-icon">
                                                    <select name="company_id" id="company_id" class="form-control reHeight" data-search="true">
                                                            <option value="" selected="selected">Choose one</option>
<?php foreach ($companies as $companies) { ?>
                                                                        <option value="<?php echo $companies->id; ?>" <?php if ($contact_persons->company_id == $companies->id) { ?> selected="selected"<?php } ?>><?php echo $companies->name; ?></option>
<?php } ?> 
                                                    </select>
                                            </div>
                                    </div>
                            </div>
                            <div class="col-sm-6">
                                    <div class="form-group">
                                            <label class="control-label">Department</label>
                                            <div class="append-icon">
                                                    <input type="text" name="department" value="<?php echo $contact_persons->department; ?>" class="form-control">
                                                    <i class="fa fa-building-o"></i>
                                            </div>
                                    </div>
                            </div>
                    </div>
                                            <div class="row">
                            <div class="col-sm-6">
                                    <div class="form-group">
                                            <label class="control-label">Job Position</label>
                                            <div class="append-icon">
                                                    <input type="text" name="job_position" value="<?php echo $contact_persons->job_position; ?>" class="form-control">
                                                    <i class="fa fa-briefcase"></i>
                                            </div>
                                    </div>
                            </div>
                            <div class="col-sm-6">
                                    <div class="form-group">
                                            <label class="control-label">Reports To</label>
                                            <div class="append-icon">
                                                    <input type="text" name="reports_to" value="<?php echo $contact_persons->reports_to; ?>" class="form-control">
                                                    <i class="fa fa-files-o"></i>
                                            </div>
                                    </div>
                            </div>
                    </div>
                    
                    <div class="row">
                            <div class="col-sm-6">
                                    <div class="form-group">
                                            <label class="control-label">Assistant</label>
                                            <div class="append-icon">
                                                    <input type="text" name="assistant" value="<?php echo $contact_persons->assistant; ?>" class="form-control">
                                                    <i class="fa fa-user-plus"></i>
                                            </div>
                                    </div>
                            </div>
                            <div class="col-sm-6">
                                    <div class="form-group">
                                            <label class="control-label">Asst Phone</label>
                                            <div class="append-icon">
                                                    <input type="text" name="asst_phone" value="<?php echo $contact_persons->asst_phone; ?>" class="form-control numeric">
                                                    <i class="fa fa-phone"></i>
                                            </div>
                                    </div>
                            </div>
                    </div> -->
                    <div class="row">
                        <h3 class="pad-l">Other Information</h3>
                        <hr /><div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Twitter</label>
                                <div class="append-icon">
                                    <div class="input-group">
                                        <div class="input-group-addon">@</div>
                                        <input type="text" name="twitter" value="<?php echo $contact_persons->twitter; ?>" class="form-control">
                                        <div class="input-group-addon"><i class="fa fa-twitter"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Skype ID</label>
                                <div class="append-icon">
                                    <input type="text" name="skype_id" value="<?php echo $contact_persons->skype_id; ?>" class="form-control">
                                    <i class="fa fa-skype"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Secondary Email</label>
                                <div class="append-icon">
                                    <input type="email" name="secondary_email" value="<?php echo $contact_persons->secondary_email; ?>" class="form-control">
                                    <i class="icon-envelope"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-group col-xs-6 clearPad-lr">
                                    <label class="control-label">Main Contact Person</label>
                                    <div class="append-icon">
                                        <input type="checkbox" name="main_contact_person" value="1" data-checkbox="icheckbox_square-blue" <?= ($contact_persons->main_contact_person == 1 ? 'checked = "checked"' : '' ) ?> /> 
                                    </div>
                                </div>
                                <div class="form-group col-xs-6 clearPad-lr clearRad-r-box">
                                    <label class="control-label">Email Opt Out</label>
                                    <div class="append-icon">
                                        <input type="checkbox" name="email_opt_out" value="1" data-checkbox="icheckbox_square-blue"  <?= ($contact_persons->email_opt_out == 1 ? 'checked = "checked"' : '' ) ?>/> 
                                    </div>
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
                                            <input type="file" class="custom-file" name="customer_avatar" id="customer_avatar" onchange="document.getElementById('upload').value = this.value;">
                                            <input type="text" class="form-control" id="upload" placeholder="no file selected" readonly="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">

                        </div>	
                    </div>
                    <div class="row">
                        <h3 class="pad-l">Address Information</h3>
                        <hr /><div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Address</label>
                                <div class="append-icon">
                                    <textarea name="address" rows="4" class="form-control height-row-2"><?php echo $contact_persons->address; ?></textarea> 
                                    <i class="fa fa-map-marker"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Zip Code</label>
                                <div class="append-icon">
                                    <input type="text" name="zip_code" value="<?php echo $contact_persons->zip_code; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Select Country</label>
                                <div class="col-sm-12 clearPad-lr">
                                    <select name="country_id" id="country_id" class="form-control reHeight" data-search="true" onChange="getstatedetails(this.value)">
                                        <option value="" selected="selected">Choose one</option>
<?php foreach ($countries as $country) { ?>
                                            <option value="<?php echo $country->id; ?>" <?php if ($contact_persons->country_id == $country->id) { ?> selected="selected"<?php } ?>><?php echo $country->name; ?></option>
<?php } ?> 
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">State & City</label>
                                <div class="form-group">
                                    <div class="form-group col-xs-6 clearPad-lr clearRad-r-box" id="load_state">
                                        <!--input type="text" value="" class="form-control" readOnly="readOnly"-->
                                        <select name="state_id" id="state_id" class="form-control reHeight" onChange="getcitydetails(this.value)">
                                            <option value="" selected="selected">Select State</option>
<?php $states = $this->contact_persons_model->state_list($contact_persons->country_id); ?>
<?php foreach ($states as $state) { ?>
                                                <option value="<?php echo $state->id; ?>" <?php if ($contact_persons->state_id == $state->id) { ?> selected="selected"<?php } ?>><?php echo $state->name; ?></option>
<?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-xs-6 clearPad-lr bord-l  clearRad-l-box" id="load_city">
                                        <!--input type="text" value="" class="form-control" readOnly="readOnly"-->
                                        <select name="city_id" id="city_id" class="form-control">
                                            <option value="" selected="selected">Select City</option>
<?php $cities = $this->contact_persons_model->city_list($contact_persons->state_id); ?>
<?php foreach ($cities as $city) { ?>
                                                <option value="<?php echo $city->id; ?>" <?php if ($contact_persons->city_id == $city->id) { ?> selected="selected"<?php } ?>><?php echo $city->name; ?></option>
<?php } ?>
                                        </select>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h3 class="pad-l">Description Information</h3>
                        <hr /><div class="clearfix"></div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="append-icon">
                                    <textarea name="description" rows="4" class="form-control"><?php echo $contact_persons->description; ?></textarea> 
                                    <i class="fa fa-clipboard"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="contact_person_submitbutton" class="modal-footer text-center"><button type="submit" class="btn btn-primary btn-embossed bnt-square">Create</button></div>

            </form>
        </div>
    </div>
</div>
