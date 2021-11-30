<?php
class Mailer 
{
	function __construct()
	{
		$this->CI =& get_instance();
        $this->CI->load->helper('email');
		$this->CI->load->model('Bookings_model', 'Bookings');  
	}
     //=============================================================
    // Eamil Templates
    function mail_template($to = '',$slug = '',$mail_data = '', $tmpl=NULL)
    {
		if(!empty($to)){ 

        $template =  $this->CI->db->get_where('email_templates',array('slug' => $slug))->row_array();
        
        // var_dump($template);exit();

        $body = $template['body'];

        $template_id = $template['id'];

        $data['head'] =  $subject = $template['subject'];

        $bodydata  = $this->mail_template_variables($body,$slug,$mail_data);

        //$data['title'] = $template['name'];
		 $data['content'] = $this->mail_template_variables($body,$slug,$mail_data);

        $data['title'] = $template['name']; 
		
		if($tmpl && $tmpl!='custom'){ 	
		$template = $this->CI->load->view($tmpl,$bodydata,TRUE);
		}elseif($tmpl=='custom'){ 	
		$template =  $data['content'];
		}else{ 
		$template =  $this->CI->load->view('admin/general_settings/email_templates/email_preview', $data,true);
		}
        send_email($to,$subject,$template);
		}
        return true;
    }

    //=============================================================
    // GET Eamil Templates AND REPLACE VARIABLES
    function mail_template_variables($content,$slug,$data = '')
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
				$content = $this->new_booking_created($data['booking_id'], $data['Spares_List'], $data['Labour_List']);
				return $content; 
			 break;
			
			case 'customer-approval':
				$content = $this->customer_approval($data['booking_id']);
				return $content; 
			 break;
				
				case 'mechanic-assigned':
				$content = $this->mechanic_assigned($data['booking_id'], $data['mechanic_name']);
				return $content; 
			 break;
				 
				case 'customer-otp':
				$content = $this->customer_otp($data['otp'],$data['customer_name'],$data['customer_email']);
				return $content; 
			 break;
				 
				case 'website-inquiry':
				$content = $this->website_inquiry($data['name'],$data['email'],$data['mobile'],$data['purpose'],$data['message']);
				return $content; 
			 break;
				
				case 'new-lead':
				$content = $this->new_lead($data['name'],$data['mobile'],$data['city']);
				return $content; 
			 break;
				
			case 'booking_from_website':
				$content = $this->booking_from_website($data);
				return $content;
				
				case 'cancel-booking-notify-gw':
				$content = $this->cancel_booking_notify_gw($data['booking_id'],$data['name'],$data['email'],$data['mobile'],$data['cancel_reason'],$data['serviceDateTime'],$data['cancelled_by'],$data['mechanic_name']);
				return $content; 
			 break;
				
				case 'booking-completed':
				$content = $this->booking_completed($data['booking_id'], $data['total_amount'], $data['payment_mode']);
				return $content; 
			 break;
				
