<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    function get_opportunities(company_id)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/logged_calls/get_opportunities_by_comp') ?>',
            data: {company_id: company_id},
            dataType: 'json',
            success: function (res) {
                $('#opportunity_id').empty();
                $('#opportunity_id').append('<option value=""></option>');
                $.each(res.data, function (i, r) {
                    $('#opportunity_id').append('<option value="' + r.id + '">' + r.opportunity + '</option>');
                });
            }
        });
    }
    function get_contacts(company_id)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/logged_calls/get_contacts_by_comp') ?>',
            data: {company_id: company_id},
            dataType: 'json',
            success: function (res) {
                $('#contact_id').empty();
                $('#contact_id').append('<option value=""></option>');
                $.each(res.data, function (i, r) {
                    $('#contact_id').append('<option value="' + r.id + '">' + r.first_name + ' ' + r.last_name + '</option>');
                });
            }
        });
    }
    $(document).ready(function () {
        <?php if ($this->uri->segment(4) != ""): ?>
            get_opportunities(<?php echo $this->uri->segment(4); ?>);
        <?php endif; ?>
        $("form[name='add_call']").submit(function (e) {
            var formData = new FormData($(this)[0]);

            $.ajax({
                url: "<?php echo base_url('admin/logged_calls/add_process'); ?>",
                type: "POST",
                data: formData,
                async: false,
                success: function (msg) {
                    $('body,html').animate({scrollTop: 0}, 200);
                    $("#call_ajax").html(msg);
                    $("#call_submitbutton").html('<button type="submit" class="btn btn-primary btn-embossed bnt-square">Save</button>');

                    $("form[name='add_call']").find("input[type=text]").val("");
<?php if ($this->uri->segment(4) != ""): ?>
                        window.location = '<?php echo base_url('admin/customers/view/' . $this->uri->segment(4)); ?>';
<?php else: ?>
                        window.location = '<?php echo base_url('admin/logged_calls'); ?>';
<?php endif; ?>
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
        <h2><strong>Create Logged Calls</strong></h2>            
    </div>
    <div class="row">

        <div class="panel">

            <div class="panel-content">
                <div id="call_ajax"> 
                    <?php
                    if ($this->session->flashdata('message')) {
                        echo $this->session->flashdata('message');
                    }
                    ?>         
                </div>

                <form id="add_call" name="add_call" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">Date</label>
                                    <input type="text" class="datetimepicker form-control" name="date" id="date" placeholder="" value="<?php echo date('m/d/Y H:i'); ?>">

                                </div>
                                <div class="form-group">
                                    <label for="field-4" class="control-label">Company</label>
                                    <select name="company_id" id="company_id" class="form-control" data-search="true" onchange="get_opportunities(this.value); get_contacts(this.value);">
                                        <option value=""></option>
                                        <?php foreach ($companies as $company) { ?>
                                            <option value="<?php echo $company->id; ?>" <?php if ($company->id == $this->uri->segment(4)): ?>selected="selected"<?php endif; ?>><?php echo $company->name; ?></option>
                                        <?php } ?> 
                                    </select>

                                    <label for="field-4" class="control-label">Contact</label>
                                    <select name="contact_id" id="contact_id" class="form-control" data-search="true">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="field-5" class="control-label">Responsible</label>
                                    <select name="resp_staff_id" id="resp_staff_id" class="form-control" data-search="true">
                                        <?php foreach ($staffs as $staff) { ?>
                                            <option value="<?php echo $staff->id; ?>" <?php if ($staff->id==$customer->salesperson_id) { ?>selected <?php } ?>><?php echo $staff->first_name . ' ' . $staff->last_name; ?></option>
                                        <?php } ?> 
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="field-4" class="control-label">Opportunity</label>
                                    <select name="opportunity_id" id="opportunity_id" class="form-control" data-search="true">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="field-2" class="control-label">Call	Summary</label>
                                    <textarea class="form-control" name="call_summary" id="call_summary" rows="17"></textarea>
                                </div>
                            </div>
                        </div>
						
						<div class="row">
							<div id="call_submitbutton" style="float:left;" class="modal-footer"><button type="submit" class="btn btn-primary btn-embossed bnt-square">Create</button></div>
						</div>
                    </div>
                </form>             

            </div>
        </div>

    </div>

</div>   
<!-- END PAGE CONTENT -->

