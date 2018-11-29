<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>
$(document).ready(function() {
	$("form[name='send_invoice']").submit(function(e) {
		 
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: "<?php echo base_url('admin/invoices/send_invoice'); ?>",
            type: "POST",
            data: formData,
            async: false,
            success: function (msg) {
			$('body,html').animate({ scrollTop: 0 }, 200);
            $("#sendby_ajax").html(msg); 
			$("#sendby_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');
			 
			 
            
        },
            cache: false,
            contentType: false,
            processData: false
        });

        e.preventDefault();
    });
});	

function create_pdf( invoice_id )
 { 
  
    $.ajax({
        type: "GET",
        url: "<?php echo base_url('admin/invoices/ajax_create_pdf' ); ?>/" + invoice_id,
        success: function(msg)
        {
			if( msg != '' )
            {	  
                
                $("#pdf_url").attr("href", msg)
                
                var index = msg.lastIndexOf("/") + 1;
				var filename = msg.substr(index);				 
				$("#pdf_url").html(filename);
				
				$("#invoice_pdf").val(filename);
				
            }
             
        }

    });
   
    
 }	
</script>
<!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
        <div class="row">
            <h2 class="col-md-6"><strong>Invoice <?php echo $invoice->invoice_number;?></strong></h2> 
            <div style="float:right; padding-top:10px;">
               <?php if (check_staff_permission('invoices_write')){?>
               <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-send_by_email" onclick="create_pdf(<?php echo $invoice->id;?>)">Send by Email</a>
               
               <a href="<?php echo base_url('admin/invoices/print_quot/'.$invoice->id); ?>" class="btn btn-primary" target="">Print</a>
                
               <a href="<?php echo base_url('admin/invoices/update/'.$invoice->id); ?>" class="btn btn-primary">Edit</a>
                
               <?php }?> 
			    		
            </div>                
          </div>
           <div class="row">
           	 
                  <div class="panel">
                     
                     <div class="panel-content">
                   				 
                        			 			 
                        				<div class="row">
                          					&nbsp;	   
					                    </div>
					                     <div class="row">
                          					 
					                          	<div class="col-sm-6">
					                            <div class="row">
					                            <div class="col-sm-12">
					                          	  <div class="form-group">
					                              <label class="col-sm-4 control-label"><i class="fa fa-user"></i>Customer</label>
					                              <div class="col-sm-8 append-icon">  
					                              <?php echo customer_name($salesorder->customer_id)->name; ?><br/>
					                          <?php echo $this->customers_model->get_company($salesorder->customer_id)->address; ?>     
					                              </div>
					                              
					                            </div>
												</div>
												</div> 
												 <div class="row">
					           		                 <div class="col-sm-12">
					                          	  <div class="form-group">
					                              <label class="col-sm-4 control-label"><i class="fa fa-calendar"></i>Invoice Date</label>
					                              <div class="col-sm-8 append-icon">
					                                 <?php echo date('m/d/Y',$invoice->invoice_date); ?> 
					                              </div>
					                              
					                            </div>
												</div>
												</div> 
												 <div class="row">
					           		                 <div class="col-sm-12">
					                          	  <div class="form-group">
					                              <label class="col-sm-4 control-label"><i class="fa fa-calendar"></i>Due Date</label>
					                              <div class="col-sm-8 append-icon">
					                                 <?php echo date('m/d/Y',$invoice->due_date); ?> 
					                              </div>
					                              
					                            </div>
												</div>
												</div> 	
												   
					                          </div>
												<div class="col-sm-6">
					                            
												
												<div class="row">
					           		                 <div class="col-sm-12">
					                          	  <div class="form-group">
					                              <label class="col-sm-4 control-label"><i class="fa fa-expand"></i>Payment Term</label>
					                              <div class="col-sm-8 append-icon">
					                               <?php if($invoice->payment_term==0){echo 'Immediate Payment';}else{echo $invoice->payment_term.' Days';} ?>   
					                                
					                              </div>
					                              
					                            </div>
												</div>
												</div>	 
												<div class="row">
					           		                 <div class="col-sm-12">
					                          	  <div class="form-group">
					                              <label class="col-sm-4 control-label"><i class="fa fa-plus-square"></i>Status</label>
					                              <div class="col-sm-8 append-icon">
					                               <?php echo $invoice->status; ?>   
					                                
					                              </div>
					                              
					                            </div>
												</div>
												</div> 
												<div class="row">
					           		                 <div class="col-sm-12">
					                          	  <div class="form-group">
					                              <label class="col-sm-4 control-label"><i class="fa fa-check-square"></i>TRN No</label>
					                              <div class="col-sm-8 append-icon">
					                               <?php echo $invoice->invoice_number; ?>   
					                                
					                              </div>
					                              
					                            </div>
												</div>
												</div> 
												  
					                          </div>
					                        </div>    
                        			     
                        			     <div class="row">
                        			     	
                        			     	<div class="panel-content">
                   									<label class="control-label"><i class="fa fa-cubes"></i>Order</label> 
                									 <table class="table">
									                    <thead>
									                      <tr style="font-size: 12px;">                         
									                        <th style='text-align:center;width:50px'>S/N</th>
									                        <th>Product & Description</th>
									                        <th style='text-align:center'>QTY</th>
									                        <th style='text-align:center'>UOM</th>
									                        <th style='text-align:center'>Unit Price</th>
									                        <th style='text-align:center'>Disc(%)</th>
									                        <th style='text-align:center'>Taxes</th>
									                        <th style='text-align:center'>Subtotal</th>
									                        <th></th>
									                      </tr>
									                    </thead>
									                    <tbody id="InputsWrapper">
									                      <?php if( ! empty($qo_products) ){ $no=0;?>
					    									<?php foreach( $qo_products as $qo_product){ $no++; ?> 
															<?php
															$product_id = $this->invoices_model->get_qo_product($qo_product->product_id)->product_id;
					    									$total_uom = $this->products_model->get_products($product_id)->total_uom;
					    									$uom_id = $this->products_model->get_products($product_id)->uom_id;
															$uom = $this->system_model->system_single_value('UOM', $uom_id)->system_value_txt;
															?>
					    								  <tr>
					    								  	<td style='text-align:center'><?php echo $no;?></td>
					    								 	<td><b><?php echo $qo_product->product_name;?></b><br><pre style= "border: medium none; background: none; padding: 0px; margin: 0px;"><?php echo $qo_product->discription;?></pre></td>
					    								  	<td style='text-align:center'><?php echo $qo_product->quantity;?></td>
															<td class=""><?php echo $uom;?></td>
															<td class="numeric"><?php echo number_format($qo_product->price, 2, '.', ',');?></td>
					    								  	<td class="numeric"><?php echo $this->invoices_model->get_qo_product($qo_product->product_id)->product_discount;?></td>
					    								  	<td class="numeric"><?php echo number_format($qo_product->quantity*$qo_product->price*$this->products_model->get_products($product_id)->tax/100,2,'.',',');?></td>
					    								  	
					    								  	<td class="numeric"><?php echo number_format($qo_product->sub_total, 2, '.', ',');?></td>
					    								  	
					    								  </tr>	
									                       
									                      <?php } ?>
					 									<?php } ?> 
									                       
									                    </tbody>
									                  </table>
									                  
                 									 </div>
                        			     	
                        			     </div>
                        			 
				                  <div class="row">
				                  	<div class="col-sm-8">
				                  		<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
												<label class="col-sm-4 control-label"><i class="fa fa-clipboard"></i>Terms and Conditions</label>
												<div class="col-sm-8 append-icon">
												<?php echo $invoice->terms_and_conditions; ?>      
												</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
									    <div class="row">
					           		                 <div class="col-sm-12">
					                          	  <div class="form-group">
					                              <label class="col-sm-6 control-label">Untaxed Amount </label>
					                              <div class="col-sm-6 append-icon numeric">
					                               <?php echo number_format($invoice->total, 2, '.', ','); ?> 
					                                
					                              </div>
					                              
					                            </div>
												</div>
												</div>
									    <div class="row">
					           		                 <div class="col-sm-12">
					                          	  <div class="form-group">
					                              <label class="col-sm-6 control-label">Discount </label>
					                              <div class="col-sm-6 append-icon numeric">
					                               <?php echo number_format($invoice->discount, 2, '.', ','); ?> 
					                                
					                              </div>
					                              
					                            </div>
												</div>
												</div>
									    <div class="row">
					           		                 <div class="col-sm-12">
					                          	  <div class="form-group">
					                              <label class="col-sm-6 control-label">Taxes </label>
					                              <div class="col-sm-6 append-icon numeric">
					                               <?php echo number_format($invoice->tax_amount, 2, '.', ','); ?> 
					                                
					                              </div>
					                              
					                            </div>
												</div>
												</div>
										<div class="row">
					           		                 <div class="col-sm-12">
					                          	  <div class="form-group">
					                              <label class="col-sm-6 control-label">Total </label>
					                              <div class="col-sm-6 append-icon numeric">
					                               <?php echo number_format($invoice->grand_total, 2, '.', ','); ?> 
					                                
					                              </div>
					                              
					                            </div>
												</div>
												</div>	
									</div>
				                  </div>       
				            <div class="row">
                          					&nbsp;	   
					         </div>            
                        			 
                  </div>
                  </div>
                 
           	</div>
            	
 		</div>   
  <!-- END PAGE CONTENT -->
  
  
