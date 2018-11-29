		<?php
				$total_source = 0;
			   
				echo "<tr>";
				echo "<th>" . $list[0]->owner . "</th>";
				$source_name = explode("~", $list[0]->lead_source); 
				for ($i = 0; $i < count($source_name); $i++) {
					echo "<th>" . $source_name[$i] . "</th>";
				}
				echo "<th>" . $list[0]->sum_days . "</th>";
				echo "</tr>";
				

				for ($i = 1; $i < count($list); $i++) {
					$arr = array();
					echo "<tr>";
					echo "<td>".$list[$i]->owner . "</td>";

					$source_name = explode("~", $list[0]->lead_source);
					for ($iy = 0; $iy < count($source_name); $iy++) {
						$arr[$iy] = 0;
					}

					$source_name = explode("~", $list[$i]->lead_source);
					for ($ix = 0; $ix < count($source_name); $ix++) {
						$source_name2 = explode("~", $list[0]->lead_source);
						for ($iy = 0; $iy < count($source_name2); $iy++) {
							$ind = explode(":", $source_name[$ix]);
							if ($ind[0] == $source_name2[$iy]) {
								$arr[$iy] = $ind[1];
							}
						}
					}

					for ($iz = 0; $iz < count($arr); $iz++) {
						echo "<td style='text-align:right;'>".$arr[$iz] . "</td>";
					}
					echo "<td style='text-align:right;'>".$list[$i]->sum_days . "</td>";
					echo "</tr>";
				  
				}
				
				echo "<tr class='nohov' style=' background: #ddd;'>";
				echo "<td><b>Avg of Lead Conversion Time in Day(s)<b></td>";
				$ind_name = explode("~", $list[0]->lead_source);
				for ($i = 0; $i < count($ind_name); $i++) {
					echo "<td class='numeric'>" . $this->report_model->get_avg_conversion_accross_source($ind_name[$i],$min,$max) . "</td>";
				}
				echo "<td class='numeric'>" . $this->report_model->get_avg_conversion_accross_source('',$min,$max) . "</td>";
				echo "</tr>";
			?>