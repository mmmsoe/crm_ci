<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    function get_opportunities()
    {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('admin/logged_calls/get_opportunities_by_comp') ?>',
            data: {company_id: '<?php echo $call->company_id?>'},
            dataType: 'json',
            success: function (res) {
                $('#opportunity_id').empty();
                $('#opportunity_id').append('<option value=""></option>');
                $.each(res.data, function (i, r) {
                    if(r.id == '<?php echo $call->opportunity_id?>')
                    {
                        $('#opportunity_id').append('<option value="' + r.id + '" selected="selected">' + r.opportunity + '</option>');
                    }
                    else
                    {
                        $('#opportunity_id').append('<option value="' + r.id + '">' + r.opportunity + '</option>');
                    }
                });
            },
        });
    }
$(document).ready(function() {
    get_opportunities();
	$("form[name='edit_call']").submit(function(e) {
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "<?php echo base_url('admin/logged_calls/update_process'); ?>",
            type: "POST",
            data: formData,
            async: false,
            success: function (msg) {
			$('body,html').animate({ scrollTop: 0 }, 200);
                        $("#call_ajax").html(msg); 
			$("#call_submitbutton").html('<button type="submit" class="btn btn-primary btn-embossed bnt-square">Save</button>');
			<?php if ($this->uri->segment(5) != ""): ?>
                        window.location = '<?php echo base_url('admin/customers/view/' . $this->uri->segment(5)); ?>';
<?php else: ?>
                        window.location = '<?php echo base_url('admin/logged_calls'); ?>';
<?php endif; ?>
			  
        },
            cache: false,
            contentType: false,
            processData: false
        });

        e.preventDefault();
    });
}); 
</script
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
      	  <div class="header">
            <h2><strong>Update Logged Call</strong></h2>  
             
            <div class="breadcrumb-wrapper">
                 
            </div>          
          </div>
		
		 <div class="row">
           	 
                  <div class="panel">
                     
                     <div class="panel-content">
                   					<div id="call_ajax"> 
				                          <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');}?>         
				                      </div>
				         
						<form id="edit_call" name="edit_call" class="form-validation" accept-charset="utf-8" enctype="multipart/form-data" method="post">
               
               	 <input type="hidden" name="call_id" value="<?php echo $call->id;?>"/>	
               
               	                          	
               	 <div class="modal-body">
                   
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="field-1" class="control-label">Date</label>
                        <input type="text" class="datetimepicker form-control" name="date" id="date" placeholder="" value="<?php echo date('m/d/Y H:i',$call->date); ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="field-2" class="control-label">Call	Summary</label>
                        <input type="text" class="form-control" name="call_summary" id="call_summary" value="<?php echo $call->call_summary;?>" placeholder="">
                      </div>
                    </div>
                  </div>
                   
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="field-4" class="control-label">Contact</label>
                         
                         <select name="company_id" id="company_id" class="form-control" data-search="true">
					                                <option value=""></option>
					                                <?php foreach( $companies as $company){ ?>
					                                <option value="<?php echo $company->id;?>" <?php if($call->company_id==$company->id){?>selected<?php }?>><?php echo $company->name;?></option>
					                                <?php }?> 
					                                </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="field-5" class="control-label">Responsible</label>
                         <select name="resp_staff_id" id="resp_staff_id" class="form-control" data-search="true">
					                                <?php foreach( $staffs as $staff){ ?>
					                                <option value="<?php echo $staff->id;?>" <?php if($call->resp_staff_id==$staff->id){?>selected<?php }?>><?php echo $staff->first_name.' '.$staff->last_name;?></option>
					                                <?php }?> 
					       </select>
                      </div>
                    </div>
                     
                  </div>
          <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="field-4" class="control-label">Opportunity</label>
                                    <select name="opportunity_id" id="opportunity_id" class="form-control" data-search="true">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">

                            </div>

                        </div>
                </div>
                 
                  <div id="call_submitbutton" class="modal-footer text-center"><button type="submit" class="btn btn-primary btn-embossed bnt-square">Update</button></div>
                 
                </form>
					</div>
				</div>
			 
		</div>			
               
</div>              