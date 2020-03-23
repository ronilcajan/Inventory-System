<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Category extends CI_Controller {

    public function __construct()
    { 
        parent::__construct();
        if(!$this->session->userdata('user_id')){ 
            redirect('login'); 
        }  
    }
        
    public function index()
    {   

        $data['page_title'] = "Category";  
        $data['category'] = $this->category_model->get_category();
        
        $this->load->view('category', $data); 
    } 

    public function submit_category()
    {
        $data = $this->input->post();

        $result = $this->category_model->insert_category($data); 
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
                'description' => 'Create category',
                'date' => date('Y-m-d H:i:s')
              );
          
              $this->user_model->insert_logs($logs);
        }else{
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span><i class="fas fa-exclamation"></i> Category already exist.Please try again.</span>
                </div>
            ');
        }
        redirect('category');
    }

    public function select_category($id){
        $data = $this->category_model->select_cat($id);
        echo json_encode($data);
    }

    public function edit_category(){
        $data = $this->input->post();

        $result = $this->category_model->edit_cat($data);

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
                'description' => 'Update category',
                'date' => date('Y-m-d H:i:s')
              );
          
              $this->user_model->insert_logs($logs);
        }else{
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span><i class="fas fa-exclamation"></i> Category already exist.</span>
                </div>
            ');
        }
        redirect('category');
    }

    public function delete_cat($id){
        $result = $this->category_model->delete_cat($id); 
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
                'description' => 'Delete category',
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
        redirect('category');
    }
        
}
        
    /* End of file  Category.php */
        
                            