<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    var err = 0;
    $(document).ready(function () {
		
		$('#archive').prop('value', 0);
		$('a[data-toggle="' + 'archive' + '"][data-title="' + '0' + '"]').removeClass('btn-default').addClass('btn-primary');
		$('a[data-toggle="' + 'archive' + '"][data-title="' + '1' + '"]').removeClass('btn-primary').addClass('btn-default');
		
        $('#radioBtn a').on('click', function () {
            var sel = $(this).data('title');
            var tog = $(this).data('toggle');
            $('#' + tog).prop('value', sel);

            $('a[data-toggle="' + tog + '"]').not('[data-title="' + sel + '"]').removeClass('btn-primary').addClass('btn-default');
            $('a[data-toggle="' + tog + '"][data-title="' + sel + '"]').removeClass('btn-default').addClass('btn-primary');
			
			$("#archive").val(sel);
        })

        $("form[name='add_leads']").submit(function (e) {
            
            if (err == 0)
            {
                var formData = new FormData($(this)[0]);
                var reUrl = "<?php echo base_url('admin/leads/add_process'); ?>";
                var lead_id = $("#lead_id").val();
                if (lead_id != '' && lead_id != null) {
                    reUrl = "<?php echo base_url('admin/leads/update_process'); ?>";
                }
                console.log(reUrl);
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
                                $("#leads_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('create_succesful') . '</div>' ?>');
                                setTimeout(function () {
                                    window.location.href = "<?php echo base_url('admin/leads/view'); ?>/" + id;
                                }, 800); //will call the function after 1 secs.
                            } else if (update == "update") {
                                $("#leads_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>' ?>');
                                setTimeout(function () {
                                    window.location.href = "<?php echo base_url('admin/leads/view'); ?>/" + id;
                                }, 800); //will call the function after 1 secs.
                            }

                        } else
                        {
                            $('body,html').animate({scrollTop: 0}, 200);
                            $("#leads_ajax").html(msg);
                            $("#leads_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');
                            //$("form[name='add_leads']").find("input[type=text], textarea").val("");
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
            e.preventDefault();
        });
    });
</script>
<script type="text/javascript">

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

    function getWhois()
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/leads/whois'); ?>',
            data: {website: $('#website_whois').val()},
            dataType: "json",
            success: function (data) {
                $('#phone').val(data.reg_phone);
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
                $('#website').val("http://www."+x[1]);
                getstatedetails2(data.reg_country, data.reg_state);
                checkcomp();
            },
        });
    }

    function getstatedetails2(country_id, state_id)
    {
        $('#state_id').empty();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/leads/ajax_state_list2') . '/'; ?>' + country_id,
            data: id = 'cat_id',
            dataType: "json",
            success: function (data) {
                $.each(data.data, function (key, value) {
                    $('#state_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    $("#state_id").select2("val", state_id);
                });
            },
        });
        getcitydetails(state_id);

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

    //Modal Open and Close
    function model_hide_show(name)
    {
        if (name == "calls")
        {
            $("#modal-all_calls").removeClass("fade").modal("hide");
            $("#modal-create_calls").modal("show").addClass("fade");
        }
    }



    function checkcomp()
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/leads/check_comp'); ?>',
            data: {company_name: $('#company_name').val()},
            dataType: "json",
            success: function (data) {
                var text = "";
                if (data.length > 0)
                {
                    if (data[0].indicator == "l")
                    {
                        text = "Company name is already exist in the leads";
                    }
                    else
                    {
                        text = "Company name is already exist in the company data";
                    }

                    $('#mod_company').modal('show');
                    $('.modal-body').text(text);
                    $('.modal-title').text('Error');
                    err = 1;
                }
                else
                {
                    err = 0;
                }
            }
        });

        //return ret;
    }
</script>

<style>
.panel-heading a:after {
    font-family:'Glyphicons Halflings';
    content:"\e114";
    float: right;
    color: grey;
}
.panel-heading a.collapsed:after {
    content:"\e080";
}
</style>

