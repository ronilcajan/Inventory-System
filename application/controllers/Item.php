<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Item extends CI_Controller {

    public function __construct()
    { 
        parent::__construct();
        if(!$this->session->userdata('user_id')){ 
            redirect('login'); 
        }  
    }
        
    public function index()
    { 
        $data['page_title'] = "Items";
        
        $data['items'] = $this->item_model->get_items();
        
        $this->load->view('item', $data, FALSE); 
    } 
    
    public function add_item()
    { 
        $data['page_title'] = "Add Items";
        // dropdown
        $data['category'] = $this->category_model->get_category();
        
        $this->load->view('add_item', $data, FALSE); 

    } 

    public function submit_item()
    { 

        $data = array(
            'description' => $this->input->post('description'), 
            'size' => $this->input->post('size'), 
            'quantity' => $this->input->post('quantity'),
            'unit' => $this->input->post('unit'),
            'limit_quantity' => $this->input->post('limit_quantity'),
        );

        if(!$this->input->post('category_id') == ''){
            $data['category_id'] = $this->input->post('category_id');
        }
 
        $result = $this->item_model->insert_item($data); 

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
                'description' => 'Create item',
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
            $this->session->set_flashdata('description', $this->input->post('description'));
            $this->session->set_flashdata('qty', $this->input->post('qty'));
            $this->session->set_flashdata('unit', $this->input->post('unit'));
        }

        redirect('item/add_item');
    }
    
    public function edit_item($id)
    { 
        $data['page_title'] = "Edit Item";
        $data['item'] = $this->item_model->select_item($id); 
        $data['category'] = $this->category_model->get_category();
        $this->load->view('edit_item', $data); 
    } 
      
    

    public function udpate_item($id){ 
        $data = array(
            'description' => $this->input->post('description'), 
            'size' => $this->input->post('size'), 
            'quantity' => $this->input->post('quantity'),
            'unit' => $this->input->post('unit'),
            'limit_quantity' => $this->input->post('limit_quantity'),
        );

        if(!$this->input->post('category_id') == ''){
            $data['category_id'] = $this->input->post('category_id');
        }else{
            $data['category_id'] = NULL;
        }
 

        $result = $this->item_model->update_item($id,$data);
        // print_r($result);
 
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
                'description' => 'Update item',
                'date' => date('Y-m-d H:i:s')
              );
          
              $this->user_model->insert_logs($logs);

        }else{
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span><i class="fas fa-exclamation"></i> Item already exist.</span>
                </div>
            '); 
        }
        redirect('item/edit_item/'. $id);
    }

    

    public function delete_item($id){
        $result = $this->item_model->delete_item($id); 
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
                'description' => 'Delete item',
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
        redirect('item');
    }

    public function get_item_by_category($id)
    {
        
        $items = $this->item_model->get_item_by_category($id);
        // print_r($items);
        $output='<option value="">Choose Item</option>';
        foreach($items as $item)
        {
            $output .='<option data-item-unit="'.$item['unit'].'" data-stock-quantity="'.$item['quantity'].'" value="'.$item['item_no'].'">'.$item['description'].'</option>';
        } 

        echo json_encode($output);
    }

    public function countTotalrow()
    {
        $data['query'] = $this->item_model->count_user();
    }
} 
        
                            