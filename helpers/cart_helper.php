<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('add_trans')) {
	function add_trans($data=FALSE)
        { 
  
		}
}

         

 if (!function_exists('get_trans')) {
        function get_trans($where)
        { 
            $ci =& get_instance();
            $ci->db->select();
        	$ci->db->from('mechanic_log'); 
			if($where)
        	$ci->db->where($where);  
		    $query = $ci->db->get(); 
			if($query->num_rows() > 0) {  
				$result =  $query->result(); 
			}else{
				return false;  
			}
        }
    }

 

?> 