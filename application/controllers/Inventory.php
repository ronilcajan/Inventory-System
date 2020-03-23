<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Inventory extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if(!$this->session->userdata('user_id')){ 
      redirect('login'); 
    }  
  }
public function index()
{

  $data['page_title'] = "Home";  
  $data['tot_user'] = $this->user_model->tot_user();  
  $data['tot_release'] = $this->inventory_model->tot_release();  
  $data['tot_pending'] = $this->inventory_model->tot_pending(); 
  $data['tot_supply'] = $this->item_model->tot_supply();   
  $this->load->view('index', $data, FALSE); 
}
        
} 
                            