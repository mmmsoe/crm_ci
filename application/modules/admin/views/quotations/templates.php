<script>
    var base_url_template = "<?php echo base_url() ?>uploads/words/";



    function modal_content(template_id, template_name, template_image, status)
    {
        $('#template_id').val(template_id);
        if (status == "1")
        {
            $('#btn_use').addClass('disabled');
            $('#btn_use').html('Already in use');
        } else
        {
            $('#btn_use').removeClass('disabled');
            $('#btn_use').html('Use');
        }
        $('#myModalLabel').empty();
        $('#myModalLabel').html(template_name);
        $('#modal_template .modal-dialog .modal-content .modal-body').empty();
        $('#modal_template .modal-dialog .modal-content .modal-body').append('<img src="' + base_url_template + template_image + '" width="100%"/>');
    }

    function get_templates()
    {
        $('#template_list').empty();
        $('#template_list').html('<img src="<?php echo base_url() ?>public/images/loading.gif"/>Loading templates list...');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/quotations/get_templates'); ?>",
            dataType: "json",
            success: function (data)
            {
                $('#template_list').empty();
                $.each(data.data, function (index, key) {
                    var html = "";

                    if (key.is_used == "1") {

                        var style = ' style="cursor:pointer; float:left; margin-left:5px; margin-right:5px; margin-top:5px; padding:5px; background-color:#ff9900;" ';
                    } else
                    {

                        var style = ' style="cursor:pointer; float:left; margin-left:5px; margin-right:5px; margin-top:5px; padding:5px;" ';
                    }

                    html += '<div data-toggle="modal" onClick="modal_content(\'' + key.id + '\',\'' + key.template_name + '\',\'' + key.template_screenshot + '\',\'' + key.is_used + '\')" data-target="#modal_template" class="template_pic" ' + style + '>';

                    html += '<img src="' + base_url_template + key.template_screenshot + '" width="150"/>';
                    html += '<div style="font-weight:bold; text-align:center;">' + key.template_name + '</div>';
                    html += '</div>'
                    $('#template_list').append(html);
                });

            }

        });
    }

    function delete_template() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/quotations/delete_template'); ?>",
            dataType: "json",
            data: {
                template_id: $('#template_id').val()
            },
            success: function (data)
            {
                $('#modal_template').modal('hide');
                get_templates();
            }
        });
    }

    function use_template()
    {
        $('#template_list').empty();
        $('#template_list').html('<img src="<?php echo base_url() ?>public/images/loading.gif"/>Saving selected template...');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/quotations/use_template'); ?>",
            dataType: "json",
            data: {
                template_id: $('#template_id').val()
            },
            success: function (data)
            {
                get_templates();
            }
        });
    }

    function submitForm() {
        var fd = new FormData(document.getElementById("fileinfo"));
        fd.append("label", "WEBUPLOAD");
        $('#output').html('<img src="<?php echo base_url() ?>public/images/loading.gif"/>&nbsp; Please wait while system updating your database');
        $.ajax({
            url: "<?php echo base_url() ?>admin/quotations/do_upload",
            type: "POST",
            data: fd,
            processData: false,
            contentType: false
        }).done(function (data) {
            console.log(data);
            $('#output').text(data);
            if (data == "Upload Finished")
            {
                setTimeout(
                        function () {
                            $("#fileinfo").get(0).reset();
                            get_templates();
                        },
                        100);
            }
        });
        return false;
    }

    function delete_file() {

    }

    $(document).ready(function ()
    {
        get_templates();

        $('#btn_use').click(function ()
        {
            use_template();

        });

        $('#btn_delete').click(function ()
        {
            delete_template();

        });
    });
</script>
<input type="hidden" id="template_id" />
<div class="page-content">
     <div class="row">
        <div>
            <?php if (check_staff_permission('quotations_write')) { ?>
                <a style="float:right;" href="<?php echo base_url('admin/quotations/add/'); ?>" class="btn btn-primary btn-embossed"> Create New</a> 
                <a href="<?php echo base_url('admin/quotations/templates'); ?>" class="btn btn-black btn-embossed"> Quotations Templates</a> 	
                <a href="<?php echo base_url('admin/quotations/'); ?>" class="btn btn-gray btn-embossed"> Manage Quotations</a> 	
            <?php } ?>	
        </div>           
    </div>
    <div class="row">
        <div class="panel">
            <div class="panel-heading"><h3>Upload new template</h3></div>
            <div class="panel-body">
                <form method="post" id="fileinfo" enctype="multipart/form-data" name="fileinfo" onsubmit="return submitForm();">
                    <div class="row" style="margin-bottom:10px;"> 
                        <div class="col-lg-6">
                            <label>Template Name:</label><br>
                            <input type="text" name="template_name" required />
                        </div>
                        <div class="col-lg-6">

                        </div>
                    </div>
                    <div class="row" style="margin-bottom:10px;">
                        <div class="col-lg-6">
                            <label>Select .docx file:</label><br>
                            <input type="file" name="file" accept=".docx,.DOCX" required />
                        </div>
                        <div class="col-lg-6">
                            <label>Select screenshot file:</label><br>
                            <input type="file" name="file2" accept=".jpg,.JPG" required />
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:10px;">
                        <div class="col-lg-6"><input type="submit" value="Upload" /></div>
                        <div class="col-lg-6"></div>
                    </div>
                    <div id="output"></div>
                </form>
            </div>

        </div>
    </div>
    <div class="row">

        <div class="panel">

            <div class="panel-heading"><h3>Templates for Words Document Generator</h3></div>
            <div class="panel-body">
                <div id="template_list">

                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="panel">

            <div class="panel-heading"><h3>Download Words Templates </h3></div>
            <div class="panel-body" style="text-transform: uppercase;">

                <a href="<?php echo base_url() ?>uploads/words/template/sales_quotation_template.docx" >
                    <img src="<?php echo base_url() ?>public/assets/global/images/logo/Microsoft_Word_logo.png" width="5%"/>
                    Word Template
                </a>
            </div>
        </div>
    </div>


</div>


<div class="modal fade" id="modal_template" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width:800px;">
        <div class="modal-content">
            <div class="modal-header">

                <button style="float:right;" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button style="float:right;" type="button" class="btn btn-danger" id="btn_delete">Delete</button>
                <button style="float:right;" type="button" id="btn_use" class="btn btn-primary disabled"  data-dismiss="modal"></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
