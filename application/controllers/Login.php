<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Login extends CI_Controller {

  
public function __construct()
{ 
  parent::__construct();
  if($this->session->userdata('user_id')){ 
    redirect('inventory'); 
  }  
}

public function index()
{
               
  $data['page_title'] = "Login";  
  $this->load->view('login', $data, FALSE);  
}

public function login_submit()
{
               
  $data = $this->input->post();

  $result = $this->user_model->login_submit($data);

  if(!is_null($result)){

    $session = array(
      'user_id' => $result['user_id'],
      'name' => $result['name'],
      'username' => $result['username'],
      'user_type' => $result['user_type'],
      'designation_office' => $result['designation_office']
    );
    
    $this->session->set_userdata( $session );
    
    $logs = array(
      'user_id' => $this->session->userdata('user_id'),
      'description' => 'User login',
      'date' => date('Y-m-d H:i:s')
    );

    $this->user_model->insert_logs($logs);
    
    redirect('inventory');
    
  }else{
    
    $this->session->set_flashdata('message', '
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <span><i class="fas fa-exclamation"></i>Invalid username/password!</span> 
    </div>');
    $this->session->set_flashdata('username', $this->input->post('username'));
    $this->session->set_flashdata('password', $this->input->post('password'));
    redirect(base_url('login'));
  }
}
        
} 
                            