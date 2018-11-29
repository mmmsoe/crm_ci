<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>

$(document).ready(function() {
	
	$("form[name='add_article']").submit(function(e) {
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "<?php echo base_url('admin/knowledgebase/add_article'); ?>",
            type: "POST",
            data:formData,
			async: false,
            success: function (msg) {
			$('body,html').animate({ scrollTop: 0 }, 200);
            $("#tickets_ajax").html(msg); 
			//$("#tickets_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');
			$("form[name='add_folder']").find("input[type=text],select,textarea").val("");
			window.location="<?php echo base_url('admin/knowledgebase/show/'.$select->ID);?>";
			
            
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
       
		<div class="row">
			<div class="panel">
			 <div class="panel-content">
                   					
									  
			<div style="float:right; padding-top:10px;">
               
			   <a href="javascript:void(0)" class="btn btn-primary btn-embossed" data-toggle="modal" data-target="#modal-basic"> Add Article</a> 	
				 
                        </div>
									  
                             <h3 class="pad-l"><a href="<?php echo base_url('admin/knowledgebase/')?>">Knowledgebase</a></h3>
				<hr /><div class="clearfix"></div>
                                <?php foreach( $select1 as $article2){ ?>
                                    <h3 class="pad-l"><b><?php echo $article2->name ?></b></h3>
                                <?php } ?>
                                
				<!--<h4 class="pad-l"><a href="<?php echo base_url('admin/knowledgebase/')?>">back</a></h4>-->
	<!--panel content area -->			
				<div class="panel-content">
				
                                    <?php if( ! empty($data) ){?>
                                        <?php foreach( $data as $detail){ ?>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <div class='panel-heading align-left' data-toggle='collapse' data-target='#<?php echo $detail->id_article;?>'><i class="fa fa-files-o"></i><strong><?php echo $detail->title;?></strong></div>
                                                        <div class='panel-body collapse out' id='<?php echo $detail->id_article ;?>'>
                                                            <p><?php echo $detail->content;?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }?>
                                    <?php } else{?>
                                            <div>There is no Document</div>
                                    <?php }?>
				</div>
	<!--panel content area end-->				
					
				
				
				</div>
			</div>
		</div>
		
		<!-- modal begins -->
		<div class="modal fade" id="modal-basic" tabindex="-1" role="dialog" aria-hidden="true">
            				<div class="modal-dialog">
              					<div class="modal-content">
					                <div class="modal-header">
					                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
					                  <h4 class="modal-title"><strong>Add Article</strong></h4>
					                </div>
									<!--form start-->
					                <form id="add_article" name="add_article" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
									<div class="modal-body">
									<input type="hidden" name="id" class="form-control" value="<?php echo $select->ID ?>"></input>
									<div class="row">
												<div class="col-sm-4">
													<div class="form-group">
														<label class="control-label">Title</label>
														<div class="append-icon">
															<input type="text" name="title" class="form-control" value=""></input>
															</div>
															</div>
															</div>
															</div>
											<div class="row">
												<div class="col-sm-12">
													<div class="form-group">
														<label class="control-label">Content</label>
														<div class="append-icon">
															<textarea name="content" class="form-control" value=""></textarea>
															</div>
															</div>
															</div>
															</div>
					                
									
						
					                </div>
					                <div class="modal-footer">
					                 <button type="submit" class="btn btn-primary btn-embossed">Add</button>
					                </div>
									<!--form finish-->
									</form>
             					 </div>
           					 </div>
        				  </div>
						  <!-- modal end -->
	</div>   
<!-- END PAGE CONTENT -->
  
  