<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="header">
        <h2><strong><?php echo $processState; ?> Leads</strong></h2>            
    </div>
    <div class="row">
        <div class="panel">
            <div class="panel-content">
                <div id="leads_ajax"> 
                    <?php
                    if ($this->session->flashdata('message')) {
                        echo $this->session->flashdata('message');
                    }
                    ?>         
                </div>
                <form id="add_leads" name="add_leads" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                    <input type="hidden" id="lead_id" name="lead_id" value="<?php echo $lead->id; ?>"/>
                    <input type="hidden" id="web_old" name="web_old" value="<?php echo $lead->website; ?>"/>
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
								<button type="button" class="btn btn-info" onclick='getWhois()'>Use Engine</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <h3 class="pad-l">Contact Information</h3>
                        <hr /><div class="clearfix"></div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" style="color:red;">* Company Name</label>
                                <div class="append-icon">
                                    <input type="text" id="company_name" name="company_name" onblur="checkcomp()" value="<?php echo $lead->company_name; ?>" class="form-control">
                                    <i class="fa fa-building"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
							<div class="form-group">
                                <label class="control-label" style="color:red;">* Email</label>
                                <div class="append-icon">
                                    <input type="email" id="email" name="email" value="<?php echo $lead->email; ?>" class="form-control">
                                    <i class="icon-envelope"></i>
                                </div>
                            </div>
						</div>
                    </div> 			
                    <div class="row">
						<div class="col-sm-6">
							<label class="control-label" style="color:red;">* Contact Name</label>
                            <div class="form-group">
                                <div class="form-group col-xs-4 clearPad-lr clearRad-r-box">
                                    <select name="title_id" id="title_id" class="form-control full" data-search="true">
                                        <option value="" selected="selected">None</option>
                                        <?php foreach ($titles as $title) { ?>
                                            <option value="<?php echo $title->system_code; ?>" <?php if ($lead->title_id == $title->system_code) { ?> selected="selected"<?php } ?>><?php echo $title->system_value_txt; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                                <div class="form-group col-xs-8 clearPad-lr bord-l">		
                                    <div class="append-icon">
                                        <input type="text" id="contact_name" name="contact_name" value="<?php echo $lead->contact_name; ?>" class="form-control full-break clearRad-l">
                                        <i class="icon-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div> 
                       
                        <div class="col-sm-6">
							<div class="form-group">
                                <label class="control-label" style="color:red;">* Lead Owner</label>
                                <div class="form-group">
									<?php
										$salesteam_id;
										foreach ($salesteams_user as $sales_user) {
											$salesteam_id = $sales_user[id];
										}
										/*
										modifyed : achmad@arkamaya.co.id
										date	: 20160906.2029
										*/
										$sales_id ="";
										foreach ($salesteams as $salesteam) {
											$arr = array();
											$sales_id = $salesteam->id;
											$tls = explode(",",$salesteam->team_leader);
											$tms = explode(",",$salesteam->team_members);
											foreach ($tls as $tl) {
												array_push($arr, $tl);
											}
											foreach ($tms as $tm) {
												array_push($arr, $tm);
											}
											$arr = array_unique($arr);
											$arr = implode(",", $arr);
											
											$narr = explode(",",$arr);
											$is_break = false;
											foreach($narr as $nk=>$nv){
												if($nv==$salesteam_id){
													$is_break = true;
													break;
												}
											}
											if($is_break){
												break;
											}
										}
									?>
                                    <div class="form-group col-xs-4 clearPad-lr clearRad-r-box">
                                        <select name="sales_team_id" id="sales_team_id" class="form-control full" data-search="true" onChange="getsalesteamdetails(this.value)">
                                            <option value="" selected="selected">Choose Team</option>
                                            <?php foreach ($salesteams as $salesteam) { ?>
												<?php if($sales_id == $salesteam->id){ ?>
													<option value="<?php echo $salesteam->id; ?>" selected><?php echo $salesteam->salesteam; ?></option>
													<script>
														$(document).ready(function () {
															getsalesteamdetails($("#sales_team_id").val());
														});
													</script>
												<?php } else { ?>
													<option value="<?php echo $salesteam->id; ?>" <?php if ($lead->sales_team_id == $salesteam->id) { ?> selected="selected"<?php } ?>><?php echo $salesteam->salesteam; ?></option>
												<?php } ?>
                                            <?php } ?> 
                                        </select>
                                    </div>
                                    <div class="form-group col-xs-8 clearPad-lr bord-l clearRad-l-box" id="load_sales">
                                        <select name="salesperson_id" id="salesperson_id" class="form-control full clearRad-r" data-search="true">
                                            <option value="" selected="selected">Choose Sales</option>
                                            <?php
                                            $salesteams = $this->salesteams_model->get_salesteam($lead->sales_team_id);
                                            $team = explode(',', $salesteams->team_members);
                                            foreach ($staffs as $staff) {
                                                ?>
                                                <?php if (in_array($staff->id, $team)) { ?>
                                                    <option value="<?php echo $staff->id; ?>" <?php if ($lead->salesperson_id == $staff->id) { ?> selected <?php } ?> ><?php echo $staff->first_name . ' ' . $staff->last_name; ?></option>
                                                <?php } ?> 
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
								<label class="control-label" style="color:red;">* Address</label>
								<div class="append-icon">
									<textarea id="address" name="address" rows="4" class="form-control height-row-2"><?php echo $lead->address; ?></textarea> 
									<i class="fa fa-map-marker"></i>
								</div>
							</div>
						</div>
						
						<div class="col-sm-6">
							<div>
								<div class="form-group">
									<label class="control-label" style="color:red;">* Lead Name</label>
									<div class="append-icon">
										<input type="text" name="lead_name" value="<?php echo $lead->lead_name; ?>" class="form-control">
										<i class="fa fa-file-text-o"></i>
									</div>
								</div>
							</div>
							<div>
								<label class="control-label" style="color:red;">* Tags</label>
								<div class="append-icon">
									<select name="tags_id[]" id="tags_id" class="form-control" multiple> 
										<?php
										$tag = explode(",", $lead->tags_id);

										foreach ($tags as $tags) {
											?>
											<option value="<?php echo $tags->system_code; ?>" <?php if (in_array($tags->system_code, $tag)) { ?>selected<?php } ?>><?php echo $tags->system_value_txt; ?></option>
										<?php } ?> 
									</select>
								</div>
							</div>
                        </div>
					</div>
					
					<div class="row">
                        <div class="col-sm-6">
							<div class="form-group">
                                <label class="control-label">Phone</label>
                                <div class="append-icon">
                                    <input type="text" id="phone" name="phone" value="<?php echo $lead->phone; ?>" class="form-control numeric">
                                    <i class="fa fa-phone"></i>
                                </div>
                            </div>
                        </div>
						
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
					</div>
					
                    <div class="row">
						<div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Mobile</label>
                                <div class="append-icon">
                                    <input type="text" id="mobile" name="mobile" value="<?php echo $lead->mobile; ?>" class="form-control numeric">
                                    <i class="icon-screen-smartphone"></i>
                                </div>
                            </div>
                        </div>
						
						<div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Fax</label>
                                <div class="append-icon">
                                    <input type="text" id="fax" name="fax" value="<?php echo $lead->fax; ?>" class="form-control numeric">
                                    <i class="fa fa-fax"></i>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<div class="row">
						<div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Website</label>
                                <div class="append-icon">
                                    <input type="text" id="website" name="website" value="<?php echo $lead->website; ?>" class="form-control">
                                    <i class="icon-globe"></i><br>
                                    <p style="font-size:11px;">Example:http://www.example.com</p>
                                </div>
                            </div>
                        </div>
						
						<div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Campaign Source</label>
                                <select name="campaign_id" id="campaign_id" class="form-control full" data-search="true">
                                    <option value="" selected="selected">Choose Campaign</option>
                                    <?php foreach ($campaigns as $campaign) { ?>
                                        <option value="<?php echo $campaign->id; ?>" <?php if ($lead->campaign_id == $campaign->id) { ?> selected="selected"<?php } ?>><?php echo $campaign->campaign_name; ?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                        </div>
					</div>
					
					<div class="row">
						<div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Lead Status</label>
                                <select name="lead_status_id" id="lead_status_id" class="form-control full" data-search="true">
                                    <option value="" selected="selected">Choose Status</option>
                                    <?php foreach ($allstatus as $status) { ?>
                                        <option value="<?php echo $status->system_code; ?>" <?php if ($lead->lead_status_id == $status->system_code) { ?> selected="selected"<?php } ?>><?php echo $status->system_value_txt; ?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                        </div>
						
						<div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Lead Archive </label>
                                <div class="input-group">
                                    <div id="radioBtn" class="btn-group">
                                        <a class="btn <?php
                                        if ($lead->archive == '0') {
											echo "btn-default";
                                        } else {
                                            echo "btn-primary";
                                        }
                                        ?> btn-sm" data-toggle="archive" data-title="1">YES</a>
                                        <a class="btn <?php
                                        if ($lead->archive == '0') {
                                            echo "btn-primary";
                                        } else {
											echo "btn-default";
                                        }
                                        ?> btn-sm" data-toggle="archive" data-title="0">NO</a>
                                    </div>
                                    <input type="hidden" name="archive" id="archive">
                                </div>
                            </div>
                        </div>
                    </div>
					
                    <div class="row">
                        <h3 class="pad-l">Address Information</h3>
						<hr /><div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Select Country</label>
                                <div class="col-sm-12 clearPad-lr">
                                    <select name="country_id" id="country_id" class="form-control reHeight" data-search="true" onChange="getstatedetails(this.value)">
                                        <option value="" selected="selected">Choose one</option>
                                        <?php foreach ($countries as $country) { ?>
                                            <option value="<?php echo $country->id; ?>" <?php if ($lead->country_id == $country->id) { ?> selected="selected"<?php } ?>><?php echo $country->name; ?></option>
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
                                            <?php $states = $this->leads_model->state_list($lead->country_id); ?>
                                            <?php foreach ($states as $state) { ?>
                                                <option value="<?php echo $state->id; ?>" <?php if ($lead->state_id == $state->id) { ?> selected="selected"<?php } ?>><?php echo $state->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-xs-6 clearPad-lr bord-l  clearRad-l-box" id="load_city">
                                        <!--input type="text" value="" class="form-control" readOnly="readOnly"-->
                                        <select name="city_id" id="city_id" class="form-control">
                                            <option value="" selected="selected">Select City</option>
                                            <?php $cities = $this->leads_model->city_list($lead->state_id); ?>
                                            <?php foreach ($cities as $city) { ?>
                                                <option value="<?php echo $city->id; ?>" <?php if ($lead->city_id == $city->id) { ?> selected="selected"<?php } ?>><?php echo $city->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
						
						<div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Zip Code</label>
                                <div class="append-icon">
                                    <input id="zip_code" type="text" name="zip_code" value="<?php echo $lead->zip_code; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
					<!--
					<div>
						<div class="panel-group" id="accordion">
							<div class="panel panel-default" id="panel1">
								<div class="panel-heading">
									 <h4 class="panel-title">
								
							  </h4>

								</div>
								<div id="collapseOne" class="panel-collapse collapse in">
									<div class="panel-body">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</div>
								</div>
							</div>
						</div>
					</div>
					-->
					
                    <div class="row">
                        <h3 class="pad-l">
							<a data-toggle="collapse" data-target=".collapseOne" href=".collapseOne"> Other Information</a>
						</h3>
                        <hr /><div class="clearfix"></div>
                        <div class="col-sm-6 collapseOne panel-collapse collapse in">
                            <div class="form-group">
                                <label class="control-label">No of Employees</label>
                                <div class="append-icon">
                                    <input type="text" name="no_of_employees" value="<?php echo $lead->no_of_employees; ?>" class="form-control numeric">
                                    <i class="fa fa-group"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 collapseOne panel-collapse collapse in">
                            <div class="form-group">
                                <label class="control-label">Industry</label>
                                <select name="industry_id" id="industry_id" class="form-control full" data-search="true">
                                    <option value="" selected="selected">None</option>
                                    <?php foreach ($industrys as $industry) { ?>
                                        <option value="<?php echo $industry->system_code; ?>" <?php if ($lead->industry_id == $industry->system_code) { ?> selected="selected"<?php } ?>><?php echo $industry->system_value_txt; ?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row collapseOne panel-collapse collapse in">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Rating</label>
                                <select name="rating_id" id="rating_id" class="form-control full" data-search="true">
                                    <option value="" selected="selected">None</option>
                                    <?php foreach ($ratings as $rating) { ?>
                                        <option value="<?php echo $rating->system_code; ?>" <?php if ($lead->rating_id == $rating->system_code) { ?> selected="selected"<?php } ?>><?php echo $rating->system_value_txt; ?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Skype ID</label>
                                <div class="append-icon">
                                    <input type="text" name="skype_id" value="<?php echo $lead->skype_id; ?>" class="form-control">
                                    <i class="fa fa-skype"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row collapseOne panel-collapse collapse in">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Priority</label>
                                <select name="priority_id" id="priority_id" class="form-control full" data-search="true">
                                    <option value="" selected="selected">Choose Priority</option>
                                    <?php foreach ($priorities as $priority) { ?>
                                        <option value="<?php echo $priority->system_code; ?>" <?php if ($lead->priority_id == $priority->system_code) { ?> selected="selected"<?php } ?>><?php echo $priority->system_value_txt; ?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Secondary Email</label>
                                <div class="append-icon">
                                    <input type="text" name="secondary_email" value="<?php echo $lead->secondary_email; ?>" class="form-control">
                                    <i class="icon-envelope"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row collapseOne panel-collapse collapse in">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Annual Revenue</label>
                                <div class="append-icon">
                                    <div class="input-group">
                                        <div class="input-group-addon">$</div>
                                        <input type="text" name="annual_revenue" value="<?php echo $lead->annual_revenue; ?>" class="form-control numeric">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Twitter</label>
                                <div class="append-icon">
                                    <div class="input-group">
                                        <div class="input-group-addon">@</div>
                                        <input type="text" name="twitter" value="<?php echo $lead->twitter; ?>" class="form-control">
                                        <div class="input-group-addon"><i class="fa fa-twitter"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row collapseOne panel-collapse collapse in">
						<div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Email Opt Out</label>
                                <div class="append-icon">
                                    <input type="checkbox" name="email_opt_out" value="1" class="form-control" data-checkbox="icheckbox_square-blue" <?= ($lead->email_opt_out == 1 ? 'checked = "checked"' : '' ) ?>>
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
                                    <textarea name="description" rows="4" class="form-control"><?php echo $lead->description; ?></textarea> 
                                    <i class="fa fa-clipboard"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-left  m-t-20">
                        <div id="leads_submitbutton">
                            <button type="submit" class="btn btn-embossed btn-primary"><?php echo $processButton; ?></button>
                        </div>
                    </div>
                </form>             
            </div>
        </div>
    </div>
</div>   
<div id="mod_company" class="modal fade" id="modal-basic" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                <h4 class="modal-title"><strong>Confirm</strong></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-embossed" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT -->

<!-- START MODAL CONTENT -->

<!-- POPUP CONTACT CALL FORM ==================================================================================================== -->

<!--div class="modal fade" id="modal-create_calls" aria-hidden="true">
        <div class="modal-dialog modal-lg">
                <div class="modal-content">
        <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                                <h4 class="modal-title"><strong>Leads</strong> Calls</h4>
        </div>
        <div id="call_ajax"> 
<?php
if ($this->session->flashdata('message')) {
    echo $this->session->flashdata('message');
}
?>         
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
</div-->             