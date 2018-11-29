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
			echo "<td class='numeric'>" . $this->report_model->get_avg_sales_duration_potential_type_by_month($ind_name[$i],$min,$max) . "</td>";
		}
		echo "<td class='numeric'>" . $this->report_model->get_avg_sales_duration_potential_type_by_month('',$min,$max) . "</td>";
		echo "</tr>";
	}
		echo "</tbody>";
    ?>