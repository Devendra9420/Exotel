<?php
defined('BASEPATH') or exit('No direct script access allowed');
class CallLog extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		$this->load->model('CallLog_model');
	}
	public function history()
	{
		$this->header($title = 'Call tracker');
		$arrData['history_detail'] = [];
		$this->load->view('Exotel/call_log', $arrData);
		$this->footer();
	}
}
