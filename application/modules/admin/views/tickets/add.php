<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

    $(document).ready(function () {

        $("form[name='add_tickets']").submit(function (e) {
            var formData = new FormData($(this)[0]);

            $.ajax({
                url: "<?php echo base_url('admin/tickets/add_process'); ?>",
                type: "POST",
                data: formData,
                async: false,
                success: function (msg) {
                    $('body,html').animate({scrollTop: 0}, 200);
                    $("#tickets_ajax").html(msg);
                    //$("#tickets_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');

                    $("form[name='add_tickets']").find("input[type=text],select,textarea").val("");
                    window.location = "<?php echo base_url('admin/tickets'); ?>";

               },
                cache: false,
                contentType: false,
                processData: false
            });

            e.preventDefault();
        });
    });

</script>

<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="row">
        <h2 class="col-md-6"><strong>New Tickets</strong></h2>
    </div>
    <div class="row">

        <div class="panel">

            <div class="panel-content">
                <div id="tickets_ajax"> 
                    <?php if ($this->session->flashdata('message')) {
                        echo $this->session->flashdata('message');
                    } ?>         
                </div>
                <h3> Tickets Information </h3>
                <form id="add_tickets" name="add_tickets" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">


                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Customer name</label>
                                <div class="append-icon">
                                    <h1><?php echo userdata("first_name"); ?></h1>
                                    <input class="form-control" name="customer_id" type="hidden" value="<?php echo userdata('id'); ?>"></input>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">	

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Priority</label>
                                <div class="append-icon">
                                    <select name="ticket_priority" class="form-control" >
                                        <option value="">Select Priority</option>
                                        <?php foreach ($ticket_priority as $priority) { ?>
                                            <?php if ($priority->system_value_txt != '') { ?>
                                                <option value="<?php echo $priority->system_code; ?>" ><?php echo $priority->system_value_txt; ?></option>
    <?php } ?> 
<?php } ?> 
                                    </select> </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Category</label>
                                <div class="append-icon">
                                    <select name="ticket_category" class="form-control" >
                                        <option value="" selected="selected">Select Category</option>
                                        <?php foreach ($ticket_cat as $cat) { ?>
                                            <?php //if ($cat->system_value_txt !=''){ ?>
                                            <option value="<?php echo $cat->ticket_category_id; ?>" ><?php echo $cat->ticket_category_name; ?></option>
    <?php //} ?> 
<?php } ?> 
                                    </select> </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Subject</label>
                                <div class="append-icon">
                                    <input type="text" name="ticket_subject" class="form-control" value=""></input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <div class="append-icon">
                                    <textarea name="ticket_description" class="form-control" value=""></textarea>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="text-left  m-t-20">
                        <div id="tickets_submitbutton"><button type="submit" class="btn btn-embossed btn-primary">Create</button></div>

                    </div>
                </form>             

            </div>
        </div>

    </div>

</div>   
<!-- END PAGE CONTENT -->

