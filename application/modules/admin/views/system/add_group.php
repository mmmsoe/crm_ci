<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $("form[name='add_systems']").submit(function (e) {
            var formData = new FormData($(this)[0]);
            var reUrl = "<?php echo base_url('admin/systems/save_group'); ?>";
            $.ajax({
                url: reUrl,
                type: "POST",
                data: formData,
                async: false,
                success: function (msg) {

                    var str = msg.split("_");
                    var id = str[1];
                    var status = str[0];

                    if (status == "yes")
                    {
                        $('body,html').animate({scrollTop: 0}, 200);
                        if (id == 'add') {
                            $("#systems_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('create_succesful') . '</div>' ?>');
                        } else if (id == 'update') {
                            $("#systems_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('update_succesful') . '</div>' ?>');
                        }
                        setTimeout(function () {
                            window.location.href = "<?php echo base_url('admin/systems'); ?>";
                        }, 800); //will call the function after 1 secs.
                    } else
                    {
                        $('body,html').animate({scrollTop: 0}, 200);
                        $("#systems_ajax").html(msg);
                        $("#systems_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');
                        //$("form[name='add_systems']").find("input[type=text], textarea").val("");
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

            e.preventDefault();
        });
    });

    //Modal Open and Close
    function model_hide_show(name)
    {
        if (name == "group")
        {
            $("#modal-create_group").modal("show").addClass("fade");
        }
    }
</script>

<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="header">
        <h2><strong><?php echo $processState; ?> Group System</strong></h2>            
    </div>
    <div class="row">
        <div class="panel">
            <div class="panel-content">
                <div id="systems_ajax"> 
                    <?php
                    if ($this->session->flashdata('message')) {
                        echo $this->session->flashdata('message');
                    }
                    ?>         
                </div>
                <form id="add_systems" name="add_systems" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                    <input type="hidden" id="system_id" name="system_id" value="<?php echo $system->system_code; ?>"/>
                    <input type="hidden" id="system_old_type" name="system_old_type" value="<?php echo $system->system_type; ?>"/>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" style="color:red;margin-bottom: 8px;">* Group Name</label>
                                <div class="append-icon">
                                    <input type="text" name="system_type" id="system_type" class="form-control" value="<?php echo $system->system_value_txt; ?>"> 
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" style="margin-bottom: 8px;">Descrption</label>
                                <div class="append-icon">
                                    <textarea name="system_desc" id="system_desc" class="form-control"></textarea>
                                    <!--input type="text" name="system_name" id="system_name" class="form-control" value="<?php echo $system->system_value_txt; ?>"--> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-left  m-t-20">
                        <div id="systems_submitbutton" class="modal-footer text-center">
                            <button type="submit" class="btn btn-embossed btn-primary"><?php echo $processButton; ?></button>
                        </div>
                    </div>
                </form>              
            </div>
        </div>
    </div>
</div>   
<!-- END PAGE CONTENT -->