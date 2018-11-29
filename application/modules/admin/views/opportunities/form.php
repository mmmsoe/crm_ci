<style type="text/css">
    .ui-autocomplete{z-index:9999999;}
    .form-control, .select2-container, .select2-results, .select2-choice {background-color: #fcfdff !important;}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/leads/get_company_auto') . '/'; ?>',
            dataType: "json",
            success: function (data) {
                console.log(data);
                $('#name').tokenfield({
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
        $('#name').val();

        $("#new_contact").attr("disabled", true);
        $("#contact_show_hide").hide();

        $("form[name='add_opportunities']").submit(function (e) {
            var formData = new FormData($(this)[0]);
            var reUrl = "<?php echo base_url('admin/opportunities/add_process'); ?>";
            var opportunity_id = $("#opportunity_id").val();
            if (opportunity_id != '' && opportunity_id != null) {
                reUrl = "<?php echo base_url('admin/opportunities/update_process'); ?>";
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
                            $("#opportunities_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('create_succesful') . '</div>' ?>');
                        } else if (update == "update") {
                            $("#opportunities_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>' ?>');

                        }
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url('admin/opportunities/view'); ?>/" + id;
                        }, 2000); //will call the function after 2 secs.

                    }
                    else
                    {

                        $('body,html').animate({scrollTop: 0}, 200);
                        $("#opportunities_ajax").html(msg);
                        $("#opportunities_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');

                        //$("form[name='add_opportunities']").find("input[type=text], textarea").val("");

                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

            e.preventDefault();
        });
    });


    function getsalesteamdetails(id)
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

    function contactName(id,idna)
    {
        if (id != "") {
            $("#new_contact").removeAttr("disabled", false);
            $("#contact_show_hide").show();

            $.ajax({
                type: "POST",
                url: '<?php echo base_url('admin/opportunities/ajax_get_contact') . '/'; ?>' + id,
                success: function (data) {
                    $("#contact_id").html(data);
					$("#contact_id").val(idna).change();
					//console.log(idna);
					
                    $('#loader').slideUp(200, function () {
                        $(this).remove();
                    });
                },
            });

        } else {
            $("#new_contact").attr("disabled", true);
            $("#contact_show_hide").hide();
        }
    }

    function companyName(id)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/opportunities/ajax_get_company'); ?>',
            success: function (data) {
                $("#customer_id").html(data);
				$('#customer_id').val(id).change();
				//console.log(id);
				//console.log(data);
                /*
                 $('#loader').slideUp(200, function () {
                 $(this).remove();
                 });
                 */
            },
        });
		
		
    }

    function add_create_customer() {
        $('#modal-create_customer').modal();
        var customer_id = $('#customer_id').val();
        $('#acc_customer_id').val(customer_id);
   }
	// function add_create_customer() {
  		// $('#customer_id').val(13).change();
		// console.log($('#customer_id').val());
    // }

    //Stages Select
    /* $(function() { 
     $('#stages').change(function() {
     var stage=$(this).val();
     
     if(stage=='New' || stage=='Lost' || stage=='Dead')
     {
     $('#probability').val(0);		 	
     }
     if(stage=='Qualification') 
     {
     $('#probability').val(20);	
     }
     if(stage=='Proposition') 
     {
     $('#probability').val(40);	
     }
     if(stage=='Negotiation') 
     {
     $('#probability').val(60);	
     }
     if(stage=='Won') 
     {
     $('#probability').val(100);	
     }         
     
     }).change(); // Trigger the event
     }); */
     
     //MM
    //Stages Select
     $( document ).ready(function() {
         $("#stages_id" ).change(function() {
             var stage=$(this).val();
             if(stage=='8' || stage=='9')
             {
             $('#probability').val('');          
             }
             if(stage=='1') 
             {
             $('#probability').val(10); 
             }
             if(stage=='2') 
             {
             $('#probability').val(20); 
             }
             if(stage=='3') 
             {
             $('#probability').val(40); 
             }
             if(stage=='4') 
             {
             $('#probability').val(50);    
             }   
             if(stage=='5') 
             {
             $('#probability').val(70);    
             }       
             if(stage=='6') 
             {
             $('#probability').val(90);    
             } 
             if(stage=='7') 
             {
             $('#probability').val(100);    
             }         
        });
    });
    //MM
