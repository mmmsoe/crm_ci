<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

error_reporting(0);

class ticket_model extends CI_Model {

    function __construct() {

        parent::__construct();
    }

    function ticket_list() {

        $this->db->select("
			tickets.id,
            tickets.description,
			users.first_name as name,
			subject, 
		  	tc.ticket_category_name as categories, 
			tms2.system_value_txt as priorities, 
			tickets.status,tickets.category,tickets.priority 
			FROM tickets
			LEFT JOIN ticket_categories tc ON category = tc.ticket_category_id
			LEFT JOIN tb_m_system tms2 on priority= tms2.system_code
			LEFT JOIN users ON users.id=tickets.customer_id 
			WHERE tms2.system_type = 'TICKET_PRIORITY'
			group by tickets.id
			");

        $this->db->order_by('priority', 'desc');


        return $this->db->get()->result();


        //print_r($this->db->get()->result());
    }

    function add_ticket() {

        $ticket_detail = array(
            //'id'=>$this->input->post('aidi'),

            'subject' => $this->input->post('ticket_subject'),
            'customer_id' => $this->input->post('customer_id'),
            'priority' => $this->input->post('ticket_priority'),
            'category' => $this->input->post('ticket_category'),
            'description' => $this->input->post('ticket_description'),
            'status' => 'Open'
        );



        return $this->db->insert('tickets', $ticket_detail);
    }

    function get_ticket($ticket_id) {

		$this->db->select('a.id AS ticket_id
				 , b.first_name as name
				 , a.subject
				 , a.description
				 , c.ticket_category_name as categories
				 , d.name as priority');
		
		$this->db->from('tickets as a');
		$this->db->join('users as b','a.customer_id = b.id');
		$this->db->join('ticket_categories as c','a.category = c.ticket_category_id');
		$this->db->join ('tickets_priority as d','a.priority = d.id');
		$this->db->where('a.id',$ticket_id);
         return $this->db->get()->row();
	
    }

    function get_reply($ticket_id) {

//		$this->db->select("tickets_reply.id as id,
//
//	tickets_reply.user_id,
//
//    users.first_name as name,
//
//	message from tickets_reply
//
//    join tickets
//
//    join users
//
//	on tickets.id=tickets_reply.ticket_id
//
//    and tickets_reply.user_id = users.id
//
//    ");
//
//		$this->db->where('tickets.id',$ticket_id);
//
//		return $this->db->get()->result();


        // $sql = "SELECT
                       // s.customer_id,
                        // s.SUBJECT,
                        // s.description,
                        // s.category,
                        // s.priority,
                        // s.STATUS,
                        // r.id AS id,
                        // r.user_id,
                        // u.first_name AS NAME,
                        // CONCAT(u.first_name,' ',u.last_name) as username,
                        // u.user_avatar as image,
                        // r.message
                    // FROM
                        // tickets_reply r 
                    // JOIN tickets s ON s.id = r.ticket_id
                    // JOIN users u ON r.user_id = u.id
                    // AND s.id = " . $ticket_id . "
                    // AND r.user_id = u.id";
		$sql = "SELECT  r.id AS id,
                        r.user_id,
                        u.first_name AS NAME,
                        CONCAT(u.first_name,' ',u.last_name) as username,
                        u.user_avatar as image,
                        r.message
                    FROM
                    tickets_reply r 
					JOIN tickets s ON s.id = r.ticket_id
                    JOIN users u ON r.user_id = u.id
                    AND s.id = " . $ticket_id . "
                    AND r.user_id = u.id";

        return $this->db->query($sql)->result();
    }

    function reply_ticket() {

        $reply_detail = array(
            //'id'=>$this->input->post('aidi'),

            'user_id' => $this->input->post('customer_id'),
            'ticket_id' => $this->input->post('id_ticket'),
            'message' => $this->input->post('ticket_reply'),
        );



        return $this->db->insert('tickets_reply', $reply_detail);
    }

    function update_status($id) {

        $ticket_details = array(
            'status' => 'Close',
        );



        //$this->db->query("update tickets set status ='Open'");
        //$this->db->where("ID",$id);	

        return $this->db->update('tickets', $ticket_details, array('id' => $id));
    }
	function delete_tickets($id)
	{
		$this->db->delete('tickets',array('id'=>$id));
		return true;
	}
	function delete_reply($id)
	{
		$this->db->delete('tickets_reply',array('id'=>$id));
		return true;
	}


}

?>