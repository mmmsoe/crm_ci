<?php if (!empty($opportunities)) { ?>
    <?php foreach ($opportunities as $opportunity) { ?>
        <tr id="opportunity_id_<?php echo $opportunity->id; ?>">
            <?php /* <td><?php echo date('d F Y g:i a',$opportunity->register_time); ?></td> */ ?>
            <td>
                <a href="<?php echo base_url('admin/opportunities/view/' . $opportunity->id); ?>"><?php echo $opportunity->opportunity; ?></a>
            </td>
            <td>
                <?php echo $this->leads_model->get_lead_single($opportunity->lead_id)->lead_name; ?>
            </td>
            <td class="numeric"><?= ($opportunity->amount != null && $opportunity->amount != '' ? number_format($opportunity->amount, 2, '.', ',') : '') ?></td>										

            <td><?php echo $this->system_model->system_single_value('OPPORTUNITIES_STAGES', $opportunity->stages_id)->system_value_txt; ?> </td>

            <td><?php echo $this->staff_model->get_user($opportunity->salesperson_id)->first_name . " " . $this->staff_model->get_user($opportunity->salesperson_id)->last_name; ?></td> 
            <td><?php echo $this->customers_model->get_company($opportunity->customer_id)->name; ?>   </td>

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
                    <a href="<?php echo base_url('admin/opportunities/update/' . $opportunity->id . '/' . $opportunity->lead_id); ?>" class="edit btn btn-sm btn-default dlt_sm_table"><i class="icon-note"></i></a> 
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