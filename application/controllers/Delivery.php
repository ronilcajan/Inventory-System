<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Delivery extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('user_id')){ 
        redirect('login'); 
        }  
    }
    public function index()
    { 
        $data['page_title'] = "Delivery"; 
        $data['delivery'] = $this->delivery_model->get_delivery(); 
        $this->load->view('delivery', $data, FALSE); 

    } 

    public function new_delivery()
    {
        $data['page_title'] = "New Delivery"; 
        $data['requests'] = $this->inventory_model->get_requests();
        $data['category'] = $this->category_model->get_category();
        $data['items'] = $this->item_model->get_items();

        $this->load->view('new_delivery', $data, FALSE); 

    }

    public function edit_delivery_item($id)
    {
        $data['page_title'] = "Edit Delivery"; 
        $data['delivery'] = $this->delivery_model->select_delivery($id);
        $data['delivery_items'] = $this->delivery_model->get_delivery_item($id);
        $data['category'] = $this->category_model->get_category();
        $data['items'] = $this->item_model->get_items();

        $this->load->view('edit_delivery_item', $data, FALSE); 

    }

    public function submit_edit_delivery_item($id){
      $items = $this->input->post();

      $result = $this->delivery_model->delete_delivery($id);


      if($result){

        for ($i=0; $i < count($items['item']) ; $i++) {

          if(is_numeric($items['item'][$i]) && !empty($items['description'][$i])){
            $new_item = array(
              'description' => $items['description'][$i],
              'size' => $items['size'][$i],
              'quantity' => $items['quantity'][$i],
              'unit' => $items['unit'][$i],
              'limit_quantity' => $items['limit_quantity'][$i]
            );

            if(empty($items['category_id'][$i])){
              $new_item['category_id'] = null; 
            }

            $update = $this->delivery_model->update_items($items['item'][$i],$new_item);

            $item = array(
              'delivery_no' => $id,
              'item_no' => $items['item'][$i],
              'quantity' => $items['quantity'][$i]
            );
            //insert on delivery items
            $new_item = $this->delivery_model->insert_new_deliver_items($item);
          
          }elseif(is_numeric($items['item'][$i]) && empty($items['description'][$i])){

            $delivery_items = array(
              'item' => $items['item'][$i],
              'quantity' => $items['quantity'][$i]
            );

            $insert = $this->delivery_model->insert_deliver_items($id,$delivery_items);


          }else{

            $new_item = array(
              'description' => $items['item'][$i],
              'size' => $items['size'][$i],
              'quantity' => $items['quantity'][$i],
              'unit' => $items['unit'][$i],
              'limit_quantity' => $items['limit_quantity'][$i]
            );

            if(empty($items['category_id'][$i])){
              $new_item['category_id'] = null; 
            }
            //insert new items
            $new_item_id = $this->item_model->insert_new_item($new_item);

            $item = array(
              'delivery_no' => $id,
              'item_no' => $new_item_id,
              'quantity' => $items['quantity'][$i]
            );
            //insert on delivery items
            $new_item = $this->delivery_model->insert_new_deliver_items($item);

          }
      }

      if($new_item || $insert || $new_item){
        $this->session->set_flashdata('message', '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <span><i class="fas fa-check"></i> Updated Successfully.</span>
              </div>
          ');
          $logs = array(
            'user_id' => $this->session->userdata('user_id'),
            'description' => 'Create Delivery Item',
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
      redirect('delivery/edit_delivery_item/'.$id);

    }

    
    public function submit_delivery_item()
  {
       
    // print_r($_POST);
    $data = array( 
      'delivery_date' => date('Y-m-d H:i:s'),
      'user_id' => $this->session->userdata('user_id')
    );

    $result = $this->delivery_model->insert_deliver($data);
    $items = $this->input->post();

    if($result){


      for ($i=0; $i < count($items['item']) ; $i++) {

        if(is_numeric($items['item'][$i])){

          $delivery_items = array(
            'item' => $items['item'][$i],
            'quantity' => $items['quantity'][$i]
          );

          $insert = $this->delivery_model->insert_deliver_items($result,$delivery_items);


        }else{

          $new_item = array(
            'description' => $items['item'][$i],
            'size' => $items['size'][$i],
            'quantity' => $items['quantity'][$i],
            'unit' => $items['unit'][$i],
            'limit_quantity' => $items['limit_quantity'][$i]
          );

          if(empty($items['category_id'][$i])){
            $new_item['category_id'] = null; 
          }

          $new_item_id = $this->item_model->insert_new_item($new_item);

          $item = array(
            'delivery_no' => $result,
            'item_no' => $new_item_id,
            'quantity' => $items['quantity'][$i]
          );

          $new_item = $this->delivery_model->insert_new_deliver_items($item);

        }

      }

      if($insert || $new_item){
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
            'description' => 'Create Delivery Item',
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
      redirect('delivery/new_delivery');  

  }

  
  public function view_delivery($id)
  {  
    $data['page_title'] = "Delivery Item"; 
    $data['delivery'] = $this->delivery_model->select_deliver($id); 
    $data['delivery_items'] = $this->delivery_model->view_delivery_item($id);  
    $this->load->view('view_delivery_item', $data, FALSE); 
  }
        
} 
        
                            