</script>
<style>
    .red {
        background-color: red;
    }

    .yellow {
        background-color: yellow;
    }
</style>
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="header">
        <h2><strong><?php echo $processState; ?> Opportunities</strong></h2>            
    </div>
    <div class="row">
        <div class="panel">
            <div class="panel-content">
                <div id="opportunities_ajax"> 
                    <?php
                    if ($this->session->flashdata('message')) {
                        echo $this->session->flashdata('message');
                    }
                    ?>         
                </div>
                <form id="add_opportunities" name="add_opportunities" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                    <input  type="hidden" id="opportunity_id" name="opportunity_id" value="<?php echo $opportunity->id; ?>"/>
                    <input type="hidden" id="lead_id" name="lead_id" value="<?php echo $opportunity->lead_id; ?>"/>
                    <div class="">
                        <h3 class="pad-l clearMar-t">Opportunity Information</h3>
                        <hr /><div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label col-xs-4 row" style="color:red; margin-right: 5px; padding-right: 5px;">* Opportunity Owner</label>
                                <?php
                                $salesteam_id;
                                foreach ($salesteams_user as $sales_user) {
                                    $salesteam_id = $sales_user[id];
                                }
                                ?>
                                <!-- <div class="form-group">
                                    <div class="form-group col-xs-4 clearPad-lr clearRad-r-box"> -->
                                        <select name="sales_team_id" id="sales_team_id" class="col-xs-4" data-search="true" onChange="getsalesteamdetails(this.value)" style="padding-right: 0px;">
                                            <option value="" selected="selected">Choose Team</option>
                                            <?php foreach ($salesteams as $salesteam) { ?>
                                                <?php if ($salesteams_user->id == $salesteam->id) { ?>
                                                    <option value="<?php echo $salesteam->id; ?>" selected><?php echo $salesteam->salesteam; ?></option>
                                                    <script>
                                                        $(document).ready(function () {
                                                            getsalesteamdetails('<?php echo $salesteam->id; ?>');
                                                        });
                                                    </script>
                                                <?php } else { ?>
                                                    <option value="<?php echo $salesteam->id; ?>" <?php if ($opportunity->sales_team_id == $salesteam->id) { ?> selected="selected"<?php } ?>><?php echo $salesteam->salesteam; ?></option>
                                                <?php } ?>
                                            <?php } ?> 
                                        </select>
                                    <!-- </div> -->
                                    <!-- <div class="form-group col-xs-8 clearPad-lr bord-l clearRad-l-box" id="load_sales"> -->
                                        <select name="salesperson_id" id="salesperson_id" class="clearRad-r col-xs-4" data-search="true" style="float: right;padding-left: 0px;">
                                            <option value="" selected="selected">Choose Sales</option>
                                            <?php
                                            $salesteams = $this->salesteams_model->get_salesteam($opportunity->sales_team_id);
                                            $team = explode(',', $salesteams->team_members);
                                            foreach ($staffs as $staff) {
                                                ?>
                                                <?php if (in_array($staff->id, $team)) { ?>
                                                    <option value="<?php echo $staff->id; ?>" <?php if ($opportunity->salesperson_id == $staff->id) { ?> selected <?php } ?> ><?php echo $staff->first_name . ' ' . $staff->last_name; ?></option>
                                                <?php }else{
                                                    ?>
                                                    <option value="<?php echo $staff->id; ?>"><?php echo $staff->first_name . ' ' . $staff->last_name; ?></option>
                                                    <?php
                                                    } ?> 
                                            <?php } ?>
                                        </select>

                                    <!-- </div> -->
                                <!-- </div> -->
                            </div>
                        </div>
                        <div class="col-sm-6" style="margin-bottom: 15px;">
                            <div class="form-group">
                                <label class="control-label col-xs-4">Opportunity</label>
                                <div class="append-icon col-xs-8" style="display:inline-block margin-right: 5px; padding-left: 20px; padding-right: 0px;">
                                    <input type="text" name="opportunity" value="<?php echo $opportunity->opportunity; ?>" class="form-control">
                                    <i class="fa fa-file-text-o"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6" style="margin-bottom: 15px;">
                            <div class="form-group">
                                <label class="control-label col-xs-4" style="color:red;">* Stages</label>
                                <div class="append-icon  col-xs-8" style="display:inline-block;">
                                    <select name="stages_id" id="stages_id" class="form-control full" data-search="true">
                                        <option value="" selected="selected">Choose Stage</option>
                                        <?php foreach ($stages as $stage) { ?>
                                             <!--MM-->
                                            <!--<?php if ($stage->system_code != '07') { ?>-->
                                            <!--    <option value="<?php echo $stage->system_code; ?>" <?php if ($opportunity->stages_id == $stage->system_code) { ?> selected="selected"<?php } ?>><?php echo $stage->system_value_txt; ?></option>-->
                                            <!--<?php } ?>-->
                                             <option value="<?php echo $stage->system_value_num; ?>" <?php if ($opportunity->stages_id == $stage->system_value_num) { ?> selected="selected"<?php } ?>><?php echo $stage->system_value_txt; ?></option>
                                             <!--MM-->
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6" style="margin-bottom: 15px;">
                            <div class="form-group">
                                <label class="control-label col-xs-4" style="color:red;">* Expected Closing</label>
                                <div class="append-icon  col-xs-8" style="display:inline-block;">
                                    <input type="text" name="expected_closing" value="<?= ($opportunity->expected_closing != '' & $opportunity->expected_closing != null ? $opportunity->expected_closing : ''); ?>" class="date-picker form-control">
                                    <i class="icon-calendar"></i>    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6" style="margin-bottom: 15px;">
                            <div class="form-group">
                                <label class="control-label col-xs-4" style="color:red;">* Tags</label>
                                <div class="append-icon col-xs-8" style="display:inline-block;">
                                    <select name="tags_id[]" id="tags_id" class="form-control" multiple> 
                                        <?php
                                        $tag = explode(",", $opportunity->tags_id);
                                        foreach ($tags as $tags) {
                                            ?>
                                            <option class="<?php echo $tags->system_code; ?>" value="<?php echo $tags->system_code; ?>" <?php if (in_array($tags->system_code, $tag)) { ?>selected<?php } ?>><?php echo $tags->system_value_txt; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6" style="margin-bottom: 15px;">
                            <div class="form-group">
                                <label class="control-label col-xs-4">Amount</label>
                                <div class="append-icon col-xs-8" style="display:inline-block;">
                                    <div class="input-group">
                                        <div class="input-group-addon">$</div>
                                        <input type="text" name="amount" value="<?php echo $opportunity->amount; ?>" class="form-control numeric">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-6" style="margin-bottom: 15px;">
                            <div class="form-group">
                                <label class="control-label col-xs-4">Probability</label>
                                <div class="append-icon col-xs-8" style="display:inline-block;">
                                    <input type="text" name="probability" id="probability" value="<?php echo $opportunity->probability; ?>" class="form-control numeric">
                                    <i class="">%</i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" style="margin-bottom: 15px;">
                            <div class="form-group">
                                <label class="control-label col-xs-4">Type</label>
                                <div class="append-icon col-xs-8" style="display:inline-block;">
                                    <select name="type_id" id="type_id" class="form-control" data-search="true">
                                        <option value="" selected="selected">Choose Type</option>
                                        <?php foreach ($types as $type) { ?>
                                            <option value="<?php echo $type->system_code; ?>" <?php if ($opportunity->type_id == $type->system_code) { ?> selected="selected"<?php } ?>><?php echo $type->system_value_txt; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-6" style="margin-bottom: 15px;">
                            <div class="form-group">
                                <label class="control-label col-xs-4" style="color:red;">Expected Revenue</label>
                                <div class="append-icon col-xs-8">
                                    <div class="input-group">
                                        <div class="input-group-addon">$</div>
                                        <input type="text" name="expected_revenue" value="<?php echo $opportunity->expected_revenue; ?>" class="form-control numeric">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <h3 class="pad-l">Contact Information</h3>
                        <hr />
                        <div class="col-sm-6">
                            <div style="text-align: right;">
                                    <!-- <a href="<?php echo base_url('admin/opportunities/add_account/'); ?>" class="btn btn-embossed btn-primary"> New Customer</a> -->
                                <a href="#" class="btn btn-primary" id="new_customer" data-toggle="modal" data-target="#modal-create_account" onclick="">New Customer</a>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Customer</label>
                                <div class="append-icon">
                                    <select id="customer_id" name="customer_id" class="form-control" data-search="true" onChange="contactName(this.value)">
                                        <option value="" selected>Choose Customer</option>
                                        <?php foreach ($companies as $company) { ?>
                                            <option value="<?php echo $company->id; ?>" <?php if ($opportunity->customer_id == $company->id) { ?> selected="selected"<?php } ?>><?php echo $company->name; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" id="contact_show_hide">
                            <div style="text-align: right;">
                                    <!-- <a href="<?php echo base_url('admin/opportunities/add_customer/'); ?>" class="btn btn-embossed btn-primary"> New Contact</a> -->
                                <!-- data-target="#modal-create_customer" -->
                                <a href="#" class="btn btn-primary" id="new_contact" data-toggle="modal" onclick="javascript: add_create_customer()">New Contact</a>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Contact Name</label>
                                <div class="append-icon" id="contact_box">
                                    <select name="contact_id" id="contact_id" class="form-control" data-search="true">
                                        <option value="" selected="selected">Choose Contact</option>
                                        <?php foreach ($contacts as $contact) { ?>
                                            <option value="<?php echo $contact->id; ?>" <?php if ($opportunity->contact_id == $contact->id) { ?> selected="selected"<?php } ?>><?php echo $contact->first_name; ?><?php echo ' ' . $contact->last_name; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h3 class="pad-l">Other Information</h3>
                        <hr /><div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Next Action Date</label>
                                <div class="append-icon">
                                    <input type="text" name="next_action" value="<?php echo $opportunity->next_action; ?>" class="date-picker form-control">
                                    <i class="icon-calendar"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Next Action</label>
                                <div class="append-icon">
                                    <input type="text" name="next_action_title" value="<?php echo $opportunity->next_action_title; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Lead Source</label>
                                <div class="append-icon">
                                    <select name="lead_source_id" id="lead_source_id" class="form-control full" data-search="true">
                                        <option value="" selected="selected">Choose Source</option>
                                        <?php foreach ($sources as $source) { ?>
                                            <option value="<?php echo $source->system_code; ?>" <?php if ($opportunity->lead_source_id == $source->system_code) { ?> selected="selected"<?php } ?>><?php echo $source->system_value_txt; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Campaign Source</label>
                                <div class="append-icon">
                                    <select name="campaign_source_id" id="campaign_source_id" class="form-control" data-search="true">
                                        <option value="" selected="selected">Choose Source</option>
                                        <?php foreach ($campaigns as $campaign) { ?>
                                            <option value="<?php echo $campaign->id; ?>" <?php if ($opportunity->campaign_source_id == $campaign->id) { ?> selected="selected"<?php } ?>><?php echo $campaign->campaign_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Priority</label>
                                <div class="append-icon">
                                    <select name="priority_id" id="priority_id" class="form-control full" data-search="true">
                                        <option value="" selected="selected">Choose Priority</option>
                                        <?php foreach ($priorities as $priority) { ?>
                                            <option value="<?php echo $priority->system_code; ?>" <?php if ($opportunity->priority_id == $priority->system_code) { ?> selected="selected"<?php } ?>><?php echo $priority->system_value_txt; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">

                        </div>
                    </div>

                    <div class="row">

                    </div>
                    <div class="row">
                        <h3 class="pad-l">Description Information</h3>
                        <hr /><div class="clearfix"></div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="append-icon">
                                    <textarea name="description" rows="4" class="form-control"><?php echo $opportunity->description; ?></textarea> 
                                    <i class="fa fa-clipboard"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-left  m-t-20">
                        <div id="opportunities_submitbutton"><button type="submit" class="btn btn-embossed btn-primary"><?php echo $processButton; ?></button></div>
                    </div>
                </form>             
            </div>
        </div>
    </div>
</div>
<!-- END OF PAGE CONTENT -->
<script type="text/javascript">
    $(document).ready(function ()
    {
        $('.select2-search-choice').css("background-color", 'red');
    });
</script>