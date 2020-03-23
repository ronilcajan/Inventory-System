<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Log_model extends CI_Model {
                    
  public function get_logs()
  {        
    $this->db->from('logs, user');
    $this->db->where('logs.user_id = user.user_id');
    return $this->db->get()->result_array(); 
  }                 
                        
}
         
    
                        