<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

    $(document).ready(function () {
        $("form[name='add_customer']").submit(function (e) {
					
            var formData = new FormData($(this)[0]);

            $.ajax({
                url: "<?php echo base_url('admin/opportunities/add_account_process'); ?>",
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
                        $("#customer_ajax").html('<?php echo '<div class="alert alert-success">' . $this->lang->line('create_succesful') . '</div>' ?>');
                        setTimeout(function () {
                            $('#modal-create_account').modal('hide');
                            companyName(id);
                        }, 800); //will call the function after 1 secs.
                    }
                    else
                    {
                        $('body,html').animate({scrollTop: 0}, 200);
                        $("#customer_ajax").html(msg);
                        $("#customer_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');

                        // $("form[name='add_customer']").find("input[type=text], textarea").val("");
                    }

                },
                cache: false,
                contentType: false,
                processData: false
            });

            e.preventDefault();
         });
    });
	
	function getsalesteamdetails1(id)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/salesteams/ajax_sales_team_list') . '/'; ?>' + id,
            // data: id='cat_id',
            success: function (data) {
                $("#load_sales1").html(data);
                //$("#load_city").html('');
                $('#loader').slideUp(200, function () {
                    $(this).remove();
                });
                $('select').select2();
            },
        });
    }

</script>

<!-- BEGIN PAGE CONTENT -->
<div class="modal fade" id="modal-create_account" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                <h2 class="col-md-6"><strong>Add Account</strong></h2>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="page-content">
                        <div class="panel">
                            <div class="panel-content">
                                <div id="customer_ajax"> 
                                    <?php if ($this->session->flashdata('message')) {
                                        echo $this->session->flashdata('message');
                                    } ?>         
                                </div>

                                <form id="add_customer" name="add_customer" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">			 
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label" style="color:red;">* Company Name</label>
                                                <div class="append-icon">
                                                    <input type="text" name="name" id="name" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Website</label>
                                                <div class="append-icon">
                                                    <input type="text" name="website" value="<?php echo $co_person_id; ?>" class="form-control">
                                                    <i class="icon-globe"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">				                         
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Address</label>
                                                <div class="append-icon">
                                                    <textarea name="address" rows="4" class="form-control"></textarea> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Mobile</label>
                                                <div class="append-icon">
                                                    <input type="text" name="mobile" value="" class="form-control numeric">
                                                    <i class="icon-screen-smartphone"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Phone</label>
                                                <div class="append-icon">
                                                    <input type="text" name="phone" value="" class="form-control numeric">
                                                    <i class="icon-screen-smartphone"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label"style="color:red;">* Email</label>
                                                <div class="append-icon">
                                                    <input type="email" name="email" value="" class="form-control">
                                                    <i class="icon-envelope"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Fax</label>
                                                <div class="append-icon">
                                                    <input type="text" name="fax" value="" class="form-control numeric">
                                                    <i class="icon-screen-smartphone"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label"> Sales Owner</label>
                                                <div class="form-group">
                                                    <div class="form-group col-xs-4 clearPad-lr clearRad-r-box">
                                                        <select name="sales_team_id" id="sales_team_id" class="form-control full" data-search="true" onChange="getsalesdetails(this.value)">
                                                            <option value="" selected="selected">Choose Team</option>
                                                            <?php foreach ($salesteams as $salesteam) { ?>
																<?php if ($salesteams_user->id == $salesteam->id) { ?>
																	<option value="<?php echo $salesteam->id; ?>" selected><?php echo $salesteam->salesteam; ?></option>
																	<script>
																		$(document).ready(function () {
																			getsalesteamdetails1('<?php echo $salesteam->id; ?>');
																		});
																	</script>
																<?php } else { ?>
																	<option value="<?php echo $salesteam->id; ?>" <?php if ($lead->sales_team_id == $salesteam->id) { ?> selected="selected"<?php } ?>><?php echo $salesteam->salesteam; ?></option>
																<?php } ?>
															<?php } ?> 
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-xs-8 clearPad-lr bord-l  clearRad-l-box" id="load_sales1">
                                                        <select name="salesperson_id" id="salesperson_id" class="form-control full clearRad-r" data-search="true">
                                                            <option value="" selected="selected">Choose Sales</option>
                                                            <?php
															$salesteams = $this->salesteams_model->get_salesteam($lead->sales_team_id);
															$team = explode(',', $salesteams->team_members);
															foreach ($staffs as $staff) {
																?>
																<?php if (in_array($staff->id, $team)) { ?>
																	<option value="<?php echo $staff->id; ?>" <?php if ($lead->salesperson_id == $staff->id) { ?> selected <?php } ?> ><?php echo $staff->first_name . ' ' . $staff->last_name; ?></option>
																<?php } ?> 
															<?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Upload Your Avatar</label>
                                                <div class="append-icon">
                                                    <div class="file">
                                                        <div class="option-group">
                                                            <span class="file-button btn-primary">Choose File</span>
                                                            <input type="file" class="custom-file" name="company_avatar" id="company_avatar" onchange="document.getElementById('uploader').value = this.value;">
                                                            <input type="text" class="form-control" id="uploader" placeholder="no file selected" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label">Upload Attachment (.Pdf)</label>
                                                <div class="append-icon">
                                                    <div class="file">
                                                        <div class="option-group">
                                                            <span class="file-button btn-primary">Choose File</span>
                                                            <input type="file" class="custom-file" name="company_attachment" id="company_attachment" onchange="document.getElementById('uploader_attach').value = this.value;">
                                                            <input type="text" class="form-control" id="uploader_attach" placeholder="no file selected" readonly="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-left  m-t-20">
                                        <div id="customer_submitbutton"><button type="submit" class="btn btn-embossed btn-primary">Create</button></div>
                                    </div>
                                </form>  				    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<!-- END PAGE CONTENT -->