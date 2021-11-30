<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Voucher extends MY_Controller
{

    public function __construct()
    {
        Parent::__construct();

        $this->load->model('Voucher_model');
    }

    public function index()
    {

        //$data['items'] = $this->Common->select('item');
        $this->header();
        $this->load->view('Voucher/voucher_details');
        $this->footer();
    }
    public function list()
    {
        $this->header($title = 'Voucher List');
        $arrData['history_detail'] = [];
        $this->load->view('Voucher/voucher_details', $arrData);
        $this->footer();
    }
    public function add()
    {
        $json = '';
        $path = '';
        $date = $this->input->post('date');
        $invoiceid = $this->input->post('invoiceid');

        $vendor = $this->input->post('vendor');
        $user = $this->input->post('user');

        $gst = $this->input->post('gst');
        $cgst = $this->input->post('cgst');
        $sgst = $this->input->post('sgst');
        $finalamt = $this->input->post('finalamt');

        if (!empty($_FILES['upload'])) {
            $fileName  =  $_FILES['upload']['name'];
            $tempPath  =  $_FILES['upload']['tmp_name'];
            $fileSize  =  $_FILES['upload']['size'];
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $fileName = $fileSize . time() . '.' . $ext;

            $upload_path = 'uploads/vouchers/'; // set upload folder path 

            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'pdf');

            if (in_array($fileExt, $valid_extensions)) {
                //check file not exist our upload folder path
                if (!file_exists($upload_path . $fileName)) {
                    // check file size '5MB'
                    if ($fileSize < 5000000) {
                        $path =  'uploads/vouchers/' . $fileName;
                        move_uploaded_file($tempPath, $upload_path . $fileName); // move file from system temporary path to our upload folder path 
                        $json = $this->Voucher_model->add_voucher($date, $invoiceid, $vendor, $user, $path, $gst, $cgst, $sgst, $finalamt);
                        echo json_encode(['statusCode' => '200', "message" => "Data Saved Successfully"], 200);
                    } else {
                        //$json = "please selected Image is To large";
                        echo  json_encode(['statusCode' => '200', "message" => "please selected Image is To large"], 500);
                    }
                } else {
                    $json = "please selected Image is allready exist";
                    echo json_encode(['statusCode' => '301', "message" => "please selected Image is allready exist"], 400);
                }
            }
        }
    }
    public function savedata()
    {

        $data = array(
            'username' => $this->input->post('username'),
            'date' => $this->input->post('date'),
            'quantity' => $this->input->post('quantity')
        );

        $this->load->model('AjaxModel');
        $result = $this->AjaxModel->saveData($data);
        if ($result) {
            echo  1;
        } else {
            echo  0;
        }
    }
}
