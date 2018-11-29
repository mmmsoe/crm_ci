<div class="page-content" style="overflow:auto; width:100%; height:auto;">
    <div class="row">
        <div class="col-md-12">
            <?php if (check_staff_permission('opportunities_write')) { ?> 
                <a href="<?php echo base_url('admin/opportunities/dashboard///'); ?>" class="btn btn-black btn-embossed"> Dashboard</a> 	
                <a href="<?php echo base_url('admin/opportunities/'); ?>" class="btn btn-gray btn-embossed"> Manage Opportunities</a> 
                <span id='current_url' hidden><?php echo base_url(); ?></span>
            <?php } ?>
        </div>    
    </div>
    <div class="row">
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
                <label class="control-label">Company ID</label>
                <select name="company_code" id="company_code" class="form-control full" data-search="true">
                    <option value="" selected="selected">Choose Company</option>
                    <?php foreach ($company_list as $cmp) { ?>
                        <option value="<?php echo $cmp->id; ?>" <?php if ($cmp->id == $company_id) { ?> selected="selected"<?php } ?>><?php echo $cmp->name; ?></option>
                    <?php } ?> 
                </select>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label">&nbsp;</label>
                <div>
                    <button class="btn btn-black btn-embossed" onclick="redirect()"> Search</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        if (!empty($stages_column)) {
            $break = 0;
            foreach ($stages_column as $c) {
                if ($break % 4 == 0) {
                    echo '<div class="clearfix"></div>';
                }
                if ($c->system_value_txt != null) {
                    $break++;
                }
                ?>
                <div class="col-sm-3 <?php echo ($c->system_value_txt != NULL ? "" : "hidden"); ?>">
                    <div class="panel">
                        <div class="panel-title">
                            <h2 style='margin: 10px 12px 0px 12px;'><small><span class="fa fa-th-list"></span>&nbsp; <?php echo ($c->system_value_txt != NULL ? $c->system_value_txt : 'Not Classified'); ?></small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-content">
                            <div class="row">
                                <ol class='dnd_opportunities vertical' style="min-height:50px;" id="<?php echo $c->system_code; ?>" >
                                    <?php
                                    $role_id = $this->user_model->get_role(userdata('id'))[0]->role_id;
                                    $data_list = $this->opportunities_model->get_data_by_stage($role_id,$c->system_code, userdata('id'), $tags, $sales, $company_id);
                                    if (!empty($data_list)) {
                                        foreach ($data_list as $d) {
                                            //print_r($d);
                                            ?>
                                            <li id="<?php echo $d->id; ?>" class='list-group-item' value='<?php echo $c->system_code; ?>' style="cursor: pointer">

                                                <?php
                                                $clr = explode(",", $this->leads_model->get_lead($d->lead_id, userdata('id'))->tags_id);
                                                foreach ($clr as $cd) {
                                                    ?>
                                                    <div style='width:44.9px;height:8px;background-color:<?php echo $this->leads_model->get_color($cd) ?>;float:left'>&nbsp;</div>
                                                    <div style='width:2px;height:8px;float:left'>&nbsp;</div>
                                                    <?php
                                                }
                                                ?>
                                                <br/>
                                                <table>
                                                    <tr>	
                                                        <td style='valign:top;width:150px'>
                                                            <p><a href='<?php echo base_url('admin/opportunities/view/' . $d->id); ?>'><span class='fa fa-file'></span> &nbsp;<?php echo $d->opportunity; ?></a></p>
                                                            <p class="<?php echo $d->name == "" ? "hidden" : ""; ?>"><span class='fa fa-building'></span> &nbsp;<?php echo $d->name; ?></p>
                                                        </td>
                                                        <td>
                                                            <p class="<?php echo $d->probability == "" ? "hidden" : ""; ?>"><span class='fa fa-circle-o'></span> &nbsp;<?php echo $d->probability . ' %'; ?></p>
                                                            <p class="<?php echo $d->amount == "" ? "hidden" : ""; ?>"><span class='fa fa-money'></span> &nbsp;<?php echo number_format($d->amount, 2, '.', ','); ?></p>
                                                            <!--<p class="<?php // echo $this->contact_persons_model->get_contact_persons($d->contact_id)->first_name == ""? "hidden" : ""; ?>"><span class='fa fa-user'></span> &nbsp;
                                                            <?php //echo ($this->contact_persons_model->get_contact_persons($d->contact_id)->first_name); ?>
                                                            <?php //echo ' ' . $this->contact_persons_model->get_contact_persons($d->contact_id)->last_name; ?>
                                                            </p>-->
                                                            <p class="<?php echo $d->next_action == "" ? "hidden" : ""; ?>"><span class='fa fa-clock-o'></span> &nbsp;<?php echo date('m/d/Y', strtotime($d->next_action)); ?></p>
                                                        </td>
                                                    </tr>
                                                </table>
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



<script>
    function redirect() {
        var tg = $('#s2id_tags_id').select2('data');
        var sls = $('#s2id_sales_code').select2('data').id;
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

        if (cmp.length == 0) {
            cmp = '00';
        }

        var base_url = $('#current_url').html();
        window.location = base_url + 'admin/opportunities/dashboard' + '/' + tag + '/' + sls + '/' + cmp;
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