
<input type="hidden" id="template_id" />
<div class="page-content">
    <div class="row">
        <div>
            <!-- top button-->
        </div>           
    </div>
    <div class="row">
        <a href="#" class="btn btn-sm btn-primary" onclick="javascript:back_()" data-toggle="modal" data-target="#modal-create_email">Compose</a> 
        <div class="col-lg-2">
            <div class="panel">
                <div class="panel-heading" style="border-bottom-color:#ddd; border-bottom-width:1px; border-bottom-style:solid;"><b>Menu</b></div>
                <div class="panel-body">
                    <ul class="nav nav-sidebar">
                        <li id="inbox" class="nav-active active"><a href="javascript:change_dir('INBOX')"><span>Inbox</span></a></li>
                        <li id="inbox" class="nav-active active"><a href="javascript:change_dir('INBOX.Sent')"><span>Sent</span></a></li>
                        <li id="inbox" class="nav-active active"><a href="javascript:change_dir('INBOX.Trash')"><span>Trash</span></a></li>
                        <li id="inbox" class="nav-active active"><a href="javascript:change_dir('INBOX.Junk')"><span>Junk</span></a></li>
                    </ul>
                </div>    
            </div>
        </div>

        <div class="col-lg-10">
            <div class="panel">
                <div class="panel-heading" style="border-bottom-color:#ddd; border-bottom-width:1px; border-bottom-style:solid;"><b>Mailbox</b></div>
                <div class="panel-body">
                    <div class="panel-content pagination2 table-responsive" id="mailbox">
                        <table class="table table-hover" id="tbmails">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>From</th>
                                    <th>Date</th>

                                    <th style="width:21%;"><?php echo $this->lang->line('options'); ?></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <a href="javascript:back()" class="btns btn btn-sm btn-w btn-default btn-embossed dlt_sm_table"><i class="glyphicon glyphicon-arrow-left"></i></a>

                    <div id="reader_wait">
                        Please wait...
                    </div>

                    <div class="panel-content pagination2 table-responsive" id="reader">
                        <div class="row">
                            <label>Subject:</label>
                            <div id="subject">sdfsdfds</div>
                            <label>From:</label>
                            <div id="from">sdfsdfds</div>
                            <label>Date:</label>
                            <div id="date">sdfsdfds</div>
                            <label id="lblAttachments">Attachments:</label>
                            <div id="attachment"></div>

                            <label>Content:</label>
                            <iframe id="frame_message" width="100%" height="700"></iframe>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-create_email" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                <h4 class="modal-title"><strong>Write</strong> an email</h4>
            </div>
            <div id="send_email_ajax"> 
                <?php
                if ($this->session->flashdata('message')) {
                    echo $this->session->flashdata('message');
                }
                ?>         
            </div>

            <form id="send_email" name="send_email" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6" class="assign">
                            <div class="form-group">
                                <label for="field-1" class="control-label">Assign Customer</label>
                                <select name="assign_customer_id" id="assign_customer_id" class="form-control" data-search="true" onChange="getcontactdetails(this.value);set_subject($('#s2id_email_type').select2('val'));get_opportunities(this.value);">
                                    <option value=""></option>
                                    <?php foreach ($customers as $customer) { ?>
                                        <option value="<?php echo $customer->id; ?>"><?php echo customer_name($customer->id)->name; ?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" class="assign">
                            <div class="form-group">
                                <label for="field-4" class="control-label">Opportunity</label>
                                <select name="opportunity_id" id="opportunity_id" class="form-control" data-search="true" onChange="set_subject($('#s2id_email_type').select2('val'));">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" >
                            <div class="form-group">
                                <label for="field-1" class="control-label">Recipients</label>
                                <div id="load_contacts">
                                    <input type="text" class="form-control" name="recipient" id="recipient">
                                    <select name="to_email_id[]" id="to_email_id" onChange="set_subject($('#s2id_email_type').select2('val'));" class="form-control" data-search="true" multiple>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" class="assign">
                            <div class="form-group">
                                <label for="field-1" class="control-label">Email Type</label>
                                <select name="email_type" id="email_type" class="form-control" data-search="true" onChange="set_subject(this.value);">
                                    <option value=""></option>
                                    <?php foreach ($email_type as $e) { ?>
                                        <option value="<?php echo $e->status; ?>"><?php echo $e->system_value_txt; ?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                        </div>

                    </div> 
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group"> 
                                <label for="field-1" class="control-label">Subject</label>
                                <input type="text" class="form-control" name="subject" id="subject">
                                <input type="hidden" class="form-control" name="check_mail" id="check_mail" value="0">
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">

                            <div class="form-group">

                                <textarea name="message" id="message" cols="80" rows="10" class="cke-editor"></textarea>

                            </div>
                        </div>
                    </div> 

                </div>

                <div id="send_email_submitbutton" class="modal-footer text-center"><button type="submit" class="btn btn-primary btn-embossed bnt-square">Send</button></div>

            </form>
        </div>
    </div>
</div>


<script>
    var datatable;
    var place;
    function read_email(uid, place)
    {
        $('#reader_wait').show();
        $('#mailbox').hide();
        $('#lblAttachments').hide();
        $('#attachment').hide();

        $('#subject').html('');
        $('#from').html('');
        $('#date').html('');
        $('#message_content').html('');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/mailbox/read_email'); ?>",
            dataType: "json",
            data: {
                uid: uid,
                place: place
            },
            success: function (data)
            {
                $('#reader_wait').hide();
                $('.btns').show();
                $('#reader').show();
                $('#subject').html(data.subject);
                $('#from').html(data.from);
                $('#date').html(data.date);
                //$('#message_content').html(data.message);

                //var html_string = "content";
                //document.getElementById('frame_message').src = "data:text/html;charset=utf-8," + escape(data.message);
                var $frame = $('#frame_message');
                setTimeout(function () {
                    var doc = $frame[0].contentWindow.document;
                    var $body = $('body', doc);
                    $body.html('<div>' + atob(data.message) + '</div>');
                }, 1);
                if (data.attachment != "")
                {
                    $('#lblAttachments').show();
                    $('#attachment').show();
                    $('#attachment').html(data.attachment);
                }
            }
        });
    }

    function delete_mail(msg_no) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/mailbox/delete_mail'); ?>",
            dataType: "json",
            data: {
                msg_no: msg_no
            },
            success: function (data)
            {
                change_dir('INBOX');
            }
        });
        datatable.api().ajax.reload();
    }

    function get_emails()
    {
        datatable = $('#tbmails').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?php echo base_url('admin/mailbox/get_emails') . '/'; ?>',
                type: "POST",
                dataType: 'json',
                data: function (d) {
                    d.place = place
                }
            },
            columns: [
                {
                    data: "subject",
                },
                {
                    data: "from"
                },
                {
                    data: "date"
                }
                ,
                {
                    data: "act"
                }
            ]

        });
    }

    function back_() {
        $('#check_mail').val(0);
        $('#s2id_to_email_id').show();
        $('.assign').show();
        $('[name="recipient"]').hide();
        $('[name="subject"]').val('');
        $('.modal-title strong').html('Write');
    }

    function set_reply(uid, place, recipient, subject) {
//        $.ajax({
//            type: "POST",
//            url: "<?php //echo base_url('admin/mailbox/read_email');     ?>",
//            dataType: "json",
//            data: {
//                uid: uid,
//                place: place
//            },
//            success: function (data)
//            {
//                console.log(data);
//               
//            }
//        });

        $('#check_mail').val('1');
        $('[name="recipient"]').show();
        $('#s2id_to_email_id').hide();
        $('.assign').hide();
        $('[name="recipient"]').val(recipient);
        
        var result = subject.toString().split(":");
        //console.log('Re: '+result[1].replace(/Re/g, '').replace(/:/g, '').trim());
        $('[name="subject"]').val('Re: '+result[1].replace(/Re/g, '').replace(/:/g, '').trim()+":");
        $('.modal-title strong').html('Reply');
        $('#message').val('');
    }

    function set_forward(uid, place) {
        back_();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/mailbox/read_email'); ?>",
            dataType: "json",
            data: {
                uid: uid,
                place: place
            },
            success: function (data)
            {
                var fd = data.subject.replace("Re: ", "");
                $('[name="subject"]').val('Fwd: ' + fd.replace("Fwd: ", ""));
                var ms = "\----- Forwarded message from " + data.from + " -----\
                          \ " + atob(data.message) + "\
                ";

                $('#message').val(ms);
                $('.modal-title strong').html('Forward');

            }
        });
    }

    function set_subject(mail_type) {
        var company_id = $('#s2id_assign_customer_id').select2('val');
        

        if(mail_type){
            $.ajax({
            type: "POST",
            url: "<?php echo base_url('admin/mailbox/get_rowmail');?>",
            dataType: "json",
            data: {
                company_id: company_id
            },
            success: function (data)
            {
                $('[name="subject"]').val('[' + mail_type + '-' + company_id + '-' +data+ '] : ');
            }
        });
        }
    }

    $(document).ready(function () {
        $('#recipient').hide();
        $("form[name='send_email']").submit(function (e) {
            var formData = new FormData($(this)[0]);
            formData.append('message',$('#message').val());
            //console.log(formData);
            //var formData = $("form[name='send_email']").serialize();//new FormData($(this)[0]);
            $.ajax({
                url: "<?php echo base_url('admin/mailbox/send_email'); ?>",
                type: "POST",
                data: formData,
                async: false,
                success: function (msg) {
                    // data.message = $('textarea.cke-editor').val();

                    // var str = msg.split("_");
                    // var id = str[1];
                    //var status = str[0];

                    //if (status == "yes")
                    //{
//                    $('body,html').animate({scrollTop: 0}, 200);
//                    $("#send_email_ajax").html('<?php echo '<div class="alert alert-success">Send Successfully... redirecting, please wait..</div>' ?>');
//
//                    setTimeout(function () {
//                        window.location.href = "<?php echo base_url('admin/mailbox'); ?>";
//                    }, 1200); //will call the function after 3 secs.
                    //}
                    // else
                    //{
                    //    $('body,html').animate({scrollTop: 0}, 200);
                    //    $("#send_email_ajax").html(msg);
                    //    $("#send_email_submitbutton").html('<button type="submit" class="btn btn-primary btn-embossed bnt-square">Save</button>');
                    //}
                    // $("form[name='send_email']").find("input[type=text], textarea").val("");

                },
                cache: false,
                contentType: false,
                processData: false
            });

            e.preventDefault();
        });


        $('#reader_wait').hide();
        $('#mailbox').show();
        $('#reader').hide();
        $('.btns').hide();
        get_emails();
    });
    function change_dir(p)
    {
        $('#reader_wait').hide();
        $('#mailbox').show();
        $('#reader').hide();
        $('.btns').hide();
        place = p;
        datatable.api().ajax.reload();
    }
    function back()
    {
        $('.btns').hide();
        $('#mailbox').show();
        $('#reader').hide();
        datatable.api().ajax.reload(null, false);
    }

    function getcontactdetails(id)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/mailbox/ajax_contact_list') . '/'; ?>' + id,
            // data: id='cat_id',
            success: function (data) {
                $("#load_contacts").html(data);
                //$("#load_city").html('');
                $('#loader').slideUp(200, function () {
                    $(this).remove();
                });
                $('select').select2();
            },
        });
    }

    function get_opportunities(company_id)
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/logged_calls/get_opportunities_by_comp') ?>',
            data: {company_id: company_id},
            dataType: 'json',
            success: function (res) {
                $('#opportunity_id').select2('val', '');
                $('#opportunity_id').append('<option value=""></option>');
                $.each(res.data, function (i, r) {
                    $('#opportunity_id').append('<option value="' + r.id + '">' + r.opportunity + '</option>');
                });
            }
        });
    }
</script>

