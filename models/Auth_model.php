<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

	public function login($data)
	{

		$this->db->from('users');
		$this->db->where('username', $data['username']);

		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return false;
		} else {
			//Compare the password attempt with the password we have stored.
			$result = $query->row_array();
			$validPassword = true;
			if ($validPassword) {
				return $result = $query->row_array();
			}
		}
	}

	//--------------------------------------------------------------------
	public function register($data)
	{
		$this->db->insert('users', $data);
		return true;
	}

	//--------------------------------------------------------------------
	public function email_verification($code)
	{
		$this->db->select('email, token, is_active');
		$this->db->from('users');
		$this->db->where('token', $code);
		$query = $this->db->get();
		$result = $query->result_array();
		$match = count($result);
		if ($match > 0) {
			$this->db->where('token', $code);
			$this->db->update('users', array('is_verify' => 1, 'token' => ''));
			return true;
		} else {
			return false;
		}
	}

	//============ Check User Email ============
	function check_user_mail($email)
	{
		$result = $this->db->get_where('users', array('email' => $email));

		if ($result->num_rows() > 0) {
			$result = $result->row_array();
			return $result;
		} else {
			return false;
		}
	}

	//============ Update Reset Code Function ===================
	public function update_reset_code($reset_code, $user_id)
	{
		$data = array('password_reset_code' => $reset_code);
		$this->db->where('id', $user_id);
		$this->db->update('users', $data);
	}

	//============ Activation code for Password Reset Function ===================
	public function check_password_reset_code($code)
	{

		$result = $this->db->get_where('users',  array('password_reset_code' => $code));
		if ($result->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	//============ Reset Password ===================
	public function reset_password($id, $new_password)
	{
		$data = array(
			'password_reset_code' => '',
			'password' => $new_password
		);
		$this->db->where('password_reset_code', $id);
		$this->db->update('users', $data);
		return true;
	}

	//--------------------------------------------------------------------
	public function get_user_detail()
	{
		$id = $this->session->userdata('id');
		$query = $this->db->get_where('users', array('id' => $id));
		return $result = $query->row_array();
	}

	//--------------------------------------------------------------------
	public function update_user($data)
	{
		$id = $this->session->userdata('id');
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		return true;
	}

	//--------------------------------------------------------------------
	public function change_pwd($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('users', $data);
		return true;
	}
}
