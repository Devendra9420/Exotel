<?php
	class Join_model extends CI_Model{
	
		public function get_all_serverside_payments()
	    {
	    	$this->db->select('
	    		ci_payments.id,
				ci_payments.invoice_no,
				ci_payments.grand_total,
				ci_payments.currency,
				ci_payments.created_date,
				users.username as client_name,
				users.email as client_email,
				users.mobile_no as client_mobile_no
	    	');
	    	$this->db->join('users','users.id = ci_payments.user_id','left');
	    	return $this->db->get('ci_payments')->result_array();
	    }


	    public function get_user_payment_details(){
	    	$this->db->select('
	    			ci_payments.id,
	    			ci_payments.invoice_no,
	    			ci_payments.payment_status,
					ci_payments.grand_total,
					ci_payments.currency,
					ci_payments.due_date,
					ci_payments.created_date,
					users.username as client_name,
					users.firstname,
					users.lastname,
					users.email as client_email,
					users.mobile_no as client_mobile_no,
					users.address as client_address,'
	    	);
	    	$this->db->from('ci_payments');
	    	$this->db->join('users', 'users.id = ci_payments.user_id ', 'left');
	    	$query = $this->db->get();					 
			return $query->result_array();
	    }

	}

?>

