<div class="page-content">
    <div class="row">
<!--h2 class="col-md-6"><strong>Leads</strong></h2--> 
        <div>
            <?php if (check_staff_permission('lead_write')) { ?> 
                <a  style="float:right;" href="<?php echo base_url('admin/sms_api/api_form/'); ?>" class="btn btn-primary btn-embossed"> Create New</a> 	
                <!--<a href="<?php echo base_url('admin/leads/'); ?>" class="btn btn-black btn-embossed"> Manage Leads</a> 	
                <a href="#" class="btn btn-gray btn-embossed"> FB Prospecting</a> 	
                <a href="#" class="btn btn-gray btn-embossed"> Telemarketing</a> 	-->
            <?php } ?>
        </div>           
    </div>

    <div class="row">
        <div class="panel">
            <div class="panel-content">
                <!--<div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Choose Status</label>
                            <div class="append-icon">
                                <input type="hidden" name="typePotensial" id="typePotensial">
                                <select name="lead_status_id" id="lead_status_id" class="form-control full" data-search="true" onChange="filter_leads()">
                                    <option value=""></option>
                                <?php foreach ($allstatus as $status) { ?>
                                            <option value="<?php echo $status->system_value_txt; ?>" <?php if ($lead->lead_status_id == $status->system_code) { ?> selected="selected"<?php } ?>><?php echo $status->system_value_txt; ?></option>
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
                                <select name="filter_time" id="filter_time" class="form-control full" data-search="true"onChange="filter_leads()">
                                    <option value="all">All Leads</option>
                                    <option value="todays">Todays</option>
                                    <option value="weeks">This Weeks</option>
                                    <option value="month">This Month</option>
                                    <option value="quarter">This Quarter</option>
                                    <option value="year">This Year</option>

                                </select>
                            </div>
                        </div>
                    </div>-->

                </div>
                <!--<table class="table table-striped table-bordered table-hover"-->
                <div class="panel-content pagination2 table-responsive">
                    <table class="table table-hover" id="tbsmsapi">
                        <thead>
                            <tr>
                                <th>Gateway</th>
                                <th>Auth ID</th>
                                <th>Auth Token</th>
                                <th>API ID (if Clickatell)</th>
                                <th>Sender ID</th>
                                <!--<th>Remaining Credit</th>-->
                                <th>Status</th>
                                <th><?php echo $this->lang->line('options'); ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var datatable;
    $(document).ready(function()
    {
       datatable = $('#tbsmsapi').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo base_url('admin/sms_api/get_api') . '/'; ?>',
                type: "POST",
                data: function (d) {
                    //d.type = $("#lead_status_id").val(),
                    //d.time = $("#filter_time").val()
                }

            },
            columns: [
                {
                    data: "gateway_name",
                },
                {
                    data: "username_auth_id"
                },
                {
                    data: "password_auth_token"
                },
                {
                    data: "api_id"
                },
                {
                    data: "phone_number"
                },
                {
                    data: "status"
                },
                {
                    data: "act"
                }
            ]
        }); 
    });
</script>