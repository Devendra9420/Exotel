<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('insert')) 
{
    function insert($table_name, $insert_data)
    {
        $CI =& get_instance();
        return $CI->db->insert($table_name, $insert_data);
    }
}

if(!function_exists('api_key')){ 
		
		function api_key($length = 25) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
	
	
}