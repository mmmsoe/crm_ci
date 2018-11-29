<script>

    function change_status(id)
    {

        $.ajax({
            type: "GET",
            url: "<?php echo base_url('admin/tickets/change_Status'); ?>/" + id,
            success: function (msg) {
                $('body,html').animate({scrollTop: 0}, 200);
                $("#tickets_ajax").html(msg);
                //$("#tickets_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');

                //$("form[name='add_tickets']").find("input[type=text],select,textarea").val("");
                window.location = "<?php echo base_url('admin/tickets'); ?>";

                //table.ajax.reload(null,false); //reload datatable ajax 



            }

        });

    }
	function delete_tickets(id)
    {

        $.ajax({
            type: "GET",
            url: "<?php echo base_url('admin/tickets/delete_tickets'); ?>/" + id,
            success: function (msg) {
                $('body,html').animate({scrollTop: 0}, 200);
               // $("#tickets_ajax").html(msg);
                //$("#tickets_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');

                //$("form[name='add_tickets']").find("input[type=text],select,textarea").val("");
                window.location = "<?php echo base_url('admin/tickets'); ?>";

                //table.ajax.reload(null,false); //reload datatable ajax 
            }

        });

    }

</script>
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="row">
        <h2 class="col-md-6"><strong>Tickets</strong></h2> 
        <div style="float:right; padding-top:10px;">
            <a href="<?php echo base_url('admin/tickets/ticket_categories'); ?>" class="btn btn-primary btn-embossed"> Ticket Categories</a>
            <a href="<?php echo base_url('admin/tickets/add'); ?>" class="btn btn-success btn-embossed"> New tickets</a> 	
        </div>           
    </div>
    <div class="row">
        <div class="panel">				
            <div class="panel-content">

                <div id="tickets_ajax"> 
                    <?php if ($this->session->flashdata('message')) {
                        echo $this->session->flashdata('message');
                    } ?>         
                </div>

                <div class="panel-content pagination2 table-responsive">

                    <table class="table table-hover table-dynamic filter-between_date">
                        <thead>
                            <tr>                        
                                <th>subject</th>                             
                                <th>customer_name</th> 
                                <th>category</th> 
                                <th>priority</th> 
                                <th>status</th> 

                                <th><?php echo $this->lang->line('options'); ?></th>     
                            </tr>
                        </thead>
                        <tbody>

<?php if (!empty($ticket)) { ?>
    <?php foreach ($ticket as $tickets) { ?>
                                    <tr id="tickets_id_<?php echo $tickets->id; ?>">


                                        <td><a href="<?php echo base_url('admin/tickets/view/' . $tickets->id); ?>"><?php echo $tickets->subject; ?></td>
                                        <td><?php echo $tickets->name; ?></td>
                                        <td><?php echo $tickets->categories;//$this->system_model->system_single_value('TICKET_CAT', $tickets->category)->system_value_txt; ?></td>

                                        <td><?php echo $this->system_model->system_single_value('TICKET_PRIORITY', $tickets->priority)->system_value_txt; ?></td>
                                        <td><?php echo $tickets->status; ?></td>

                                        <td style="width: 12%;">
                                            <?php if ($tickets->status != "Close") { ?>
                                                <a href="javascript:void(0)" class="delete btn btn-sm btn-danger dlt_sm_table" data-toggle="modal" data-target="#modal-basic<?php echo $tickets->id; ?>">close</a>
											<?php } ?>								
											
											<?php if(userdata('role_id') == 1){?>
												<a href="javascript:void(0)" class="delete btn btn-sm btn-danger dlt_sm_table" data-toggle="modal" data-target="#modal-basicdua<?php echo $tickets->id; ?>">delete</a>
											<?php }?>
                                        </td> 
                                    </tr>
                                <div class="modal fade" id="modal-basic<?php echo $tickets->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                                                <h4 class="modal-title"><strong>Confirm</strong></h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to close this ticket?<br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default btn-embossed" data-dismiss="modal">Cancel</button>
                                                <button type="button" onclick="change_status(<?php echo $tickets->id; ?>)" class="btn btn-primary btn-embossed" data-dismiss="modal">close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
								<div class="modal fade" id="modal-basicdua<?php echo $tickets->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                                                <h4 class="modal-title"><strong>Confirm</strong></h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this ticket?<br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default btn-embossed" data-dismiss="modal">Cancel</button>
                                                <button type="button" onclick="delete_tickets(<?php echo $tickets->id; ?>)" class="btn btn-primary btn-embossed" data-dismiss="modal">delete</button>
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