            default:
                # code...
                break;
        }
    }

	//=============================================================
	function registration_email($username, $email_verification_link)
	{
    $login_link = base_url('auth/login');  

		$tpl = '<h3>Hi ' .strtoupper($username).'</h3>
            <p>Welcome to LightAdmin!</p>
            <p>Active your account with the link above and start your Career :</p>  
            <p>'.$email_verification_link.'</p>

            <br>
            <br>

            <p>Regards, <br> 
               CodeGlamoour Team <br> 
            </p>
    ';
		return $tpl;		
	}

	//=============================================================
	function pwd_reset_email($username, $reset_link)
	{
		$tpl = '<h3>Hi ' .strtoupper($username).'</h3>
            <p>Welcome to LightAdmin!</p>
            <p>We have received a request to reset your password. If you did not initiate this request, you can simply ignore this message and no action will be taken.</p> 
            <p>To reset your password, please click the link below:</p> 
            <p>'.$reset_link.'</p>

            <br>
            <br>

            <p>© 2018 CodeGlamoour - All rights reserved</p>
    ';
		return $tpl;		
	}
	
	
	function new_booking_created($booking_id, $Spares_List,  $Labour_List)
	{
		$get_booking  = $this->CI->Bookings->getbooking($booking_id);
		
		$emailbooking = $get_booking['booking'];
		 
		$make   = $this->CI->Common->single_row('vehicle_make', array('make_id'=>$emailbooking->vehicle_make));
		$make_name  = $make->make_name;
		 
		$model   = $this->CI->Common->single_row('vehicle_model', array('model_id'=>$emailbooking->vehicle_model));
		$model_name  = $model->model_name;
		 
		$service_category   = $this->CI->Common->single_row('service_category', array('id'=>$emailbooking->service_category_id));  
		 
				  
				$emaildata['customer_name'] = $emailbooking->customer_name;
				$emaildata['customer_phone'] = $emailbooking->customer_mobile;
				$emaildata['customer_alternate_no'] = $emailbooking->customer_alternate_no;
				$emaildata['customer_address'] = $emailbooking->customer_address.',<br>'.$emailbooking->customer_area.',<br>'.$emailbooking->customer_city.$emailbooking->customer_pincode;
				$emaildata['customer_email'] = $emailbooking->customer_email;
				$emaildata['booking_id'] = $emailbooking->booking_id;
				$emaildata['make'] = $make_name;
				$emaildata['model'] = $model_name;
				$emaildata['service_category'] = $service_category->service_name;
				$emaildata['created_date'] = date('d-m-Y', strtotime($emailbooking->created_on));
				$emaildata['service_date'] = date('d-m-Y', strtotime($emailbooking->service_date));
				$emaildata['service_time'] = date('H:i a', strtotime($emailbooking->time_slot));
				$emaildata['comments'] = $emailbooking->comments; 
				$emaildata['estimate_amount'] = '';
				
				$emaildata['complaints'] = '';
				$splitcomplaints = explode('+',$emailbooking->complaints);
				foreach($splitcomplaints as $singlecomplains){  
				$emaildata['complaints'] .= $singlecomplains.'<br>'; 
				}  
				$emaildata['specific_spares'] = $Spares_List; 
				$emaildata['specific_repairs'] = $Labour_List; 
		
				if(!empty($emaildata['customer_email'])){ 
				//$message = $this->CI->load->view('emailer/new_bookings.php',$emaildata); 
				$message = $emaildata; 	
				}
		
			return $message;
	}
	
	
	function customer_approval($booking_id)
	{
		$get_booking  = $this->CI->Bookings->getbooking($booking_id);
		
		$emailbooking = $get_booking['booking'];
		 
		$make   = $this->CI->Common->single_row('vehicle_make', array('make_id'=>$emailbooking->vehicle_make));
		$make_name  = $make->make_name;
		 
		$model   = $this->CI->Common->single_row('vehicle_model', array('model_id'=>$emailbooking->vehicle_model));
		$model_name  = $model->model_name;
		 
		$service_category   = $this->CI->Common->single_row('service_category', array('id'=>$emailbooking->service_category_id));  
		 
		$mechanic_name = $this->CI->Common->single_row('service_providers', array('id'=>$emailbooking->assigned_mechanic), 'name');    
		
				$emaildata['customer_name'] = $emailbooking->customer_name;
				$emaildata['customer_email'] = $emailbooking->customer_email;
				$emaildata['booking_id'] = base64_encode($emailbooking->booking_id);
				$emaildata['make'] = $make_name;
				$emaildata['model'] = $model_name;
				$emaildata['service_category'] = $service_category;
				$emaildata['mechanic_name'] = $mechanic_name; 
				$emaildata['created_date'] = date('d-m-Y', strtotime($emailbooking->created_on));
				$emaildata['service_date'] = date('d-m-Y', strtotime($emailbooking->service_date));
				$emaildata['service_time'] = date('H:i a', strtotime($emailbooking->time_slot));;
				$emaildata['comments'] = $emailbooking->comments;
				$emaildata['estimate_amount'] = '';
				if(!empty($emaildata['customer_email'])){ 
				$message = $this->CI->load->view('emailer/jobcard_approve.php',$emaildata,TRUE);   
				}	   
		
			return $message;
	}
	
	function mechanic_assigned($booking_id, $Mechanic_Q)
	{
		$get_booking  = $this->CI->Bookings->getbooking($booking_id);
		
		$emailbooking = $get_booking['booking'];
		 
		$make   = $this->CI->Common->single_row('vehicle_make', array('make_id'=>$emailbooking->vehicle_make));
		$make_name  = $make->make_name;
		 
		$model   = $this->CI->Common->single_row('vehicle_model', array('model_id'=>$emailbooking->vehicle_model));
		$model_name  = $model->model_name;
		 
		$mechanic_name = $this->CI->Common->single_row('service_providers', array('id'=>$emailbooking->assigned_mechanic), 'name');         
		
	 
		$service_category   = $this->CI->Common->single_row('service_category', array('id'=>$emailbooking->service_category_id), 'service_name');  
		 
				$emaildata['customer_name'] = $emailbooking->customer_name;
				$emaildata['customer_email'] = $emailbooking->customer_email;
				$emaildata['booking_id'] = $emailbooking->booking_id;
				$emaildata['make'] = $make_name;
				$emaildata['model'] = $model_name;
				$emaildata['service_category'] = $service_category;
				$emaildata['mechanic_name'] = $mechanic_name; 
				$emaildata['created_date'] = date('d-m-Y', strtotime($emailbooking->created_on));
				$emaildata['service_date'] = date('d-m-Y', strtotime($emailbooking->service_date));
				$emaildata['service_time'] = date('H:i a', strtotime($emailbooking->time_slot)); 
				$emaildata['comments'] = '';
				$emaildata['estimate_amount'] = '';
		
		  
				if(!empty($emaildata['customer_email'])){ 
				$message = $this->CI->load->view('emailer/mechanic_assigned.php',$emaildata,TRUE); 
				}
		
			return $message;
	}
	
	function customer_otp($otp, $customer_name, $customer_email)
	{
	  
				$emaildata['customer_name'] = $customer_name;
				$emaildata['customer_email'] = $customer_email;
				$emaildata['otp'] = $otp; 
		
		  
				if(!empty($emaildata['customer_email'])){ 
				$message = $this->CI->load->view('emailer/customer_otp.php',$emaildata,TRUE); 
				}
		
			return $message;
	}
	
	function website_inquiry($name,$email,$mobile,$purpose,$message)
	{ 
				$emailmessage = '<table width="60%" cellpadding="0" border="0" style="background-color:#f7f7f9"><tbody><tr><td><table cellspacing="0 cellpadding=0 border=0 bgcolor=#68c1ec align=center style=background: #68c1ec"><tbody> <tr><td valign="top"><a href="https://www.garageworks.in/" rel="noreferrer" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://www.garageworks.in/&amp;source=gmail&amp;ust=1605211978898000&amp;usg=AFQjCNGuJZTCPWSweoCvXbwuh_7SBauGVQ"><img src="https://ci4.googleusercontent.com/proxy/k-frTltuDnkH-OmG4QaB-7XcQSH6C-J48EtIk1ndSN3tm0hFnf1Xiyer4Ft5BR6B6jJhDncz95Sl4-NRR1uWg32TEfc0ur0Srw=s0-d-e1-ft#https://www.garageworks.in/assets/images/logo_icon.png" height="85px" width="152px" style="margin-left:485px;margin-top:18px" class="CToWUd"></a><br> </td> </tr></tbody></table><table width="581 cellspacing=0 cellpadding=0 border=0 align=center style=border-bottom: 1px solid #e1e1e1;margin-bottom:30px;"><tbody> <tr> <td valign="top style=padding: 0px 13px 10px 14px;font-family:Arial"><table width="100% cellspacing=0 cellpadding=0"><tbody><tr> <td style="color:#000;padding-bottom:14px;font-size:16px;font-family:Arial">Hi Team !</td></tr><tr><td style="color:#000;padding-bottom:14px;font-size:16px;font-family:Arial">Contact Inquiry from Website<br><b> Name : '.$name.' <br>Email : <a href="mailto:'.$email.'" rel="noreferrer" target="_blank">'.$email.'</a> <br>Mobile : '.$mobile.' <br>  Purpose : '.$purpose.' <br>Message : '.$message.' <br>Inquiry Date : '.date('d-m-Y H:i').' <br><br></b></td></tr><tr><td style="color:#000;padding-bottom:14px;font-size:16px;font-family:Arial">Thanks! <br>Garageworks Team.</td></tr></tbody></table> </td> </tr></tbody> </table> </td></tr> </tbody> </table>';
				 
		
			return $emailmessage;
	}
	
	function new_lead($name,$mobile,$city)
	{ 
				$emailmessage = '<table width="60%" cellpadding="0" border="0" style="background-color:#f7f7f9"><tbody><tr><td><table cellspacing="0 cellpadding=0 border=0 bgcolor=#68c1ec align=center style=background: #68c1ec"><tbody> <tr><td valign="top"><a href="https://www.garageworks.in/" rel="noreferrer" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://www.garageworks.in/&amp;source=gmail&amp;ust=1605211978898000&amp;usg=AFQjCNGuJZTCPWSweoCvXbwuh_7SBauGVQ"><img src="https://ci4.googleusercontent.com/proxy/k-frTltuDnkH-OmG4QaB-7XcQSH6C-J48EtIk1ndSN3tm0hFnf1Xiyer4Ft5BR6B6jJhDncz95Sl4-NRR1uWg32TEfc0ur0Srw=s0-d-e1-ft#https://www.garageworks.in/assets/images/logo_icon.png" height="85px" width="152px" style="margin-left:485px;margin-top:18px" class="CToWUd"></a><br> </td> </tr></tbody></table><table width="581 cellspacing=0 cellpadding=0 border=0 align=center style=border-bottom: 1px solid #e1e1e1;margin-bottom:30px;"><tbody> <tr> <td valign="top style=padding: 0px 13px 10px 14px;font-family:Arial"><table width="100% cellspacing=0 cellpadding=0"><tbody><tr> <td style="color:#000;padding-bottom:14px;font-size:16px;font-family:Arial">Hi Team !</td></tr><tr><td style="color:#000;padding-bottom:14px;font-size:16px;font-family:Arial">Lead from Future Group<br><b> Name : '.$name.' <br> <br>Mobile : '.$mobile.' <br>  City : '.$city.' <br>Inquiry Date : '.date('d-m-Y H:i').' <br><br></b></td></tr><tr><td style="color:#000;padding-bottom:14px;font-size:16px;font-family:Arial">Thanks! <br>Garageworks Team.</td></tr></tbody></table> </td> </tr></tbody> </table> </td></tr> </tbody> </table>';
				 
		
			return $emailmessage;
	}
	
	
	function booking_from_website($mailbodydata)
	{
			$emailmessage = '<table width="60%" cellpadding="0" border="0" style="background-color:#f7f7f9"><tbody><tr><td><table cellspacing="0 cellpadding=0 border=0 bgcolor=#68c1ec align=center style=background: #68c1ec"><tbody> <tr><td valign="top"><a href="https://www.garageworks.in/" rel="noreferrer" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://www.garageworks.in/&amp;source=gmail&amp;ust=1605211978898000&amp;usg=AFQjCNGuJZTCPWSweoCvXbwuh_7SBauGVQ"><img src="https://ci4.googleusercontent.com/proxy/k-frTltuDnkH-OmG4QaB-7XcQSH6C-J48EtIk1ndSN3tm0hFnf1Xiyer4Ft5BR6B6jJhDncz95Sl4-NRR1uWg32TEfc0ur0Srw=s0-d-e1-ft#https://www.garageworks.in/assets/images/logo_icon.png" height="85px" width="152px" style="margin-left:485px;margin-top:18px" class="CToWUd"></a><br> </td> </tr></tbody></table><table width="581 cellspacing=0 cellpadding=0 border=0 align=center style=border-bottom: 1px solid #e1e1e1;margin-bottom:30px;"><tbody> <tr> <td valign="top style=padding: 0px 13px 10px 14px;font-family:Arial"><table width="100% cellspacing=0 cellpadding=0"><tbody><tr> <td style="color:#000;padding-bottom:14px;font-size:16px;font-family:Arial">Hi Team !</td></tr><tr><td style="color:#000;padding-bottom:14px;font-size:16px;font-family:Arial">Booking Confirmed from Website<br><b> Name : '.$mailbodydata['name'].' '.$mailbodydata['existingcustmsg'].' <br>Email : <a href="mailto:'.$mailbodydata['email'].'" rel="noreferrer" target="_blank">'.$mailbodydata['email'].'</a> <br>Mobile : '.$mailbodydata['mobile'].' <br> Address : '.$mailbodydata['customer_address'].' <br> Google Map Location: '.$mailbodydata['customer_google_map'].' <br> Area : '.$mailbodydata['customer_area'].' <br>City : '.$mailbodydata['customer_city'].' <br>Service Date : '.date('d-m-Y', strtotime($mailbodydata['desired_service_date'])).'<br>Service Time : '. $mailbodydata['desired_time_slot'].' <br>Make : '.$mailbodydata['make_name'].' <br>Model : '.$mailbodydata['model_name'].' <br>Service Category : '.$mailbodydata['service_category'].' <br>Specific Spares : '.$mailbodydata['sparesLISTNAME'].' <br>Specific Repairs : '.$mailbodydata['labourLISTNAME'].' <br>Complaints : '.$mailbodydata['complaint_list'].' <br>Booking Requested Date : '.date('d-m-Y H:i').' <br><br>Comments: '.$mailbodydata['comments'].' <br><br>Generated Booking ID: '.$mailbodydata['booking_id'].' <br></b></td></tr><tr><td style="color:#000;padding-bottom:14px;font-size:16px;font-family:Arial">Thanks! <br>Garageworks Team.</td></tr></tbody></table> </td> </tr></tbody> </table> </td></tr> </tbody> </table>';	
		
			return $emailmessage;
		
	}
	
	function cancel_booking_notify_gw($booking_id,$name,$email,$mobile,$cancel_reason,$serviceDateTime,$cancelled_by,$mechanic_name)
	{
		$emailmessage = '<table width="60%" cellpadding="0" border="0" style="background-color:#f7f7f9"><tbody><tr><td><table cellspacing="0 cellpadding=0 border=0 bgcolor=#68c1ec align=center style=background: #68c1ec"><tbody> <tr><td valign="top"><a href="https://www.garageworks.in/" rel="noreferrer" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://www.garageworks.in/&amp;source=gmail&amp;ust=1605211978898000&amp;usg=AFQjCNGuJZTCPWSweoCvXbwuh_7SBauGVQ"><img src="https://ci4.googleusercontent.com/proxy/k-frTltuDnkH-OmG4QaB-7XcQSH6C-J48EtIk1ndSN3tm0hFnf1Xiyer4Ft5BR6B6jJhDncz95Sl4-NRR1uWg32TEfc0ur0Srw=s0-d-e1-ft#https://www.garageworks.in/assets/images/logo_icon.png" height="85px" width="152px" style="margin-left:485px;margin-top:18px" class="CToWUd"></a><br> </td> </tr></tbody></table><table width="581 cellspacing=0 cellpadding=0 border=0 align=center style=border-bottom: 1px solid #e1e1e1;margin-bottom:30px;"><tbody> <tr> <td valign="top style=padding: 0px 13px 10px 14px;font-family:Arial"><table width="100% cellspacing=0 cellpadding=0"><tbody><tr> <td style="color:#000;padding-bottom:14px;font-size:16px;font-family:Arial">Hi Team !</td></tr><tr><td style="color:#000;padding-bottom:14px;font-size:16px;font-family:Arial">Booking Cancel Request in Flywheel<br><b> Booking Id : '.$booking_id.' <br><b> Name : '.$name.' <br>Email : '.$email.'<br><b> Service Date Time : '.$serviceDateTime.'  <br>Mobile : '.$mobile.' <br><b> Mechanic Name : '.$mechanic_name.' <br>Reason for Cancellation : '.$cancel_reason.' <br>Cancelled Requested By : '.$cancelled_by.' <br>Request Date : '.date('d-m-Y H:i').' <br><br></b></td></tr><tr><td style="color:#000;padding-bottom:14px;font-size:16px;font-family:Arial">Thanks! <br>Garageworks Team.</td></tr></tbody></table> </td> </tr></tbody> </table> </td></tr> </tbody> </table>';
		
		return $emailmessage;
	}
	
	function booking_completed($booking_id, $total_amount, $payment_mode)
	{
		$get_booking  = $this->CI->Bookings->getbooking($booking_id);
		
		$emailbooking = $get_booking['booking'];
		 
		$make   = $this->CI->Common->single_row('vehicle_make', array('make_id'=>$emailbooking->vehicle_make));
		$make_name  = $make->make_name;
		 
		$model   = $this->CI->Common->single_row('vehicle_model', array('model_id'=>$emailbooking->vehicle_model));
		$model_name  = $model->model_name;
		 
		$mechanic_name = $this->CI->Common->single_row('service_providers', array('id'=>$emailbooking->assigned_mechanic), 'name');         
		
	 
		$service_category   = $this->CI->Common->single_row('service_category', array('id'=>$emailbooking->service_category_id), 'service_name');  
		 
				$emaildata['customer_name'] = $emailbooking->customer_name;
				$emaildata['customer_email'] = $emailbooking->customer_email;
				$emaildata['booking_id'] = base64_encode($emailbooking->booking_id);
				$emaildata['make'] = $make_name;
				$emaildata['model'] = $model_name;
				$emaildata['service_category'] = $service_category;
				$emaildata['mechanic_name'] = $mechanic_name; 
				$emaildata['created_date'] = date('d-m-Y', strtotime($emailbooking->created_on));
				$emaildata['service_date'] = date('d-m-Y', strtotime($emailbooking->service_date));
				$emaildata['service_time'] = date('H:i a', strtotime($emailbooking->time_slot)); 
				$emaildata['comments'] = '';
				$emaildata['estimate_amount'] = '';
				$emaildata['total_amount'] = $total_amount;
				$emaildata['payment_mode'] = $payment_mode;
		
		  
				if(!empty($emaildata['customer_email'])){ 
				$message = $this->CI->load->view('emailer/completed_booking.php',$emaildata,TRUE); 
				}
		
			return $message;
	}
	

}
?>