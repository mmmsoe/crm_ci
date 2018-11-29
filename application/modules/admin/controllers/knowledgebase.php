<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Knowledgebase extends CI_Controller {

    function Knowledgebase() 
    {	
         parent::__construct();
		 $this->load->database();
		 $this->load->model("article_model");
		 $this->load->model("ticket_model");
	
         /*cache control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
         
         check_login(); 

    }

	function index()
	{
		if (!check_staff_permission('knowledge_base_read'))	
			{
				redirect(base_url('admin/access_denied'), 'refresh');  
			}
			 
		//$data['article'] = $this->article_model->data_list();
		$data['data'] = $this->article_model->data_list();
		$this->load->view('header');
		$this->load->view('knowledge/index',$data);
		$this->load->view('footer');
	}
	function show($data)
	{
		if (!check_staff_permission('knowledge_base_read'))	
			{
				redirect(base_url('admin/access_denied'), 'refresh');  
			}
			
		$item['select']=$this->article_model->select($data);
                $item['select1']=$this->article_model->select1($data);
		$item['data']=$this->article_model->collect($data);
		$this->load->view('header');
		$this->load->view('knowledge/view',$item);
		$this->load->view('footer');
	}
	
	
	function add_folder()
	{
		if (!check_staff_permission('knowledge_base_write'))	
			{
				redirect(base_url('admin/access_denied'), 'refresh');  
			}
			
		if( $this->article_model->adding())
            { 
                echo '<div class="alert alert-success">'.$this->lang->line('create_succesful').'</div>';
				
			}
            else
            {
                echo $this->lang->line('technical_problem');
            }
	}
	function add_article()
	{
		if (!check_staff_permission('knowledge_base_write'))	
			{
				redirect(base_url('admin/access_denied'), 'refresh');  
			}

		if( $this->article_model->addarticle())
            { 
                echo '<div class="alert alert-success">'.$this->lang->line('create_succesful').'</div>';
				
			}
            else
            {
                echo $this->lang->line('technical_problem');
            }
	}
	
	
	function delete_folder($data)
	{
		if (!check_staff_permission('knowledge_base_delete'))	
			{
				redirect(base_url('admin/access_denied'), 'refresh');  
			}

		$this->article_model->erase($data);
	}
	function add($pilih)
	{
		if (!check_staff_permission('knowledge_base_write'))	
			{
				redirect(base_url('admin/access_denied'), 'refresh');  
			}
			
		$data['folder']=$this->article_model->select_folder($pilih);
		$this->load->view('header');
		$this->load->view('knowledge/add',$data);
		$this->load->view('footer');
	}
}

