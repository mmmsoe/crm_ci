<?php
$delimiter = ",";
$f = fopen('php://memory', 'w');
    
//set column headers
$fields = array('Stage', 'Account Name', 'Opportunity', 'Created Date', 'Estimated Closing Date', 'sales Person', 'Expected Revenue');
fputcsv($f, $fields, $delimiter);

if( ! empty($opportunities_group) ){
	foreach( $opportunities_group as $opportunity_group){
		if($opportunity_group->customer_id !== '0' && $opportunity_group->stages_id !== '') {
			$lineData = array(
					$this->system_model->system_single_value('OPPORTUNITIES_STAGES', $opportunity_group->stages_id)->system_value_txt .' ('.$opportunity_group->cnt.')'
				);
			fputcsv($f, $lineData, $delimiter);

			// $opportunities = $this->opportunities_model->get_list_by_group( array('stages_id' => $opportunity_group->stages_id),'','','stages'); 
			$opportunities = $this->opportunities_model->get_list_by_group_b($opportunity_group->stages_id);
			if( ! empty($opportunities) ){
				foreach( $opportunities as $opportunity){
					$lineData = array(
							'',
							$opportunity->opportunity,
							$this->customers_model->get_account_name($opportunity->customer_id,'name'),
							$opportunity->create_date,
							$opportunity->expected_closing,
							$opportunity->firts_name." ".$opportunity->last_name,
							number_format($opportunity->amount, 2, '.', ',')
						);
					fputcsv($f, $lineData, $delimiter);
				}
			}
			$lineData = array('', '', '', '', number_format($opportunity_group->amt, 2, '.', ','));
			fputcsv($f, $lineData, $delimiter);
		}
	}
}
$lineData = array('', '', '', '', number_format($sum_amount, 2, '.', ','));
fputcsv($f, $lineData, $delimiter);

// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename='.$fname.'.csv');

//move back to beginning of file
fseek($f, 0);
//output all remaining data on a file pointer
fpassthru($f);
?>

      