<!-- START MODAL PRODUCT CONTENT -->
 <div class="modal fade" id="modal-send_by_email" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons-office-52"></i></button>
                  <h4 class="modal-title"><strong>Send </strong>by Email</h4>
                </div>
               	<div id="sendby_ajax" style="text-align:center;
"> 
				                          <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');}?>         
				  </div>
				  
               	 <div class="modal-body">
                  <form id="send_invoice" name="send_invoice" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
                  <input type="hidden" name="quotation_id" id="quotation_id" value="<?php echo $salesorder->id;?>" class="form-control">    
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="field-1" class="control-label">Subject</label> 
                        	<input type="text" name="email_subject" id="email_subject" value="Demo Company Invoice (Ref <?php echo $invoice->invoice_number;?>)" class="form-control"> 
                         
                      </div>
                    </div>
					 
                     
                  </div>
                   
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="field-1" class="control-label">Recipients</label> 
                        	<select name="recipients[]" id="recipients" class="form-control" data-search="true" multiple>
                                <option value=""></option>
                                <?php foreach( $companies as $company){ ?>
					               <option value="<?php echo $company->email;?>" <?php if($salesorder->customer_id==$company->id){?>selected<?php }?>><?php echo $company->name." (".$company->email.")";?></option>
					             
					             <?php }?> 
					       
					       </select>
                         
                      </div>
                    </div>
					 
                     
                  </div>
				  
				  <div class="row">
                    
					<div class="col-md-12">
                      <div class="form-group">
                        <label for="field-1" class="control-label"></label>
                         
                       <textarea name="message_body" id="message_body" cols="80" rows="10" class="cke-editor">
                       	
                       	<p>Hello <?php echo customer_name($salesorder->customer_id)->name; ?>,</p>

    <p>Here is your order confirmation from Demo Company: </p>

    <p style="border-left: 1px solid #8e0000; margin-left: 30px;">
       &nbsp;&nbsp;<strong>REFERENCES</strong><br>
       &nbsp;&nbsp;Invoice number: <strong><?php echo $invoice->invoice_number;?></strong><br>
       &nbsp;&nbsp;Invoice total: <strong><?php echo $invoice->grand_total; ?></strong><br>
       &nbsp;&nbsp;Invoice date: <?php echo date('m/d/Y',$invoice->invoice_date); ?> <br>
       
    </p>
                       	
                       </textarea>	 
                         
                      </div>
                    </div>
                     
                  </div>	
                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="field-1" class="control-label">File</label> 
                        	<a href="" id="pdf_url" target="_blank"></a>
                         <input type="hidden" name="invoice_pdf" id="invoice_pdf" value="" class="form-control">
                      </div>
                    </div>
					 
                     
                  </div> 
                  <div class="modal-footer text-center"> 
                   <div id="sendby_submitbutton"><button type="submit" class="btn btn-embossed btn-primary">Send</button></div>
                  </div>
                 </form> 
                  
                </div>
                  
                
              </div>
            </div>
          </div>
