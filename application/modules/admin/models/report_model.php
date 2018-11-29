<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function quotations_list($customer_id) {
        if ($customer_id != '1') {
            $this->db->where('customer_id', $customer_id);
        }

        $this->db->order_by("id", "desc");
        $this->db->from('quotations_salesorder');

        return $this->db->get()->result();
    }

    function report_getfilter($staff_id, $filter) {
        if ($staff_id != '1') {
            $this->db->where('customer_id', $staff_id);
        }
        $nextMonth = date("m") + 1;
        $startDate = date("Y-m") . '-01';
        $endDate = date("Y-") . $nextMonth . '-01';

        if ($filter == "todays") {
            $this->db->where('date', strtotime(date('m/d/Y')));
        } else if ($filter == "month") {
            $this->db->where('date >=', strtotime($startDate));
            $this->db->where('date <', strtotime($endDate));
        }


        $this->db->order_by("id", "desc");
        $this->db->from('quotations_salesorder');

        return $this->db->get()->result();
    }

    function get_quotation($quotation_id) {
        return $this->db->get_where('quotations_salesorder', array('id' => $quotation_id, 'quot_or_order' => 'q'))->row();
    }

    function delete($quotation_id) {

        if ($this->db->delete('quotations_salesorder', array('id' => $quotation_id))) {  // Delete customer
            return true;
        }
    }

    //Get last row
    function get_quotations_last_id() {
        $query = "select * from quotations_salesorder order by id DESC limit 1";

        $res = $this->db->query($query);

        if ($res->num_rows() > 0) {
            return $res->result("array");
        }
        return array();
    }

    function confirm_sales_order($quotation_id) {
        $quotation_details = array(
            'quot_or_order' => 'o',
            'sales_order_create_date' => strtotime(date('Y-m-d'))
        );

        return $this->db->update('quotations_salesorder', $quotation_details, array('id' => $quotation_id));
    }

    function quot_order_products($qo_id) {
        $this->db->where(array('quotation_order_id' => $qo_id));
        $this->db->order_by("id", "desc");
        $this->db->from('quotations_salesorder_products');

        return $this->db->get()->result();
    }

    function get_qo_product($product_id) {
        return $this->db->get_where('quotations_salesorder_products', array('id' => $product_id))->row();
    }

    function delete_qo_product($product_id) {
        $product_data = $this->quotations_model->get_qo_product($product_id);
        $quotations_data = $this->quotations_model->get_quotation($product_data->quotation_order_id);

        $new_total = number_format($quotations_data->total - $product_data->price, 2, '.', '');

        $new_tax_amount = $quotations_data->tax_amount - number_format($product_data->quantity * $product_data->price * config('sales_tax') / 100, 2, '.', ' ');

        $new_grand_total = number_format($new_total + $new_tax_amount, 2, '.', '');

        $quotation_details = array(
            'total' => $new_total,
            'tax_amount' => $new_tax_amount,
            'grand_total' => $new_grand_total
        );

        $this->db->update('quotations_salesorder', $quotation_details, array('id' => $product_data->quotation_order_id));

        if ($this->db->delete('quotations_salesorder_products', array('id' => $product_id))) {
            return true;
        }
    }

    function get_pricelist_version_by_pricelist_id($pricelist_id) {
        return $this->db->get_where('pricelist_version', array('pricelist_id' => $pricelist_id, 'start_date <=' => strtotime(date('Y-m-d')), 'end_date >=' => strtotime(date('Y-m-d'))))->row();
    }

    function get_pricelist_version_product($pricelist_ver_id, $product_id) {
        $data['product_price'] = $this->db->get_where('pricelist_versions_products', array('pricelist_versions_id' => $pricelist_ver_id, 'product_id' => $product_id))->row();
        return $data['product_price']->special_price;
    }

    function get_product_price($product_id, $pricelist_id) {
        $data['pricelist_version'] = $this->report_model->get_pricelist_version_by_pricelist_id($pricelist_id);

        return $this->db->get_where('pricelist_versions_products', array('product_id' => $product_id, 'pricelist_versions_id' => $data['pricelist_version']->id))->row();
    }
    
	//ADD DANNI RAMDAN START
    
    function get_sales_duration_potential_type($min,$max)
    {
		
		$nextMonth = date("m") + 1;
		$startDate = date("Y-m").'-01';
		$endDate = date("Y-").$nextMonth.'-01';
		
        $q = "";
        $q .= "SELECT potential_type, GROUP_CONCAT(regis_datetime SEPARATOR '~') AS regis_datetime, sum_days from (
		SELECT potential_type, regis_datetime, sum_days from (
          SELECT 'Type' AS potential_type, DATE_FORMAT(FROM_UNIXTIME(o.register_time), '%Y-%m') AS regis_datetime, 'Sum Days' AS sum_days FROM opportunities o
                JOIN leads l ON l.id = o.lead_id
                JOIN tb_m_system tms ON tms.system_type = 'OPPORTUNITIES_TYPE' AND tms.system_code = o.type_id
				    JOIN quotations_salesorder qs ON qs.opportunities_id = o.id";
				
		if ($min && $max){
			if($min !== '-' || $max !== '-'){ 
				$q .= " where DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' and '".date('Y-m-d', strtotime($max))."'";       
			}
		}else{
			$q .= " where o.register_time >= '".strtotime($startDate)."' and o.register_time < '".strtotime($endDate)."'";       
		}
					
        $q .= "GROUP BY o.type_id
                
       ) th group by regis_datetime, potential_type
	   
			) th2
              
              UNION ALL
              SELECT t2.`potential_type`, t2.regis_datetime, ROUND(t2.sum_days, 2) as sum_days FROM (
                SELECT t1.potential_type, GROUP_CONCAT(t1.regis_datetime SEPARATOR '~') AS regis_datetime, AVG(t1.sum_days) AS sum_days  FROM (
                  SELECT tms.system_value_txt AS `potential_type`, CONCAT(DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m'), ':', CAST(COUNT(*) AS CHAR(10))) AS regis_datetime,  CAST(COUNT(*) AS CHAR(10)) as sum_days FROM opportunities o
                  JOIN leads l ON l.id = o.lead_id
                  JOIN tb_m_system tms ON tms.system_type = 'OPPORTUNITIES_TYPE' AND tms.system_code = o.type_id
				  JOIN quotations_salesorder qs ON qs.opportunities_id = o.id
                  ";
        //disini bisa nambahin query lagi buat kondisional
		if ($min && $max){
			if($min !== '-' || $max !== '-'){ 
				$q .= " where DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' and '".date('Y-m-d', strtotime($max))."'";       
			}
		}else{
			$q .= " where o.register_time >= '".strtotime($startDate)."' and o.register_time < '".strtotime($endDate)."'";       
		}
        //end
        
        $q .= "GROUP BY  o.type_id, DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m')
                ) t1 GROUP BY t1.potential_type
              )t2;";
        return $this->db->query($q)->result();
    }
	
    function get_avg_sales_duration_potential_type_by_month($month,$min,$max)
    {
		
		$nextMonth = date("m") + 1;
		$startDate = date("Y-m").'-01';
		$endDate = date("Y-").$nextMonth.'-01';
		
        $q = "";
        $q .= "SELECT t2.`potential_type`, t2.regis_datetime, ROUND(AVG(t2.sum_days), 2) AS sum_days FROM (
                SELECT t1.potential_type, GROUP_CONCAT(t1.regis_datetime SEPARATOR '~') AS regis_datetime, ";
				// if($month){
					$q .=" SUM(t1.sum_days)";
				// }else{
					// $q .=" AVG(t1.sum_days)";
				// }
		$q	.=" AS sum_days  FROM (
                  SELECT tms.system_value_txt AS `potential_type`, CONCAT(DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m'), ':', CAST(COUNT(*) AS CHAR(10))) AS regis_datetime,  CAST(COUNT(*) AS CHAR(10)) as sum_days FROM opportunities o
                  JOIN leads l ON l.id = o.lead_id
                  JOIN tb_m_system tms ON tms.system_type = 'OPPORTUNITIES_TYPE' AND tms.system_code = o.type_id
				  JOIN quotations_salesorder qs ON qs.opportunities_id = o.id
                  ";
        //disini bisa nambahin query lagi buat kondisional

		if($month){
			$q.= "WHERE DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m') = '". $month ."' ";
		}

		if ($min && $max){
			if($min !== '-' || $max !== '-'){ 
				$q .= "AND DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' AND '".date('Y-m-d', strtotime($max))."'";       
			}
		}else{
			$q .= "AND o.register_time >= '".strtotime($startDate)."' AND o.register_time < '".strtotime($endDate)."'";       
		}
		
        //end
        
        $q .= "GROUP BY  o.type_id, DATE_FORMAT(FROM_UNIXTIME(o.register_time),'%Y-%m')
                ) t1 GROUP BY t1.potential_type
              )t2;";
        return $this->db->query($q)->row()->sum_days;
    }
	
	
    function get_sales_duration_lead_source($min,$max)
    {
		
		$nextMonth = date("m") + 1;
		$startDate = date("Y-m").'-01';
		$endDate = date("Y-").$nextMonth.'-01';
		
        $q = "";
        $q .= "SELECT lead_sources, GROUP_CONCAT(regis_datetime SEPARATOR '~') AS regis_datetime, sum_days from (
		SELECT lead_sources, regis_datetime, sum_days from (
          SELECT 'Lead Source' AS lead_sources, DATE_FORMAT(FROM_UNIXTIME(l.register_time), '%Y-%m') AS regis_datetime, 'Sum Days' AS sum_days FROM opportunities o
                JOIN leads l ON l.id = o.lead_id
                JOIN tb_m_system tms ON tms.system_type = 'LEAD' AND tms.system_code = l.lead_source_id
				JOIN quotations_salesorder qs ON qs.opportunities_id = o.id";
				
		if ($min && $max){
			if($min !== '-' || $max !== '-'){ 
				$q .= " where DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' and '".date('Y-m-d', strtotime($max))."'";       
			}
		}else{
			$q .= " where l.register_time >= '".strtotime($startDate)."' and l.register_time < '".strtotime($endDate)."'";       
		}
					
        $q .= "GROUP BY l.lead_source_id
                
       ) th group by regis_datetime, lead_sources
	   
			) th2
              
              UNION ALL
              SELECT t2.`lead_sources`, t2.regis_datetime, ROUND(t2.sum_days, 2) as sum_days FROM (
                SELECT t1.lead_sources, GROUP_CONCAT(t1.regis_datetime SEPARATOR '~') AS regis_datetime, AVG(t1.sum_days) AS sum_days  FROM (
                  SELECT tms.system_value_txt AS `lead_sources`, CONCAT(DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m'), ':', CAST(COUNT(*) AS CHAR(10))) AS regis_datetime,  CAST(COUNT(*) AS CHAR(10)) as sum_days FROM opportunities o
                  JOIN leads l ON l.id = o.lead_id
                  JOIN tb_m_system tms ON tms.system_type = 'LEAD' AND tms.system_code = l.lead_source_id
				  JOIN quotations_salesorder qs ON qs.opportunities_id = o.id
                  ";
        //disini bisa nambahin query lagi buat kondisional
		if ($min && $max){
			if($min !== '-' || $max !== '-'){ 
				$q .= " where DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' and '".date('Y-m-d', strtotime($max))."'";       
			}
		}else{
			$q .= " where l.register_time >= '".strtotime($startDate)."' and l.register_time < '".strtotime($endDate)."'";       
		}
        //end
        
        $q .= "GROUP BY  l.lead_source_id, DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m')
                ) t1 GROUP BY t1.lead_sources
              )t2; ";
        return $this->db->query($q)->result();
    }
	
    function get_avg_sales_duration_lead_source_by_month($month,$min,$max)
    {
		
		$nextMonth = date("m") + 1;
		$startDate = date("Y-m").'-01';
		$endDate = date("Y-").$nextMonth.'-01';
		
        $q = "";
        $q .= "SELECT t2.`lead_sources`, t2.regis_datetime, ROUND(AVG(t2.sum_days), 2) AS sum_days FROM (
                SELECT t1.lead_sources, GROUP_CONCAT(t1.regis_datetime SEPARATOR '~') AS regis_datetime, ";
				// if($month){
					$q .=" SUM(t1.sum_days)";
				// }else{
					// $q .=" AVG(t1.sum_days)";
				// }
		$q	.=" AS sum_days  FROM (
                  SELECT tms.system_value_txt AS `lead_sources`, CONCAT(DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m'), ':', CAST(COUNT(*) AS CHAR(10))) AS regis_datetime,  CAST(COUNT(*) AS CHAR(10)) as sum_days FROM opportunities o
                  JOIN leads l ON l.id = o.lead_id
                  JOIN tb_m_system tms ON tms.system_type = 'LEAD' AND tms.system_code = l.lead_source_id
				  JOIN quotations_salesorder qs ON qs.opportunities_id = o.id
                  ";
        //disini bisa nambahin query lagi buat kondisional

		if($month){
			$q.= "WHERE DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m') = '". $month ."' ";
		}

		if ($min && $max){
			if($min !== '-' || $max !== '-'){ 
				$q .= "AND DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' AND '".date('Y-m-d', strtotime($max))."'";       
			}
		}else{
			$q .= "AND l.register_time >= '".strtotime($startDate)."' AND l.register_time < '".strtotime($endDate)."'";       
		}
		
        //end
        
        $q .= "GROUP BY  l.lead_source_id, DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m')
                ) t1 GROUP BY t1.lead_sources
              )t2;";
        return $this->db->query($q)->row()->sum_days;
    }
	
	//END DANNI RAMDAN
	
	
	
	//ADD YOGA TAUFIK START
	
    function get_lead_conversion_accross_industries($min,$max)
    {
		  $nextMonth = date("m") + 1;
		  $startDate = date("Y-m").'-01';
		  $endDate = date("Y-").$nextMonth.'-01';
		  
        $q = "";
        $q .= "SELECT 'Lead Owner' AS `owner`, GROUP_CONCAT(t.industry SEPARATOR '~') AS industries,'Avg of Lead Conversion Time in Day(s)' as `average`, 'Avg of Lead Conversion Time in Day(s)' AS sum_days FROM(
                SELECT l.industry_id,l.register_time, tms.system_value_txt AS industry FROM opportunities o
                JOIN leads l ON l.id = o.lead_id
                JOIN tb_m_system tms ON tms.system_type = 'INDUSTRY' AND tms.system_code = l.industry_id
                JOIN users u ON u.id = l.salesperson_id ";
		 
		 if ($min && $max){
			if($min !== '-' || $max !== '-'){ 
				
				$q .= " where DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' and '".date('Y-m-d', strtotime($max))."'";       
			}
		 }else{
				$q .= " where l.register_time >= '".strtotime($startDate)."' and l.register_time < '".strtotime($endDate)."'";       
		}				
				
        $q .= "GROUP BY l.industry_id
              )t
              UNION ALL
              SELECT t2.`owner`, t2.industries,t2.average, t2.sum_days FROM (
                SELECT t1.owner, GROUP_CONCAT(t1.industries SEPARATOR '~') AS industries,t1.average, AVG(t1.sum_days) AS sum_days FROM (
                  SELECT CONCAT(u.first_name, ' ', u.last_name) AS `owner`, CONCAT(tms.system_value_txt, ':', CAST(COUNT(*) AS CHAR(10))) AS industries
				  ,datediff(from_unixtime(o.register_time),from_unixtime(l.register_time)) as average,  CAST(COUNT(*) AS CHAR(10)) as sum_days FROM opportunities o
                  JOIN leads l ON l.id = o.lead_id
                  JOIN tb_m_system tms ON tms.system_type = 'INDUSTRY' AND tms.system_code = l.industry_id
                  JOIN users u ON u.id = l.salesperson_id
                  ";
				  
		if ($min && $max){
			 if($min !== '-' || $max !== '-'){ 
				
				$q .="where DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' and '".date('Y-m-d', strtotime($max))."'";
		    }
		 }else{
				$q .= " where l.register_time >= '".strtotime($startDate)."' and l.register_time < '".strtotime($endDate)."'";       
			
		}				  
        
        
        $q .= "GROUP BY l.salesperson_id, l.industry_id
                ) t1 GROUP BY t1.owner
              )t2 ;";
        return $this->db->query($q)->result();
    }
	
	
		function get_lead_conversion_accross_source($min,$max)
    {
		  $nextMonth = date("m") + 1;
		  $startDate = date("Y-m").'-01';
		  $endDate = date("Y-").$nextMonth.'-01';
		  
        $q = "";
        $q .= "SELECT 'Lead Owner' AS `owner`, GROUP_CONCAT(t.lead_source SEPARATOR '~') AS lead_source, 'Avg of Lead Conversion Time in Day(s)' AS sum_days FROM(
                SELECT l.lead_source_id, tms.system_value_txt AS lead_source FROM opportunities o
                JOIN leads l ON l.id = o.lead_id
                JOIN tb_m_system tms ON tms.system_type = 'LEAD' AND tms.system_code = l.lead_source_id
                JOIN users u ON u.id = l.salesperson_id ";
         
		 if ($min && $max){
			if($min !== '-' || $max !== '-'){ 
				
				$q .= " where DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' and '".date('Y-m-d', strtotime($max))."'";       
			}
		 }else{
				$q .= " where l.register_time >= '".strtotime($startDate)."' and l.register_time < '".strtotime($endDate)."'";       
		}
				
			$q .="	GROUP BY l.lead_source_id
              )t
              UNION ALL
              SELECT t2.`owner`, t2.lead_source, t2.sum_days  FROM (
                SELECT t1.owner, GROUP_CONCAT(t1.lead_source SEPARATOR '~') AS lead_source, AVG(t1.sum_days) AS sum_days FROM (
                  SELECT CONCAT(u.first_name, ' ', u.last_name) AS `owner`, CONCAT(tms.system_value_txt, ':', CAST(COUNT(*) AS CHAR(10))) AS lead_source,  CAST(COUNT(*) AS CHAR(10)) as sum_days FROM opportunities o
                  JOIN leads l ON l.id = o.lead_id
                  JOIN tb_m_system tms ON tms.system_type = 'LEAD' AND tms.system_code = l.lead_source_id
                  JOIN users u ON u.id = l.salesperson_id ";
				 
		 if ($min && $max){
			 if($min !== '-' || $max !== '-'){ 
				
				$q .="where DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' and '".date('Y-m-d', strtotime($max))."'";
		    }
		 }else{
				$q .= " where l.register_time >= '".strtotime($startDate)."' and l.register_time < '".strtotime($endDate)."'";       
			
		}
						 
				$q .="GROUP BY l.salesperson_id, l.lead_source_id";		
				
                  
        //disini bisa nambahin query lagi buat kondisional
       
	   
        //end
        
        $q .= " ) t1 GROUP BY t1.owner
				)t2  ;";
        return $this->db->query($q)->result();
    }
	
	function get_lead_conversion_accross_owner($min,$max)
    {
		  $nextMonth = date("m") + 1;
		  $startDate = date("Y-m").'-01';
		  $endDate = date("Y-").$nextMonth.'-01';
		  
        $q = "";
        $q .= "	SELECT owner, GROUP_CONCAT(regis_datetime SEPARATOR '~') AS regis_datetime, sum_days from (
				SELECT owner, regis_datetime, sum_days from (
				SELECT 'Lead Owner' AS `owner`, DATE_FORMAT(FROM_UNIXTIME(l.register_time), '%Y-%m') AS regis_datetime, 'Sum Days' AS sum_days FROM opportunities o
                JOIN leads l ON l.id = o.lead_id
                JOIN users u ON u.id = l.salesperson_id  ";
         
		 if ($min && $max){
			if($min !== '-' || $max !== '-'){ 
				
				$q .= " where DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' and '".date('Y-m-d', strtotime($max))."'";       
			}
		 }else{
				$q .= " where l.register_time >= '".strtotime($startDate)."' and l.register_time < '".strtotime($endDate)."'";       
		}
				
			$q .="GROUP BY l.salesperson_id
                  ) th group by regis_datetime, owner
					) th2
					
				  UNION ALL
				  SELECT t2.`owner`, t2.regis_datetime, ROUND(t2.sum_days, 2) as sum_days FROM (
				  SELECT t1.owner, GROUP_CONCAT(t1.regis_datetime SEPARATOR '~') AS regis_datetime, AVG(t1.sum_days) AS sum_days  FROM (
                  SELECT CONCAT(u.first_name, ' ', u.last_name) AS `owner`, CONCAT(DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m'), ':', CAST(COUNT(*) AS CHAR(10))) AS regis_datetime,  CAST(COUNT(*) AS CHAR(10)) as sum_days FROM opportunities o
                  JOIN leads l ON l.id = o.lead_id
                  JOIN users u ON u.id = l.salesperson_id  ";
				 
		 if ($min && $max){
			 if($min !== '-' || $max !== '-'){ 
				
				$q .="where DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' and '".date('Y-m-d', strtotime($max))."'";
		    }
		 }else{
				$q .= " where l.register_time >= '".strtotime($startDate)."' and l.register_time < '".strtotime($endDate)."'";       
			
		}
						 
		        
       
        
        $q .= " GROUP BY  l.salesperson_id, DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m')
                ) t1 GROUP BY t1.owner
              )t2;";
        return $this->db->query($q)->result();
    }
	
	function get_lead_conversion_count_accross_owner($min,$max)
    {
		  $nextMonth = date("m") + 1;
		  $startDate = date("Y-m").'-01';
		  $endDate = date("Y-").$nextMonth.'-01';
		  
        $q = "";
        $q .= "	SELECT owner, GROUP_CONCAT(regis_datetime SEPARATOR '~') AS regis_datetime, sum_days from (
				SELECT owner, regis_datetime, sum_days from (
				SELECT 'Lead Owner' AS `owner`, DATE_FORMAT(FROM_UNIXTIME(l.register_time), '%Y-%m') AS regis_datetime, 'Sum Days' AS sum_days FROM opportunities o
                JOIN leads l ON l.id = o.lead_id
                JOIN users u ON u.id = l.salesperson_id  ";
         
		 if ($min && $max){
			if($min !== '-' || $max !== '-'){ 
				
				$q .= " where DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' and '".date('Y-m-d', strtotime($max))."'";       
			}
		 }else{
				$q .= " where l.register_time >= '".strtotime($startDate)."' and l.register_time < '".strtotime($endDate)."'";       
		}
				
			$q .="GROUP BY l.salesperson_id
                  ) th group by regis_datetime, owner
					) th2
					
				  UNION ALL
				  SELECT t2.`owner`, t2.regis_datetime, ROUND(t2.sum_days, 2) as sum_days FROM (
				  SELECT t1.owner, GROUP_CONCAT(t1.regis_datetime SEPARATOR '~') AS regis_datetime, SUM(t1.sum_days) AS sum_days  FROM (
                  SELECT CONCAT(u.first_name, ' ', u.last_name) AS `owner`, CONCAT(DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m'), ':', CAST(COUNT(*) AS CHAR(10))) AS regis_datetime,  CAST(COUNT(*) AS CHAR(10)) as sum_days FROM opportunities o
                  JOIN leads l ON l.id = o.lead_id
                  JOIN users u ON u.id = l.salesperson_id  ";
				 
		 if ($min && $max){
			 if($min !== '-' || $max !== '-'){ 
				
				$q .="where DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' and '".date('Y-m-d', strtotime($max))."'";
		    }
		 }else{
				$q .= " where l.register_time >= '".strtotime($startDate)."' and l.register_time < '".strtotime($endDate)."'";       
			
		}
						 
		        
       
        
        $q .= " GROUP BY  l.salesperson_id, DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m')
                ) t1 GROUP BY t1.owner
              )t2;";
        return $this->db->query($q)->result();
    }
	
	function get_avg_conversion_accross_industries($cat,$min,$max)
    {
		  $nextMonth = date("m") + 1;
		  $startDate = date("Y-m").'-01';
		  $endDate = date("Y-").$nextMonth.'-01';
        $q = "";
        $q .= " SELECT t2.`owner`, t2.industries,t2.average, AVG(t2.sum_days) AS sum_days FROM (
                SELECT t1.owner, GROUP_CONCAT(t1.industries SEPARATOR '~') AS industries,t1.average,"; 
			
				if ($cat){
				$q .= "SUM(t1.sum_days)";	
				}else {
				$q .= "AVG(t1.sum_days)";	
				}
				
				
		 $q .= "  AS sum_days FROM (
                  SELECT CONCAT(u.first_name, ' ', u.last_name) AS `owner`, CONCAT(tms.system_value_txt, ':', CAST(COUNT(*) AS CHAR(10))) AS industries
				  ,datediff(from_unixtime(o.register_time),from_unixtime(l.register_time)) as average,  CAST(COUNT(*) AS CHAR(10)) as sum_days FROM opportunities o
                  JOIN leads l ON l.id = o.lead_id
                  JOIN tb_m_system tms ON tms.system_type = 'INDUSTRY' AND tms.system_code = l.industry_id
                  JOIN users u ON u.id = l.salesperson_id 
					
                  ";
        //disini bisa nambahin query lagi buat kondisional
		if($cat){
			$q .= "where tms.system_value_txt = '". $cat ."'";
		}
		
		if ($min && $max){
			if($min !== '-' || $max !== '-'){ 
				
				$q .= "and DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' and '".date('Y-m-d', strtotime($max))."'";       
			
			}
		 }else{
			 
				$q .= "and l.register_time >= '".strtotime($startDate)."' and l.register_time < '".strtotime($endDate)."'";     
				
		}	
        
		
        //end
        
        $q .= "GROUP BY l.salesperson_id, l.industry_id
                ) t1 GROUP BY t1.owner
              )t2;";
        return $this->db->query($q)->row()->sum_days;
    }
	
	function get_avg_conversion_accross_source($cat,$min,$max)
    {
		  $nextMonth = date("m") + 1;
		  $startDate = date("Y-m").'-01';
		  $endDate = date("Y-").$nextMonth.'-01';
        $q = "";
        $q .= " SELECT t2.`owner`,t2.lead_source,AVG(t2.sum_days) AS sum_days FROM (
                 SELECT t1.owner, GROUP_CONCAT(t1.lead_source SEPARATOR '~') AS lead_source,"; 
			
				if ($cat){
				$q .= "SUM(t1.sum_days)";	
				}else {
				$q .= "AVG(t1.sum_days)";	
				}
				
				
		 $q .= "  AS sum_days FROM (
                  SELECT CONCAT(u.first_name, ' ', u.last_name) AS `owner`, CONCAT(tms.system_value_txt, ':', CAST(COUNT(*) AS CHAR(10))) AS lead_source,  CAST(COUNT(*) AS CHAR(10)) as sum_days FROM opportunities o
                  JOIN leads l ON l.id = o.lead_id
                  JOIN tb_m_system tms ON tms.system_type = 'LEAD' AND tms.system_code = l.lead_source_id
                  JOIN users u ON u.id = l.salesperson_id


				  ";
        //disini bisa nambahin query lagi buat kondisional
		
		if($cat){
			$q .= "where tms.system_value_txt = '". $cat ."'";
		}
		
		if ($min && $max){
			if($min !== '-' || $max !== '-'){ 
				
				$q .= "and DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' and '".date('Y-m-d', strtotime($max))."'";       
			
			}
		 }else{
			 
				$q .= "and l.register_time >= '".strtotime($startDate)."' and l.register_time < '".strtotime($endDate)."'";     
				
		}	
        
		
        //end
        
        $q .= "GROUP BY l.salesperson_id, l.lead_source_id
                ) t1 GROUP BY t1.owner
              )t2;";
        return $this->db->query($q)->row()->sum_days;
    }
	
	
	function get_avg_conversion_accross_owner($cat,$min,$max)
    {
		  $nextMonth = date("m") + 1;
		  $startDate = date("Y-m").'-01';
		  $endDate = date("Y-").$nextMonth.'-01';
        $q = "";
        $q .= " SELECT  t2.`owner`, t2.regis_datetime,  avg(t2.sum_days) AS sum_days FROM (
                SELECT t1.owner, GROUP_CONCAT(t1.regis_datetime SEPARATOR '~') AS regis_datetime,"; 
			
				if ($cat){
				$q .= "SUM(t1.sum_days)";	
				}else {
				$q .= "AVG(t1.sum_days)";	
				}
				
				
		 $q .= "  AS sum_days FROM (
                 SELECT CONCAT(u.first_name, ' ', u.last_name) AS `owner`, CONCAT(DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m'), ':', CAST(COUNT(*) AS CHAR(10))) AS regis_datetime,  CAST(COUNT(*) AS CHAR(10)) as sum_days FROM opportunities o
                  JOIN leads l ON l.id = o.lead_id
				  JOIN users u ON u.id = l.salesperson_id 


				  ";
        //disini bisa nambahin query lagi buat kondisional
		
		if($cat){
			$q .= "where DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m')  = '". $cat ."'";
		}
		
		if ($min && $max){
			if($min !== '-' || $max !== '-'){ 
				
				$q .= "and DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' and '".date('Y-m-d', strtotime($max))."'";       
			
			}
		 }else{
			 
				$q .= "and l.register_time >= '".strtotime($startDate)."' and l.register_time < '".strtotime($endDate)."'";     
				
		}	
        
		
        //end
        
        $q .= "GROUP BY  l.salesperson_id, DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m')
                ) t1 GROUP BY t1.owner
              )t2;";
			  
        return $this->db->query($q)->row()->sum_days;
    }
	
	function get_avg_conversion_count_accross_owner($cat,$min,$max)
    {
		  $nextMonth = date("m") + 1;
		  $startDate = date("Y-m").'-01';
		  $endDate = date("Y-").$nextMonth.'-01';
        $q = "";
        $q .= " SELECT  t2.`owner`, t2.regis_datetime,  sum(t2.sum_days) AS sum_days FROM (
                SELECT t1.owner, GROUP_CONCAT(t1.regis_datetime SEPARATOR '~') AS regis_datetime,"; 
			
				// if ($cat){
				$q .= "SUM(t1.sum_days)";	
				// }else {
				// $q .= "SUM(t1.sum_days)";	
				// }
				
				
		 $q .= "  AS sum_days FROM (
                 SELECT CONCAT(u.first_name, ' ', u.last_name) AS `owner`, CONCAT(DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m'), ':', CAST(COUNT(*) AS CHAR(10))) AS regis_datetime,  CAST(COUNT(*) AS CHAR(10)) as sum_days FROM opportunities o
                  JOIN leads l ON l.id = o.lead_id
				  JOIN users u ON u.id = l.salesperson_id 


				  ";
        //disini bisa nambahin query lagi buat kondisional
		
		if($cat){
			$q .= "where DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m')  = '". $cat ."'";
		}
		
		if ($min && $max){
			if($min !== '-' || $max !== '-'){ 
				
				$q .= "and DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($min))."' and '".date('Y-m-d', strtotime($max))."'";       
			
			}
		 }else{
			 
				$q .= "and l.register_time >= '".strtotime($startDate)."' and l.register_time < '".strtotime($endDate)."'";     
				
		}	
        
		
        //end
        
        $q .= "GROUP BY  l.salesperson_id, DATE_FORMAT(FROM_UNIXTIME(l.register_time),'%Y-%m')
                ) t1 GROUP BY t1.owner
              )t2;";
			  
        return $this->db->query($q)->row()->sum_days;
    }
	
	


	//END YOGA TAUFIK

}

?>