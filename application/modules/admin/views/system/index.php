<style>
    th{font-size:10px;}
</style>
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="row">
        <!--a href="#" style="float:right;" data-toggle="modal" data-target="#modal-create_group" class="btn btn-primary btn-embossed">Create New Group</a-->
        <div>
            <?php if (check_staff_permission('systems_write')) { ?> 
                <a  style="float:right;" href="<?php echo base_url('admin/systems/add/' . $system_old); ?>" class="btn btn-primary btn-embossed"> Create New</a>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="panel">	
            <div class="panel-content">
                <div class="panel-content table-responsive">

                    <table class="table table-hover filter-between_date" id="tbPotensial">
                        <thead>
                            <tr>                        
                                <th>Group Name</th>
                                <th>Descrption</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($system_types)) { ?>
                                <?php foreach ($system_types as $system_type) { ?>
                                    <?php if ($system_type->system_code == "00") { ?>
                                        <tr>
                                            <td><a href="<?php echo base_url('admin/systems/list_system/' . $system_type->system_type); ?>"><?php echo str_replace('_', ' ', $system_type->system_type); ?></a></td>
                                            <td><?php echo $system_type->system_value_txt; ?></td>
                                        </tr>
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
<!-- END PAGE CONTENT -->