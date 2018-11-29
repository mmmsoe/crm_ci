
<div class="page-content">
    <div class="header">
        <h2><strong><?php echo $processState; ?> SMS</strong></h2>            
    </div>
    <div class="row">
        <div class="panel">
            <div class="panel-content">
                <div id="contact_person_ajax"> 
                    <?php
                    if ($this->session->flashdata('message')) {
                        echo $this->session->flashdata('message');
                    }
                    ?>         
                </div>
                <form name="sms_api" class="form-validation" accept-charset="utf-8" method="post">

                    <div class="row">
                        <h3 class="pad-l clearMar-t">SMS</h3>
                        <hr /><div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">To</label>
                                <div class="append-icon">
                                    <input type="text" name="to" id="to" class="form-control full-break clearRad-l"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Message</label>
                                <div class="append-icon">
                                    <input type="text" name="message" id="message" class="form-control full-break clearRad-l"/>
                                </div>
                            </div>
                        </div>
                    </div>   
                    <div class="row">
                        <h3 class="pad-l clearMar-t">Config</h3>
                        <hr /><div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Select API</label>
                                <div class="append-icon">
                                    <select name="api" class="form-control" data-search="true">
                                        <option value=""></option>
                                        <?php foreach ($api_list as $l): ?>
                                            <option value="<?php echo $l->id ?>"><?php echo $l->gateway_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                        
                            </div>
                        </div>
                        
                    </div> 
                    <div id="response">
                    </div>
                    <div class="text-left  m-t-20">
                        <div id="sms_api_submitbutton"><button type="submit" class="btn btn-embossed btn-primary"><?php echo $processState; ?></button></div>
                    </div>
                </form>             
            </div>
        </div>
    </div>
</div>   


<script>
    $(document).ready(function () {
        $("form[name='sms_api']").submit(function (e) {
            $('#response').html('<img src="<?php echo base_url() ?>public/images/loading.gif"/>&nbsp; sending sms..');
            var formData = new FormData($(this)[0]);

            $.ajax({
                url: "<?php echo base_url('admin/send_sms/send'); ?>",
                type: "POST",
                data: formData,
                async: false,
                success: function (msg) {
                    console.log(msg);
                    //window.location = '<?php echo base_url('admin/sms_api'); ?>';
                    $('#response').html(msg);

                },
                cache: false,
                contentType: false,
                processData: false
            });

            e.preventDefault();
        });
    });
</script>