<?php
class Sms 
{
	function __construct()
	{
		$this->CI =& get_instance();
        $this->CI->load->helper('email');
        $this->CI->load->library('Textlocal');
		$this->CI->load->model('Bookings_model', 'Bookings'); 
	}
     //=============================================================
    // Eamil Templates
    function sms_template($to = '',$slug = '',$sms_data = '', $tmpl=NULL)
    {

        $template =  $this->CI->db->get_where('sms_templates',array('slug' => $slug))->row_array();
        
        // var_dump($template);exit();

        $body = $template['body'];

        $template_id = $template['id'];

        $data['head'] = $subject = $template['subject'];

        $data['content'] = $this->sms_template_variables($body,$slug,$sms_data);

        $data['title'] = $template['name'];
		
		$sender = $template['sender'];
		 
		$send_sms = $this->CI->textlocal->sendSms($to, $data['content'], $sender);
		 
        return true;
    }

    //=============================================================
    // GET Eamil Templates AND REPLACE VARIABLES
    function sms_template_variables($content,$slug,$data = '')
    {
        switch ($slug) {
            case 'email-verification':
                $content = str_replace('{FULLNAME}',$data['fullname'],$content);
                $content = str_replace('{VERIFICATION_LINK}',$data['verification_link'],$content);
                return $content;
            break;

            case 'forget-password':
                $content = str_replace('{FULLNAME}',$data['fullname'],$content);
                $content = str_replace('{RESET_LINK}',$data['reset_link'],$content);
                return $content;
            break;

            case 'general-notification':
                $content = str_replace('{CONTENT}',$data['content'],$content);
                return $content;
            break;
			
			case 'new-booking': 
				$content = str_replace('{SERVICE_CATEGORY}',$data['service_category'],$content);
				$content = str_replace('{TIME_SLOT}',$data['time_slot'],$content);
				$content = str_replace('{SERVICE_DATE}',$data['service_date'],$content);
                return $content; 
			break;
				
			case 'jobcard-edited': 
				$content = str_replace('{BOOKING_ID}',$data['booking_id'],$content);
				$content = str_replace('{BOOKING_ID_ENCODE}',$data['booking_id_encode'],$content);
				$content = str_replace('{BASE_URL}',$data['base_url'],$content); 
                return $content; 	
			break;
				
			case 'customer-approval': 
				$content = str_replace('{BOOKING_ID}',$data['booking_id'],$content);
				$content = str_replace('{BASE_URL}',$data['base_url'],$content); 
                return $content; 	
			break;
				
			case 'payment-done': 
				$content = str_replace('{BOOKING_ID}',$data['booking_id'],$content); 
				$content = str_replace('{TOTAL_AMOUNT}',$data['total_amount'],$content); 
				$content = str_replace('{PAYMENT_MODE}',$data['payment_mode'],$content);  
			return $content; 	
			break; 
				
			case 'booking-completed': 
				$content = str_replace('{BOOKING_ID}',$data['booking_id'],$content);
				$content = str_replace('{BASE_URL}',$data['base_url'],$content); 
				$content = str_replace('{TOTAL_AMOUNT}',$data['total_amount'],$content); 
				$content = str_replace('{PAYMENT_MODE}',$data['payment_mode'],$content);  	
					
                return $content; 	
			break;	
				
			case 'send-otp': 
				$content = str_replace('{OTP}',$data['otp'],$content); 
                return $content; 	
			break;	
			
			case 'trip-started': 
				$content = str_replace('{SERVICE_PROVIDER_NAME}',$data['service_provider_name'],$content); 
                return $content; 	
			break;
				
			case 'trip-ended': 
				$content = str_replace('{SERVICE_PROVIDER_NAME}',$data['service_provider_name'],$content); 
                return $content; 	
			break;
			
			case 'end-work': 
				$content = str_replace('{INVOICE_TOTAL}',$data['invoice_total'],$content); 
                return $content; 	
			break;
				
			case 'complaints-close': 
				$content = str_replace('{BASE_URL}',$data['base_url'],$content); 
				$content = str_replace('{CUSTOMER_NAME}',$data['customer_name'],$content);
				$content = str_replace('{COMPLAINTS_ID}',$data['complaints_id'],$content); 
                return $content; 	
			break;	
			
			case 'mechanic-assigned':
				$content = str_replace('{MECHANIC_NAME}',$data['mechanic_name'],$content);
				$content = str_replace('{SERVICE_CATEGORY}',$data['service_category'],$content);
				$content = str_replace('{TIME_SLOT}',$data['time_slot'],$content);
				$content = str_replace('{SERVICE_DATE}',$data['service_date'],$content);
				return $content;
			break;
				
            default:
                # code...
                break;
        }
    }

	 

}
?>