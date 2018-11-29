		<?php
				$total_industries = 0;
				
				
				
				
				
				echo "<tr style='width:20%'>";
				echo "<th>" . $list[0]->owner . "</th>";
				$ind_name = explode("~", $list[0]->industries); 
				for ($i = 0; $i < count($ind_name); $i++) {
					echo "<th style='width:40px;font-size: 10px;'>" . $ind_name[$i] . "</th>";
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
					echo "<td class='numeric'>" . $this->report_model->get_avg_conversion_accross_industries($ind_name[$i],$min,$max) . "</td>";
				}
				echo "<td class='numeric'>" . $this->report_model->get_avg_conversion_accross_industries('',$min,$max) . "</td>";
				echo "</tr>";
				
			?>