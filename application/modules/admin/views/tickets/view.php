<style>

    body{
        background:#eee;
    }

    hr {
        margin-top: 20px;
        margin-bottom: 20px;
        border: 0;
        border-top: 1px solid #FFFFFF;
    }
    a {
        color: #82b440;
        text-decoration: none;
    }
    .blog-comment::before,
    .blog-comment::after,
    .blog-comment-form::before,
    .blog-comment-form::after{
        content: "";
        display: table;
        clear: both;
    }

    .blog-comment{
        /*        padding-left: 15%;
                padding-right: 15%;*/
        padding-right: 15%;
    }

    .blog-comment ul{
        list-style-type: none;
        padding: 0;
    }

    .blog-comment img{
        opacity: 1;
        filter: Alpha(opacity=100);
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
    }

    .blog-comment img.avatar {
        position: relative;
        float: left;
        margin-left: 0;
        margin-top: 0;
        width: 65px;
        height: 65px;
    }

    .avatar-staff {
        position: relative;
        float: right;
        margin-right: 0;
        margin-top: 0;
        width: 65px;
        height: 65px;
    }


    .post-comments-staff{
        border: 1px solid #eee;
        margin-bottom: 20px;
        margin-left: 0px;
        margin-right: 85px;
        padding: 10px 20px;
        position: relative;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        background: #fff;
        color: #6b6e80;
        position: relative;
    }

    .blog-comment .post-comments{
        border: 1px solid #eee;
        margin-bottom: 20px;
        margin-left: 85px;
        margin-right: 0px;
        padding: 10px 20px;
        position: relative;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        background: #fff;
        color: #6b6e80;
        position: relative;
    }

    .blog-comment .meta {
        font-size: 13px;
        color: #aaaaaa;
        padding-bottom: 8px;
        margin-bottom: 10px !important;
        border-bottom: 1px solid #eee;
    }

    .blog-comment ul.comments ul{
        list-style-type: none;
        padding: 0;
        margin-left: 85px;
    }

    .blog-comment-form{
        padding-left: 15%;
        padding-right: 15%;
        padding-top: 40px;
    }

    .blog-comment h3,
    .blog-comment-form h3{
        margin-bottom: 40px;
        font-size: 26px;
        line-height: 30px;
        font-weight: 800;
    }
</style>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>

    $(document).ready(function () {

        $("form[name='reply_tickets']").submit(function (e) {
            var formData = new FormData($(this)[0]);

            $.ajax({
                url: "<?php echo base_url('admin/tickets/reply_process'); ?>",
                type: "POST",
                data: formData,
                async: false,
                success: function (msg) {
                    $('body,html').animate({scrollTop: 0}, 200);
                    $("#tickets_ajax").html(msg);
                    //$("#tickets_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');

                    $("form[name='reply_tickets']").find("textarea").val("");
                    location.reload();

                },
                cache: false,
                contentType: false,
                processData: false
            });

            e.preventDefault();
        });
		
		// $.ajax({
					// url 	 : "<?php echo base_url('admin/tickets/viewticket/21'); ?>",
					// type	 : 'post',
					// dataType : 'JSON',
					// data	 :{},
					// success:function(data){
					// console.log(data.data);
					// },
					
				
			// });
		
    });
	function delete_reply(id)
    {
		
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('admin/tickets/delete_reply'); ?>/" + id,
            success: function (msg) {
                $('body,html').animate({scrollTop: 0}, 200);
                $("#tickets_ajax").html(msg);
                //$("#tickets_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');

                //$("form[name='add_tickets']").find("input[type=text],select,textarea").val("");
                //window.location = "<?php echo base_url('admin/tickets'); ?>";

                //table.ajax.reload(null,false); //reload datatable ajax 
            }

        });

    }
