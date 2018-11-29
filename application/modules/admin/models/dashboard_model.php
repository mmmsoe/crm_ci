<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Dashboard_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }   
     
    function total_salesteams() 
    {
        $this->db->order_by("id", "desc");
        $this->db->from('salesteams');       
        	
		return count($this->db->get()->result());	
	}
	
	function total_leads() 
    {	
    	if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('salesperson_id', userdata('id'));
		}
		
        $this->db->order_by("id", "desc");
        $this->db->from('leads');
		$this->db->where('active_status', 0);
        	
		return count($this->db->get()->result());	
	}
	
	function dis_leads()
	{
            if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('salesperson_id', userdata('id'));
		}
            
		$this->db->select('count(DISTINCT(email)) AS countData');  
        $this->db->order_by("id", "desc");
        $this->db->from('leads');   
		$this->db->where('active_status', 0);
		
        $res = $this->db->get()->result();
		
		return $res[0]->countData;	
	}
	
	function total_opportunities() 
    {
    	if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('salesperson_id', userdata('id'));
		}
		
        $this->db->order_by("id", "desc");
        $this->db->from('opportunities');       
        	
		return count($this->db->get()->result());	
	}
	
	function dis_opportunities()
	{
            	if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('salesperson_id', userdata('id'));
		}
		$this->db->select('count(DISTINCT(customer_id)) AS countData');  
        $this->db->order_by("id", "desc");
        $this->db->from('opportunities');       
        $res = $this->db->get()->result();
		
		return $res[0]->countData;	
	}
	
	function total_products() 
    {
        $this->db->order_by("id", "desc");
        $this->db->from('products');       
        	
		return count($this->db->get()->result());	
	}
	
	function total_quotations() 
    {
    	$id=userdata('id');
    	if($id!='1')
		{
			//$this->db->where('sales_person', userdata('id'));
			$salesteam_id = $this->dashboard_model->get_staff_salesteam($id);
			
			$this->db->where('sales_person', $id);
			$this->db->or_where('sales_team_id', $salesteam_id);
		}
		
        // $this->db->where("quot_or_order", "q");
        $this->db->order_by("id", "desc");
        $this->db->from('quotations_salesorder');       
        	
		return count($this->db->get()->result());	
	}
	
	function dis_quotations()
	{
    	if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('sales_person', userdata('id'));
		}
		$this->db->select('count(DISTINCT(customer_id)) AS countData');  
        $this->db->order_by("id", "desc");
        $this->db->from('quotations_salesorder');   
		$this->db->where("quot_or_order", "q");
		
        $res = $this->db->get()->result();
		
		return $res[0]->countData;	
	}
	
	function total_salesorders() 
    {
    	$id=userdata('id');
    	if($id!='1')
		{
			//$this->db->where('sales_person', $id);
			$salesteam_id = $this->dashboard_model->get_staff_salesteam($id);
			
			$this->db->where('sales_person', $id);
			$this->db->or_where('sales_team_id', $salesteam_id);
		}
		
        $this->db->where("quot_or_order", "o");
        $this->db->order_by("id", "desc");
        $this->db->from('quotations_salesorder');       
        	
		return count($this->db->get()->result());	
	}
	
	function dis_salesorders()
	{
            if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('sales_person', userdata('id'));
		}
                
		$this->db->select('count(DISTINCT(customer_id)) AS countData');  
        $this->db->order_by("id", "desc");
        $this->db->from('quotations_salesorder');   
		$this->db->where("quot_or_order", "o");
		
        $res = $this->db->get()->result();
		
		return $res[0]->countData;	
	}
	
	function total_calls() 
    {   
    	if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('resp_staff_id', userdata('id'));
		}
		      
        $this->db->order_by("id", "desc");
        $this->db->from('calls');       
        	
		return count($this->db->get()->result());	
	}
	
    function total_customers() 
    {
        $this->db->order_by("id", "desc");
        $this->db->from('company');       
        	
		return count($this->db->get()->result());	
	}
	
	function dis_customers($id)
	{
            if($this->user_model->get_role($id)[0]->role_id!='1')
		{
			$this->db->where('id', $id);
		}
		$this->db->select('count(DISTINCT(email)) AS countData');  
        $this->db->order_by("id", "desc");
        $this->db->from('company');   
		
        $res = $this->db->get()->result();
		
		return $res[0]->countData;	
	}
	
	function total_meetings() 
    {
    	if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('responsible', userdata('id'));
		}
		
        $this->db->order_by("id", "desc");
        $this->db->from('meetings');       
        	
		return count($this->db->get()->result());	
	}
    
	function total_email() 
    {
    	$this->db->where('to', userdata('id'));
		 
        $this->db->order_by("id", "desc");
        $this->db->from('emails');       
        	
		return count($this->db->get()->result());	
	}
	function total_contracts() 
    {
    	if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('resp_staff_id', userdata('id'));
		}
		
        $this->db->order_by("id", "desc");
        $this->db->from('contracts');       
        	
		return count($this->db->get()->result());	
	}
	
	function sales_today_total() 
    {
    	$date = strtotime(date('Y-m-d'));
		
		$this->db->select_sum('grand_total');	
		$this->db->where(array('sales_order_create_date' => $date,'quot_or_order' => 'o'));
        $this->db->from('quotations_salesorder');  
        
        $query = $this->db->get();
	    $total_sales = $query->row()->grand_total;
		
	    if ($total_sales > 0)
	    {
	        return round($total_sales);
	        
	    }

	    return '0';
        	
		//return count($this->db->get()->result());	
	}
	
	function sales_yesterday_total() 
    {
    	$date = strtotime(date('Y-m-d',strtotime("-1 days")));
		$this->db->select_sum('grand_total'); 	
		$this->db->where(array('sales_order_create_date' => $date,'quot_or_order' => 'o'));	
        $this->db->order_by("id", "desc");
        $this->db->from('quotations_salesorder');  
        	
		$query = $this->db->get();
	    $total_sales = $query->row()->grand_total;
		
	    if ($total_sales > 0)
	    {
	        return round($total_sales);
	        
	    }

	    return '0';
		
		//return count($this->db->get()->result());	
	}
	
	function sales_this_week_total() 
    {
    	 
         $start = (date('D') != 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
  		
  		 $finish = (date('D') != 'Sat') ? date('Y-m-d', strtotime('next Saturday')) : date('Y-m-d');     
		 
		$this->db->select_sum('grand_total'); 
		$this->db->where('sales_order_create_date BETWEEN "'.strtotime($start).'" AND "'.strtotime($finish).'"'); 
		$this->db->where('quot_or_order','o');
        $this->db->from('quotations_salesorder');  
        
        $query = $this->db->get();
	    $total_sales = $query->row()->grand_total;
		
	    if ($total_sales > 0)
	    {
	        return round($total_sales);
	        
	    }

	    return '0';
        	
		//return count($this->db->get()->result());	
	}
	
	function sales_this_month_total() 
    {
    	$first_date = date('d-m-Y',strtotime('first day of this month'));
		$last_date = date('d-m-Y',strtotime('last day of this month'));
 		
 		$this->db->select_sum('grand_total');
		$this->db->where('sales_order_create_date BETWEEN "'.strtotime($first_date).'" AND "'.strtotime($last_date).'"'); 
		$this->db->where('quot_or_order','o');
        $this->db->from('quotations_salesorder');  
        	
		$query = $this->db->get();
	    $total_sales = $query->row()->grand_total;
		
	    if ($total_sales > 0)
	    {
	        return round($total_sales);
	        
	    }

	    return '0';

		
		//return count($this->db->get()->result());	
	}
	
	function top_selling_team() 
    {
        $this->db->order_by("actual_invoice", "desc");
        $this->db->from('salesteams');       
        	
		return $this->db->get()->result();	
	}
	
	function salesteams_performance_list() 
    {
        $this->db->order_by("id", "desc");
        $this->db->from('salesteams');       
        	
		return $this->db->get()->result();	
	}

	function opportunities_sumary(){
		$q = "SELECT system_type, system_code, system_value_txt, COUNT(system_value_txt) as jumlah FROM `tb_m_system` as tbms
left JOIN opportunities as o on tbms.system_code=o.tags_id
WHERE tbms.system_type='TAGS'
GROUP BY tbms.system_value_txt";
		return $this->db->query($q)->result();
		// return $this->db->get()->result();
	}
	
	function opportunities_by_owner(){
		$q="SELECT s.salesteam, o.opportunity, COUNT(opportunity) as sum_opportunity, SUM(expected_revenue)as sum_expected_revenue, sales_team_id
			FROM `salesteams` as s
			LEFT JOIN opportunities as o on o.sales_team_id=s.id 
			GROUP BY sales_team_id
			ORDER BY s.salesteam asc";
		// $q="SELECT opportunity, COUNT(opportunity) as sum_opportunity, SUM(expected_revenue)as sum_expected_revenue FROM `opportunities` GROUP BY opportunity";
		return $this->db->query($q)->result();
	}

	function opportunities_by_salesperson(){
		$q="SELECT o.salesperson_id, COUNT(o.salesperson_id) as count_id, SUM(o.expected_revenue)as sum_expected_revenue, u.first_name, u.last_name 
			FROM `opportunities` o
			JOIN users as u on o.salesperson_id=u.id
			GROUP BY o.salesperson_id
			ORDER BY u.first_name ASC";
		return $this->db->query($q)->result();
	}

	function opportunities_by_salesperson_b(){
		$q="SELECT o.customer_id, o.customer_id as count_id, o.salesperson_id, count(o.salesperson_id) as sid, SUM(o.expected_revenue)as sum_expected_revenue, SUM(o.amount) as sum_amount, u.first_name, u.last_name, c.`name` 
			FROM `opportunities` o
			JOIN users as u on o.salesperson_id=u.id
			JOIN company as c on o.customer_id=c.id
			GROUP BY o.salesperson_id
			ORDER BY u.first_name ASC";
		return $this->db->query($q)->result();
	}

	function opportunities_by_salespersons($years=null, $status=null){		
		$q="SELECT o.salesperson_id, COUNT(o.salesperson_id) as count_id, SUM(o.expected_revenue)as sum_expected_revenue, u.first_name, u.last_name 
			FROM `opportunities` o
			JOIN users as u on o.salesperson_id=u.id";

		if (!is_null($years)){
			$q.= " where create_date like '%".$years."%'";
		}

		if (!is_null($status) and !is_null($years)){
			$q.= " and closed_status = ".$status;
		}elseif(!is_null($status) and is_null($years)){
			$q .= " where closed_status = ".$status;
		}

		$q.=" GROUP BY o.salesperson_id
			ORDER BY u.first_name ASC";
		return $this->db->query($q)->result();
		// return $q;
	}

	function opportunities_revenue($tags_id){
		$q = "SELECT sum(expected_revenue) as sum_revanue FROM `opportunities` WHERE tags_id like '%".$tags_id."%'";
		$res = $this->db->query($q)->row();
		if ($res->sum_revanue > 0){
			return $res->sum_revanue;
		}else{
			return 0;
		}
	}

	function salesteams_percent_count($salesteam_id) 
    {
        $res=$this->db->get_where('salesteams',array('id' => $salesteam_id))->row();       
        	 
				if($res->invoice_target!="0" and $res->actual_invoice!="0")
              	{
					$percent = $res->actual_invoice/$res->invoice_target;
				 	$percent_total = number_format( $percent * 100, 2 ) . '%';
				
				}
				else
				{
					$percent_total = '0%';
				}
		return $percent_total;	
		
	} 
	
	function sales_data_by_team_id($id) 
    { 			
		$this->db->where(array('sales_team_id' => $id,'quot_or_order' => 'o'));	
        $this->db->order_by("id", "desc");
        $this->db->from('quotations_salesorder');  
        $res=$this->db->get()->result();	
		
		return $res;	
	}
	
	function get_staff_salesteam($id) 
    {
    	
    	$query = $this->db->query('SELECT id FROM salesteams WHERE FIND_IN_SET('.$id.',team_members) LIMIT 1'); 
		if ($query->num_rows() > 0)
		{
			$row = $query->row_array();
		 	$team_id=$row['id'];
			return $team_id;
		}     	
    }
	
	function staff_leads_list($id) 
    {
    	$this->db->where(array('salesperson_id' => $id));
        $this->db->order_by("id", "desc");
        $this->db->limit(5);
        $this->db->from('leads');       
        	
		return $this->db->get()->result();	
	}
	
	function staff_leads_by_team($team_id) 
    {
    	$this->db->where(array('sales_team_id' => $team_id));
        $this->db->order_by("id", "desc");
        $this->db->limit(5);
        $this->db->from('leads');       
        	
		return $this->db->get()->result();	
	}
	
	function staff_opportunities_list($id) 
    {
    	$this->db->where(array('salesperson_id' => $id));
        $this->db->order_by("id", "desc");
        $this->db->limit(5);
        $this->db->from('opportunities');       
        	
		return $this->db->get()->result();	
	}
	
	function staff_opportunities_by_team($team_id) 
    {
    	$this->db->where(array('sales_team_id' => $team_id));
        $this->db->order_by("id", "desc");
        $this->db->limit(5);
        $this->db->from('opportunities');       
        	
		return $this->db->get()->result();	
	}
	
	function staff_quotations_list($id) 
    {
    	$this->db->where(array('sales_person' => $id,'quot_or_order' => 'q'));
        $this->db->order_by("id", "desc");
        $this->db->limit(5);
        $this->db->from('quotations_salesorder'); 
        	
		return $this->db->get()->result();	
	}
	
	function staff_quotations_by_team($team_id) 
    {
    	$this->db->where(array('sales_team_id' => $team_id,'quot_or_order' => 'q'));
        $this->db->order_by("id", "desc");
        $this->db->limit(5);
        $this->db->from('quotations_salesorder'); 
        	
		return $this->db->get()->result();	
	}
	
	function staff_invoices_list($id) 
    {
    	$this->db->where(array('salesperson_id' => $id));
        $this->db->order_by("id", "desc");
        $this->db->limit(5);
        $this->db->from('invoices'); 
        	
		return $this->db->get()->result();	
	}
	
	function staff_invoices_by_team($team_id) 
    {
    	$this->db->where(array('sales_team_id' => $team_id));
        $this->db->order_by("id", "desc");
        $this->db->limit(5);
        $this->db->from('invoices'); 
        	
		return $this->db->get()->result();	
	}
	
	function staff_call_log_list($id) 
    {
    	$this->db->where(array('resp_staff_id' => $id));
        $this->db->order_by("id", "desc");
        $this->db->limit(5);
        $this->db->from('calls'); 
        	
		return $this->db->get()->result();	
	}
	
	function staff_contracts_list($id) 
    {
    	$this->db->where(array('resp_staff_id' => $id));
        $this->db->order_by("id", "desc");
        $this->db->limit(5);
        $this->db->from('contracts'); 
        	
		return $this->db->get()->result();	
	}
	
	function staff_leads_event_list($id) 
    {
    	$start = (date('D') != 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
  		
  		$finish = (date('D') != 'Sat') ? date('Y-m-d', strtotime('next Saturday')) : date('Y-m-d');
  		 
    	//echo strtotime($start); exit();
    	$this->db->where('register_time BETWEEN "'.strtotime($start).'" AND "'.strtotime($finish).'"'); 
		$this->db->where('salesperson_id',$id);
        
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $this->db->from('leads'); 
        	
		return $this->db->get()->result();	
	}
	
	function staff_company_event_list($id) 
    {
    	$start = (date('D') != 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
  		
  		 $finish = (date('D') != 'Sat') ? date('Y-m-d', strtotime('next Saturday')) : date('Y-m-d');
  		 
    	 
    	$this->db->where('register_time BETWEEN "'.strtotime($start).'" AND "'.strtotime($finish).'"'); 
		$this->db->where('salesperson_id',$id);
        
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $this->db->from('company'); 
        	
		return $this->db->get()->result();	
	}
	
	function staff_opportunities_event_list($id) 
    {
    	$start = (date('D') != 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
  		
  		 $finish = (date('D') != 'Sat') ? date('Y-m-d', strtotime('next Saturday')) : date('Y-m-d');
  		 
    	 
    	$this->db->where('register_time BETWEEN "'.strtotime($start).'" AND "'.strtotime($finish).'"'); 
		$this->db->where('salesperson_id',$id);
        
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $this->db->from('opportunities'); 
        	
		return $this->db->get()->result();	
	}
	
	 function staff_quotations_event_list($id, $status) 
     {
    	 $start = (date('D') != 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
  		
  		 $finish = (date('D') != 'Sat') ? date('Y-m-d', strtotime('next Saturday')) : date('Y-m-d');
  		 
    	 $this->db->where('register_time BETWEEN "'.strtotime($start).'" AND "'.strtotime($finish).'"'); 
		 $this->db->where('sales_person',$id);
		 $this->db->where('quot_or_order',$status);
        
         $this->db->order_by("id", "desc");
         $this->db->limit(1);
         $this->db->from('quotations_salesorder'); 
		
		 return $this->db->get()->result();	
	 }
	
	function staff_logged_call_event_list($id) 
    {
    	$start = (date('D') != 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
  		
  		 $finish = (date('D') != 'Sat') ? date('Y-m-d', strtotime('next Saturday')) : date('Y-m-d');
  		 
    	 
    	$this->db->where('date BETWEEN "'.strtotime($start).'" AND "'.strtotime($finish).'"'); 
		$this->db->where('resp_staff_id',$id);
        
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $this->db->from('calls'); 
        	
		return $this->db->get()->result();	
	}
	
	function staff_meetings_event_list($id) 
    {
    	$start = (date('D') != 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
  		
  		 $finish = (date('D') != 'Sat') ? date('Y-m-d', strtotime('next Saturday')) : date('Y-m-d');
  		 
    	 
    	$this->db->where('starting_date BETWEEN "'.strtotime($start).'" AND "'.strtotime($finish).'"'); 
		$this->db->where('responsible',$id);
        
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $this->db->from('meetings'); 
        	
		return $this->db->get()->result();	
	}
	
	function staff_contracts_event_list($id) 
    {
    	$start = (date('D') != 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
  		
  		 $finish = (date('D') != 'Sat') ? date('Y-m-d', strtotime('next Saturday')) : date('Y-m-d');
  		 
    	 
    	$this->db->where('end_date BETWEEN "'.strtotime($start).'" AND "'.strtotime($finish).'"'); 
		$this->db->where('resp_staff_id',$id);
        
        $this->db->order_by("id", "desc");
        $this->db->limit(1);
        $this->db->from('contracts'); 
        	
		return $this->db->get()->result();	
	}
	
	function delete_notification( $notification_id )
	{ 
		if( $this->db->delete('notifications',array('id' => $notification_id)) )  // Delete customer
		{  
			return true;
		}
	}


    function quotation_summary(){
        $q = "SELECT q.sales_person, COUNT(q.sales_person) as sum_sales, SUM(q.total) as sum_total, u.first_name, u.last_name FROM `quotations_salesorder` as q JOIN users as u on q.sales_person=u.id GROUP BY sales_person";
        return $this->db->query($q)->result();
    }

    function quotation_summary_by_owner(){
        $q = "SELECT s.salesteam, q.customer_id, COUNT(q.sales_person) as sum_sales, SUM(q.total) as sum_total
			FROM `salesteams` as s 
			LEFT JOIN `quotations_salesorder` as q on s.id=q.sales_team_id
			GROUP BY sales_team_id
			ORDER BY s.salesteam ASC";
        return $this->db->query($q)->result();
    }

    function count_leads()
	{
		$this->db->select('count(system_type) AS countData');
        $this->db->from('tb_m_system');   
		$this->db->where(array('system_type'=>'LEAD'));
		// $this->db->where(array('system_type'=>'LEAD', 'system_value_num !='=>0));
        $res = $this->db->get()->row();
		return $res->countData;	
	}
	
	function count_opportunities()
	{
        if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('salesperson_id', userdata('id'));
		}
		$this->db->select('count(DISTINCT(id)) AS countData');  
		// $this->db->select('count(DISTINCT(opportunity)) AS countData');  
        $this->db->order_by("id", "desc");
        $this->db->from('opportunities');       
        $res = $this->db->get()->result();
		
		return $res[0]->countData;	
	}
	
	//MM
	function count_opportunities_qualification()
	{
        if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('salesperson_id', userdata('id'));
		}
		$this->db->select('count(DISTINCT(id)) AS countData');  
		// $this->db->select('count(DISTINCT(opportunity)) AS countData');  
		$this->db->where('stages_id', 1);
        $this->db->order_by("id", "desc");
        $this->db->from('opportunities');       
        $res = $this->db->get()->result();
		
		return $res[0]->countData;	
	}

	function count_opportunities_analysis()
	{
        if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('salesperson_id', userdata('id'));
		}
		$this->db->select('count(DISTINCT(id)) AS countData');  
		// $this->db->select('count(DISTINCT(opportunity)) AS countData');  
		$this->db->where('stages_id', 2);
        $this->db->order_by("id", "desc");
        $this->db->from('opportunities');       
        $res = $this->db->get()->result();
		
		return $res[0]->countData;	
	}

	function count_opportunities_demo()
	{
        if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('salesperson_id', userdata('id'));
		}
		$this->db->select('count(DISTINCT(id)) AS countData');  
		// $this->db->select('count(DISTINCT(opportunity)) AS countData');  
		$this->db->where('stages_id', 3);
        $this->db->order_by("id", "desc");
        $this->db->from('opportunities');       
        $res = $this->db->get()->result();
		
		return $res[0]->countData;	
	}

	function count_opportunities_proposal ()
	{
        if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('salesperson_id', userdata('id'));
		}
		$this->db->select('count(DISTINCT(id)) AS countData');  
		// $this->db->select('count(DISTINCT(opportunity)) AS countData');  
		$this->db->where('stages_id', 4);
        $this->db->order_by("id", "desc");
        $this->db->from('opportunities');       
        $res = $this->db->get()->result();
		
		return $res[0]->countData;	
	}

	function count_opportunities_negotiation  ()
	{
        if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('salesperson_id', userdata('id'));
		}
		$this->db->select('count(DISTINCT(id)) AS countData');  
		// $this->db->select('count(DISTINCT(opportunity)) AS countData');  
		$this->db->where('stages_id', 5);
        $this->db->order_by("id", "desc");
        $this->db->from('opportunities');       
        $res = $this->db->get()->result();
		
		return $res[0]->countData;	
	}

	function count_opportunities_close  ()
	{
        if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('salesperson_id', userdata('id'));
		}
		$this->db->select('count(DISTINCT(id)) AS countData');  
		// $this->db->select('count(DISTINCT(opportunity)) AS countData');  
		$this->db->where('stages_id', 6);
        $this->db->order_by("id", "desc");
        $this->db->from('opportunities');       
        $res = $this->db->get()->result();
		
		return $res[0]->countData;	
	}

	function count_opportunities_won ()
	{
        if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('salesperson_id', userdata('id'));
		}
		$this->db->select('count(DISTINCT(id)) AS countData');  
		// $this->db->select('count(DISTINCT(opportunity)) AS countData');  
		$this->db->where('stages_id', 7);
        $this->db->order_by("id", "desc");
        $this->db->from('opportunities');       
        $res = $this->db->get()->result();
		
		return $res[0]->countData;	
	}

	function count_opportunities_lost ()
	{
        if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('salesperson_id', userdata('id'));
		}
		$this->db->select('count(DISTINCT(id)) AS countData');  
		// $this->db->select('count(DISTINCT(opportunity)) AS countData');  
		$this->db->where('stages_id', 8);
        $this->db->order_by("id", "desc");
        $this->db->from('opportunities');       
        $res = $this->db->get()->result();
		
		return $res[0]->countData;	
	}

	function count_opportunities_deferred ()
	{
        if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('salesperson_id', userdata('id'));
		}
		$this->db->select('count(DISTINCT(id)) AS countData');  
		// $this->db->select('count(DISTINCT(opportunity)) AS countData');  
		$this->db->where('stages_id', 9);
        $this->db->order_by("id", "desc");
        $this->db->from('opportunities');       
        $res = $this->db->get()->result();
		
		return $res[0]->countData;	
	}
	
	//MM

	function count_quotations()
	{
    	if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$this->db->where('sales_person', userdata('id'));
		}
		$this->db->select('count(DISTINCT(quotations_number)) AS countData');  
        $this->db->order_by("id", "desc");
        $this->db->from('quotations_salesorder');  
        $this->db->where("quot_or_order", "q"); 
		
        $res = $this->db->get()->result();
		
		return $res[0]->countData;	
	}

	function count_quot_salesorders()
	{
        if($this->user_model->get_role(userdata('id'))[0]->role_id!='1')
		{
			$salesteam_id = $this->dashboard_model->get_staff_salesteam(userdata('id'));

			$this->db->where('sales_person', userdata('id'));
            $this->db->or_where('sales_team_id', $salesteam_id);
		}
                
		$this->db->select('count(DISTINCT(quotations_number)) AS countData');  
        $this->db->order_by("id", "desc");
        $this->db->from('quotations_salesorder');   
		$this->db->where("quot_or_order", "o");
		$this->db->where(array('archive' => '0'));
		
        $res = $this->db->get()->result();
		
		return $res[0]->countData;	
	}

	function count_opportunities_stages(){
		$q = "SELECT o.customer_id, o.salesperson_id, sum(o.expected_revenue) as sum_expected_revenue, sum(o.amount) as sum_amount, o.opportunity, tms.system_type, tms.system_code, count(system_code) as jumlah, tms.system_value_txt, c.name 
			FROM opportunities o
			JOIN tb_m_system tms on o.stages_id=tms.system_code
			JOIN company c on o.customer_id=c.id
			WHERE tms.system_type='OPPORTUNITIES_STAGES'
			GROUP BY tms.system_code
			ORDER BY tms.system_code asc";
			
		return $this->db->query($q)->result();
		// return $this->db->get()->result();
	}
}

?>