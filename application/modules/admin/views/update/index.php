<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
    <div class="row">

    </div>
    <div class="row">
        <div class="panel">
            <div class="panel-content">
                <div class="panel-content pagination2 table-responsive">
                    <h1>Application Update</h1>
                    <hr />

                    <form method="post" id="fileinfo" enctype="multipart/form-data" name="fileinfo" onsubmit="return submitForm();">
                        <label>Select a file:</label><br>
                        <input type="file" name="file" accept=".zip,.ZIP" required />
                        <br>
                        <input type="submit" value="Start Update" />
                    </form>
                    <br>

                    <div id="output"></div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTENT -->
<script type="text/javascript">
    function submitForm() {
        //console.log("submit event");

        var fd = new FormData(document.getElementById("fileinfo"));
        fd.append("label", "WEBUPLOAD");
        $('#output').html('<img src="<?php echo base_url() ?>public/images/loading.gif"/>&nbsp; Please wait while system updating your application');
        $.ajax({
            url: "update/do_upload",
            type: "POST",
            data: fd,
            processData: false, // tell jQuery not to process the data
            contentType: false   // tell jQuery not to set contentType
        }).done(function (data) {
            console.log("PHP Output:");
            console.log(data);

            $('#output').text(data);
            if (data == "Update Finished")
            {
                setTimeout(
                        function () {
                            window.location = "<?php echo base_url() ?>admin/dashboard";
                        },
                        100);
            }
        });
        return false;
    }


</script>