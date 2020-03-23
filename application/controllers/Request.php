<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class Request extends CI_Controller {

  public function __construct()
  { 
      parent::__construct();
      if(!$this->session->userdata('user_id')){ 
          redirect('login'); 
      }  
  }
      
  public function index()
  { 
      $data['page_title'] = "Request"; 
      $data['requests'] = $this->inventory_model->get_requests(); 
      $this->load->view('request', $data, FALSE); 
  } 
 
  public function request_item()
  {
    $data['page_title'] = "Request Item"; 
    $data['requests'] = $this->inventory_model->get_requests();
    $data['category'] = $this->category_model->get_category();
    $data['items'] = $this->item_model->get_items();

    $this->load->view('request_item', $data, FALSE); 

  }

  public function submit_item_request()
  {
    $data = array(
      'requesting_office' => $this->input->post('req_office'),
      'request_date' => date('Y-m-d H:i:s')
    );

    $result = $this->inventory_model->insert_req($data);

    if($result){
      $items = $this->input->post();
      $insert = $this->inventory_model->insert_req_items($result,$items);

      if($insert){
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
            'description' => 'Create request',
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

      
      redirect('request/request_item');
      
  }
  
  
  public function edit_request_item($id)
  {   
    $data['page_title'] = "Edit Request"; 
    $data['request'] = $this->inventory_model->select_request($id);
    $data['request_items'] = $this->inventory_model->view_request_item($id); 
    $data['category'] = $this->category_model->get_category();
    $data['items'] = $this->item_model->get_items();
    // print_r($data);
    $this->load->view('edit_request_item', $data); 
  }
     

  public function view_item($id)
  {  
    $data['page_title'] = "Request Item"; 
    $data['request'] = $this->inventory_model->select_request($id); 
    $data['request_items'] = $this->inventory_model->view_request_item($id);  
    $this->load->view('view_request_item', $data, FALSE); 
  }

  public function update_request_item($id)
  {
        $arr = array(
            'requesting_office' => $this->input->post('req_office')
        );
        // Update request
        $this->inventory_model->update_request($id,$arr);

        $data = $this->input->post();
        $result = $this->inventory_model->update_request_item($id,$data);

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
                'description' => 'Update request',
                'date' => date('Y-m-d H:i:s')
              );
          
              $this->user_model->insert_logs($logs);
        }else{
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span><i class="fas fa-exclamation"></i>Update unsuccessfull.Please contact developer.</span>
                </div>
            '); 
        }
        redirect('request/edit_request_item/'. $id);

  }

  public function released_info($id){
    $data['page_title'] = "Release Items"; 
    $data['request'] = $this->inventory_model->select_request($id); 
    $data['request_items'] = $this->inventory_model->view_request_item($id);  
    $this->load->view('view_release_item', $data, FALSE); 
  }
        

  public function delete_request($id)
  {
    $this->inventory_model->delete_request_item($id); 
    $result = $this->inventory_model->delete_request($id);  
    echo $result;
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
            'description' => 'Delete request',
            'date' => date('Y-m-d H:i:s')
          );
      
          $this->user_model->insert_logs($logs);
    }else{
        $this->session->set_flashdata('message', '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span><i class="fas fa-exclamation"></i>  '.$this->db->error()['message'].'.</span>
            </div>
        ');
    }
    redirect('request');
  }

  public function approved_request($id)
  {
    $result = $this->inventory_model->approved_req($id);
    if($result>0){ 
        $this->session->set_flashdata('message', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span><i class="fas fa-check"></i> Request has been approved.</span>
            </div>
        ');

        $logs = array(
            'user_id' => $this->session->userdata('user_id'),
            'description' => 'Approved request',
            'date' => date('Y-m-d H:i:s')
          );
      
          $this->user_model->insert_logs($logs);
    }else{
        $this->session->set_flashdata('message', '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span><i class="fas fa-exclamation"></i>  '.$this->db->error()['message'].'.</span>
            </div>
        ');
    }
    redirect('request', 'refresh');
  }

  public function released_request($id)
  {
    $data = $this->input->post();
    $result = $this->inventory_model->released_req($data,$id);
    
    if($result>0){ 
        $this->session->set_flashdata('message', '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span><i class="fas fa-check"></i> Request has been released successfully.</span>
            </div>
        ');

        $logs = array(
            'user_id' => $this->session->userdata('user_id'),
            'description' => 'Released request',
            'date' => date('Y-m-d H:i:s')
          );
      
          $this->user_model->insert_logs($logs);
    }else{
        $this->session->set_flashdata('message', '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span><i class="fas fa-exclamation"></i>  '.$this->db->error()['message'].'.</span>
            </div>
        ');
    }
    redirect('request/released_info/' . $id, 'refresh');
  }

  
	public function get_notification()
	{ 

		if($_GET['unseen_notif'] == 'check_quantity'):  
			$count = $this->inventory_model->check_quantity()->num_rows();  
			$query = $this->inventory_model->check_quantity()->result_array(); 
            
            $output = '<p class="red">You have '.$count.' Notification</p> ';
            foreach($query as $row){
                $output .= '
                    <a class="dropdown-item media" href="'.base_url().'item/edit_item/'.$row['item_no'].'">
                        <i class="fas fa-box"></i>
                        <p><span class=" text-capitalize font-weight-bold"><u>'.$row["description"].'</u></span> is below on stock.</p>
                    </a> 
                ';

            }    
		endif;  
			
		$data = array(
				'notification' => $output,
				'unseen_notification'  => $count,
		);
		
		echo json_encode($data); 
	}
  
}
         
                            