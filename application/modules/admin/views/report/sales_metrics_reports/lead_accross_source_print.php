<?php 
$logo_url=base_url('uploads/site').'/'.config('site_logo');

$filename =str_replace(' ', '-', $title).'-'.date('Ymd');

$html ='<style>
body {
	font-family: "Open Sans", Arial, sans-serif;
	font-size: 14px;
	line-height: 22px;
	margin:0;
	padding:0;
}
table {
	background-color: transparent;
	border-collapse: collapse;
	border-spacing: 0;
	max-width: 100%;
}
th{
	background:#555;
	color:#fff;
}
.main {
	width: 1024px;
	margin:0px auto;
}
.main_detail{
	width: 100%;
	margin:10px auto;
	float:left;
}
.head_item_fl{ width:100%; float:left; margin-bottom:30px; margin-top:-100px !important; border-bottom:1px solid #555; padding-bottom:10px;}
.logo_item{ width:50%; float:left}
.lt_item{ width:50%; float:left; text-align:right; font-size:18px; height:68px; line-height:68px;}
.detail_view_item {
	float: left;
	height: auto;
	margin-bottom:20px;
	width: 100%;
}
.view_title_bg td {
	background: #7fa637 none repeat scroll 0 0;
	color: #fff;
	font-weight: 700;
}
.view_frist{ border:0px !important; width:50%; float:left; padding-left:0px !important; padding-top:2px !important; padding-bottom:2px !important; line-height:24px;}
.view_second{ border:0px !important; padding-left:0 !important;}
.detail_view_item td {
	color: #656565;
	padding: 4px 10px;
}
.detail_view_item table tr td {
	border: 1px solid #d6d6d5;
	font-size: 14px;
}
.view_bg_one {
	background: #f3f3f3;
}
.detail_head_titel {
	/*background: #f3f3f3;*/
	padding: 5px 5px 5px 0px;
	width: 100%;
	font-size: 30px;
	height:44px;
	line-height:30px;
	box-sizing: border-box;
	margin-bottom: 20px;
	float:left;
}
.fl_right{ float:right}
</style>
<body>

<!--mpdf
<htmlpageheader name="myheader">
<table width="100%" class="head_item_fl"><tr>
<td width="50%" style="color:#0000BB; "><span style="font-weight: bold; font-size: 14pt;"><img src="'.$logo_url.'" width="90" height="30" /></span></td>
<td width="50%" style="text-align: right;">'.$setting->site_name.'</span></td>
</tr></table>
</htmlpageheader>
<htmlpagefooter name="myfooter" style=" maring-top:-100px !important">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top:3mm !important; margin-top:-50px !imporatnt">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<div class="main" style="margin-top:-90px !important">  
  <div class="main_detail">
    <div class="detail_head_titel">'.$title.'</div>
    <div class="detail_view_item">      
      <table width="100%" cellspacing="0" cellpadding="0" border="1">
        <tbody>
          
            ';
$total_source = 0;
			   
$html .=' <tr>
			<th>'. $list[0]->owner .'</th>

			</tr>';
				
		$source_name = explode("~", $list[0]->lead_source); 
		for ($i = 0; $i < count($source_name); $i++) {
			
$html .='
		<th>'. $source_name[$i] .'</th>
		';
}
$html .='
		<th>'. $list[0]->sum_days .'</th>
		';
$html .='
		</tr>';
				
		for ($i = 1; $i < count($list); $i++) {
		$arr = array();
		
$html .='
		<tr>
			<td>'.$list[$i]->owner .'</td>
		';
					
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
$html .='<td style="text-align:right;">'.$arr[$iz] .'</td>';
					}

$html .='<td style="text-align:right;">'.$list[$i]->sum_days .'</td>';
					
$html .='</tr>';
				  
				}
				
$html .="<tr style=' background: #ddd;'>
		<td><b>Avg of Lead Conversion Time in Day(s)<b></td>
		
		";
			
$ind_name = explode("~", $list[0]->lead_source);
for ($i = 0; $i < count($ind_name); $i++) {		
$html .="<td style='text-align:right;'>". $this->report_model->get_avg_conversion_accross_source($ind_name[$i],$min,$max) ."</td>

		";
	}
$html .="<td style='text-align:right;'>" . $this->report_model->get_avg_conversion_accross_source('',$min,$max) .  "</td>";
				
$html .='</tr>';

  
$html .=' </tbody>
      </table>
    </div>
  </div>
</div>
</body>'
   ;
    
$mpdf=new mPDF('c','A4-L','','',20,15,48,25,10,10); 
$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("Acme Trading Co. - Invoice");
$mpdf->SetAuthor("Acme Trading Co.");
$mpdf->SetWatermarkText($quotation->payment_term);
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');
 

$mpdf->WriteHTML($html);

$mpdf->Output($filename . '.pdf', 'D');
//$mpdf->Output(); exit;

exit;