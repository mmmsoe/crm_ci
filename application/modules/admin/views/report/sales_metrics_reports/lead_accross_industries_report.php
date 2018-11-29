 <script>

$(document).ready(function() {
	
	$("#print").attr('href', '<?php echo base_url('admin/report/accross_industries_print').'/'; ?>');
				
	$("#applyFilter").click(function() {
		var min = document.getElementById("min").value;
		var max = document.getElementById("max").value;
		var stat= 'accross_industries';
		if(min && max){
			var mindt = new Date(min);
				mindt = mindt.toLocaleFormat('%Y-%m-%d');
			var maxdt = new Date(max);
				maxdt = maxdt.toLocaleFormat('%Y-%m-%d');	
		}else{
			var mindt = '-';
			var maxdt = '-';
		}
	
		// alert(mindt.toLocaleFormat('%Y-%m-%d'));
		
		$.ajax({
			type: "POST",
			url: '<?php echo base_url('admin/report/search_period');?>',
			data: {min: min, max: max,status:stat},
			success: function(data){
				
				$("#tbindustries tbody").html(data);
				$('#loader').slideUp(200, function() {
					$(this).remove();
				});
				$("#print").attr('href', '<?php echo base_url('admin/report/accross_industries_print').'/'; ?>'+ mindt +'/'+ '-' +'/'+ maxdt);
			
			},
		});
	});
});
</script>
<style>
.table-hover > tbody > tr.nohov:hover > td {
  background-color: transparent;
}
</style>
 <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
             <div class="row">
             <div>
               <?php if (check_staff_permission('report_write')){?>
      			 	 <a style="float:right;" href="" id="print" class="btn btn-primary" target="">Print</a>
					 <a   href="<?php echo base_url('admin/report/'); ?>" class="btn btn-black btn-embossed"> Back To Report</a> 	
		   	
				<?php }?>
			    		
            </div>          
		</div>
            <div class="row">
	           <div class="panel">																				
			   <div class="panel-content">
           		<div class="row">
				<div class="col-sm-3">
						<div class="form-group">
						  <label class="control-label">Start Date</label>
						  <div class="append-icon">
						    <input type="text" id="min" name="min" class="date-picker form-control">
						    <i class="icon-calendar"></i>
						  </div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
						  <label class="control-label">End Date</label>
						  <div class="append-icon">
						    <input type="text" id="max" name="max" class="date-picker form-control">
						    <i class="icon-calendar"></i>
						  </div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<div style="padding-top:25px;">
								<?php if (check_staff_permission('quotations_write')){?>
									<a href="#" id="applyFilter" class="btn btn-success" target="">Apply Filter</a>
								<?php }?>	
							</div>
						</div>
					</div>
				</div>
						   
           		<div class="panel-content pagination2 table-responsive" >
            	
                  <table class="table table-hover filter-between_date" id="tbindustries">
                   
             
		<?php
				$total_industries = 0;
			   
			
				
				echo "<tr>";
				echo "<th >" . $list[0]->owner . "</th>";
				$ind_name = explode("~", $list[0]->industries); 
				for ($i = 0; $i < count($ind_name); $i++) {
					echo "<th  style='width:40px;'>" . $ind_name[$i] . "</th>";
				}
				echo "<th>" . $list[0]->sum_days . "</th>";
				echo "</tr>";
				

				for ($i = 1; $i < count($list); $i++) {
					$arr = array();
					echo "<tr>";
					echo "<td>".$list[$i]->owner . "</td>";

					$ind_name = explode("~", $list[0]->industries);
					for ($iy = 0; $iy < count($ind_name); $iy++) {
						$arr[$iy] = 0;
					}

					$ind_name = explode("~", $list[$i]->industries);
					for ($ix = 0; $ix < count($ind_name); $ix++) {
						$ind_name2 = explode("~", $list[0]->industries);
						for ($iy = 0; $iy < count($ind_name2); $iy++) {
							$ind = explode(":", $ind_name[$ix]);
							if ($ind[0] == $ind_name2[$iy]) {
								$arr[$iy] = $ind[1];
							}
						}
					}

					for ($iz = 0; $iz < count($arr); $iz++) {
						echo "<td class='numeric'>".$arr[$iz] . "</td>";
					}
					echo "<td class='numeric'>".$list[$i]->sum_days . "</td>";
				
					echo "</tr>";
				  
				}
				
				echo "<tr class='nohov' style=' background: #ddd;'>";
				echo "<td><b>Avg of Lead Conversion Time in Day(s)<b></td>";
				$ind_name = explode("~", $list[0]->industries);
				for ($i = 0; $i < count($ind_name); $i++) {
					echo "<td class='numeric'>" . $this->report_model->get_avg_conversion_accross_industries($ind_name[$i]) . "</td>";
				}
				echo "<td class='numeric'>" . $this->report_model->get_avg_conversion_accross_industries() . "</td>";
				echo "</tr>";
			?>
                      
                      
                    </tbody>
                  </table>
                </div>
		   		</div>
			   </div>
		 	   	
       		 </div>
        </div>
        <!-- END PAGE CONTENT -->
      