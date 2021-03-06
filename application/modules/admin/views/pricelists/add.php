<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

$(document).ready(function() {
	$("form[name='add_pricelist']").submit(function(e) {
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "<?php echo base_url('admin/pricelists/add_process'); ?>",
            type: "POST",
            data: formData,
            async: false,
            success: function (msg) {
			$('body,html').animate({ scrollTop: 0 }, 200);
            $("#pricelist_ajax").html(msg); 
			$("#pricelist_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');
			
			$("form[name='add_pricelist']").find("input[type=text]").val("");
			
            
        },
            cache: false,
            contentType: false,
            processData: false
        });

        e.preventDefault();
    });
});
 
 
 </script>
 <script>
 
								 $(document).ready(function() {
								
								var MaxInputs       = 50; //maximum input boxes allowed
								var InputsWrapper   = $("#InputsWrapper"); //Input boxes wrapper ID
								var AddButton       = $("#AddMoreFileBox"); //Add button ID
								
								var x = InputsWrapper.length; //initlal text box count
								var FieldCount=1; //to keep track of text box added
								
								 
								
								$(AddButton).click(function (e)  //on add input button click
								{
												if(x <= MaxInputs) //max input box allowed
												{
														FieldCount++; //text box added increment
														//add input box
														$('#start_date').addClass('date-picker');
														
														$(InputsWrapper).append('<tr><td><input type="text" name="pricelist_version_name[]" value="" class="form-control"></td><td><input type="checkbox" name="active[]" value="1" checked data-checkbox="icheckbox_square-blue"/></td><td><input type="text" name="start_date[]" id="start_date" value="" class="date-picker form-control"></td><td><input type="text" name="end_date[]" value="" class="date-picker form-control"></td><td><a href="javascript:void(0)" class="delete btn btn-sm btn-danger removeclass" data-toggle="modal" data-target="#modal-basic"><i class="icons-office-52"></i></a></td></tr>');
														
														x++; //text box increment
												}
									 
								return false;
								});
								
								
								
								$("body").on("click",".removeclass", function(e){ //user click on remove text
												if( x > 1 ) {
																$(this).parent().parent().remove(); //remove text box
																x--; //decrement textbox
												}
								return false;
								}) 
								
								});

	$(document).on('focus',".date-picker", function(){
		    $(this).datepicker();
		}); 
		
 </script>
 
 <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
        <div class="header">
            <h2><strong>Add Pricelist</strong></h2>            
          </div>
           <div class="row">
           	 
                  <div class="panel">
                     
                     <div class="panel-content">
                   					<div id="pricelist_ajax"> 
				                          <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');}?>         
				                      </div>
				         
				            <form id="add_pricelist" name="add_pricelist" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                        				 
                        				<div class="row">
                          					<div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label">Pricelist Name</label>
					                              <div class="append-icon">
					                                <input type="text" name="pricelist_name" value="" class="form-control">
					                                 
					                              </div>
					                            </div>
					                          </div>
					                          <div class="col-sm-6">
				                                 <div class="form-group">
				                              <label class="control-label">Active</label>
				                              <div class="append-icon">
				                                <input type="checkbox" name="pricelist_status" value="1" checked data-checkbox="icheckbox_square-blue"/> 
				                                 
				                              </div>
				                            </div>
				                              </div>
					                        </div>
					                    <div class="row">
					                    	<div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label">Currency</label>
					                              <div class="append-icon">
					                                 
					                                <select name="pricelist_currency" class="form-control" data-search="true">
					                                <option value="USD">USD</option>
					                                <option value="EUR">EUR</option>
					                                 
					                                </select>
					                              </div>
					                            </div>
					                          </div>
					                    </div>
					                   <!-- <div class="row">
					                    
					                    	 <div class="panel-content">
                   									<label class="control-label">Pricelist Versions</label> 
                									 <table class="table">
									                    <thead>
									                      <tr style="font-size: 12px;">                         
									                        <th>Name</th>
									                        <th>Active</th>
									                        <th>Start Date</th>
									                        <th>End Date</th>
									                        <th></th>
									                      </tr>
									                    </thead>
									                    <tbody id="InputsWrapper">
									                      
									                       
									                    </tbody>
									                  </table>
									                  <a href="<?php echo base_url('admin/pricelist_versions/add'); ?>" id=""><button type="button" class="btn btn-sm btn-primary">Add an Version</button></a>
                 									 </div>
					                    	
					                    </div>   -->
					                     
					                        
                        				<div class="text-left  m-t-20">
                         				 <div id="pricelist_submitbutton"><button type="submit" class="btn btn-embossed btn-primary">Create</button></div>
                           
                        </div>
                      </form>             
                  				    
                  </div>
                  </div>
                 
           	</div>
            	
 		</div>   
  <!-- END PAGE CONTENT -->
 
