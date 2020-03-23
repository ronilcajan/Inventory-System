<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Release extends CI_Controller {


  public function __construct()
  { 
      parent::__construct();
      if(!$this->session->userdata('user_id')){ 
          redirect('login'); 
      }  
  }
      
  public function index()
  { 
    $data['page_title'] = "Release"; 
    $data['release'] = $this->inventory_model->get_all_release();  
    $this->load->view('release', $data, FALSE);           
  }

  public function view_release($id)
  {
    $data['page_title'] = "Release Item"; 
    $data['request'] = $this->inventory_model->select_request($id); 
    $data['request_items'] = $this->inventory_model->view_request_item($id);  
    $this->load->view('release_item', $data, FALSE); 
  }
        
}
         
                            