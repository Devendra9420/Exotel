<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
    
    // -----------------------------------------------------------------------------
    //check auth
    if (!function_exists('auth_check')) {
        function auth_check()
        {
            // Get a reference to the controller object
            $ci =& get_instance();
            if(!$ci->session->has_userdata('is_admin'))
            {
                redirect('auth/login', 'refresh');
            }elseif(!$ci->session->has_userdata('user_id'))
            {
                redirect('auth/login', 'refresh');
            }
        }
    }


    // -----------------------------------------------------------------------------
    // Get General Setting
    if (!function_exists('get_general_settings')) {
        function get_general_settings($key=NULL)
        {
            $ci =& get_instance();
            $ci->load->model('setting_model');
            $result =  $ci->setting_model->get_general_settings();
			if($key)
			return $result[$key];	
			else
			return $result;	
        }
    }

     // -----------------------------------------------------------------------------
    // Generate Admin Sidebar Sub Menu
    if (!function_exists('get_sidebar_sub_menu')) {
        function get_sidebar_sub_menu($parent_id)
        {
            $ci =& get_instance();
            $ci->db->select('*');
            $ci->db->where('parent',$parent_id);
            $ci->db->where('menu_show',1);
            $ci->db->order_by('sort_order','asc');
            return $ci->db->get('menu')->result();
        }
    }


    // -----------------------------------------------------------------------------
    // Generate Admin Sidebar Menu
    if (!function_exists('get_sidebar_menu')) {
        function get_sidebar_menu()
        {
            $ci =& get_instance();
            $ci->db->select('*');
            $ci->db->where('parent',0);
            $ci->db->where('menu_show',1);
            $ci->db->order_by('sort_order','asc');
            return $ci->db->get('menu')->result();
        }
    }

     // -----------------------------------------------------------------------------
     
    if (!function_exists('make_slug'))
    {
        function make_slug($string)
        {
            $lower_case_string = strtolower($string);
            $string1 = preg_replace('/[^a-zA-Z0-9 ]/s', '', $lower_case_string);
            return strtolower(preg_replace('/\s+/', '-', $string1));        
        }
    }

	// -----------------------------------------------------------------------------
     
    if (!function_exists('make_capital'))
    {
        function make_capital($string)
        {
           return $upper_case_string = strtoupper($string); 
        }
    }

	// -----------------------------------------------------------------------------
     
    if (!function_exists('make_first_small'))
    {
        function make_first_small($string)
        {
          return  $small_first_case_string = lcfirst($string); 
        }
    }
	
	// -----------------------------------------------------------------------------
     
    if (!function_exists('make_first_capital'))
    {
        function make_first_capital($string)
        {
           return $capital_first_case_string = ucfirst($string); 
        }
    }


	// -----------------------------------------------------------------------------
    
    if (!function_exists('make_all_first_capital'))
    {
        function make_all_first_capital($string)
        {
           return $capital_first_case_string = ucwords($string);      
        }
    }
	
	// -----------------------------------------------------------------------------
     
    if (!function_exists('remove_char'))
    {
        function remove_char($char, $str)
        {
           return str_replace($char,"",$str); 
             
        }
    }
	
	// -----------------------------------------------------------------------------
    // Encode Function    
    if (!function_exists('encode'))
    {
		function encode($input) 
		{
			return urlencode(base64_encode($input));
		}
	}
		// -----------------------------------------------------------------------------
    // Decode Function    
    if (!function_exists('decode'))
    {
		function decode($input) 
		{
			return base64_decode(urldecode($input) );
		}
	}
	
	 // ----------------------------------------------------------------------------
    //print old form data
    if (!function_exists('old')) {
        function old($field)
        {
            $ci =& get_instance();
            return html_escape($ci->session->flashdata('form_data')[$field]);
        }
    }

    // --------------------------------------------------------------------------------
    if (!function_exists('date_time')) {
        function date_time($datetime) 
        {
           return date('F j, Y',strtotime($datetime));
        }
    }

	// --------------------------------------------------------------------------------
    if (!function_exists('convert_date')) {
        function convert_date($datetime) 
        {
           return date('d-m-Y',strtotime($datetime));
        }
    }

	// --------------------------------------------------------------------------------
    if (!function_exists('convert_datetime')) {
        function convert_datetime($datetime) 
        {
           return date('d-m-Y H:i:s',strtotime($datetime));
        }
    }
	
	// --------------------------------------------------------------------------------
    if (!function_exists('checkNull')) {
        function checkNull($value) 
        {
			if(!empty($value)){ 
            return $value;
			}else{
			$value = '';
			return $value;	
			}
        }
    }

	// --------------------------------------------------------------------------------
    if (!function_exists('whitespace')) {
        function whitespace() 
        { 
			$emptyspace = '&nbsp;';
			return $emptyspace;	
		 }
    }

    // --------------------------------------------------------------------------------
    // limit the no of characters
    if (!function_exists('text_limit')) {
        function text_limit($x, $length)
        {
          if(strlen($x)<=$length)
          {
            echo $x;
          }
          else
          {
            $y=substr($x,0,$length) . '...';
            echo $y;
          }
        }
    }

    // -----------------------------------------------------------------------------
    //get recaptcha
    if (!function_exists('generate_recaptcha')) {
        function generate_recaptcha()
        {
            $ci =& get_instance();
            if ($ci->recaptcha_status) {
                $ci->load->library('recaptcha');
                echo '<div class="form-group mt-2">';
                echo $ci->recaptcha->getWidget();
                echo $ci->recaptcha->getScriptTag();
                echo ' </div>';
            }
        }
    }

   if(!function_exists('delete_all_uploads')){
	   function delete_all_uploads($folder_name=NULL)
	   {
		   if($folder_name){ 
		   	$path = '/var/www/html/flywheel_v3/uploads/'.$folder_name.'/'; 
 			}else{
			$path = '/var/www/html/flywheel_v3/uploads/raw/'; 
 			}
		    
 			$files = glob($path.'*'); // get all file names
    		foreach($files as $file){ // iterate files
      		if(is_file($file))
			//$deleted_file[] = $file;	
        	unlink($file); // delete file
        	//echo $file.'file deleted';
			//return $deleted_file;	
    }   
	   }
   }


   if(!function_exists('delete_single_uploads')){
	   function delete_single_uploads($file)
	   {   
		   if(file_exists($file)){   
			   if(unlink($file)){ 
			   return true;
			   }else{
				return false;   
			   } 
		   }else{
			return false;   
		   } 
	   }
   }



?>