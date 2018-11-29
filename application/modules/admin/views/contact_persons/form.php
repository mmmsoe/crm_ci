<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

    $(document).ready(function () {
        $("form[name='add_contact_person']").submit(function (e) {
            var formData = new FormData($(this)[0]);
            var reUrl = "<?php echo base_url('admin/contact_persons/add_process'); ?>";
            var customer_id = $("#customer_id").val();
            if (customer_id != '' && customer_id != null) {
                reUrl = "<?php echo base_url('admin/contact_persons/update_process'); ?>";
            }
            $.ajax({
                url: reUrl,
                type: "POST",
                data: formData,
                async: false,
                success: function (msg) {

                    var str = msg.split("_");
                    var id = str[1];
                    var status = str[0];
                    var update = str[2];

                    if (status == "yes")
                    {
                        $('body,html').animate({scrollTop: 0}, 200);
                        if (update == "add") {
                            $("#contact_person_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('create_succesful') . '</div>' ?>');
                        } else if (update == "update") {
                            $("#contact_person_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>' ?>');
                        }
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url('admin/contact_persons/view'); ?>/" + id;
                        }, 800); //will call the function after 1 secs.
                    }
                    else
                    {
                        $('body,html').animate({scrollTop: 0}, 200);
                        $("#contact_person_ajax").html(msg);
                        $("#contact_person_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');

                        //$("form[name='add_contact_person']").find("input[type=text], textarea").val("");
                    }

                },
                cache: false,
                contentType: false,
                processData: false
            });

            e.preventDefault();
        });
    });


    function getWhois()
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/leads/whois'); ?>',
            data: {website: $('#website_whois').val()},
            dataType: "json",
            success: function (data) {
                //$('#first_name').val(data.reg_name);
                var s = data.reg_name;
                var n;
                var nx = "";
                if (s.indexOf(' ') >= 0) {
                    n = s.split(' ');
                    $('#first_name').val(n[0]);

                    for (var i = 1; i < n.length; i++)
                    {

                        nx += n[i];
                    }
                    $('#last_name').val(nx);

                } else {
                    $('#first_name').val(n);
                }
                var x = $('#website_whois').val();
                $('#email').val($('#website_whois').val());
                x = x.split("@");
                $('#website').val("http://www." + x[1]);
                $('#phone').val(data.reg_phone);
                $('#mobile').val(data.reg_phone);
                $('#fax').val(data.reg_fax);
                $('#address').val(data.reg_street);
                $('#zip_code').val(data.reg_postal);
                $('#country_id').val(data.reg_country);
                $('#country_id').select2("val", data.reg_country);
                /*$('#phone').val(data.reg_phone);
                 $('#mobile').val(data.reg_phone);
                 $('#fax').val(data.reg_fax);
                 $('#address').val(data.reg_street);
                 $('#zip_code').val(data.reg_postal);
                 $('#country_id').val(data.reg_country);
                 $('#country_id').select2("val", data.reg_country);
                 
                 $('#contact_name').val(data.reg_name);
                 //$('#email').val(data.reg_email);
                 $('#email').val($('#website_whois').val());
                 var x = $('#website_whois').val();
                 x = x.split("@");
                 
                 $('#company_name').val(data.reg_org);
                 //$('#website').val($('#website_whois').val())
                 $('#website').val("http://www." + x[1]);
                 getstatedetails2(data.reg_country, data.reg_state);
                 checkcomp();
                 */
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
    <div class="header">
        <h2><strong><?php echo $processState; ?> Contact Person</strong></h2>            
    </div>
    <div class="row">
        <div class="panel">
            <div class="panel-content">
                <div id="contact_person_ajax"> 
                    <?php
                    if ($this->session->flashdata('message')) {
                        echo $this->session->flashdata('message');
                    }
                    ?>         
                </div>
                <form id="add_contact_person" name="add_contact_person" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="append-icon">
                                    <div class="append-icon">
                                        <!--<input type="text" placeholder="http://www.example.com" id="website_whois" name="website_whois" value="<?php echo $lead->website; ?>" class="form-control">-->
                                        <input type="text" placeholder="user@domain.com" id="website_whois" name="website_whois" value="<?php echo $lead->website; ?>" class="form-control">
                                        <i class="icon-globe"></i><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="append-icon">
                                    <button type="button" class="btn btn-info" onclick='getWhois()'>Use Engine</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $contact_persons->id; ?>"/>
                    <div class="row">
                        <h3 class="pad-l clearMar-t">Contact Information</h3>
                        <hr /><div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Contact Owner</label>
                                <div class="append-icon">
                                    <select name="contact_owner" class="form-control" data-search="true">
                                        <option value=""></option>
                                        <?php foreach ($owner as $owner) { ?>
                                            <option value="<?php echo $owner->system_code; ?>" <?php if ($contact_persons->contact_owner == $owner->system_code) { ?> selected="selected"<?php } ?>><?php echo $owner->system_value_txt; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Lead Source</label>
                                <div class="append-icon">
                                    <select name="lead_source_id" class="form-control" data-search="true">
                                        <option value=""></option>
                                        <?php foreach ($leads as $leads) { ?>
                                            <option value="<?php echo $leads->system_code; ?>" <?php if ($contact_persons->lead_source_id == $leads->system_code) { ?> selected="selected"<?php } ?>><?php echo $leads->system_value_txt; ?></option>
                                        <?php } ?> 
                                    </select>    
                                </div>
                            </div>
                        </div>
                    </div>                        				 
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="control-label"style="color:red">* First Name</label>
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
                                        <input type="text" id="first_name" name="first_name" value="<?php echo $contact_persons->first_name; ?>" class="form-control full-break clearRad-l">
                                        <i class="icon-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Last Name</label>
                                <div class="append-icon">
                                    <input type="text" id="last_name" name="last_name" value="<?php echo $contact_persons->last_name; ?>" class="form-control">
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
                                    <?php ?>
                                    <input type="text" id="min" name="date_birth" class="date-picker form-control" value="<?php
                                    if ($contact_persons->date_birth != 0) {
                                        echo date('m/d/Y', $contact_persons->date_birth);
                                        ?> <?php } ?>">

                                    <i class="icon-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label"style="color:red;">* Email</label>
                                <div class="append-icon">
                                    <input type="email" id="email" name="email" value="<?php echo $contact_persons->email; ?>" class="form-control">
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
                                    <input type="text" id="phone" name="phone" value="<?php echo $contact_persons->phone; ?>" class="form-control numeric">
                                    <i class="fa fa-phone"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Mobile</label>
                                <div class="append-icon">
                                    <input type="text" id="mobile" name="mobile" value="<?php echo $contact_persons->mobile; ?>" class="form-control numeric">
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
                                    <input type="text" id="website" name="website" value="<?php echo $contact_persons->website; ?>" class="form-control">
                                    <i class="icon-globe"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Fax</label>
                                <div class="append-icon">
                                    <input type="text" id="fax" name="fax" value="<?php echo $contact_persons->fax; ?>" class="form-control numeric">
                                    <i class=" fa fa-fax"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
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
                    </div>

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
                                            <input type="file" class="custom-file" name="customer_avatar" id="customer_avatar" onchange="document.getElementById('uploader').value = this.value;">
                                            <input type="text" class="form-control" id="uploader" placeholder="no file selected" readonly="">
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
                                    <textarea id="address" name="address" rows="4" class="form-control height-row-2"><?php echo $contact_persons->address; ?></textarea> 
                                    <i class="fa fa-map-marker"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Zip Code</label>
                                <div class="append-icon">
                                    <input type="text" id="zip_code" name="zip_code" value="<?php echo $contact_persons->zip_code; ?>" class="form-control">
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
                    <div class="text-left  m-t-20">
                        <div id="contact_person_submitbutton"><button type="submit" class="btn btn-embossed btn-primary"><?php echo $processButton; ?></button></div>
                    </div>
                </form>             
            </div>
        </div>
    </div>
</div>   
<!-- END PAGE CONTENT -->

