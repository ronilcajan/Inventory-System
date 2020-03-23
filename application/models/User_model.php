<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class User_model extends CI_Model {
                        
  public function login_submit($data){

    $userdata = array(
      'username' => $data['username'],
      'password' => md5($data['password'])
    );

    
    $this->db->where($userdata);

    return $this->db->get('user')->result_array()[0];
                                  
  } 

  public function get_users(){ 
    return $this->db->get('user')->result_array(); 
  }

  

  public function insert_user($data){ 
    $this->db->insert('user', $data);
    return $this->db->affected_rows(); 
  }

  
  
  public function select_user($data){  
    $this->db->from('user'); 
    $this->db->where('user_id', $data);
    return $this->db->get()->result_array()[0];
  }

  
  public function update_user($id,$data){
    
    $this->db->where('user_id', $id); 
    $this->db->set($data); 
    return $this->db->update('user'); 
    
  } 

  public function delete_user($id){
    
    $this->db->where('user_id', $id);
    $this->db->delete('user');
    return $this->db->affected_rows();
    
  }

  public function tot_user(){
     
    return $this->db->get('user')->num_rows(); 
    
  }

  public function insert_logs($data){
    
    $this->db->insert('logs', $data);
    return $this->db->affected_rows();
  }
                        
                            
                        
}
                        
/* End of file User.php */
    
                        