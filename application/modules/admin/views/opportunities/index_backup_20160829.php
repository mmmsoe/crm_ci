<script>
    function delete_opportunities(opportunity_id)
    {
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('admin/opportunities/delete'); ?>/" + opportunity_id,
            success: function (msg)
            {
                if (msg == 'deleted')
                {
                    $('#opportunity_id_' + opportunity_id).fadeOut('normal');
                }
            }
        });
    }

//        $(document).ready(function() {
//            $("#filter_time option[value='month']").prop("selected", true);
//            filter_opportunities();
//        });

    function filter_opportunities() {
        var x = document.getElementById("stages_id").value;
        var y = document.getElementById("filter_time").value;
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/opportunities/get_filter') . '/'; ?>',
            data: {type: x, time: y},
            success: function (data) {

                $("#tb_opportunities tbody").html(data);

                $('#loader').slideUp(200, function () {
                    $(this).remove();
                });
            },
        });

    }
</script>

<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="row">
<!--h2 class="col-md-6"><strong>Opportunities</strong></h2--> 
        <div>
            <?php if (check_staff_permission('opportunities_write')) { ?> 
                <a  style="float:right;" href="<?php echo base_url('admin/opportunities/add/'); ?>" class="btn btn-primary btn-embossed"> Create New</a> 	
                <a href="<?php echo base_url('admin/opportunities/dashboard///'); ?>" class="btn btn-gray btn-embossed"> Dashboard</a> 	
				<a href="<?php echo base_url('admin/opportunities/'); ?>" class="btn btn-black btn-embossed"> Manage Opportunities</a> 					
                <!--a href="#" class="btn btn-gray btn-embossed"> FB Prospecting</a> 	
                <a href="#" class="btn btn-gray btn-embossed"> Telemarketing</a--> 	
            <?php } ?>
        </div>    
    </div>
    <div class="row">
        <div class="panel">
            <div class="panel-content">
                <div class="row">

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Choose Stages</label>
                            <div class="append-icon">
                                <input type="hidden" name="typePotensial" id="typePotensial">
                                <select name="stages_id" id="stages_id" class="form-control full" data-search="true" onChange="filter_opportunities()">
                                    <option value=""></option>
                                    <?php foreach ($allstatus as $status) { ?>
                                        <option value="<?php echo $status->system_code; ?>" <?php if ($lead->lead_status_id == $status->system_code) { ?> selected="selected"<?php } ?>><?php echo $status->system_value_txt; ?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Choose Time</label>

                            <div class="append-icon">
                                <input type="hidden" name="typePotensial" id="typePotensial">
                                <select name="filter_time" id="filter_time" class="form-control full" data-search="true"onChange="filter_opportunities()">
                                    <option value="all">All Opportunity</option>
                                    <option value="todays">Todays</option>
                                    <option value="weeks">This Weeks</option>
                                    <option value="month">This Month</option>
                                    <option value="quarter">This Quarter</option>
                                    <option value="year">This Year</option>

                                </select>
                            </div>
                        </div>
                    </div></div>
                <div class="panel-content pagination2 table-responsive">
                    <table class="table table-hover table-dynamic" id="tb_opportunities">
                        <thead>
                            <tr>
                                    <!--<th>Creation Date</th>-->
                                <th>Opportunity</th>
                                <!--<th>Lead Name</th>-->
                                <th>Amount</th>
                                <th>Stages</th>
                                <th>Sales Person</th>
                                <th>Account name</th>
                                <!--<th>Created Date</th>-->
                                <th>Created By</th>

                                <th><?php echo $this->lang->line('options'); ?></th>     
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($opportunities)) { ?>
                                <?php foreach ($opportunities as $opportunity) { ?>
                                    <tr id="opportunity_id_<?php echo $opportunity->id; ?>">
                                        <?php /* <td><?php echo date('d F Y g:i a',$opportunity->register_time); ?></td> */ ?>
                                        <td>
                                            <a href="<?php echo base_url('admin/opportunities/view/' . $opportunity->id); ?>"><?php echo $opportunity->opportunity; ?></a>
                                        </td>
<!--                                        <td>
                                            <?php echo $this->leads_model->get_lead_single($opportunity->lead_id)->lead_name; ?>
                                        </td>-->
                                        <td class="numeric"><?= ($opportunity->amount != null && $opportunity->amount != '' ? number_format($opportunity->amount, 2, '.', ',') : '') ?></td>										

                                        <td><?php echo $this->system_model->system_single_value('OPPORTUNITIES_STAGES', $opportunity->stages_id)->system_value_txt; ?> </td>

                                        <td><?php echo $this->staff_model->get_user($opportunity->salesperson_id)->first_name . " " . $this->staff_model->get_user($opportunity->salesperson_id)->last_name; ?></td> 
                                        <td><?php echo $this->customers_model->get_company($opportunity->customer_id)->name; ?>   </td>
                                        <!--<td><?php echo $opportunity->create_date; ?></td>-->
                                        <td><?php echo $opportunity->create_by; ?></td>
                                        <td style="width: 17%;" align="right">
                                            <?php
                                            $next_week = strtotime(date('m/d/Y', strtotime('+' . config('opportunities_reminder_days') . ' days')));

                                            $expiration_date = strtotime($opportunity->next_action);
                                            $today = strtotime(date('m/d/Y'));

                                            // $today = date('d-m-Y',time()); 
                                            // $exp = date('d-m-Y',strtotime($mc[0]->expiry_date)); //query result form database
                                            // $expDate =  date_create($exp);
                                            // $todayDate = date_create($today);
                                            // $diff =  date_diff($todayDate, $expDate);
                                            // if($diff->format("%R%a")>0){
                                            // echo "active";
                                            // }else{
                                            // echo "inactive";
                                            // }
                                            // echo "Remaining Days ".$diff->format("%R%a days");
                                            //echo "exp : ".$expiration_date." -  today : ".$today;
                                            if ($expiration_date < $today && $opportunity->closed_status == 0) {
                                                ?>
                                                <a href="#" class="edit btn btn-sm btn-warning dlt_sm_table" data-rel="tooltip" data-toggle="tooltip" data-placement="top" title="Opportunities has been expired"><i class="icon-info"></i></a>

        <?php } elseif ($expiration_date <= $next_week && $opportunity->closed_status == 0) { ?>

                                                <a href="#" class="edit btn btn-sm btn-dark dlt_sm_table" data-rel="tooltip" data-toggle="tooltip" data-placement="top" title="Opportunities will expire within the few days"><i class="icon-info"></i></a>

        <?php } elseif ($opportunity->closed_status != 0) { ?>
                                                <a href="#" class="edit btn btn-sm btn-success dlt_sm_table" data-rel="tooltip" data-toggle="tooltip" data-placement="top" title="Opportunities Closed"><i class="fa fa-check"></i></a>
                                            <?php } ?>

                                            <?php if (check_staff_permission('opportunities_write') && $opportunity->closed_status == 0) { ?>
                                                <a href="<?php echo base_url('admin/opportunities/update/' . $opportunity->id); ?>" class="edit btn btn-sm btn-default dlt_sm_table"><i class="icon-note"></i></a> 
                                            <?php } ?>

                                            <?php if (check_staff_permission('opportunities_delete')) { ?>
                                                            <a href="javascript:void(0)" class="delete btn btn-sm btn-danger dlt_sm_table" data-toggle="modal" data-target="#modal-basic<?php echo $opportunity->id; ?>"><i class="glyphicon glyphicon-trash"></i></a>
                                                        <?php } ?>
                                                </td> 
                                            </tr>
                                <div class="modal fade" id="modal-basic<?php echo $opportunity->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                <button type="button" onclick="delete_opportunities(<?php echo $opportunity->id; ?>)" class="btn btn-primary btn-embossed" data-dismiss="modal">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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