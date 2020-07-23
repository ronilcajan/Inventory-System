<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Delivery_model extends CI_Model {
                        
  public function get_delivery(){

    $this->db->from('delivery,user'); 
    $this->db->where('delivery.user_id=user.user_id');
    return $this->db->get()->result_array();     
                                  
  }
              
  public function insert_deliver($data)
  { 
    $this->db->insert('delivery', $data);
    return $this->db->insert_id(); 
  } 

  public function insert_deliver_items($id, $data){ 

    // for($i=0; $i<count($data['item']); $i++){ 

        $prev_quantity =  $this->get_quantity($data['item']);
        $new_quantity =  $prev_quantity + $data['quantity'];
        $this->update_quantity($data['item'], $new_quantity);
        $items = array(
          'delivery_no' => $id,
          'item_no' => $data['item'],
          'quantity' => $data['quantity']
        );  
  
        $this->db->insert('delivery_item', $items);
      // }
     

    return $this->db->affected_rows(); 
  }

  public function insert_new_deliver_items($data)
  {
    $this->db->insert('delivery_item', $data);
    return $this->db->affected_rows(); 
  }

  private function get_quantity($item_no)
  { 
    $this->db->select('quantity');
    $this->db->where('item_no', $item_no); 
    return $this->db->get('item')->result_array()[0]['quantity'];  
  }  

  private function update_quantity($item_no, $new_quantity)
  {
    $data = array(
      'quantity' => $new_quantity,
    );
    $this->db->where('item_no', $item_no);
    return $this->db->update('item', $data); 
  }


  public function get_delivery_item($id)
  {
    $this->db->select('*, delivery_item.quantity as qty');  
    $this->db->from('delivery_item, item'); 
    $this->db->where('delivery_item.item_no = item.item_no');
    $this->db->where('delivery_item.delivery_no', $id);
    return $this->db->get()->result_array();
  }

  public function select_delivery($id){
    $this->db->where('delivery_no', $id);
    return $this->db->get('delivery')->result_array()[0];
  }

  public function select_deliver($data){   
    $this->db->where('delivery_no', $data);
    return $this->db->get('delivery')->result_array()[0];
  }

  public function view_delivery_item($data)
  {  
    $this->db->from('delivery_item, item');
    $this->db->select('item.description, item.size, item.unit, delivery_item.quantity as qty');  
    $this->db->where('delivery_item.item_no = item.item_no'); 
    $this->db->where('delivery_no', $data); 
    return $this->db->get()->result_array();
  }

  public function delete_delivery($id){
    $this->db->where('delivery_no', $id);
    $this->db->delete('delivery_item');
    return $this->db->affected_rows();
  }

  public function update_items($id,$item){
    $this->db->where('item_no', $id);
    $this->db->update('item', $item);
    return $this->db->affected_rows();
  }
                        
} 
    
                        