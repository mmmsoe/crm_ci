 <script>

$(document).ready(function() {
		
	$("#print").attr('href', '<?php echo base_url('admin/report/print_sales_duration_potential_type').'/'; ?>');
			
	$("#applyFilter").click(function() {
		var min = document.getElementById("min").value;
		var max = document.getElementById("max").value;
		var stat = 'sales_duration_potential_type';
		
		if(min && max){
			var mindt = new Date(min);
				mindt = mindt.toLocaleFormat('%Y-%m-%d');
			var maxdt = new Date(max);
				maxdt = maxdt.toLocaleFormat('%Y-%m-%d');	
			var print = mindt +'/'+ '-' +'/'+ maxdt;
		}else{
			var print = '';
		}
			
		// alert(mindt.toLocaleFormat('%Y-%m-%d'));
		
		$.ajax({
			type: "POST",
			url: '<?php echo base_url('admin/report/search_period');?>',
			data: {min: min, max: max,status:stat},
			success: function(data){
				
				$("#tbSalesPotentialType").html(data);
				$('#loader').slideUp(200, function() {
					$(this).remove();
				});
				$("#print").attr('href', '<?php echo base_url('admin/report/print_sales_duration_potential_type').'/'; ?>'+ print);
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
            	
                  <table class="table table-hover filter-between_date" id="tbSalesPotentialType">
				  
 <?php
    $total_regis_datetime = 0;
    /*
     * table header
     */
    echo "<thead>";    
	if($list[0]->potential_type){
		
	echo "<th>" . $list[0]->potential_type . "</th>";
    $ind_name = explode("~", $list[0]->regis_datetime); //$list[0] adalah index header
    for ($i = 0; $i < count($ind_name); $i++) {
		echo "<th style='width: 40px;'>" . date('M Y', strtotime($ind_name[$i]) ) . "</th>";
    }
	
	}else{
		echo "<th>Type</th>";
		echo "<th></th>";
	}
    echo "<th style='width: 68px;'>Avg of Overall Sales Duration in Day(s)</th>";
    echo "</tr>";
    echo "</thead>";
    //end of table header
	
    for ($i = 1; $i < count($list); $i++) {
        $arr = array();
        echo "<tbody>";
        echo "<tr>";
        echo "<td>".$list[$i]->potential_type . "</td>";		

		// $pos = strpos($list[0]->regis_datetime, "~");

		$ind_name = explode("~", $list[0]->regis_datetime);
		for ($iy = 0; $iy < count($ind_name); $iy++) {
			$arr[$iy] = 0;
		}
		
		$ind_name = explode("~", $list[$i]->regis_datetime);
		for ($ix = 0; $ix < count($ind_name); $ix++) {
			$ind_name2 = explode("~", $list[0]->regis_datetime);
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
        
        // echo print_r($arr);
    }
	if($list[0]->potential_type){
		echo "<tr class='nohov' style='background:#ddd;'>";
		echo "<td><b>Avg of Overall Sales Duration in Day(s)</b></td>";
		$ind_name = explode("~", $list[0]->regis_datetime); //$list[0] adalah index header
		for ($i = 0; $i < count($ind_name); $i++) {
			echo "<td class='numeric'>" . $this->report_model->get_avg_sales_duration_potential_type_by_month($ind_name[$i]) . "</td>";
		}
		echo "<td class='numeric'>" . $this->report_model->get_avg_sales_duration_potential_type_by_month() . "</td>";
		echo "</tr>";
	}
		echo "</tbody>";
    ?>
                  </table>
                </div>
		   		</div>
			   </div>
		 	   	
       		 </div>
        </div>
        <!-- END PAGE CONTENT -->
      