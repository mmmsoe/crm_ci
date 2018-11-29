<script>

    function delete_system(systems_type, systems_id)
    {
        //return confirm('Are you sure?');
        // alert(systems_type+' - '+systems_id);
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('admin/systems/delete'); ?>/" + systems_type + '/' + systems_id,
            success: function (msg)
            {
                if (msg == 'deleted')
                {
                    $('#systemId_' + systems_id + '_systemType_' + systems_type).fadeOut('normal');
                }
            }

        });

    }

</script>

<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="row">
        <div>
            <?php if (check_staff_permission('staff_write')) { ?> 
                <a  style="float:right;" href="<?php echo base_url('admin/systems/add/' . $system_old); ?>" class="btn btn-primary btn-embossed"> Create New</a>
                <a href="<?php echo base_url('admin/systems/'); ?>" class="btn btn-black btn-embossed"> Back to System</a>
            <?php } ?>
        </div>
    </div>
    <?php
    if ($systems[0]->system_type == "TAGS" || $systems[0]->system_type == "OPPORTUNITIES_STAGES") {
        $cls = "";
    } else {
        $cls = "hidden";
    };
    ?>


    <div class="row">
        <!--MM-->
        <?php
            if ($systems[0]->system_type == "OPPORTUNITIES_STAGES") {
                $per_cls = "";
            } else {
                $per_cls = "hidden";
            };
            ?>
        <!--MM-->
        <div class="panel">
            <div class="panel-content"> 
                <div class="panel-content pagination2 table-responsive">
                    <table class="table table-hover table-dynamic">
                        <thead>
                            <tr>
                                <th><?php echo $this->lang->line('type'); ?></th>
                                <th><?php echo $this->lang->line('name'); ?></th>
                                <th><?php echo $this->lang->line('sequence_number'); ?></th>
                                <!--MM-->
                                <th class="<?php echo $per_cls; ?>">Percentage</th>
                                <!--MM-->
                                <th class="<?php echo $cls; ?>"><?php echo ($systems[0]->system_type == "TAGS" ? $this->lang->line('color_pict') : $this->lang->line('color_stages')); ?> </th>
                                <th><?php echo $this->lang->line('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (!empty($systems)) { ?>
                                <?php foreach ($systems as $system) { ?>
                                    <?php if ($system->system_code !== '00') { ?>
                                        <tr id="systemId_<?php echo $system->system_code; ?>_systemType_<?php echo $system->system_type; ?>">
                                            <td><?php echo str_replace('_', ' ', $system->system_type); ?></td>
                                            <td><?php echo $system->system_value_txt; ?></td>
                                            <td class="numeric"><?php echo $system->system_value_num; ?></td>
                                            <!--MM-->
                                            <td class="<?php echo $per_cls; ?> numeric"><?php echo $system->percentage; ?></td>
                                            <!--MM-->
                                            <td class='<?php echo $cls; ?>'><div style='width:150px;background-color:<?php echo $system->status; ?>;border:solid 1px black'><?php echo $system->status; ?></div></td>
                                            <td>
                                                <?php if (check_staff_permission('staff_write')) { ?>
                                                    <a href="<?php
//                                                    if ($this->user_model->get_role(userdata('id'))[0]->role_id == $system->system_code) {
//                                                        echo base_url('admin/account_settings/');
//                                                    } else {
                                                        echo base_url('admin/systems/update/' . $system->system_type . '/' . $system->system_code);
//                                                    }
                                                    ?>" class="edit btn btn-sm btn-default dlt_sm_table"><i class="icon-note"></i></a> 
                                                   <?php } ?>

                                                <?php if (check_staff_permission('staff_delete')) { ?>
                                                    <a href="javascript:void(0)" class="delete btn btn-sm btn-danger dlt_sm_table" data-toggle="modal" data-target="#modal-basic<?php echo $system->system_code; ?><?php echo $system->system_type; ?>"><i class="glyphicon glyphicon-trash"></i></a>
                                                <?php } ?>
                                            </td> 
                                        </tr>
                                    <div class="modal fade" id="modal-basic<?php echo $system->system_code; ?><?php echo $system->system_type; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                                                    <h4 class="modal-title"><strong>Confirm</strong></h4>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this?<br>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default btn-embossed" data-dismiss="modal">Cancel</button>
                                                    <button type="button" onclick="delete_system('<?php echo $system->system_type; ?>', '<?php echo $system->system_code; ?>')" class="btn btn-primary btn-embossed" data-dismiss="modal">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>
                            <?php } ?>
                        <?php } ?> 


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>       
