<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Item_model extends CI_Model {
                        
  public function get_items(){
                          
    $this->db->from('item');
    $this->db->join('category', 'category.category_id = item.category_id', 'left');
    return $this->db->get()->result_array();
                                  
  }

  public function insert_item($data){ 
    $this->db->insert('item', $data);
    return $this->db->affected_rows();
                                  
  }

  public function insert_new_item($data){ 
    $this->db->insert('item', $data);
    return $this->db->insert_id();
                                  
  }
  
  public function select_item($data){  
    $this->db->from('item');
    $this->db->join('category', 'category.category_id = item.category_id', 'left');
    $this->db->where('item_no', $data);
    return $this->db->get()->result_array()[0];
  }
  
  public function update_item($id,$data){
    
    $this->db->where('item_no', $id); 
    $this->db->set($data); 
    return $this->db->update('item'); 
    
  }
     
  

  public function delete_item($id){
    
    $this->db->where('item_no', $id);
    $this->db->delete('item');
    return $this->db->affected_rows();
    
  }

  public function get_item_by_category($id)
  {
    if($id == 'null')
    {
      $id = NULL;
    }
    $this->db->where('category_id', $id);
    return $this->db->get('item')->result_array();
    
  }
  
  public function count_user()
  {
    $query = $this->db->query("SELECT * FROM users");
    echo $query->num_rows();
        
  }

  public function tot_supply()
  {
    
    $this->db->from('item');
    $this->db->join('category', 'category.category_id = item.category_id', 'left');
    return $this->db->get()->num_rows();
  }
}
                        