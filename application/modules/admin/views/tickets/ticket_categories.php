

<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="row">
        <h2 class="col-md-6"><strong>Tickets</strong></h2> 
        <div style="float:right; padding-top:10px;">
            <a href="<?php echo base_url('admin/tickets/categories_form'); ?>" class="btn btn-primary btn-embossed"> Add Category</a>
            <a href="<?php echo base_url('admin/tickets/add'); ?>" class="btn btn-success btn-embossed"> New tickets</a> 	
        </div>           
    </div>

    <div class="row">
        <div class="panel">
            <div class="panel-content">

 <!--<table class="table table-striped table-bordered table-hover"-->
                <div class="panel-content pagination2 table-responsive">
                    <table class="table table-hover" id="tbticket_categories">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th style="width:18%;">Options</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="ticket_category_id" />
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
                <button type="button" onclick="delete_cats()" class="btn btn-primary btn-embossed" data-dismiss="modal">Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT -->
<script>
    var datatable;


    $(document).ready(function () {
        datatable = $('#tbticket_categories').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo base_url('admin/tickets/get_filter_categories') . '/'; ?>',
                type: "POST",
                dataType: 'json',
                data: function (d) {

                }
            },
            columns: [
                {
                    data: "ticket_category_name"
                },
                {
                    data: "act"
                }
            ]
        });


    });

    function setCatId(id)
    {
        $('#ticket_category_id').val(id);
    }

    function delete_cats()
    {
        var id = $('#ticket_category_id').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/tickets/delete_ticket_category'); ?>/",
            data: {
                ticket_category_id: id
            },
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