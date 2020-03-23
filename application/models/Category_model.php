<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Category_model extends CI_Model {          

  public function get_category(){
    return $this->db->get('category')->result_array();   
  }

  public function insert_category($data){
    
    $this->db->insert('category', $data);
    return $this->db->affected_rows();
    
  }

  public function select_cat($data){
    
    $this->db->where('category_id', $data);
    return $this->db->get('category')->result_array()[0];
     
  }

  public function edit_cat($data){
    
    $this->db->set('category', $data['category']);
    $this->db->where('category_id', $data['category_id']);
    return $this->db->update('category');
    
  }

  public function delete_cat($id){
    
    $this->db->where('category_id', $id);
    $this->db->delete('category');
    return $this->db->affected_rows();
    
  }

} 