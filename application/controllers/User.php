<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class User extends CI_Controller {

  public function __construct()
  { 
      parent::__construct();
      if(!$this->session->userdata('user_id')){ 
          redirect('login'); 
      }  
  }
      
  public function index()
  { 
      $data['page_title'] = "Users"; 
      $data['users'] = $this->user_model->get_users(); 
      $this->load->view('users', $data, FALSE); 
  } 
 
  public function add_user()
  { 
      $data['page_title'] = "Add User";  
      $this->load->view('add_user', $data, FALSE); 
  } 

  
  public function submit_user()
  { 
      $data = array(
          'name'               => $this->input->post('name'),
          'username'           => $this->input->post('username'),
          'password'           => md5($this->input->post('password')),
          'user_type'          => $this->input->post('user_type'),
          'designation_office' => $this->input->post('designation_office'),
      );
  

      $result = $this->user_model->insert_user($data); 
         

      if($result>0){
          
          $this->session->set_flashdata('message', '
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  <span><i class="fas fa-check"></i> Successfully Added.</span>
              </div>
          ');

          $logs = array(
            'user_id' => $this->session->userdata('user_id'),
            'description' => 'Create user',
            'date' => date('Y-m-d H:i:s')
          );
      
          $this->user_model->insert_logs($logs);

      }else{
          $this->session->set_flashdata('message', '
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  <span><i class="fas fa-exclamation"></i> Something went wrong.Please try again.</span>
              </div>
          ');
          $this->session->set_flashdata('name', $this->input->post('name'));
          $this->session->set_flashdata('username', $this->input->post('username'));
          $this->session->set_flashdata('password', $this->input->post('password'));
          $this->session->set_flashdata('user_type', $this->input->post('user_type'));
          $this->session->set_flashdata('designation_office', $this->input->post('designation_office'));
      }

      redirect('user/add_user');
  }

  
  public function edit_user($id)
  { 
      $data['page_title'] = "Edit User";
      $data['user'] = $this->user_model->select_user($id);  
      $this->load->view('edit_user', $data); 
  } 

  
  public function update_user($id){ 
    
    $data = array( 
        'name' => $this->input->post('name'), 
        'username' => $this->input->post('username'),
        'user_type' => $this->input->post('user_type'),
        'designation_office' => $this->input->post('designation_office'),
    );

    if(!$this->input->post('password') == ''){
        $data['password'] = md5($this->input->post('password'));
    } 
 
    $result = $this->user_model->update_user($id,$data); 
     

    if($result){ 
        $this->session->set_flashdata('message', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span><i class="fas fa-check"></i> Edit Successfully.</span>
            </div>
        ');

        $logs = array(
            'user_id' => $this->session->userdata('user_id'),
            'description' => 'Update user',
            'date' => date('Y-m-d H:i:s')
          );
      
          $this->user_model->insert_logs($logs);

    }else{
        $this->session->set_flashdata('message', '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span><i class="fas fa-exclamation"></i> User already exist.</span>
            </div>
        '); 
    }
    redirect('user/edit_user/'. $id);
  }

  

  public function delete_user($id){
    $result = $this->user_model->delete_user($id); 
    if($result>0){ 
        $this->session->set_flashdata('message', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span><i class="fas fa-check"></i> Deleted Successfully.</span>
            </div>
        ');

        $logs = array(
            'user_id' => $this->session->userdata('user_id'),
            'description' => 'Delete user',
            'date' => date('Y-m-d H:i:s')
          );
      
          $this->user_model->insert_logs($logs);

    }else{
        $this->session->set_flashdata('message', '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span><i class="fas fa-exclamation"></i> Cant delete this category.</span>
            </div>
        ');
    }
    redirect('user');
}


  public function logout()
  {
      $all_sessions = $this->session->all_userdata();

      $logs = array(
        'user_id' => $this->session->userdata('user_id'),
        'description' => 'Logout user',
        'date' => date('Y-m-d H:i:s')
      );
  
      $this->user_model->insert_logs($logs);

      // unset all sessions
      foreach ($all_sessions as $key => $val) {
          $this->session->unset_userdata($key);
      }

      redirect('login');
  }
  
  
        
} 