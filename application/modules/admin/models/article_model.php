<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(0);





class article_model extends CI_Model {



    function __construct()

    {

        parent::__construct();

    }

    

	function data_list()

	{

//		$sql="select * from article_categories";
                $sql = "SELECT
                            (@cnt := @cnt + 1) AS rowNumber,
                            t.*
                            FROM article_categories AS t
                            CROSS JOIN (SELECT @cnt := 0) AS dummy";
		

		return $this->db->query($sql)->result();

	



	}

	

	function collect($data)

	{

		$this->db->select('*');

		$this->db->from('articles');

		$this->db->where('id',$data);

		//print_r($this->db->get()->result());die();

		return $this->db->get()->result();

	}

	function select($data)

	{

		$this->db->select('ID,name');

		$this->db->from('article_categories');

		$this->db->where('ID',$data);
                
		return $this->db->get()->row();

	}
        
        function select1($data)

	{
            $this->db->select('name');

            $this->db->from('article_categories');

            $this->db->where('ID',$data);

            return $this->db->get()->result();
	}

	

	function select_folder($data)

	{

		

	}



	

	function addarticle()

	{

		$add_detail=array(

			'id'=>$this->input->post('id'),

			'title'=>$this->input->post('title'),

			'content'=>$this->input->post('content'));

			return $this->db->insert('articles',$add_detail);

			

	}

	function adding()

	{

		$add_detail=array(

		'name'=>$this->input->post('name'),

		'article_descr'=>$this->input->post('descr'));

		return $this->db->insert('article_categories',$add_detail);

	}

	

	

	function erase($data)

	{

		$this->db->delete('article_categories',array('ID'=>$data));

	}

	

}







?>