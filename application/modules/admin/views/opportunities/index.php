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
                    <table class="table table-hover" id="tb_opportunities">
                        <thead>
                            <tr>
                                    <!--<th>Creation Date</th>-->
                                <th style="width: 150px;">Opportunity</th>
                                <!--<th>Lead Name</th>-->
                                <th>Amount</th>
                                <th>Stages</th>
                                <th>Sales Person</th>
                                <th style="width: 200px;">Account name</th>
                                <!--<th>Created Date</th>-->
                                <!--<th>Created By</th>-->

                                <th><?php echo $this->lang->line('options'); ?></th>     
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="opportunities_id" />
<div class="modal fade" id="modal-basic" tabindex="-1" role="dialog" aria-hidden="true">
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
                <button type="button" onclick="delete_opportunities()" class="btn btn-primary btn-embossed" data-dismiss="modal">Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT -->


<script>
    var datatable;
    $(document).ready(function () {
        datatable = $('#tb_opportunities').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo base_url('admin/opportunities/getfilter') . '/'; ?>',
                type: "POST",
                dataType: 'json',
                data: function (d) {
                    d.stage_id = $("#stages_id").val(),
                            d.time = $("#filter_time").val()
                }

            },
            columns: [
                {
                    data: "opportunity",
                },
                /*{
                    data: "lead_name"
                },*/
                {
                    data: "amount"
                },
                {
                    data: "stage"
                },
                {
                    data: "sales_person"
                },
                {
                    data: "company_name"
                },
                /*
				{
                    data: "create_by"
                },
				*/
                {
                    data: "act"
                }
            ]
        });


    });

    function filter_opportunities() {
        datatable.api().ajax.reload();
    }

    function setid(id)
    {
        $('#opportunities_id').val(id);
    }
    function delete_opportunities(opportunity_id)
    {
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('admin/opportunities/delete'); ?>/" + $('#opportunities_id').val(),
            success: function (msg)
            {
                if (msg == 'deleted')
                {
                    datatable.api().ajax.reload();
                }
            }
        });
    }
</script>