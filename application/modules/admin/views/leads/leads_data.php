<?php if (!empty($leads)) { ?>
    <?php foreach ($leads as $lead) { ?>
        <tr id="lead_id_<?php echo $lead->id; ?>">
            <td><a href="<?php echo base_url('admin/leads/view/' . $lead->id); ?>"><?php echo $lead->lead_name; ?></a></td>
            <td><?php echo $lead->company_name; ?>
                <?php if ($lead->company_name == null) { ?>
                    <?php echo $this->customers_model->get_customers($lead->customer_id)->first_name . " " . $this->customers_model->get_customers($lead->customer_id)->last_name; ?>

                <?php } ?>  
            </td>
            <td><?php echo $lead->email; ?></td>
            <td><?php echo $this->system_model->system_single_value('LEAD', $lead->lead_source_id)->system_value_txt; ?></td>
            <td><?php echo $this->staff_model->get_user($lead->salesperson_id)->first_name . " " . $this->staff_model->get_user($lead->salesperson_id)->last_name; ?></td>
                <td><?php echo $this->salesteams_model->get_salesteam($lead->sales_team_id)->salesteam; ?></td>	                        
            <td style="width: 12%;">
                <?php if (check_staff_permission('lead_write')) { ?> 
                    <a href="<?php echo base_url('admin/leads/update/' . $lead->id); ?>" class=" btn btn-sm btn-w btn-default btn-embossed dlt_sm_table"><i class="icon-note"></i></a>
                <?php } ?>

                <?php if (check_staff_permission('lead_delete')) { ?>
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-embossed dlt_sm_table" data-toggle="modal" data-target="#modal-basic<?php echo $lead->id; ?>"><i class="glyphicon glyphicon-trash"></i></a>
                <?php } ?>
            </td> 
        </tr>
        <div class="modal fade" id="modal-basic<?php echo $lead->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <button type="button" onclick="delete_leads(<?php echo $lead->id; ?>)" class="btn btn-primary btn-embossed" data-dismiss="modal">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?> 
