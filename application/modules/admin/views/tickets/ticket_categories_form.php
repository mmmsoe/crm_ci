

<div class="page-content">
    <div class="header">
        <h2><strong><?php echo $title; ?></strong></h2>            
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel">

                <div class="panel-content">
                    <div id="message"> 

                    </div>

                    <form id="form_category" name="form_category" method="post">

                        <input type="hidden" id="ticket_category_id" name="ticket_category_id" value="<?php echo $this->uri->segment(4); ?>"/>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" style="color:red;">* Category Name</label>
                                    <div class="append-icon">
                                        <input type="text" id="ticket_category_name" name="ticket_category_name" value="<?php echo $ticket_category_name; ?>" class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="text-left  m-t-20">
                            <div id="category_submit"><button type="submit" class="btn btn-embossed btn-primary"><?php echo $submit; ?></button></div>
                        </div>
                    </form>             

                </div>
            </div>
        </div>
    </div>

</div>   
<!-- END PAGE CONTENT -->

<script>

    $(document).ready(function () {
        $("#form_category").submit(function (e) {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('admin/tickets/save_categories'); ?>',
                dataType: 'json',
                data: {
                    ticket_category_id: $('#ticket_category_id').val(),
                    ticket_category_name: $('#ticket_category_name').val()
                },
                success: function (data) {

                    $('#message').html(data.message);
                    if (data.result == "success")
                    {
                        setTimeout(function () {
                            window.location = '<?php echo base_url('admin/tickets/ticket_categories'); ?>';
                        }, 2000);
                    }

                },
            });
            e.preventDefault();
        });
    });
</script>