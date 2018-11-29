<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

$(document).ready(function() {
	$("form[name='update_account']").submit(function(e) {
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "<?php echo base_url('admin/account/update_process'); ?>",
            type: "POST",
            data: formData,
            async: false,
            success: function (msg) {
			$('body,html').animate({ scrollTop: 0 }, 200);
            $("#account_ajax").html(msg); 
			$("#account_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');
			
			  
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
            <h2><strong>Update Account</strong></h2>            
          </div>
           <div class="row">
           	<div class="col-md-12">
                  <div class="panel">
                     
                     <div class="panel-content">
                   					<div id="account_ajax"> 
				                          <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');}?>         
				                      </div>
				         
				           <form id="update_account" name="update_account" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
							<input type="hidden" name="id" value="<?php echo $account->id; ?>" />	                                        				 
                  				 
                        				<div class="row">
                          					<div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label">Account Owner</label>
					                              <div class="append-icon">
													<select name="account_owner" id="account_owner" class="form-control" data-search="true">
					                                 <option value=""></option>
													<?php foreach( $owner as $owner){ ?>
					                                <option value="<?php echo $owner->system_code;?>" <?php if($account->account_owner==$owner->system_code){?>selected<?php }?>><?php echo $owner->system_value_txt;?></option>
					                                <?php }?> 
												</select>
												 </div>
					                            </div>
					                          </div>
					                           <div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label">Rating</label>
					                              <div class="append-icon">
					                         		<select name="rating" id="rating" class="form-control" data-search="true">
					                                <option value=""></option>
													<?php foreach( $rating as $rating){ ?>
					                                <option value="<?php echo $rating->system_code;?>" <?php if($account->rating==$rating->system_code){?>selected<?php }?>><?php echo $rating->system_value_txt;?></option>
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
				                                 <input type="text" name="account_name" value="<?php echo $account->account_name;?>" class="form-control">
					                                </div>
				                            </div>
				                          </div>
				                           <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Phone</label>
				                              <div class="append-icon">
				                                <input type="text" name="phone" value="<?php echo $account->phone;?>" class="form-control">
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
					                                <input type="text" name="account_site" value="<?php echo $account->account_site;?>" class="form-control">
					                         <i class="icon-globe"></i>
											 </div>
					                            </div>
					                          </div>
					                          <div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label">Fax</label>
					                              <div class="append-icon">
					                                <input type="text" name="fax" value="<?php echo $account->fax;?>" class="form-control">
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
					                                <input type="text" name="parent_account" value="<?php echo $account->parent_account;?>" class="form-control">
					                               </div>
					                            </div>
					                          </div>
					                          <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Website</label>
				                              <div class="append-icon">
				                                <input type="text" name="website" value="<?php echo $account->website;?>" class="form-control">
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
					                            <input type="text" name="account_number" value="<?php echo $account->account_number;?>" class="form-control">
												<i class="icon-screen-smartphone"></i>
     				                                 
					                              </div>
					                            </div>
					                          </div>
					                          <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Ticker Symbol</label>
				                              <div class="append-icon">
				                               <input type="text" name="ticker" value="<?php echo $account->ticker;?>" class="form-control">
												   
				                              </div>
				                            </div>
				                          </div>												 
				                        </div>
				                        <div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Account Type</label>
				                              <div class="append-icon">
													<select name="account_type" id="account_type" class="form-control" data-search="true">
					                                <option value=""></option>
													<?php foreach( $type as $type){ ?>
					                                <option value="<?php echo $type->system_code;?>" <?php if($account->account_type==$type->system_code){?>selected<?php }?>><?php echo $type->system_value_txt;?></option>
					                                <?php }?> 
												</select>
																									
				                              </div>
				                            </div>
				                          </div>
											 <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Ownership</label>
				                              <div class="append-icon">
													<div class="append-icon">
													<select name="ownership" id="ownership" class="form-control" data-search="true">
					                                <option value=""></option>
													<?php foreach( $ownership as $ownership){ ?>
					                                <option value="<?php echo $ownership->system_code;?>" <?php if($account->ownership==$ownership->system_code){?>selected<?php }?>><?php echo $ownership->system_value_txt;?></option>
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
				                        </div></div>
				                        <div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Industry</label>
				                              <div class="append-icon">
													<select name="industry" id="industry" class="form-control" data-search="true">
					                                <option value=""></option>
													<?php foreach( $industry as $industry){ ?>
					                                <option value="<?php echo $industry->system_code;?>" <?php if($account->industry==$industry->system_code){?>selected<?php }?>><?php echo $industry->system_value_txt;?></option>
					                                <?php }?> 
												</select>
												
											  </div>
				                            </div>
				                          </div>
										<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Employees</label>
				                              <div class="append-icon">
				                                <input type="text" name="employee" value="<?php echo $account->employee;?>" class="form-control">
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  <div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Annual Revenue</label>
				                              <div class="append-icon">
				                                <input type="text" name="annual_revenue" value="<?php echo $account->annual_revenue;?>" class="form-control">
				                                
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">SIC Code</label>
				                              <div class="append-icon">
				                                <input type="text" name="sic" value="<?php echo $account->sic;?>" class="form-control">
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
				                                <input type="text" name="billing_street" value="<?php echo $account->billing_street;?>" class="form-control">
				                                 
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Shipping Streets</label>
				                              <div class="append-icon">
				                                <input type="text" name="shipping_street" value="<?php echo $account->shipping_street;?>" class="form-control">
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  	<div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Billing City</label>
				                              <div class="append-icon">
				                                <input type="text" name="billing_city" value="<?php echo $account->billing_city;?>" class="form-control">
				                                 
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Shipping City</label>
				                              <div class="append-icon">
				                                <input type="text" name="shipping_city" value="<?php echo $account->shipping_city;?>" class="form-control">
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  	<div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Billing State</label>
				                              <div class="append-icon">
				                                <input type="text" name="billing_state" value="<?php echo $account->billing_state;?>" class="form-control">
				                                 
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Shipping State</label>
				                              <div class="append-icon">
				                                <input type="text" name="shipping_state" value="<?php echo $account->shipping_state;?>" class="form-control">
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  	<div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Billing Code</label>
				                              <div class="append-icon">
				                                <input type="text" name="billing_code" value="<?php echo $account->billing_code;?>" class="form-control">
				                                 
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Shipping Code</label>
				                              <div class="append-icon">
				                                <input type="text" name="shipping_code" value="<?php echo $account->shipping_code;?>" class="form-control">
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  	<div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Billing Country</label>
				                              <div class="append-icon">
				                                <input type="text" name="billing_country" value="<?php echo $account->billing_country;?>" class="form-control">
				                                 
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Shipping Country</label>
				                              <div class="append-icon">
				                                <input type="text" name="shipping_country" value="<?php echo $account->shipping_country;?>" class="form-control">
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
				                                <textarea name="description"  rows="4" class="form-control"><?php echo $account->description;?></textarea>   
					                              
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  
                        				<div class="text-left  m-t-20">
                         				 <div id="account_submitbutton"><button type="submit" class="btn btn-embossed btn-primary">Update</button></div>
                           
                        </div>
                      </form>              
                  				    
                  </div>
                  </div>
                </div>
           	</div>
            	
 		</div>   
  <!-- END PAGE CONTENT -->
 

 