</script>
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">

    <div class="row">
        <div class="panel">
            <div class="panel-content">
                <div id="tickets_ajax"> 
                    <?php
                    if ($this->session->flashdata('message')) {
                        echo $this->session->flashdata('message');
                    }
                    ?>         
                </div>
                <h3 class="pad-l">Ticket Detail Information</h3>
				
                <div class="panel-content">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><i class="fa fa-file-text-o"></i>Subject</label>
                                <div class="col-sm-7 append-icon">
                                    <?php echo $ticket->subject; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><i class="fa fa-archive"></i>Customer Name</label>
                                <div class="col-sm-7 append-icon">					                                 
                                    <?php echo $ticket->name; ?>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><i class="fa fa-archive"></i>Priority</label>
                                <div class="col-sm-7 append-icon">					                                 
                                    <?php echo $ticket->priority;//echo $this->system_model->system_single_value('TICKET_PRIORITY', $ticket->priority)->system_value_txt; ?>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><i class="fa fa-archive"></i>Category</label>
                                <div class="col-sm-7 append-icon">					                                 
                                    <?php echo $ticket->categories;//echo $this->system_model->system_single_value('TICKET_CAT', $ticket->category)->system_value_txt; ?>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <br/>
                    <div class="row">
						<div class="form-group">
							<label class="control-label">Description</label>
							<div class="append-icon">
								<textarea name="ticket_description" rows="2" class="form-control" readonly='true'><?php echo $ticket->description; ?></textarea>
							</div>
						</div>
                    </div>

                    <!--------- comment area ------------->
                    <!-- <div class="container bootstrap snippet"> -->
                        <div class="row" >
							<div class="blog-comment">
								<h3 class="text-success">Comments</h3>
								<ul class="comments">
									<?php
									if (!empty($reply)) {
										?>
										<?php foreach ($reply as $rs) { ?>
											<li class="clearfix">
												<?php if ($rs->image) { ?>
													<img src="<?php echo base_url('uploads/staffs') . '/' . $rs->image; ?>" alt="profil 4" class="<?php echo $rs->user_id == userdata('id') ? "avatar-staff" : "avatar"; ?>">
												<?php } else { ?>
													<img src="<?php echo base_url(); ?>public/assets/global/images/avatars/avatar1_big.png" alt="user image" class="<?php echo $rs->user_id == userdata('id') ? "avatar-staff" : "avatar"; ?>">  
												<?php } ?>
												<div class="<?php echo $rs->user_id == userdata('id') ? "post-comments-staff" : "post-comments"; ?>">
													<p class="meta"><!-- Dec 18, 2014 --> <a href="<?php echo base_url('admin/staff/view/' . $rs->user_id); ?>"><?php echo $rs->username; ?></a> says : <i class="pull-right"><a href="#"><small>Reply</small></a></i></p>
													<p><?php echo $rs->message; ?></p>
												<?php if(userdata('role_id') == 1){?>
														<a href="javascript:void(0)" class="delete btn btn-sm btn-danger dlt_sm_table" data-toggle="modal" data-target="#modal-basicdua<?php echo $rs->id; ?>">delete</a>
												<?php }?>
												</div>
											</li>
											<?php
										}
									} else {
										?>
										<div>There is no comment</div>
									<?php } ?>

								</ul>
							</div>
                        </div>
                        <!--</div>-->

                        <!---------end comment area ------------->	
                        <?php if ($ticket->status != "Close") { ?>
                            <form id="reply_tickets" name="reply_tickets" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                                <div class="row">
									<div class="form-group">
										<label class="control-label">Leave Comment</label>
										<div class="append-icon">
											<textarea name="ticket_reply" rows="1" style="width:100%" class="form-control"></textarea>
										</div>
									</div>
                                </div>



                                <input type="hidden" name="customer_id" value="<?php echo userdata("id"); ?>"></input>
                                <input type="hidden" name="id_ticket" value="<?php echo $ticket->ticket_id; ?>"></input>
                                <div class="text-left  m-t-20">
                                    <div id="reply_submitbutton"><button type="submit" class="btn btn-embossed btn-primary">Reply</button></div>
								
                                </div>
                            </form>	
                        <?php } ?>
                    </div>




                </div>
            </div>
        </div>
    </div> 
<div class="modal fade" id="modal-basicdua<?php echo $rs->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                                                <h4 class="modal-title"><strong>Confirm</strong></h4>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this comment?<br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default btn-embossed" data-dismiss="modal">Cancel</button>
                                                <button type="button" onclick="delete_reply(<?php echo $rs->id; ?>)" class="btn btn-primary btn-embossed" data-dismiss="modal">delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>	
    <!-- END PAGE CONTENT -->
