<?php

$logo_url = base_url('uploads/site') . '/' . config('site_logo');
$time_sales = date("Y/m/d H:i:s", $quotation->date);

date_default_timezone_set("Asia/Jakarta");
$filename = 'Quotation-' . $quotation->quotations_number;
if ($quotation->payment_term == 0) {
    $term = 'Immediate Payment';
} else {
    $term = $quotation->payment_term . ' Days';
}

$html = '<style>
body {
	font-family: "Open Sans", Arial, sans-serif;
	font-size: 11px;
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
	padding: 4px 5px;
}
.detail_view_item table tr td {
	border: 1px solid #d6d6d5;
	font-size: 11px;
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
	line-height:20px;
	box-sizing: border-box;
	margin-bottom: 20px;
	float:left;
	text-align:right;
}
.detail_head_titel span{
	font-size:11px;
}
.detail_view_customer {
	float: left;
	height: auto;
	margin-bottom:20px;
	width: 100%;
}
.detail_view_customer td {
	padding: 0;
}
.detail_view_customer table tr td {
	border: none;
	font-size: 11px;
}
.fl_right{ float:right}
.uppercase{text-transform:uppercase;}
</style>
<body>

<!--mpdf
<htmlpageheader name="myheader">
<table width="100%" class="head_item_fl"><tr>
<td width="50%" style="color:#0000BB; "><span style="font-weight: bold; font-size: 14px;"><img src="' . $logo_url . '" width="90" height="30" /></span></td>
<td width="50%" style="text-align: right;"><b>' . config('site_name') . '</b><br><span style="font-size: 9px;">' . config('site_address') . '</span></span></td>
</tr></table>
</htmlpageheader>
<htmlpagefooter name="myfooter" style=" maring-top:-100px !important">
<div style="border-top: 1px solid #000000; font-size: 9px; text-align: center; padding-top:3mm !important; margin-top:-50px !imporatnt">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<div class="main" style="margin-top:-90px !important">  
  <div class="main_detail">
    <div class="detail_head_titel" style="margin-top:-30px !important">Sales Order<br><span><b>Ref No : </b>CO-' . $quotation->quotations_number . '</span> </div>
    <div class="detail_view_item" style="margin-bottom:0px;">
	  <div class="view_frist">
		<span><b>Sold To :</b></span><br>
		<div style="margin-bottom:10px;line-height:15px"><b>' . $this->customers_model->get_company($quotation->customer_id)->name . '</b>
		<br>' . $this->customers_model->get_company($quotation->customer_id)->address . '</div>
		<div style="margin-bottom:10px;width:150px; float:left;">
		<span><b>Tel :</b> ' . $this->customers_model->get_company($quotation->customer_id)->phone . '</span>
		</div>
		<div style="margin-bottom:10px;width:150px; float:left;">
		<span><b>Fax :</b> ' . $this->customers_model->get_company($quotation->customer_id)->fax . '</span>
		</div>
	  </div>
	</div>
    <div class="detail_view_customer" style="margin-bottom:10px;">
      <table width="100%" cellspacing="0" cellpadding="0" border="">
        <tbody>
          <tr>
            <td style="width:150px;padding-bottom:2px"><b>Contact Person :</b></td>
            <td style="padding-bottom:2px"><b>Term :</b></td>
            <td style="padding-bottom:2px"><b>Salesperson :</b></td>
            <td style="padding-bottom:2px"><b>TRN No :</b></td>
            <td style="padding-bottom:2px"><b>Date :</b></td>
          </tr>
          <tr>
            <td>' . $this->contact_persons_model->get_contact_persons($quotation->contact_id)->first_name . ' ' . $this->contact_persons_model->get_contact_persons($quotation->contact_id)->last_name . '</td>
            <td>' . $term . '</td>
            <td>' . $this->staff_model->get_user_fullname($quotation->sales_person) . '</td>
            <td>CO-' . $quotation->quotations_number . '</td>
            <td>' . $time_sales . '</td>
          </tr>
		</tbody>
	  </table>
    </div>
    <div class="detail_view_item" style="margin-top:10px;">
      <table width="100%" cellspacing="0" cellpadding="0" border="">
        <tbody>
          <tr style="background: #f3f3f3;">
            <td style="width:30px;"><b>S/N</b></td>
            <td style="width:250px;"><b>Product & Description</b></td>
            <td style="width:50px;text-align:center;"><b>QTY</b></td>
            <td style="width:50px;text-align:center;"><b>UOM</b></td>
            <td style="text-align:center;"><b>Unit Price</b></td>
            <td style="width:50px;text-align:center;"><b>Disc(%)</b></td>
            <td style="text-align:center;"><b>Taxes</b></td>
            <td style="text-align:center;"><b>Amount</b></td>
          </tr>';
