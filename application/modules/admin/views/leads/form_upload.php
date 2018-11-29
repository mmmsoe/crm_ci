<script>
    function submitForm() {
        $('#result').empty();
        var fd = new FormData(document.getElementById("fileinfo"));
        fd.append("label", "WEBUPLOAD");
        $('#output').html('<img src="<?php echo base_url() ?>public/images/loading.gif"/>&nbsp; Please wait while system updating your database');
        $.ajax({
            url: "<?php echo base_url() ?>admin/leads/do_upload",
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            dataType:'json',
        }).done(function (data) {
            
            if(data.result=="Upload Finished")
            {
                $("#fileinfo").get(0).reset();
                $('#output').text("");
            }
            $.each(data.data, function(key, val){
                var color = "";
                if(val.type=="E")
                {
                    color="#ff0000";
                }
                else
                {
                    color="#0f9d58";
                }
                $('#result').append('<font color="'+color+'">'+val.seq_no+' : '+val.message+'</font><br/>');
            });
            /*console.log(data);
            $('#output').text(data);
            if (data == "Upload Finished")
            {
                setTimeout(
                        function () {
                            $("#fileinfo").get(0).reset();
                            //get_templates();
                        },
                        100);
            }*/
        });
        return false;
    }



    $(document).ready(function ()
    {

    });
</script>
<input type="hidden" id="template_id" />
<div class="page-content">
    <div class="row">

    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="panel">
                <div class="panel-heading"><h3>Upload leads data</h3></div>
                <div class="panel-body">
                    <form method="post" id="fileinfo" enctype="multipart/form-data" name="fileinfo" onsubmit="return submitForm();">
                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-lg-6">
                                <label>Select .csv file:</label><br>
                                <input type="file" name="file" accept=".csv,.CSV" required />
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-lg-6"><input type="submit" value="Upload" /></div>
                            <div class="col-lg-6"></div>
                        </div>
                        <div>
                            <a href="<?php echo base_url()?>uploads/words/template/csv/leads.csv">Download template</a>
                        </div>
                        <div id="output"></div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="panel">
                <div class="panel-heading"><h3>Results</h3></div>
                <div class="panel-body" id="result">
                    
                </div>
            </div>
        </div>
    </div>
</div>