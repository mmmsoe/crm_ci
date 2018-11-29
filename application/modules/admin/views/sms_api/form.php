
<div class="page-content">
    <div class="header">
        <h2><strong><?php echo $processState; ?> SMS API</strong></h2>            
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
                    <input type="hidden" name="id" value="<?php echo $id ?>"/>
                    <div class="row">
                        <h3 class="pad-l clearMar-t">SMS API</h3>
                        <hr /><div class="clearfix"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Gateway</label>
                                <div class="append-icon">
                                    <select name="gateway_name" class="form-control" data-search="true">
                                        <option value=""></option>
                                        <?php foreach ($gateway_list as $gl): ?>
                                            <option value="<?php echo $gl ?>" <?php if ($gl == $gateway_name): ?>selected="selected"<?php endif; ?>><?php echo $gl ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Auth ID/ Auth Key/ API Key/ MSISDN/ Account Sid/ Account ID/ Username/ Admin</label>
                                <div class="append-icon">
                                    <input type="text" name="username_auth_id" value="<?php echo $username_auth_id ?>" class="form-control full-break clearRad-l">
                                </div>
                            </div>
                        </div>
                    </div>                        				 
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="control-label">Auth Token/ API Secret/ Password</label>
                            <div class="form-group">
                                <div class="append-icon">
                                    <input type="text" name="password_auth_token" value="<?php echo $password_auth_token ?>" class="form-control full-break clearRad-l">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">API ID (if clickatell)</label>
                                <div class="append-icon">
                                    <input type="text" name="api_id" value="<?php echo $api_id ?>" class="form-control full-break clearRad-l">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Sender/ Sender ID/ Mask/ From </label>
                                <div class="append-icon">
                                    <input type="text" name="phone_number" value="<?php echo $phone_number ?>" class="form-control full-break clearRad-l">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Status</label>
                                <div class="append-icon">
                                    <select name="status" class="form-control" data-search="true">
                                        <!--<option value="1">Enabled</option>
                                        <option value="0">Disabled</option>-->
                                        <?php foreach ($status_list as $sl): ?>
                                            <option value="<?php echo $sl[0] ?>" <?php if ($sl[0] == $status): ?>selected="selected"<?php endif; ?>><?php echo $sl[1] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
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
            var formData = new FormData($(this)[0]);

            $.ajax({
                url: "<?php echo base_url('admin/sms_api/save'); ?>",
                type: "POST",
                data: formData,
                async: false,
                success: function (msg) {
                    window.location = '<?php echo base_url('admin/sms_api'); ?>';
                },
                cache: false,
                contentType: false,
                processData: false
            });

            e.preventDefault();
        });
    });
</script>