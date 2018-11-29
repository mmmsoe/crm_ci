<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

$(document).ready(function() {
	$("form[name='add_account']").submit(function(e) {
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "<?php echo base_url('admin/account/add_process'); ?>",
            type: "POST",
            data: formData,
            async: false,
            success: function (msg) {
			$('body,html').animate({ scrollTop: 0 }, 200);
            $("#account_ajax").html(msg); 
			$("#account_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');
			
			$("form[name='add_account']").find("input[type=text],input[type=email], textarea,select").val("");
			
            
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
            <h2 class="col-md-6"><strong>Create Account</strong></h2>
           </div>
           <div class="row">
           	 
                  <div class="panel">
                     
                     <div class="panel-content">
                   					<div id="account_ajax"> 
				                          <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');}?>         
				                      </div>
				         <h3> Account Information </h3>
				            <form id="add_account" name="add_account" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
 
                        				                        				 
                        				<div class="row">
                          					<div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label">Account Owner</label>
					                              <div class="append-icon">
													<select name="account_owner" class="form-control" data-search="true">
					                                <option value=""></option>
					                                <?php foreach( $owner as $owner){ ?>
					                                <option value="<?php echo $owner->system_code;?>"><?php echo $owner->system_value_txt;?></option>
					                                <?php }?> 
					                                </select>
												 </div>
					                            </div>
					                          </div>
					                           <div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label">Rating</label>
					                              <div class="append-icon">
					                          <select name="rating" class="form-control" data-search="true">
					                               <option value="-None-">-None-</option>
					                                 <?php foreach( $rating as $rating){ ?>
					                                <option value="<?php echo $rating->system_code;?>"><?php echo $rating->system_value_txt;?></option>
					                                <?php }?> 
					                                </select>				                                 
				                             	 </div>
					                            </div>
					                          </div>
					                          
					                        </div>
                        				<div class="row">				                         
				                          <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Account Name</label>
				                              <div class="append-icon">
				                                 <input type="text" name="account_name" value="" class="form-control">
					                                </div>
				                            </div>
				                          </div>
				                           <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Phone</label>
				                              <div class="append-icon">
				                                <input type="text" name="phone" value="" class="form-control">
												<i class="icon-screen-smartphone"></i>

				                                
				                              </div>
				                            </div>
				                          </div>
				                        </div>
				                        <div class="row">
					                          <div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label">Account Site</label>
					                              <div class="append-icon">
					                                <input type="text" name="account_site" value="" class="form-control">
					                         <i class="icon-globe"></i>
											 </div>
					                            </div>
					                          </div>
					                          <div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label">Fax</label>
					                              <div class="append-icon">
					                                <input type="text" name="fax" value="" class="form-control">
													<i class="icon-envelope"></i>
					                              </div>
					                            </div>
					                          </div>
					                        </div>
					                    <div class="row">
					                          <div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label">Parent Account</label>
					                              <div class="append-icon">
					                                <input type="text" name="parent_account" value="" class="form-control">
					                               </div>
					                            </div>
					                          </div>
					                          <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Website</label>
				                              <div class="append-icon">
				                                <input type="text" name="website" value="" class="form-control">
				                                <i class="icon-globe"></i>
				                              </div>
				                            </div>
				                          </div>
					                    </div>
					                        
				                        <div class="row">
				                          <div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label">Account Number</label>
					                              <div class="append-icon">
					                            <input type="text" name="account_number" value="" class="form-control">
												<i class="icon-screen-smartphone"></i>
     
					                                </select>
					                                 
					                              </div>
					                            </div>
					                          </div>
					                          <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Ticker Symbol</label>
				                              <div class="append-icon">
				                               <input type="text" name="ticker" value="" class="form-control">
												   
				                              </div>
				                            </div>
				                          </div>												 
				                        </div>
				                        <div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Account Type</label>
				                              <div class="append-icon">
				                                <select name="account_type" class="form-control" data-search="true">
					                               <option value="-None-">-None-</option>
					                                 <?php foreach( $type as $type){ ?>
					                                <option value="<?php echo $type->system_code;?>"><?php echo $type->system_value_txt;?></option>
					                                <?php }?> 
					                                </select>				                                 
				                              </div>
				                            </div>
				                          </div>
											 <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Ownership</label>
				                              <div class="append-icon">
				                                 <select name="ownership" class="form-control" data-search="true">
					                                <option value="-None-">-None-</option>
					                                <?php foreach( $ownership as $ownership){ ?>
					                                <option value="<?php echo $ownership->system_code;?>"><?php echo $ownership->system_value_txt;?></option>
					                                <?php }?> 
					                                </select>				                                 
				                                   </div>
				                            </div>
				                          </div>
											<!--<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Upload Attachment</label>
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
				                          </div>-->
				                        </div>
				                        <div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Industry</label>
				                              <div class="append-icon">
				                                <select name="industry" class="form-control" data-search="true">
					                                <option value="-None-">-None-</option>
														<?php foreach( $industry as $industry){ ?>
					                                <option value="<?php echo $industry->system_code;?>"><?php echo $industry->system_value_txt;?></option>
					                                <?php }?> 
					                                </select> 
				                              </div>
				                            </div>
				                          </div>
										<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Employees</label>
				                              <div class="append-icon">
				                                <input type="text" name="employee" value="" class="form-control">
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  <div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Annual Revenue</label>
				                              <div class="append-icon">
				                                <input type="text" name="annual_revenue" value="" class="form-control">
				                                
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">SIC Code</label>
				                              <div class="append-icon">
				                                <input type="text" name="sic" value="" class="form-control">
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  <div class="row">
										  <div class="col-sm-6">
				                            <h3> Address Information </h3> 	
											</div>
											</div>
									<div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Billing Streets</label>
				                              <div class="append-icon">
				                                <input type="text" name="billing_street" value="" class="form-control">
				                                 
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Shipping Streets</label>
				                              <div class="append-icon">
				                                <input type="text" name="shipping_street" value="" class="form-control">
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  	<div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Billing City</label>
				                              <div class="append-icon">
				                                <input type="text" name="billing_city" value="" class="form-control">
				                                 
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Shipping City</label>
				                              <div class="append-icon">
				                                <input type="text" name="shipping_city" value="" class="form-control">
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  	<div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Billing State</label>
				                              <div class="append-icon">
				                                <input type="text" name="billing_state" value="" class="form-control">
				                                 
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Shipping State</label>
				                              <div class="append-icon">
				                                <input type="text" name="shipping_state" value="" class="form-control">
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  	<div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Billing Code</label>
				                              <div class="append-icon">
				                                <input type="text" name="billing_code" value="" class="form-control">
				                                 
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Shipping Code</label>
				                              <div class="append-icon">
				                                <input type="text" name="shipping_code" value="" class="form-control">
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  	<div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Billing Country</label>
				                              <div class="append-icon">
				                                <input type="text" name="billing_country" value="" class="form-control">
				                                 
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Shipping Country</label>
				                              <div class="append-icon">
				                                <input type="text" name="shipping_country" value="" class="form-control">
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  <h3>Description Information </h3>
										  	<div class="row">
				                        	<div class="col-sm-12">
				                            <div class="form-group">
				                              <label class="control-label">Description</label>
				                              <div class="append-icon">
				                                <textarea name="description" rows="4" class="form-control"></textarea>   
					                              
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  
                        				<div class="text-left  m-t-20">
                         				 <div id="account_submitbutton"><button type="submit" class="btn btn-embossed btn-primary">Create</button></div>
                           
                        </div>
                      </form>             
                  				    
                  </div>
                  </div>
                 
           	</div>
            	
 		</div>   
  <!-- END PAGE CONTENT -->
 
