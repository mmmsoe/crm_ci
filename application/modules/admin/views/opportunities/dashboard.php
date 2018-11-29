<style>
    h2{
        margin: 10px 12px 0px 12px;
    }
    .page-content{
        overflow:auto; width:100%; height:auto;
    }
    ol{
        min-height:50px;
    }
    .main-opportunity{
        line-height:100%;
    }
    /*    .fa-circle-o{
            padding-right:5%;
            float:right;
        }*/
    .fa-money{
        padding-right:5%;
        float:right;
    }
    .fa-user{
        padding-right:5%;
        float:right;
    }
    .fa-users{
        padding-right:5%;
        float:right;
    }
    .font_family {
        font-family:Arial Narrow,Arial,sans-serif;
        font-size:11px;
    }

    /*    .fa-clock-o{
            padding-right:5%;
            float:right;
        }*/
    /*    a{
            padding-right:2%;
        }*/
</style>
<div class="page-content font_family">
    <div class="row" style="background-color:white;border-top:1px solid #d5dddd;border-left:1px solid #d5dddd;border-right:1px solid #d5dddd;padding-top: 13px">
        <div class="col-md-12">
            <?php if (check_staff_permission('opportunities_write')) { ?> 
                <a href="<?php echo base_url('admin/opportunities/dashboard///'); ?>" class="btn btn-black btn-embossed"> Dashboard</a> 	
                <a href="<?php echo base_url('admin/opportunities/'); ?>" class="btn btn-gray btn-embossed"> Manage Opportunities</a> 
                <span id='current_url' hidden><?php echo base_url(); ?></span>
				
				<a href="<?php echo base_url('admin/opportunities/add'); ?>" style="float:right" class="btn btn-black btn-embossed"> Create New</a> 
                <button style="float:right" class="btn btn-black btn-embossed" onclick="redirect()"> Search</button>

            <?php } ?>
        </div>    
    </div>
    <div class="row" style="background-color:white;border-bottom:1px solid #d5dddd;border-left:1px solid #d5dddd;border-right:1px solid #d5dddd">
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label">Tags</label>
                <div class="append-icon">
                    <select name="tags_id[]" id="tags_id" class="form-control" multiple> 
                        <?php
                        if ($tags == '00') {
                            $tags = '';
                        }
                        $tag = explode("_", $tags);
                        foreach ($tags_list as $x) {
                            ?>
                            <option value="<?php echo $x->system_code; ?>" <?php if (in_array($x->system_code, $tag)) { ?>selected<?php } ?>><?php echo $x->system_value_txt; ?></option>
                            <?php
                        }
                        ?> 
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label">Sales</label>
                <select name="sales_code" id="sales_code" class="form-control full" data-search="true">
                    <option value="" selected="selected">Choose Sales</option>
                    <?php foreach ($name_list as $name) { ?>
                        <option value="<?php echo $name->id; ?>" <?php if ($name->id == $sales) { ?> selected="selected"<?php } ?>><?php echo $name->first_name . ' ' . $name->last_name; ?></option>
                    <?php } ?> 
                </select>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label">Sales Teams</label>
                <select name="salesteams_code" id="salesteams_code" class="form-control full" data-search="true">
                    <option value="" selected="selected">Choose Sales Team</option>
                    <?php foreach ($salesteams_list as $sl) { ?>
                        <option value="<?php echo $sl->id; ?>" <?php if ($sl->id == $steams) { ?> selected <?php } ?>><?php echo $sl->salesteam; ?></option>
                    <?php } ?> 
                </select>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label">Company ID</label>
                <select name="company_code" id="company_code" class="form-control full" data-search="true">
                    <option value="" selected="selected">Choose Company</option>
                    <?php foreach ($company_list as $cmp) { ?>
                        <option value="<?php echo $cmp->id; ?>" <?php if ($cmp->id == $company_id) { ?> selected="selected"<?php } ?>><?php echo $cmp->name; ?></option>
                    <?php } ?> 
                </select>
            </div>
        </div>
    </div>
    <br/>
    <div>
        <div class="row" style="background-color:white;border-top:1px solid #d5dddd;border-left:1px solid #d5dddd;border-right:1px solid #d5dddd">
            &nbsp;
        </div>
        <div class="row" style="background-color:white;border-bottom:1px solid #d5dddd;border-left:1px solid #d5dddd;border-right:1px solid #d5dddd">
            <?php
            if (!empty($stages_column)) {
                $break = 0;
                foreach ($stages_column as $c) {
                    //MM
                    //if ($break % 4 == 0) {
                    if ($break % 6 == 0) {
                     //MM    
                        echo '<div class="clearfix"></div>';
                    }
                    if ($c->system_value_txt != null) {
                        $break++;
                    }
                    ?>
                    <!--MM-->
                    <!--<div class="col-sm-3 <?php echo ($c->system_value_txt != NULL ? "" : "hidden"); ?>">-->
                    <div class="col-sm-2 <?php echo ($c->system_value_txt != NULL ? "" : "hidden"); ?>">
                    <!--MM-->
                        <?php
                        $role_id = $this->user_model->get_role(userdata('id'))[0]->role_id;
                        //MM
                        // $data_list = $this->opportunities_model->get_data_by_stage($role_id, $c->system_code, userdata('id'), $tags, $sales, $company_id, $steams);
                        $data_list = $this->opportunities_model->get_data_by_stage($role_id, $c->system_value_num, userdata('id'), $tags, $sales, $company_id, $steams);
                        //MM
                        $total_amount = 0;
                        $total_opotunities = 0;
                        if (!empty($data_list)) {
                            foreach ($data_list as $d) {
                                $total_amount = $total_amount + $d->amount;
                                $total_opotunities = $total_opotunities + 1;
                            }
                        }
                        ?>
                        <div class="panel" style="background-color:<?php echo $c->status; ?>;">
                            <div class="panel-title">
                                <h2><small><span class="fa fa-th-list"></span>&nbsp; <?php echo ($c->system_value_txt != NULL ? $c->system_value_txt : 'Not Classified'); ?></small></h2>
                                <div class="pull-right" style="font-size: 14px;">
                                    <div>
                                        <div style="text-align: right;">
                                        <i class="fa fa-money" style="float: none; display: inline-block;"></i>&nbsp;: <small><?=number_format($total_amount, 2, '.', ',');?></small>
                                        </div>
                                    </div>
                                    <div><small class="pull-right">&nbsp;<?=$total_opotunities;?> Oportunities</small></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-content" >
                                <div class="row">
                                    <!--MM-->
                                    <!--<ol class='dnd_opportunities vertical' id="<?php echo $c->system_code; ?>" >-->
                                    <ol class='dnd_opportunities vertical' id="<?php echo $c->system_value_num; ?>" >
                                    <!--MM-->
                                        <?php
                                        if (!empty($data_list)) {
                                            foreach ($data_list as $d) {
                                                //print_r($d);
                                                ?>
                                                <!--MM-->
                                                <!--<li id="<?php echo $d->id; ?>" class='list-group-item' value='<?php echo $c->system_code; ?>' style="cursor: pointer">-->
                                                <li id="<?php echo $d->id; ?>" class='list-group-item' value='<?php echo $c->system_value_num; ?>' style="cursor: pointer">
                                                    <!--MM-->

                                                    <?php
                                                    $clr = explode(",", $this->leads_model->get_lead($d->lead_id, userdata('id'))->tags_id);
                                                    foreach ($clr as $cd) {
                                                        ?>
                                                        <div style='width:44px;height:8px;background-color:<?php echo $this->leads_model->get_color($cd) ?>;float:left'>&nbsp;</div>
                                                        <div style='width:2px;height:8px;float:left'>&nbsp;</div>
                                                        <?php
                                                    }
                                                    ?>
                                                    <p class="main-opportunity">
                                                        <br/>
                                                        <!--<span class='fa fa-circle-o'></span>-->
                                                        <span data-toggle="popover" title="Amount" data-content="<?php echo number_format($d->amount, 2, '.', ','); ?>" class='fa fa-money <?php echo $d->probability == "" ? "hidden" : ""; ?>'></span>
                                                        <span data-toggle="popover" title="Contact" data-content="<?php echo ($this->contact_persons_model->get_contact_persons($d->contact_id)->first_name) . ' ' . $this->contact_persons_model->get_contact_persons($d->contact_id)->last_name; ?>" class='fa fa-user <?php echo $this->contact_persons_model->get_contact_persons($d->contact_id)->first_name == "" ? "hidden" : ""; ?>' onclick="javascript:icon_click('<?php echo base_url('admin/contact_persons/view/' . $d->contact_id); ?>');"></span>
                                                        <span data-toggle="popover" title="Sales Teams" data-content="<?php echo $d->salesteam; ?>" class='fa fa-users <?php echo $d->sales_team_id == "" ? "hidden" : ""; ?>' onclick="javascript:icon_click('<?php echo base_url('admin/contact_persons/view/' . $d->salesteam); ?>');"></span>
                                                        <!--<span class='fa fa-clock-o'></span>-->


                                                        <br/>
                                                        <span class='fa fa-building'></span> <span onclick="javascript:icon_click('<?php echo base_url('admin/customers/view/' . $d->customer_id); ?>');"><span style="font-weight:bold"><?php echo $d->name; ?></span></span><br/>
                                                        <span><a href='<?php echo base_url('admin/opportunities/view/' . $d->id); ?>' ><span class='fa fa-file'></span>&nbsp;<?php echo $d->opportunity; ?></a></span>&nbsp;
                                                        <span><a href="#" class="<?php echo $d->probability == "" ? "hidden" : ""; ?>"><span class='fa fa-circle-o'></span>&nbsp;<?php echo $d->probability . ' %'; ?></a></span>&nbsp;
                                                        <span><a href="#" class="<?php echo $d->next_action == "" ? "hidden" : ""; ?>"><span class='fa fa-clock-o'></span>&nbsp;<?php echo date('m/d/Y', strtotime($d->next_action)); ?></a></span>
                                                    </p>
                                                </li>

                                                <?php
                                            }
                                        }
                                        ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

</div>



<script>
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover({
            placement: 'left',
            trigger: 'hover'
        });
    });

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
	
    function icon_click(val) {
        window.location.href = val;
    }
    function redirect() {
        var tg = $('#s2id_tags_id').select2('data');
        var sls = $('#s2id_sales_code').select2('data').id;
        var stm = $('#s2id_salesteams_code').select2('data').id;
        var cmp = $('#s2id_company_code').select2('data').id;
        //$('.select2-search-choice').hide()
        var tag = '';
        for (var i = 0; i < tg.length; i++) {
            tag = tag + tg[i].id + '_';
        }
        tag = tag.slice(0, -1);

        if (tag.length == 0) {
            tag = '00';
        }

        if (sls.length == 0) {
            sls = '00';
        }

        if (stm.length == 0) {
            stm = '00';
        }

        if (cmp.length == 0) {
            cmp = '00';
        }

        var base_url = $('#current_url').html();
        window.location = base_url + 'admin/opportunities/dashboard' + '/' + tag + '/' + sls + '/' + cmp + '/' + stm;
    }
    var adjustment;

    $("ol.dnd_opportunities").sortable({
        group: 'dnd_opportunities',
        pullPlaceholder: false,
        // animation on drop
        onDrop: function ($item, container, _super) {
            var $clonedItem = $('<li/>').css({height: 0});
            $item.before($clonedItem);
            //console.log($item);
            $clonedItem.animate({'height': $item.height()});

            $item.animate($clonedItem.position(), function () {
                $clonedItem.detach();
                _super($item, container);
            });

            update_stage_by_id($item[0].id, container.el[0].id);
        },
        // set $item relative to cursor position
        onDragStart: function ($item, container, _super) {
            var offset = $item.offset(),
                    pointer = container.rootGroup.pointer;

            adjustment = {
                left: pointer.left - offset.left,
                top: pointer.top - offset.top
            };

            _super($item, container);
        },
        onDrag: function ($item, position) {
            $item.css({
                left: position.left - adjustment.left,
                top: position.top - adjustment.top
            });
        }
    });

    function update_stage_by_id(id, target_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('admin/opportunities/update_stage_by_id'); ?>',
            data: {id: id, stages_id: target_id},
            async: false,
            success: function (result) {
                if (result.messsage != "GAGAL") {
                    console.log('success');
                } else {
                    console.log('failed');
                }
            }
        });
    }
</script>