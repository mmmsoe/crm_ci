<?php 
$delimiter = ",";
$f = fopen('php://memory', 'w');
//set column headers
$fields = array('SALESPERSON', 'CUSTOMER', 'QUOTATIONS NUMBER', 'CREATION DATE', 'QUOTATION TOTAL AMOUNT', 'STATUS');
fputcsv($f, $fields, $delimiter);

if (!empty($quotations)) {
	foreach ($quotations as $quotation) {
	    if ($quotation->quot_or_order == "o") {
	        $view = 'quotations';
	    } else {
	        $view = 'quotations';
	    }

	    $fields = array(
	    		$this->staff_model->get_user_fullname($quotation->sales_person),
	    		customer_name($quotation->customer_id)->name,
	    		$quotation->quotations_number . '-' . $quotation->id,
	    		date('m/d/Y', $quotation->date),
	    		number_format($quotation->grand_total, 2, '.', ','),
	    		$quotation->status
	    	);
	    fputcsv($f, $fields, $delimiter);
	}
} 

// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=Quotation.csv');

//move back to beginning of file
fseek($f, 0);
//output all remaining data on a file pointer
fpassthru($f);
?>