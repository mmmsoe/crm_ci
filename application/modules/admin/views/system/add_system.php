<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.3/js/bootstrap-colorpicker.min.js"></script>  

<script>
    $(document).ready(function () {
        $('#color_pic').colorpicker({
            format: "hex"
        });
        $('#system_type').on('change', function () {
            if (this.value == 'TAGS' || this.value == 'OPPORTUNITIES_STAGES') {
                document.getElementById("class_color").style.display = "inline";
                document.getElementById("class_email").style.display = "none";
            } else if (this.value == 'EMAIL_TYPE') {
                document.getElementById("class_color").style.display = "none";
                document.getElementById("class_email").style.display = "inline";
            } else {
                document.getElementById("class_color").style.display = "none";
                document.getElementById("class_email").style.display = "none";
            }
        });

        $("form[name='add_systems']").submit(function (e) {
            var formData = new FormData($(this)[0]);
            var reUrl = "<?php echo base_url('admin/systems/add_process'); ?>";
            var system_id = $("#system_id").val();
            var system_type = $('#system_type option:selected').val();
            if (system_id != '' && system_id != null) {
                reUrl = "<?php echo base_url('admin/systems/update_process'); ?>";
            }
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
                            window.location.href = "<?php echo base_url('admin/systems/list_system'); ?>/" + system_type;
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
</script>

<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="header">
        <h2><strong><?php echo $processState; ?> System </strong></h2>            
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
                    <input type="hidden" id="system_id" name="system_id" value="<?php if (isset($system->system_code)){echo $system->system_code;} ?>"/>
                    <input type="hidden" id="system_old_type" name="system_old_type" value="<?php if (isset($system->system_type)){echo $system->system_type;} ?>"/>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" style="color:red;">* Type</label>
                                <div class="form-group">
                                    <select name="system_type" id='system_type' class="form-control" style="margin-top: 3px;" <?php if (isset($system->system_code) and ($processState != 'Update')) { ?> disabled <?php } ?>>
                                        <?php if (!empty($system_types)) { ?>
                                            <?php foreach ($system_types as $system_type) { ?>                                                 
                                                <option value="<?php echo $system_type->system_type; ?>" <?php if ($system_old == $system_type->system_type) { ?> selected <?php } else if (isset($system->system_type) and ($system->system_type == $system_type->system_type)) { ?> selected <?php } ?> ><?php echo str_replace('_', ' ', $system_type->system_type); ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" style="color:red;margin-bottom: 8px;">* Name</label>
                                <div class="append-icon">
                                    <input type="text" name="system_name" id="system_name" class="form-control" value="<?php if(isset($system->system_value_txt)){echo $system->system_value_txt;} ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6" style='display:none;'>
                            <div class="form-group">
                                <label class="control-label" style="color:red;">* Code</label>
                                <div class="append-icon">
                                    <input type="text" name="system_code" id="system_code" class="form-control" value="<?php if(isset($system->system_code)){echo $system->system_code;} ?>" <?php if (isset($system->system_code)) { ?> disabled <?php } ?>> 
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" style="color:red;">* Sequence Number</label>
                                <div class="append-icon">
                                    <input type="text" name="system_number" id="system_number" class="form-control numeric" value="<?php if(isset($system->system_value_num)){echo $system->system_value_num;} ?>" > 
                                </div>
                            </div>
                        </div>
                        <?php
                        $col = "";
                        if (isset($system->system_type) and ($system->system_type == '')) {
                            $col = $system_old;
                        } elseif (isset($system->system_type)) {
                            $col = $system->system_type;
                        }

                        if ($col == 'TAGS' || $col == 'OPPORTUNITIES_STAGES') {
                            $cls = "";
                        } else {
                            $cls = "none";
                        };
                        
                        ?>


                        <div class="col-sm-6" id='class_color' style='display:<?php echo $cls;?>'>
                            <div class="form-group">
                                <label class="control-label" style="color:red;margin-bottom: 8px;">* Color Picker</label>
                                <div class="append-icon">
                                    <input type="text" name="color_pic" id="color_pic" class="form-control" value="<?php echo isset($system->status) ? $system->status:""; ?>"> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id='class_email' style='display:<?php echo ($system->system_type == "" ? $system_old : $system->system_type) == "EMAIL_TYPE" ? "hidden" : "none"; ?>;'>
                            <div class="form-group">
                                <label class="control-label" style="color:red;margin-bottom: 8px;">* Email Code</label>
                                <div class="append-icon">
                                    <input type="text" name="email_type" id="email_type" class="form-control" value="<?php if(isset($system->status)){echo $system->status;} ?>"> 
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- MM -->
                     <div class="row">     
                       <?php
                        $col = "";
                        if (isset($system->system_type) and ($system->system_type == '')) {
                            $col = $system_old;
                        } elseif (isset($system->system_type)) {
                            $col = $system->system_type;
                        }

                        if ($system_old = 'OPPORTUNITIES_STAGES'|| $col == 'OPPORTUNITIES_STAGES') {
                            $cls = "";
                        } else {
                            $cls = "none";
                        };
                        
                        ?> 
                                    
                        <div class="col-sm-6" style='display:<?php echo $cls;?>'>
                            <div class="form-group">
                                <label class="control-label" style="margin-bottom: 8px;">Percentage</label>
                                <div class="append-icon">
                                    <input type="text" name="percentage" id="percentage" class="form-control" value="<?php if(isset($system->percentage)){echo $system->percentage;} ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- MM -->
                     
                    <div class="text-left  m-t-20">
                        <div id="systems_submitbutton">
                            <button type="submit" class="btn btn-embossed btn-primary"><?php echo $processButton; ?></button>
                        </div>
                    </div>
                </form>             
            </div>
        </div>
    </div>
</div>   
<!-- END PAGE CONTENT -->
