<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

$(document).ready(function() {
	$("form[name='add_contact']").submit(function(e) {
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "<?php echo base_url('admin/contact/add_process'); ?>",
            type: "POST",
            data: formData,
            async: false,
            success: function (msg) {
			$('body,html').animate({ scrollTop: 0 }, 200);
            $("#contact_ajax").html(msg); 
			$("#contact_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');
			
			$("form[name='add_contact']").find("input[type=text], textarea").val("");
			
            
        },
            cache: false,
            contentType: false,
            processData: false
        });

        e.preventDefault();
    });
});
 
 function copyToClipboard(){
	 $("#mailing").select();
	 document.execCommand("copy");
 }

 </script>
 
 <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
        <div class="row">
            <h2 class="col-md-6"><strong>New Contact</strong></h2>
           </div>
           <div class="row">
           	 
                  <div class="panel">
                     
                     <div class="panel-content">
                   					<div id="contact_ajax"> 
				                          <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');}?>         
				                      </div>
				         <h3> Contact Information </h3>
				            <form id="add_contact" name="add_contact" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
 
                        				                        				 
                        				<div class="row">
                          					<div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label">Contact Owner</label>
					                              <div class="append-icon">
					                                <select name="contact_owner" class="form-control" data-search="true">
					                                <option value=""></option>
					                                <?php foreach( $owner as $owner){ ?>
					                                <option value="<?php echo $owner->system_value_txt;?>"><?php echo $owner->system_value_txt;?></option>
					                                <?php }?> 
					                                </select> </div>
					                            </div>
					                          </div>
					                           <div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label">Lead Source</label>
					                              <div class="append-icon">
													<select name="lead_source" class="form-control" data-search="true">
					                                <option value=""></option>
					                                <?php foreach( $leads as $leads){ ?>
					                                <option value="<?php echo $leads->system_value_txt;?>"><?php echo $leads->system_value_txt;?></option>
					                                <?php }?> 
					                                </select>     </select>
												 </div>
					                            </div>
					                          </div>
					                          
					                        </div>
                        				<div class="row">				                         
				                          <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">First Name</label>
				                              <div class="append-icon">
				                                 <input type="text" name="first_name" value="" class="form-control">
					                                </div>
				                            </div>
				                          </div>
				                           <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Last Name</label>
				                              <div class="append-icon">
				                                <input type="text" name="last_name" value="" class="form-control">
												
				                                
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
					                              <label class="control-label">Title</label>
					                              <div class="append-icon">
					                                <input type="text" name="fax" value="" class="form-control">
										         </div>
					                            </div>
					                          </div>
					                        </div>
					                    <div class="row">
					                          <div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label">Email</label>
					                              <div class="append-icon">
					                                <input type="email" name="email" value="" class="form-control">
													<i class="icon-envelope"></i>
												</div>
					                            </div>
					                          </div>
					                          <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Department</label>
				                              <div class="append-icon">
				                                <input type="text" name="department" value="" class="form-control">
				                              </div>
				                            </div>
				                          </div>
					                    </div>
					                        
				                        <div class="row">
				                          <div class="col-sm-6">
					                            <div class="form-group">
					                              <label class="control-label">Phone</label>
					                              <div class="append-icon">
					                            <input type="text" name="phone" value="" class="form-control">
												<i class="icon-screen-smartphone"></i>
     
					                              </div>
					                            </div>
					                          </div>
					                          <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Home Phone</label>
				                              <div class="append-icon">
				                                <input type="text" name="home_phone" value="" class="form-control">
												<i class="icon-screen-smartphone"></i>
        
				                              </div>
				                            </div>
				                          </div>												 
				                        </div>
				                        <div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Other Phone</label>
				                              <div class="append-icon">
												<input type="text" name="other_phone" value="" class="form-control">
												<i class="icon-screen-smartphone"></i>
     			                                 
				                              </div>
				                            </div>
				                          </div>
											 <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Fax</label>
				                              <div class="append-icon">
				                                <input type="text" name="fax" value="" class="form-control">
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
				                              <label class="control-label">Mobile</label>
				                              <div class="append-icon">
				                              <input type="text" name="mobile" value="" class="form-control">
												   
				                              </div>
				                            </div>
				                          </div>
										<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Date Of Birth</label>
				                              <div class="append-icon">
											<input type="text" id="min" name="date_birth" class="date-picker form-control">
											<i class="icon-calendar"></i>
											</div>
				                            </div>
				                          </div>
										  </div>
										  <div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Assistant</label>
				                              <div class="append-icon">
				                                <input type="text" name="assistant" value="" class="form-control">
				                                
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Asst Phone</label>
				                              <div class="append-icon">
				                                <input type="text" name="asst_phone" value="" class="form-control">
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  <div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Reports To</label>
				                              <div class="append-icon">
				                                <input type="text" name="reports_to" value="" class="form-control">
				                                
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Email Opt Out</label>
				                              <div class="append-icon">
				                                <input type="checkbox" name="sic" value="" class="form-control">
											
				                              </div>
				                            </div>
				                          </div></div>
										  <div class="row">
										  <div class="col-sm-6"></div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Email Opt Out</label>
				                              <div class="append-icon">
				                             <input type="checkbox" name="email_opt" value="1" data-checkbox="icheckbox_square-blue"/> 
					                            
												</div>
				                            </div>
				                          </div>
										  </div>
										  
										  <div class="row">
										  <div class="col-sm-6"></div>
										  <div class="col-sm-6">
				                             <div class="form-group">
				                              <label class="control-label">Skype ID</label>
				                              <div class="append-icon">
				                                <input type="text" name="skype_id" value="" class="form-control">
													<i class="fa fa-skype"></i>
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  <div class="row">
										  <div class="col-sm-6"></div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Secondary Email</label>
				                              <div class="append-icon">
				                                <input type="email" name="secondary_email" value="" class="form-control">
													<i class="icon-envelope"></i>
				                              </div>
				                            </div>
				                          </div>
										  </div>
										   <div class="row">
										  <div class="col-sm-6"></div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Twitter</label>
				                              <div class="append-icon">
				                              <div class="input-group">
											  <div class="input-group-addon">@</div>
											     <input type="text" name="twitter" value="" class="form-control">
												 <i class="fa fa-twitter"></i>

				                              </div>
				                            </div>
				                          </div>
										  </div>
										  </div>
					
										<div class="row">
										  <div class="col-sm-6">
				                            <h3> Address Information </h3> 
											</div>
											<div class="col-sm-6">
				                            <button onclick="copyToClipboard()" style="float:right;margin-top: 25px;margin-bottom: 15px;"> Copy Address </button>
											</div></div>
									<div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Mailling Streets</label>
				                              <div class="append-icon">
				                                <input type="text" id="mailing" name="mailling_street" value="" class="form-control">
				                                 
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Other Streets</label>
				                              <div class="append-icon">
				                                <input type="text" name="other_street" value="" class="form-control">
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  	<div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Mailing City</label>
				                              <div class="append-icon">
				                                <input type="text" name="mailling_city" value="" class="form-control">
				                                 
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Other City</label>
				                              <div class="append-icon">
				                                <input type="text" name="other_city" value="" class="form-control">
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  	<div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Mailing State</label>
				                              <div class="append-icon">
				                                <input type="text" name="mailling_state" value="" class="form-control">
				                                 
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Other State</label>
				                              <div class="append-icon">
				                                <input type="text" name="other_state" value="" class="form-control">
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  	<div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Mailing Zip</label>
				                              <div class="append-icon">
				                                <input type="text" name="mailling_zip" value="" class="form-control">
				                                 
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Other Zip</label>
				                              <div class="append-icon">
				                                <input type="text" name="other_zip" value="" class="form-control">
				                              </div>
				                            </div>
				                          </div>
										  </div>
										  	<div class="row">
				                        	<div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Mailing Country</label>
				                              <div class="append-icon">
				                                <input type="text" name="mailling_country" value="" class="form-control">
				                                 
				                              </div>
				                            </div>
				                          </div>
										  <div class="col-sm-6">
				                            <div class="form-group">
				                              <label class="control-label">Other Country</label>
				                              <div class="append-icon">
				                                <input type="text" name="other_country" value="" class="form-control">
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
                         				 <div id="contact_submitbutton"><button type="submit" class="btn btn-embossed btn-primary">Create</button></div>
                           
                        </div>
                      </form>             
                  				    
                  </div>
                  </div>
                 
           	</div>
            	
 		</div>   
  <!-- END PAGE CONTENT -->
