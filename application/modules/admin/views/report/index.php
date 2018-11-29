<style>
th{font-size:10px;}
</style>
<!-- BEGIN PAGE CONTENT -->
<div class="page-content">
	<div class="row">
    <a href="<?php echo base_url('admin/report/'); ?>" class="btn btn-black btn-embossed"> Manage Report</a> 	
   	</div>
    <div class="row">
		<div class="panel">	
		<!-- 
		<div class="panel-content">
		  <ul class="nav nav-tabs">
			<li class="active"><a href="#tab1_1" data-toggle="tab">Opportunity Reports</a></li>
			<li class=""><a href="#tab1_2" data-toggle="tab">Lead Reports</a></li>
			<li class=""><a href="#tab1_3" data-toggle="tab">Account and Contact Reports</a></li>
			<li class=""><a href="#tab1_4" data-toggle="tab">Sales Metrics Reports</a></li> 
		  </ul>
		<div class="tab-content">
		-->
			
			
			<!--START Tab Potensial Reports -->
                <div class="tab-pane fade active in" id="tab1_1">
					<div class="panel-content table-responsive">
					
					  <table class="table table-hover filter-between_date" id="tbPotensial">
						<thead>
						  <tr>                        
							<th>Report Name</th>
							<th>Descrption</th> 
						  </tr>
						</thead>
						<tbody>

							<tr>
								<td><a href="<?php echo base_url('admin/report/pipeline_stages'); ?>">Pipeline by Stage</a></td>
                                <td>Opportunities by their Stage.</td>
							</tr>
							<tr>
								<td><a href="<?php echo base_url('admin/report/key_account'); ?>">Opportunities by Account</a></td>
								<td>Accounts that have more number of Potentials.</td>
							</tr>
						</tbody>
					  </table>
					</div>
                </div>
			<!-- END Tab Potensial Reports -->
				
			</div>			  
   	
   		</div>
	   </div>
 	   	
	</div>
</div>
<!-- END PAGE CONTENT -->
