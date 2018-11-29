<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

$(document).ready(function() {

	$("form[name='form_campaign']").submit(function(e) {
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "<?php echo base_url('admin/campaign/save'); ?>",
            type: "POST",
            data: formData,
            async: false,
            success: function (msg) {
				
				var str=msg.split("_");
				var id=str[1];
				var status=str[0]; 
				var update=str[2]; 
				
				if(status=="yes")
				{
					$('body,html').animate({ scrollTop: 0 }, 200);
					if (update=="add") {
					$("#campaign_ajax").html('<?php echo '<div class="alert alert-success">'.$this->lang->line('create_succesful').'</div>'?>');
					setTimeout(function () {
					window.location.href="<?php echo base_url('admin/campaign/index' ); ?>/";
					}, 800); //will call the function after 1 secs.
					}else if(update=="update"){
					$("#campaign_ajax").html('<?php echo '<div class="alert alert-success">'.$this->lang->line('update_succesful').'</div>'?>');
					setTimeout(function () {
					window.location.href="<?php echo base_url('admin/campaign/index' ); ?>/";
					}, 800); //will call the function after 1 secs.
					}	
					
				}else
				{
			$('body,html').animate({ scrollTop: 0 }, 200);
            $("#campaign_ajax").html(msg); 
			$("#campaign_submitbutton").html('<button type="submit" class="btn btn-embossed btn-primary">Save</button>');
			}
			// $("form[name='add_opportunities']").find("input[type=text], textarea").val("");
			
            
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
            <h2><strong><?php echo $title; ?></strong></h2>            
          </div>
           <div class="row">
           	<div class="col-md-12">
                  <div class="panel">
                     
                     <div class="panel-content">
						<div id="campaign_ajax"> 
							  <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');}?>        
						</div>
				            <form id="form_campaign" name="form_campaign" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">

								<input type="hidden" name="campaign_id" value="<?php if(count($campaign) > 0) {echo $campaign->id;}?>"/>

									<div class="row">
										 <div class="col-sm-6">
											<div class="form-group">
											  <label class="control-label" style="color:red;">* Campaign Owner</label>
											  <div class="append-icon">
												 
												<select name="campaign_owner" class="form-control" data-search="true">
												<option value=""></option>
												<?php foreach( $staffs as $staff){ ?>
												<option value="<?php echo $staff->id;?>" <?php if (count($campaign) > 0) { if($campaign->customer_id==$staff->id){?>selected<?php }}?>><?php echo $staff->first_name.' '. $staff->last_name;?></option>
												<?php }?> 
												</select>
											  </div>
											</div>
										  </div>
										<div class="col-sm-6">
											<div class="form-group">
											  <label class="control-label" style="color:red;">* Type</label>
											  <div class="append-icon">
												<select name="campaign_type" class="form-control" data-search="true">
												<option value=""></option>
												<?php foreach( $type as $type){ ?>
												<option value="<?php echo $type->system_code;?>" <?php if (count($campaign) > 0) { if($campaign->type==$type->system_code){?>selected<?php }}?>><?php echo $type->system_value_txt;?></option>
												<?php }?> 
												</select>
											  </div>
											</div>
										</div>
									</div>
									
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
											  <label class="control-label" style="color:red;">* Campaign Name</label>
											  <div class="append-icon">
												<input type="text" name="campaign_name" value="<?php if (count($campaign) > 0) {echo $campaign->campaign_name;}?>" class="form-control">
											  </div>
											</div>
										  </div>
										<div class="col-sm-6">
											<div class="form-group">
											  <label class="control-label" style="color:red;">* Status</label>
											  <div class="append-icon">
												<select name="campaign_sts" class="form-control" data-search="true">
												<option value=""></option>
												<?php foreach( $status as $status){ ?>
												<option value="<?php echo $status->system_code;?>" <?php if (count($campaign) > 0) { if($campaign->status==$status->system_code){?>selected<?php }}?>><?php echo $status->system_value_txt;?></option>
												<?php }?> 
												</select>
											  </div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
											  <label class="control-label" style="color:red;">* Campaign Source</label>
											  <div class="append-icon">
												<select name="campaign_source_id" class="form-control" data-search="true">
												<option value=""></option>
												<?php foreach( $sources as $source){ ?>
												<?php if ($source->system_value_txt !=''){ ?>
												<option value="<?php echo $source->system_code;?>" <?php if($campaign->campaign_source_id==$source->system_code){?>selected<?php }?>><?php echo $source->system_value_txt;?></option>
													<?php }?> 
												<?php }?> 
												</select>	 
											  </div>
											</div>
										  </div>
										<div class="col-sm-6">
											<div class="form-group">
											  <label class="control-label" style="color:red;">* Num sent</label>
											  <div class="append-icon">
												<input type="text" name="num_sent" value="<?php if (count($campaign) > 0) {echo $campaign->num_sent;}?>" class="form-control numeric">
											  </div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
											  <label class="control-label" style="color:red;">* Start Date</label>
											  <div class="append-icon">
												<input type="text" name="start_date" value="<?php if (count($campaign) > 0) {echo ($campaign->start_date)? date('m/d/Y',$campaign->start_date) : "";}?>" class="date-picker form-control">
												<i class="icon-calendar"></i>
											  </div>
											</div>
										</div>										<div class="col-sm-6">
											<div class="form-group">
											  <label class="control-label" style="color:red;">* End Date</label>
											  <div class="append-icon">
												<input type="text" name="end_date" value="<?php if (count($campaign) > 0) {echo ($campaign->end_date)? date('m/d/Y',$campaign->end_date) : "";}?>" class="date-picker form-control">
												<i class="icon-calendar"></i>
											  </div>
											</div>
										</div>
										  
									</div> 
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
											  <label class="control-label" style="color:red;" >* Expected Revenue</label>
											  <div class="append-icon">
												<input type="text" name="expected_revenue" value="<?php if (count($campaign) > 0) {echo $campaign->expected_revenue;}?>" class="form-control numeric">
												 <i class="fa fa-usd"></i>
											  </div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
											  <label class="control-label" style="color:red;">* Budgeted Cost</label>
											  <div class="append-icon">
												<input type="text" name="budgeted_cost" value="<?php if (count($campaign) > 0) {echo $campaign->budgeted_cost;}?>" class="form-control numeric">
												 <i class="fa fa-usd"></i>
											  </div>
											</div>
										</div>
										
									</div>
									
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
											  <label class="control-label" style="color:red;">* Actual Cost</label>
											  <div class="append-icon">
												<input type="text" name="actual_cost" value="<?php if (count($campaign) > 0) {echo $campaign->actual_cost;}?>" class="form-control numeric">
												 <i class="fa fa-usd"></i>
											  </div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
											  <label class="control-label" style="color:red;">* Expected Response</label>
											  <div class="append-icon">
												<input type="text" name="expected_response" value="<?php if (count($campaign) > 0) {echo $campaign->expected_response;}?>" class="form-control">
											  </div>
											</div>
										</div>
										
									</div>
									
									

									<div class="row">										
										<div class="col-sm-8">
											<div class="form-group">
											  <label class="control-label" style="color:red;">* Description Information</label>
											  <div class="append-icon">
												 
												<textarea name="description_information" rows="4" class="form-control"><?php if (count($campaign) > 0) {echo $campaign->description;}?></textarea> 
											  </div>
											</div>
										</div>
									</div>  
									<div class="text-left  m-t-20">
										<div id="campaign_submitbutton"><button type="submit" class="btn btn-embossed btn-primary"><?php echo $submit;?></button></div>
									</div>
                      </form>             
                  				    
                  </div>
                  </div>
                </div>
           	</div>
            	
 		</div>   
  <!-- END PAGE CONTENT -->
 
