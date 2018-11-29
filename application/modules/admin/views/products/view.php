<!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
        <div class="row">
            <h2 class="col-md-6"><strong><?php echo $product->product_name;?></strong></h2> 
            <div style="float:right; padding-top:10px;">
               <?php if (check_staff_permission('products_write')){?>
               <a href="<?php echo base_url('admin/products/update/'.$product->id); ?>" class="btn btn-primary btn-embossed">Edit Product</a>
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
					                              <label class="col-sm-4 control-label"></label>
					                              <div class="col-sm-8 append-icon">
					                                <?php if($product->product_image){?>	
					             	<img src="<?php echo base_url('uploads/products').'/'.$product->product_image; ?>" alt="company image">  
					             	<?php }else{?>
					             		<img src="<?php echo base_url('uploads/products').'/default.gif'; ?>" alt="user image" class="img-lg img-thumbnail">  
					             	<?php }?>
					                                 
					                              </div>
					                              
					                            </div>
												</div>
												</div>
												 
					                          </div>
					                          	<div class="col-sm-6">
					                            <div class="row">
					                            <div class="col-sm-12">
					                          	  <div class="form-group">
					                              <label class="col-sm-4 control-label">Internal Category</label>
					                              <div class="col-sm-8 append-icon">
					                                <?php echo $this->system_model->system_single_value('INTERNAL_CAT' ,$product->internal_category)->system_value_txt; ?>
					                                
					                              </div>
					                              
					                            </div>
												</div>
												</div> 
												 <div class="row">
					           		                 <div class="col-sm-12">
					                          	  <div class="form-group">
					                              <label class="col-sm-4 control-label">Status</label>
					                              <div class="col-sm-8 append-icon">
					                                <?php echo $product->status;?>
					                                
					                              </div>
					                              
					                            </div>
												</div>
												</div> 
												<div class="row">
					           		                 <div class="col-sm-12">
					                          	  <div class="form-group">
					                              <label class="col-sm-4 control-label">Quantity On Hand</label>
					                              <div class="col-sm-8 append-icon">
					                                <?php echo $product->quantity_on_hand;?>
					                                
					                              </div>
					                              
					                            </div>
												</div>
												</div>
												<div class="row">
					           		                 <div class="col-sm-12">
					                          	  <div class="form-group">
					                              <label class="col-sm-4 control-label">Quantity Available</label>
					                              <div class="col-sm-8 append-icon">
					                                <?php echo $product->quantity_available;?>
					                                
					                              </div>
					                              
					                            </div>
												</div>
												</div>
												 <div class="row">
					           		                 <div class="col-sm-12">
					                          	  <div class="form-group">
					                              <label class="col-sm-4 control-label">Tax</label>
					                              <div class="col-sm-8 append-icon">
					                                <?php echo $product->tax;?> %
					                                
					                              </div>
					                              
					                            </div>
												</div>
												</div>
												<div class="row">
					           		                 <div class="col-sm-12">
					                          	  <div class="form-group">
					                              <label class="col-sm-4 control-label">UOM</label>
					                              <div class="col-sm-8 append-icon">
					                                <?php 
					                                $single_val = $this->system_model->system_single_value('UOM', $product->uom_id);
					                                if (count($single_val) > 0){
					                                	echo $single_val->system_value_txt;
					                                }
					                                ?> 
					                              </div>
					                              
					                            </div>
												</div>
												</div>
												  
					                          </div>
					                        </div>    
                        			   
                        			    <ul class="nav nav-tabs">
				                        <li class="active"><a href="#tab1_1" data-toggle="tab">Information</a></li>
				                        <li class=""><a href="#tab1_2" data-toggle="tab">Sales</a></li>                      
				                      </ul>
					                     <div class="tab-content">
						                        <div class="tab-pane fade active in" id="tab1_1">
							                           <div class="panel-body bg-white">
						                 			  		   											 				  							  <div class="row">
						                 			  <div class="col-sm-6">
						                 			   <div class="col-sm-12">
							                          	  <div class="form-group">
							                              <label class="col-sm-4 control-label">Product Type</label>
							                              <div class="col-sm-8 append-icon">
							                                <?php echo $product->product_type;?>
							                                
							                              </div>
							                              
							                            </div>
														</div>
						                 			  </div>
						                 			  <div class="col-sm-6">
						                 			  		<div class="col-sm-12">
							                          	  <div class="form-group">
							                              <label class="col-sm-4 control-label">Active</label>
							                              <div class="col-sm-8 append-icon">
							                                <input type="checkbox" name="active" <?php if($product->active==1){?>checked<?php }?> value="1" data-checkbox="icheckbox_square-blue" disabled/>
							                                
							                              </div>
							                              
							                            </div>
														</div>
						                 			  </div>		   											 				  		   
					                    			     </div>
					                    			     <div class="row">
						                 			  <div class="col-sm-6">
						                 			   <div class="col-sm-12">
							                          	  <div class="form-group">
							                              <label class="col-sm-4 control-label">Sale Price</label>
							                              <div class="col-sm-8 append-icon">
							                                <?php echo number_format($product->sale_price,2,'.',',');?>
							                                
							                              </div>
							                              
							                            </div>
														</div>
						                 			  </div>
						                 			  </div>
					                    			  <div class="row">
						                 			  <div class="col-sm-12">
						                 			  <?php echo $product->description;?>
						                 			  </div>
						                 			  </div>    
	 													 
														 
							               			   </div>
						                        </div>
											<div class="tab-pane fade" id="tab1_2">
												<div class="panel-body bg-white">	
													<div class="col-sm-12">
					                            <div class="form-group">
					                               <label class="control-label">Description for Quotations</label>
					                              <div class="append-icon">
					                                
					                                <?php echo $product->description_for_quotations;?>
					                              </div>
					                            </div>
					                          </div>
												</div>
					                         </div> 
					                          
					                        </div>
				                         
				                         
                        			 
                  </div>
                  </div>
                 
           	</div>
            	
 		</div>   
  <!-- END PAGE CONTENT -->
