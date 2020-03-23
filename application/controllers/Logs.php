<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Logs extends CI_Controller {

  public function __construct()
  { 
      parent::__construct();
      if(!$this->session->userdata('user_id')){ 
          redirect('login'); 
      }  
  }
      
  public function index()
  { 
    $data['page_title'] = "Logs"; 
    $data['logs'] = $this->log_model->get_logs();   
    $this->load->view('logs', $data, FALSE);           
  }
        
}
         
                            