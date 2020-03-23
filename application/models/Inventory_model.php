<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Inventory_model extends CI_Model { 

  public function get_requests(){ 
    $this->db->where('status != "Released"');
    $this->db->from('request'); 
    return $this->db->get()->result_array();
                                  
  }
  
  public function insert_req($data){
    $this->db->insert('request', $data);
    return $this->db->insert_id(); 
  }

  
  public function select_request($data){   
    $this->db->where('request_id', $data);
    return $this->db->get('request')->result_array()[0];
  }

  public function insert_req_items($id, $data){
    for($i=0; $i<count($data['item']); $i++){
      $items = array(
        'requested_id' => $id,
        'item_no' => $data['item'][$i],
        'quantity' => $data['quantity'][$i]
      );

      $this->db->insert('requested_item', $items);
    }

    return $this->db->affected_rows();
    
  }

  public function update_request($id,$data)
  { 
    $this->db->where('request_id', $id);
    $this->db->set($data); 
    return $this->db->update('request'); 
  }

  public function update_request_item($id,$data){

    $this->db->where('requested_id', $id);
    $this->db->delete('requested_item');
    $result = $this->db->affected_rows();

      for($i=0; $i<count($data['item']); $i++){
        $items = array(
          'requested_id' => $id,
          'item_no' => $data['item'][$i],
          'quantity' => $data['quantity'][$i]
        );
        $this->db->insert('requested_item', $items);
      }

    return $this->db->affected_rows();
  }


  public function view_request_item($id)
  {
    $this->db->select('requested_item.requested_id, size, item.item_no, requested_item.quantity as r_quantity, item.description as "desc",
    item.quantity, item.unit, item.category_id ');  
    $this->db->from('requested_item, item'); 
    $this->db->where('requested_item.item_no = item.item_no');
    $this->db->where('requested_item.requested_id', $id);
    return $this->db->get()->result_array();
    
  }

  public function delete_request_item($id)
  { 
    $this->db->where('requested_id', $id); 
    $this->db->delete('requested_item');
    return $this->db->affected_rows();  
  }

  
  public function delete_request($id)
  { 
    $this->db->where('request_id` ', $id); 
    $this->db->delete('request');
    return $this->db->affected_rows();  
  }

  public function approved_req($data,$id){
    $this->db->set('status', 'Approved');
    $this->db->set('approved_date', date('Y-m-d H:i:s'));
    $this->db->where('request_id', $id);
    $this->db->update('request');
    return $this->db->affected_rows();
  }

  public function released_req($data,$id){
    
    $this->db->from('requested_item');
    $this->db->where('requested_id', $id);
    $query = $this->db->get()->result_array();
    
    $items = array();
    for($i=0; $i<count($query); $i++){

      $this->db->where('item_no', $query[$i]['item_no']);
      $result = $this->db->get('item')->result_array()[0];

      $qty = $result['quantity'] - $query[$i]['quantity'];

      $items[] = array(
                  'item_no' => $query[$i]['item_no'], 
                  'quantity' => $qty);
    }

    $sql = $this->db->update_batch('item', $items, 'item_no');
   
    if($sql){
      $this->db->set('status', 'Released');
      $this->db->set('approved_by', $data['approved_by']);
      $this->db->set('released_by', $data['released_by']);
      $this->db->set('received_by', $data['received_by']);
      $this->db->set('release_date', date('Y-m-d H:i:s'));
      $this->db->set('received_date', $data['date_recieved']);
      $this->db->where('request_id', $id);
      $this->db->update('request');
      return $this->db->affected_rows();
    } 
  }
 

  public function check_quantity()
  { 
    $this->db->where('quantity <= limit_quantity');
    return $this->db->get('item');
  }

  public function get_all_release()
  {
    
    $this->db->where('status','released');
    return $this->db->get('request')->result_array();
    
  }
  public function tot_release()
  { 
    $this->db->where('status','released');
    return $this->db->get('request')->num_rows(); 
  }
  public function tot_pending()
  { 
    $this->db->where('status','pending');
    return $this->db->get('request')->num_rows(); 
  } 
  public function tot_approved()
  { 
    $this->db->where('status','approved');
    return $this->db->get('request')->num_rows(); 
  }
                        
} 
    
                        