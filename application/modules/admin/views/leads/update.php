<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/leads/get_company_auto') . '/'; ?>',
            dataType: "json",
            success: function (data) {
                $('#company_name').tokenfield({
                    autocomplete: {
                        source: data,
                        delay: 100,
                    },
                    limit: 1,
                    showAutocompleteOnFocus: false,
                    createTokensOnBlur: true
                });
            },
        });
        $('#company_name').val();
        $("form[name='update_leads']").submit(function (e) {
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "<?php echo base_url('admin/leads/update_process'); ?>",
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
                        $("#customer_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>' ?>');
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url('admin/customers/view'); ?>/" + id;
                        }, 800); //will call the function after 1 secs.
                    }
                    else
                    {
                        $('body,html').animate({scrollTop: 0}, 200);
                        $("#leads_ajax").html(msg);
                        $("#leads_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');

                        $('#password,#company_avatar,#uploader').val('');
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
            e.preventDefault();
        });
    });

    /**Add Call**/
    $(document).ready(function () {
        $("form[name='add_call']").submit(function (e) {
            var formData = new FormData($(this)[0]);
            $.ajax({
                url: "<?php echo base_url('admin/leads/add_call'); ?>",
                type: "POST",
                data: formData,
                async: false,
                success: function (msg) {
                    $('body,html').animate({scrollTop: 0}, 200);
                    $("#call_ajax").html(msg);

                    if (msg == 'yes')
                    {
                        $("#modal-create_calls").removeClass("fade").modal("hide");
                        location.reload();
                    }

                    $("#call_submitbutton").html('<button type="submit" class="btn btn-primary btn-embossed bnt-square">Save</button>');

                    $("form[name='add_call']").find("input[type=text]").val("");
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
                url: "<?php echo base_url('admin/leads/call_delete'); ?>/" + call_id,
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
</script>
<script type="text/javascript">

    function getstatedetails(id)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/leads/ajax_state_list') . '/'; ?>' + id,
            data: id = 'state_id',
            success: function (data) {
                $("#load_state").html(data);
                $("#load_city").html('');
                $('#loader').slideUp(200, function () {
                    $(this).remove();
                });
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
            },
        });
    }

    //Modal Open and Close
    function model_hide_show(name)
    {
        if (name == "calls")
        {
            $("#modal-all_calls").removeClass("fade").modal("hide");
            $("#modal-create_calls").modal("show").addClass("fade");
        }
    }

</script>
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="header">
        <h2><strong>Update Leads</strong></h2>
        <div class="breadcrumb-wrapper">
            <!-- <div class="m-b-10 f-left">
                    <div class="btn-group">
                            <button type="button" class="btn btn-primary">Calls</button>
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <span class="dropdown-arrow "></span>
                            <ul class="dropdown-menu" role="menu">
                                    <li><a href="#" data-toggle="modal" data-target="#modal-all_calls">All Calls</a></li>
                                    <li><a href="#" data-toggle="modal" data-target="#modal-create_calls">Create</a></li>
                            </ul>
                    </div>
            </div>--> 	
        </div>
    </div>
    <div class="row">
        <div class="panel">
            <div class="panel-content">
                <div id="leads_ajax"> 
                    <?php if ($this->session->flashdata('message')) {
                        echo $this->session->flashdata('message');
                    } ?>         
                </div>
                <form id="update_leads" name="update_leads" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                    <input type="hidden" name="lead_id" value="<?php echo $lead->id; ?>"/>	                        				 
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Opportunity</label>
                                <div class="append-icon">
                                    <input type="text" name="opportunity" value="<?php echo $lead->opportunity; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row m-t-10">
                                <div class="widget-infobox">
                                    <a href="#" data-toggle="modal" data-target="#modal-all_calls">
                                        <div class="infobox">
                                            <div class="left">
                                                <i class="fa fa-phone bg-red"></i>
                                            </div>
                                            <div class="right">
                                                <div class="clearfix">
                                                    <div>
                                                        <span class="c-red pull-left"><?php echo count($calls); ?></span>
                                                        <br>
                                                    </div>
                                                    <div class="txt">CALLS</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Company Name</label>
                                <div class="append-icon">
                                    <input type="text" name="company_name" value="<?php echo $lead->company_name; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">

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
                                <label class="control-label"></label>
                                <div class="append-icon">
                                    <div class="col-sm-12">
                                        <select name="country_id" id="country_id" class="form-control" data-search="true" onChange="getstatedetails(this.value)">
                                            <option value="" selected="selected">Select Country</option>
                                            <?php foreach ($countries as $country) { ?>
                                                <option value="<?php echo $country->id; ?>" <?php if ($lead->country_id == $country->id) { ?> selected="selected"<?php } ?>><?php echo $country->name; ?></option>
<?php } ?> 
                                        </select>
                                    </div>
                                </div>
                                <br/><br/>
                                <div class="col-sm-6" id="load_state">
                                    <select name="state_id" id="state_id" class="form-control" onChange="getcitydetails(this.value)">
                                        <option value="" selected="selected">Select State</option>
                                        <?php $states = $this->leads_model->state_list($lead->country_id); ?>
                                        <?php foreach ($states as $state) { ?>
                                            <option value="<?php echo $state->id; ?>" <?php if ($lead->state_id == $state->id) { ?> selected="selected"<?php } ?>><?php echo $state->name; ?></option>
<?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-6" id="load_city">
                                    <select name="city_id" id="city_id" class="form-control">
                                        <option value="" selected="selected">Select City</option>
                                        <?php $cities = $this->leads_model->city_list($lead->state_id); ?>
                                        <?php foreach ($cities as $city) { ?>
                                            <option value="<?php echo $city->id; ?>" <?php if ($lead->city_id == $city->id) { ?> selected="selected"<?php } ?>><?php echo $city->name; ?></option>
<?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Salesperson</label>
                                <div class="append-icon">
                                    <select name="salesperson_id" id="salesperson_id" class="form-control" data-search="true">
                                        <option value="" selected="selected"></option>
                                        <?php foreach ($staffs as $staff) { ?>
                                            <option value="<?php echo $staff->id; ?>" <?php if ($lead->salesperson_id == $staff->id) { ?> selected="selected"<?php } ?>><?php echo $staff->first_name . ' ' . $staff->last_name; ?></option>
<?php } ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Sales Team</label>
                                <div class="append-icon">
                                    <select name="sales_team_id" id="sales_team_id" class="form-control" data-search="true">
                                        <option value="" selected="selected"></option>
                                        <?php foreach ($salesteams as $salesteam) { ?>
                                            <option value="<?php echo $salesteam->id; ?>" <?php if ($lead->sales_team_id == $salesteam->id) { ?> selected="selected"<?php } ?>><?php echo $salesteam->salesteam; ?></option>
<?php } ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Contact Name</label>
                                <div class="append-icon">
                                    <input type="text" name="contact_name" value="<?php echo $lead->contact_name; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Title</label>
                                <div class="append-icon">
                                    <?php
                                    if (config('titles')) {
                                        $titles = config('titles');
                                    } else {
                                        $titles = "Doctor,Madam,Miss,Mister,Professor,Sir";
                                    }

                                    $all_title = explode(',', $titles);
                                    $options = array();

                                    foreach ($all_title as $title) {
                                        $options[$title] = $title;
                                    }
                                    echo form_dropdown('title', $options, $lead->title, 'class="form-control"');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Email</label>
                                <div class="append-icon">
                                    <input type="text" name="email" value="<?php echo $lead->email; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Function</label>
                                <div class="append-icon">
<?php
if (config('functions')) {
    $functions = config('functions');
} else {
    $functions = "Sales manager,Manager";
}

$all_functions = explode(',', $functions);

$options = array();
foreach ($all_functions as $function) {
    $options[$function] = $function;
}

echo form_dropdown('function', $options, $lead->function, 'class="form-control"');
?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Phone</label>
                                <div class="append-icon">
                                    <input type="text" name="phone" value="<?php echo $lead->phone; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Mobile</label>
                                <div class="append-icon">
                                    <input type="text" name="mobile" value="<?php echo $lead->mobile; ?>" class="form-control">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Fax</label>
                                <div class="append-icon">
                                    <input type="text" name="fax" value="<?php echo $lead->fax; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Tags</label>
                                <div class="append-icon">
<?php
if (config('tags')) {
    $tags = config('tags');
} else {

    $tags = "Product,Software,Design,Training,Other";
}

$all_tags = explode(',', $tags);

$options = array();
foreach ($all_tags as $tag) {
    $options[$tag] = $tag;
}

echo form_dropdown('tags[]', $options, explode(',', $lead->tags), 'class="form-control" multiple');
?>
                                </div>
                            </div>
                        </div>    	  
                    </div>    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Priority</label>
                                <div class="append-icon">
<?php
if (config('priorities')) {
    $priorities = config('priorities');
} else {
    $priorities = "Low,High,Very High";
}

$all_priorities = explode(',', $priorities);

$options = array();
foreach ($all_priorities as $priority) {
    $options[$priority] = $priority;
}

echo form_dropdown('priority', $options, $lead->priority, 'class="form-control"');
?>  
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Internal Notes</label>
                                <div class="append-icon">
                                    <textarea name="internal_notes" rows="4" class="form-control"><?php echo $lead->internal_notes; ?></textarea> 
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="row">                          					 
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Assigned Partner</label>
                                <div class="append-icon">
                                    <select name="assigned_partner_id" class="form-control" data-search="true">
                                        <option value=""></option>
<?php foreach ($companies as $company) { ?>
                                            <option value="<?php echo $company->id; ?>" <?php if ($lead->assigned_partner_id == $company->id) { ?> selected="selected"<?php } ?>><?php echo $company->name; ?></option>
<?php } ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>    
                    <div class="text-left  m-t-20">
                        <div id="leads_submitbutton"><button type="submit" class="btn btn-embossed btn-primary">Update</button></div>
                    </div>
                </form>               
            </div>
        </div>
    </div>
</div>   
<!-- END PAGE CONTENT -->

<!-- START MODAL CONTENT -->
<div class="modal fade" id="modal-create_calls" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                <h4 class="modal-title"><strong>Leads</strong> Calls</h4>
            </div>
            <div id="call_ajax"> 
<?php if ($this->session->flashdata('message')) {
    echo $this->session->flashdata('message');
} ?>         
            </div>
            <form id="add_call" name="add_call" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                <input type="hidden" name="call_type_id" value="<?php echo $lead->id; ?>"/>
                <input type="hidden" name="call_type" value="leads"/>	                        	
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-1" class="control-label">Date</label>
                                <input type="text" class="date-picker form-control" name="date" id="date" placeholder="" value="<?php echo date('m/d/Y'); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-2" class="control-label">Call	Summary</label>
                                <input type="text" class="form-control" name="call_summary" id="call_summary" placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-4" class="control-label">Contact</label>
                                <select name="company_id" id="company_id" class="form-control" data-search="true">
                                    <option value=""></option>
<?php foreach ($companies as $company) { ?>
                                        <option value="<?php echo $company->id; ?>"><?php echo $company->name; ?></option>
<?php } ?> 
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="field-5" class="control-label">Responsible</label>
                                <select name="resp_staff_id" id="resp_staff_id" class="form-control" data-search="true">
                                    <?php foreach ($staffs as $staff) { ?>
                                        <option value="<?php echo $staff->id; ?>"><?php echo $staff->first_name . ' ' . $staff->last_name; ?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="call_submitbutton" class="modal-footer text-center"><button type="submit" class="btn btn-primary btn-embossed bnt-square">Create</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-all_calls" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                <h4 class="modal-title"><strong>Leads</strong> Calls</h4>
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
                                            <a href="<?php echo base_url('admin/leads/edit_call/' . $call->id); ?>" class="edit btn btn-sm btn-default"><i class="icon-note"></i></a>
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