<?php
class Firebase 
{
	function __construct()
	{
		$this->CI =& get_instance(); 
		$this->CI->load->model('Bookings_model', 'Bookings'); 
	}
     //=============================================================
    // Eamil Templates
    function send_notification($message, $id, $message_info='', $type ='') {

    $API_ACCESS_KEY = "YOUR_FCM_SERVER_KEY";

    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array (
            'registration_ids' => array (
                    $id
            ),
            'data' => array (
                    "message" => $message,
                    'message_info' => $message_info, 
            ),                
            'priority' => 'high',
            'notification' => array(
                        'title' => $message['title'],
                        'body' => $message['body'], 
                       'type' =>  $d_type,
                    'id' => $id, 
                    'icon' => "new",
                    'sound' => "default"
						
				
            ),
    );
    $fields = json_encode ( $fields );

    $headers = array (
            'Authorization: key=' . $API_ACCESS_KEY,
            'Content-Type: application/json'
    );
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
    $result = curl_exec($ch);
    if ($result === FALSE) {
       // die('FCM Send Error: ' . curl_error($ch));
		curl_close($ch); 
		return false;
    }else{ 
		
    curl_close($ch);
    //return $result;
	return true;	
	}
}
	
	
	
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