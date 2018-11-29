<table border="1" width="100%">
    <?php
    $total_industries = 0;
    /*
     * table header
     */
    echo "<tr>";
    echo "<th>" . $list[0]->owner . "</th>";
    $ind_name = explode("~", $list[0]->industries); //$list[0] adalah index header
    for ($i = 0; $i < count($ind_name); $i++) {
        echo "<th>" . $ind_name[$i] . "</th>";
    }
    echo "</tr>";
    //end of table header


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
            echo "<td>".$arr[$iz] . "</td>";
        }
        
        echo "</tr>";
        //echo print_r($arr);
    }
    ?>

</table>


<?php ?>