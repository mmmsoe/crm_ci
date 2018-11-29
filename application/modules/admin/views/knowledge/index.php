<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>
function delete_folder(id)
	{
		if(confirm('Are you sure delete this folder?'))
		{
			$.ajax({
            url : "<?php echo base_url('admin/knowledgebase/delete_folder')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
               window.location="<?php echo base_url('admin/knowledgebase');?>";
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
		});
		}
	}
$(document).ready(function() {
	
	$("form[name='add_folder']").submit(function(e) {
		
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "<?php echo base_url('admin/knowledgebase/add_folder'); ?>",
            type: "POST",
            data:formData,
			async: false,
            success: function (msg) {
			$('body,html').animate({ scrollTop: 0 }, 200);
            $("#tickets_ajax").html(msg); 
			//$("#tickets_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');
			
			$("form[name='add_folder']").find("input[type=text],select,textarea").val("");
			window.location="<?php echo base_url('admin/knowledgebase');?>";
            
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
                            <div id="tickets_ajax"> 
                                  <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');}?>         
                            </div>
                            <div style="float:right; padding-top:10px;">
               
                                <a href="javascript:void(0)" class="btn btn-primary btn-embossed" data-toggle="modal" data-target="#modal-basic"> New Folder</a> 	
				 
                            </div>
                            <h3 class="pad-l">Knowledgebase</h3>
				     
                            <hr />
                            <div class="clearfix"></div>
                            <!--panel content area start-->			
                            <div class="panel-content">                                                                
                                <div class="row">                                                                       
                                    
                                    <div class="col-sm-6">                                            
                                        <div class="form-group">
                                            <?php foreach( $data as $article){ ?> 
                                                <?php 
                                                    if ($article->rowNumber % 2 != 0){ ?>
                                                        <label class="col-sm-12 control-label">
                                                            <i class="glyphicon glyphicon-folder-open margin-right"></i>
                                                            <a href="<?php echo base_url('admin/knowledgebase/show/'.$article->ID);?>"><?php echo $article->name;?></a> &nbsp <a href="#" onclick="delete_folder(<?php echo $article->ID;?>)"><i class="glyphicon glyphicon-trash"></i></a>
                                                            <div class="col-sm-12"><?php echo $article->article_descr?></div>
                                                        </label>                                                                                                                
                                                    <?php    
                                                    }
                                                ?>
                                            <?php }?>
                                        </div>                                                                                                                                                            
                                    </div>                                    
                                    
                                    <div class="col-sm-6">                                            
                                        <div class="form-group">
                                            <?php foreach( $data as $article1){ ?>
                                                <?php 
                                                    if ($article1->rowNumber % 2 == 0){ ?>
                                                        <label class="col-sm-12 control-label">
                                                            <i class="glyphicon glyphicon-folder-open margin-right"></i>
                                                            <a href="<?php echo base_url('admin/knowledgebase/show/'.$article1->ID);?>"><?php echo $article1->name;?></a> &nbsp <a href="#" onclick="delete_folder(<?php echo $article1->ID;?>)"><i class="glyphicon glyphicon-trash"></i></a>
                                                            <div class="col-sm-12"><?php echo $article1->article_descr?></div>
                                                        </label>                                                                                                                
                                                    <?php    
                                                    }
                                                ?>
                                            <?php }?>
                                        </div>                                            
                                    </div>                                                                                                          
                                </div>
                            </div>
	<!--panel content area end-->				
					
				
				
				</div>
			</div>
		</div>
		<!-- modal begin -->
		<div class="modal fade" id="modal-basic" tabindex="-1" role="dialog" aria-hidden="true">
            				<div class="modal-dialog">
              					<div class="modal-content">
					                <div class="modal-header">
					                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
					                  <h4 class="modal-title"><strong>New Document</strong></h4>
					                </div>
					                <div class="modal-body">
									
					                 <form id="add_folder" name="add_folder" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">

									 <div class="form-group">
                            <label class="control-label col-md-3">Name</label>
                            <div class="col-md-9">
                                <input name="name" placeholder="Name" class="form-control" type="text" value="">
                                <span class="help-block"></span>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="control-label col-md-3">Description</label>
                            <div class="col-md-9">
                                <input name="descr" placeholder="Description" class="form-control" type="text" value="">
                                <span class="help-block"></span>
                            </div>
                        </div>
						
					                </div>
					                <div class="modal-footer">
					                 <button type="submit" class="btn btn-primary btn-embossed">Create</button>
					                </div>
									</form>
             					 </div>
           					 </div>
        				  </div>
						  <!-- modal end -->
	</div>   
<!-- END PAGE CONTENT -->
  
  