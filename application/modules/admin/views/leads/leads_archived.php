

<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="row">
<!--h2 class="col-md-6"><strong>Leads</strong></h2--> 
        <div>
            <?php if (check_staff_permission('lead_write')) { ?> 
				<a  style="float:right;" href="<?php echo base_url('admin/leads/add/'); ?>" class="btn btn-primary btn-embossed"> Create New</a> 	
                <a  style="float:right;" href="<?php echo base_url('admin/leads/'); ?>" class="btn btn-success btn-embossed">All Leads</a>
				
				<a href="<?php echo base_url('admin/leads/'); ?>" class="btn btn-black btn-embossed"> Manage Archive Leads</a> 	
               <!-- <a href="#" class="btn btn-gray btn-embossed"> FB Prospecting</a> 	
                <a href="#" class="btn btn-gray btn-embossed"> Telemarketing</a> 	-->
            <?php } ?>
        </div>           
    </div>
	<input type="hidden" name="archive" id="archive" value="Not Interested">
    <div class="row">
        <div class="panel">
            <div class="panel-content">
                <div class="row">
                   <!-- <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Choose Status</label>
                            <div class="append-icon">
                                <input type="hidden" name="typePotensial" id="typePotensial">
                                <select name="lead_status_id" id="lead_status_id" class="form-control full" data-search="true" onChange="filter_leads()">
                                    <option value=""></option>
                                    <?php foreach ($allstatus as $status) { ?>
                                        <option value="<?php echo $status->system_code; ?>"> <?php echo $status->system_value_txt; ?></option>
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
                                <select name="filter_time" id="filter_time" class="form-control full" data-search="true" onChange="filter_leads()">
                                    <option value="all">All Leads</option>
                                    <option value="todays">Todays</option>
                                    <option value="weeks">This Weeks</option>
                                    <option value="month">This Month</option>
                                    <option value="quarter">This Quarter</option>
                                    <option value="year">This Year</option>

                                </select>
                            </div>
                        </div>
                    </div> -->

                </div>
                <!--<table class="table table-striped table-bordered table-hover"-->
                <div class="panel-content pagination2 table-responsive">
                    <table class="table table-hover" id="tbleads">
                        <thead>
                            <tr>
                                <th>Lead Name</th>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Campaign Source</th>
                                <th>Sales</th>
                                <th>Created Date</th> 
                                <th>Created By</th>
                                <th style="width:18%;"><?php echo $this->lang->line('options'); ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="lead_id" />
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
                <button type="button" onclick="delete_leads()" class="btn btn-primary btn-embossed" data-dismiss="modal">Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT -->
<script>
    var datatable;
    $(document).ready(function () {
        $("#filter_time option[value='all']").prop("selected", true);
        $("#archive").prop("selected", true);
        x = $("#lead_status_id").val();
        y = $("#filter_time").val();
        z = $("#archive").val();
        datatable = $('#tbleads').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo base_url('admin/leads/get_filter') . '/'; ?>',
                type: "POST",
                dataType:'json',
                data: function (d) {
                    d.type = $("#lead_status_id").val(),
                    d.time = $("#filter_time").val(),
                    d.archived = '<?php echo $this->uri->segment(3) ?>'
                }

            },
            columns: [
                {
                    data: "lead_name",
                },
                {
                    data: "company_name"
                },
                {
                    data: "email"
                },
                {
                    data: "campaign_name"
                },
                {
                    data: "sales"
                },
                {
                    data: "create_date"
                },
                {
                    data: "create_by"
                },
                {
                    data: "act"
                }
            ]
        });


    });

    function delete_leads()
    {
        var lead_id = $('#lead_id').val();
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('admin/leads/delete'); ?>/" + lead_id,
            success: function (msg)
            {
                if (msg == 'deleted')
                {
                    $('#lead_id_' + lead_id).fadeOut('normal');
                }
                datatable.api().ajax.reload();
            }
        });
    }

    function setLeadId(id)
    {
        $('#lead_id').val(id);

    }
    function filter_leads() {
        datatable.api().ajax.reload();
    }

    function buildSearchData() {
        console.log($("#filter_time").val());
        var obj = {
            type: $("#lead_status_id").val(), time: $("#filter_time").val()
        };
        console.log(obj);
        return obj;

    }


    /*
     function filter_leads() {
     var x = document.getElementById("lead_status_id").value;
     var y = document.getElementById("filter_time").value;
     $.ajax({
     type: "POST",
     url: '<?php echo base_url('admin/leads/get_filter') . '/'; ?>',
     data: {type: x, time: y},
     success: function (data) {
     
     $("#tbleads tbody").html(data);
     
     $('#loader').slideUp(200, function () {
     $(this).remove();
     });
     },
     });
     
     }*/

</script>