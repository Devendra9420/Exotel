<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'libraries/API_Controller.php';

class Exotel extends API_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->model('Api_model');
        $this
            ->load
            ->model('CallLog_model');
    }

    /*
     *	@author : Irfan shaikh
     *  @support: irfan@digitalflake.com
     *	date	: 22 November, 2021
     *  version: 1.0
    */
    public function callLog()
    {
        $callto = $this
            ->input
            ->get('CallTo');
        $callfrom = $this
            ->input
            ->get('CallFrom');
        $calltype = $this
            ->input
            ->get('CallType');
        $currenttime = $this
            ->input
            ->get('CurrentTime');
        $data = ['call_to' => $callto, 'call_from' => $callfrom, 'call_type' => $calltype,];
        $this
            ->CallLog_model
            ->addCallLog($data);
        $this->api_return(['status' => true, "result" => ['message' => "call log added succesfuly"]], 200);
    }


    public function getCallHistoryLog()
    {
        $fdate = $this
            ->input
            ->get('fdate');
        $tdate = $this
            ->input
            ->get('tdate');
        if ($fdate != '' && $tdate != '' && new DateTime($fdate) <= new DateTime($tdate)) {
            $data = $this
                ->CallLog_model
                ->get_callhistory($fdate, $tdate);
            $this->api_return(['status' => true, "result" => $data, "message" => "Record show successfully",], 200);
        } else {
            $this->api_return(['status' => false, "result" => [], "message" => "Invalid date",], 200);
        }
    }
    public function updateCallLog()
    {

        $id = $this->input->get('id');
        $p_call = $this->input->post('purpose_of_call');
        $comm = $this->input->post('comment');
        $data = ['purpose_of_call' => "'" . $p_call . "'", 'comment' => "'" . $comm . "'"];
        print_r($data);
        $result = $this->CallLog_model->update_call_history($id, $data);

        if ($result == 1) {
            $this->api_return(['msg' => 'Updated'], 200);
        } else {
            $this->api_return(['msg' => 'Error'], 401);
        }
    }
}