$this->load->library('number_towords');
$no = 0;
foreach ($qo_products as $qo_product) {
    $no ++;
    $total_uom = $this->products_model->get_products($qo_product->product_id)->total_uom;
    //$uom_id = $this->products_model->get_products($qo_product->product_id)->uom_id;
    $uom_id = $qo_product->uom_id;
    if ($uom_id == '' || $uom_id == '0') {
        $uom_id = '01';
    }

    $description = str_replace("&", "and", $qo_product->discription);
    $description = str_replace("\n", "<br/>", $description);
    $uom = $this->system_model->system_single_value('UOM', $uom_id)->system_value_txt;
    $html .='<tr>
            <td style="text-align:center">' . $no . '</td>
            <td nowrap><b>' . $qo_product->product_name . '</b><br><pre style= "border: medium none; background: none; padding: 0px; margin: 0px;">' . $description . '</pre></td>
            <td style="text-align:center;">' . $qo_product->quantity . '</td>
            <td style="">' . $uom . '</td>
            <td style="text-align:right;">' . number_format($qo_product->price, 2, '.', ',') . '</td>
            <td style="text-align:right;">' . $qo_product->product_discount . '</td>
            <td style="text-align:right;">' . number_format($qo_product->quantity * $qo_product->price * $this->products_model->get_products($qo_product->product_id)->tax / 100, 2, '.', ',') . '</td>
            <td style="text-align:right;">' . number_format($qo_product->sub_total, 2, '.', ',') . '</td>
          </tr>';
}

$rem = str_replace("&", "and", $quotation->terms_and_conditions);
    $rem = str_replace("\n", "<br/>", $rem);
$html .=' </tbody>
      </table>
    </div>

    <div class="detail_view_item">
      <table width="100%" cellspacing="0" cellpadding="0" border="" class="fl_right;">
        <tbody>
          <tr>
            <td colspan="2" rowspan="2" width=""><b>Remarks :</b><br>' . $rem . '</td>
            <td width="15%"><b>SubTotal</b></td>
            <td style="width:20%;text-align:right;">' . number_format($quotation->total, 2, '.', ',') . '</td>
          </tr>
          <tr>
            <td><b>Discount</b></td>
            <td style="text-align:right;">' . number_format($quotation->discount, 2, '.', ',') . '</td>
          </tr>
          <tr>
          	<td colspan="3"><b>Exchange Rate</b></td>
            <td style="text-align:right;">' . number_format($quotation->tax_amount, 2, '.', ',') . '</td>
          </tr>
          <tr>
          	<td colspan="2"><b>GST In Base Currency</b></td>
          	<td><b>Net Amount</b></td>
            <td style="text-align:right;" id="grand_total">' . number_format($quotation->grand_total, 2, '.', ',') . '</td>
          </tr>
          <tr>
          	<td colspan="4">Amt in word : <span id="word_total">' . $this->number_towords->convert_number_to_words($quotation->grand_total) . '</span></td>
          </tr>
        </tbody>
      </table>
    </div>
	<div class="detail_view_item">
		<div class="view_frist">
			<span>CUSTOMERS ACKNOWLEDGEMENT</span>
			<div style="width:100%;height:60px;background:transparent;"></div>
			<div style="float:left;border-top:1px solid #000;width:135px;">Signature, Stamp and Date</div>
		</div>
		<div class="view_frist">
			<span style="float:right;"></span>
			<div style="width:100%;height:84px;background:transparent;float:right;"></div>
			<div style="float:right;border-top:1px solid #000;width:140px;">AUTHORIZED SIGNATURE</div>
		</div>
	</div>
  </div>
</div>
</body>'
;

$mpdf = new mPDF('c', 'A4', '', '', 20, 15, 48, 25, 10, 10);
$mpdf->SetProtection(array('print'));
$company_name1 = $this->customers_model->get_company($quotation->customer_id)->name;
$mpdf->SetTitle($company_name1 . " - Sales Order");
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
