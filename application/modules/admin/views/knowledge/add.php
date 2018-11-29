<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

$(document).ready(function() {
	
	$("form[name='add_tickets']").submit(function(e) {
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "<?php echo base_url('admin/tickets/add_process'); ?>",
            type: "POST",
            data:formData,
			async: false,
            success: function (msg) {
			$('body,html').animate({ scrollTop: 0 }, 200);
            $("#tickets_ajax").html(msg); 
			//$("#tickets_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');
			
			$("form[name='add_tickets']").find("input[type=text],select,textarea").val("");
			window.location="<?php echo base_url('admin/tickets');?>";
            
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
            <h2 class="col-md-6"><strong>New Article</strong></h2>
           </div>
           <div class="row">
           	 
                  <div class="panel">
                     
                     <div class="panel-content">
                   					<div id="tickets_ajax"> 
				                          <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');}?>         
				                      </div>
				         <h3> Knowledgebase </h3>
				            <form id="add_tickets" name="add_tickets" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
 
                        				                        				 
                        				
                      </form>             
                  				    
                  </div>
                  </div>
                 
           	</div>
            	
 		</div>   
  <!-- END PAGE CONTENT -->
 
