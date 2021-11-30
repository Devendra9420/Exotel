<?php
	class Functions 
	{
		function __construct()
		{
			$this->obj =& get_instance();  
			$this->obj->load->config('file_upload', TRUE);
			$this->obj->load->helper(array('form', 'url'));
		
		//Loading upload library without any configuration as we have to initialize $config according to type of upload 
			$this->obj->load->library('upload');
		}

		 
		//--------------------------------------------------------
		// Paginaiton function 
		public function pagination_config($url,$count,$perpage,$uri_segment=NULL) 
		{
			$config = array();
			$config["base_url"] = $url;
			$config["total_rows"] = $count;
			$config["per_page"] = $perpage;
			if($uri_segment)
			$config["uri_segment"] = $uri_segment;
			$choice=$config['total_rows']/$config['per_page'];
			$config['num_links'] = floor($choice);
			$config['full_tag_open'] = '<ul class="pagination pagination-split">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = '&lt;&lt;';
			$config['last_link'] = '&gt;&gt;';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&lt;';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&gt;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>'; 
			return $config;
		}


		// --------------------------------------------------------------
		/*
		* Function Name : File Upload
		* Param1 : Location
		* Param2 : HTML File ControlName
		* Param3 : Extension
		* Param4 : Size Limit
		* Return : FileName
		*/
	   
		function file_insert($location, $controlname, $type, $size)
		{
			$return = array();
			$type = strtolower($type);
			if(isset($_FILES[$controlname]) && $_FILES[$controlname]['name'] != NULL)
	        {
				$filename = $_FILES[$controlname]['name'];
				$file_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
				$filesize = $_FILES[$controlname]["size"];	
						
				if($type == 'image')
				{
					if($file_extension == 'jpg' || $file_extension == 'jpeg' || $file_extension == 'png' || $file_extension == 'gif')
					{
						if ($filesize <= $size) 
						{
							$return['msg'] = $this->file_upload($location, $controlname);
							$return['status'] = 1;
						}
						else
						{
							$size=$size/1024;
							$return['msg'] = 'File must be smaller then  '.$size.' KB';
							$return['status'] = 0;
						}
					}
					else
					{
						$return['msg'] = 'File Must Be In jpg,jpeg,png,gif Format';
						$return['status'] = 0;
						
					}
				}
				elseif($type == 'pdf')
				{
					if($file_extension == 'pdf')
					{
						if ($filesize <= $size) 
						{
							$return['msg'] = $this->file_upload($location, $controlname);
							$return['status'] = 1;
						}
						else
						{
							$size = $size/1024;
							$return['msg'] = 'File must be smaller then  '.$size.' KB';
							$return['status'] = 0;
						}
					}
					else
					{
						$return['msg'] = 'File Must Be In PDF Format';
						$return['status'] = 0;	
					}
				}
				elseif($type == 'excel')
				{
					if( $file_extension == 'xlsx' || $file_extension == 'xls')
					{
						if ($filesize <= $size) 
						{
							$return['msg'] = $this->file_upload($location, $controlname);
							$return['status'] = 1;
							
						}
						else
						{
							$size = $size/1024;
							$return['msg'] = 'File must be smaller then  '.$size.' KB';
							$return['status'] = 0;
						}
					}
					else
					{
						$return['msg'] = 'File Must Be In Excel Format Only allow .xlsx and .xls extension';
						$return['status'] = 0;
					}
				}
				elseif($type == 'doc')
				{
					if( $file_extension == 'doc' || $file_extension == 'docx' || $file_extension == 'txt' || $file_extension == 'rtf')
					{
						if ($filesize <= $size) 
						{
							$return['msg'] = $this->file_upload($location, $controlname);
							$return['status'] = 1;
						}
						else
						{
							$size=$size/1024;
							$return['msg'] = 'File must be smaller then  '.$size.' KB';
							$return['status'] = 0;
						}
					}
					else
					{
						$return['msg'] = 'File Must Be In doc,docx,txt,rtf Format'; 
						$return['status'] = 0;		
					}
				}
				else
				{
					$return['msg'] = 'Not Allow other than image,pdf,excel,doc file..';
					$return['status'] = 0;	
				}

			}
	        else
	        {
	            $return['msg'] = '';
				$return['status'] = 1;
	        }
			return $return;
		}


		/*
		* Function Name : File Delete
		* Param1 : Location
		* Param2 : OLD Image Name
		*/
		
		public function delete_file($oldfile)
	    {		
			if($oldfile)
			{
				if(file_exists(FCPATH.$oldfile)) 
				{
					unlink(FCPATH.$oldfile);		
				}
			}
	    }
	
			
		//--------------------------------------------------------
		/*
		* Function Name : File Upload
		* Param1 : Location
		* Param2 : HTML File ControlName
		* Return : FileName
		*/
		function file_upload($location, $controlname)
		{
			if ( ! file_exists(FCPATH.$location))
			{
				$create = mkdir(FCPATH.$location,0777,TRUE);
				if ( ! $create)
					return '';
			}
	        
			$new_filename= $this->rename_image($_FILES[$controlname]['name']);
			if(move_uploaded_file(realpath($_FILES[$controlname]['tmp_name']),$location.$new_filename))
			{
				return $new_filename;
			}
			else
			{
				return '';
			}     
		}

		/*
		* Function Name : Rename Image
		* Param1 : FileName
		* Return : FileName
		*/
		public function rename_image($img_name)
	    {
	        $randString = md5(time().$img_name);
	        $fileName =$img_name;
	        $splitName = explode(".", $fileName);
	        $fileExt = end($splitName);
	        return strtolower($randString.'.'.$fileExt);
	    }
		
		
		 function custom_file_upload($file, $location, $new_name){
					if(isset($_FILES[$file]["tmp_name"]) &&  $_FILES[$file]['name']!=""){   
		$uploaddir = $location; 
		$full_dirpath = base_url().$uploaddir;	
    	$allowed_types = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'mp3', 'mp4', 'wma', 'mid','midi','mpga','mp2','mp3','aif','aiff','aifc','ram','rm','rpm','ra','rv','wav');  
    	$maxsize = 6 * 1024 * 1024;  
		$uploaded_on = date('Y-m-d');
			if ($_FILES[$file]['name'] != '') { 
			$file_tmpname = $_FILES[$file]['tmp_name']; 
            $file_name = $_FILES[$file]['name']; 
            $file_size = $_FILES[$file]['size']; 
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);   
				$temp = explode(".", $file_name);
				$newfilename = $new_name . '.' . end($temp);
 			  	$data_upload = $uploaddir . basename($newfilename);
                $imageFileType = strtolower(pathinfo($data_upload,PATHINFO_EXTENSION));   
				
				//create dirctory if not exist
        if(!is_dir($uploaddir))
        {
        	 if(!mkdir($uploaddir,0777))
        	 	return $uploaddir;
        }
        
				
				
							if(!in_array(strtolower($file_ext), $allowed_types)) { 
								return 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';  
            				}
			  				if ($file_size > $maxsize){           
												 return 'Error: File size is larger than the allowed limit..';	    
						 	}
			if (move_uploaded_file($file_tmpname, $data_upload)) { 
                 
				$data_upload =	array('file_name'=>$newfilename, 'original_name'=>$_FILES[$file]['name'], 'file_ext'=>$file_ext, 'file_path'=>$full_dirpath.$newfilename);
				 return $data_upload;
            }  
			else {
							 return 'Error: in uploading file..';	   
            } 
		  }
		} 
			
		}
		
		
		
		 function custom_file_upload_mulitple($file, $location, $new_name){
			 
			 $response= [];
			 $filesCount = count($_FILES[$file]['name']); 
			 
			 
			 if(!empty(array_filter($_FILES[$file]['name']))) {  
        // Loop through each file in files[] array 
        foreach ($_FILES[$file]['tmp_name'] as $i => $value) {  
			
			 
		//for($i = 0; $i < $filesCount; $i++){    
							 
							if(!empty($_FILES[$file]['name'][$i])){    
								
								
					if(isset($_FILES[$file]["tmp_name"][$i]) &&  $_FILES[$file]['name'][$i]!=""){   
		$uploaddir = $location; 
		$full_dirpath = base_url().$uploaddir;	
    	$allowed_types = array('jpg', 'png', 'jpeg', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'mp3', 'mp4', 'wma', 'mid','midi','mpga','mp2','mp3','aif','aiff','aifc','ram','rm','rpm','ra','rv','wav');  
    	$maxsize = 6 * 1024 * 1024;  
		$uploaded_on = date('Y-m-d');
			if ($_FILES[$file]['name'][$i] != '') { 
			$file_tmpname = $_FILES[$file]['tmp_name'][$i]; 
            $file_name = $_FILES[$file]['name'][$i]; 
            $file_size = $_FILES[$file]['size'][$i]; 
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);   
				$temp = explode(".", $file_name);
				$newfilename = $new_name . $i .'.' . end($temp);
 			  	$data_upload = $uploaddir . basename($newfilename);
                $imageFileType = strtolower(pathinfo($data_upload,PATHINFO_EXTENSION));   
				
				//create dirctory if not exist
        if(!is_dir($uploaddir))
        {
        	 if(!mkdir($uploaddir,0777))
        	 	return $uploaddir;
        } 
				
							if(!in_array(strtolower($file_ext), $allowed_types)) { 
								return 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';  
            				}
			  				if ($file_size > $maxsize){           
												 return 'Error: File size is larger than the allowed limit..';	    
						 	}
				
				
							 
			if (move_uploaded_file($file_tmpname, $data_upload)) { 
                 
				$response[$i] =	array('file_name'=>$newfilename, 'original_name'=>$_FILES[$file]['name'][$i], 'file_ext'=>$file_ext, 'file_path'=>$full_dirpath.$newfilename);
				 
            }  
			else {
							 return false;	   
            } 
		  }
		}
								
							}
							
						}
				 
			 }
			 
			 return $response;
			 
			
		}
		
   
	}


?>