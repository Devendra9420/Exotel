<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 *	@author : Chintan Desai
 *  @support: chintz2806@gmail.com
 *	date	: 01 November, 2019
 *	GarageWorks Inventory Management System
 * website: garageworks.in
 *  version: 1.0
 */
class Reports extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access(); 
		$this->load->model('Bookings_model', 'Bookings'); 
		
    }

    //Purchase Report  Form
    public function purchase()
    {
        $data['items'] = $this->Common->select('item');        
        $this->header($title = 'Purchase Report');
        $this->load->view('reports/purchase',$data);
        $this->footer();

    }
     // Purchase Report Details
    public function purchaseReportOld()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));
        $data['purchases'] = $this->Common->purchases($start_date1,$end_date1);
//echo "<pre>";print_r($data['purchases']);exit;       
	   $data['start'] = $start_date;
        $data['end'] = $end_date;
        $data['items'] = $this->Common->select('item');
        $this->header();
        $this->load->view('reports/purchase',$data);
        $this->footer();
    }
	function purchaseReport(){
		$start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

        $invoice = $this->Common->get_invoice_by_date1($start_date1, $end_date1);
               //echo "<pre>";print_r($invoice);exit;
        if (!empty($invoice)) {
            $this->bps_table();
            foreach ($invoice as $v_invoice) {
                $data['invoice_details'][$v_invoice->purchase_no] = $this->Common->p_detail(array('purchase_no' => $v_invoice->purchase_no));
                $data['order'][] = $v_invoice;
            }
        }

       // echo "<pre>";print_r($data);exit;
        //$data['purchases'] = $this->Common->getSales($start_date1,$end_date1);
        $data['start'] = $start_date;
        $data['end'] = $end_date;
        $data['items'] = $this->Common->select('item');
        $this->header();
        //print_r($data);
        $this->load->view('reports/p_report',$data);
        $this->footer();
	}
	
	function inwardsReport(){
		$start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

        $invoice = $this->Common->get_purchase_by_date($start_date1, $end_date1);
               //echo "<pre>";print_r($invoice);exit;
        if (!empty($invoice)) {
            $this->bps_table();
            foreach ($invoice as $v_invoice) {
                $data['invoice_details'][$v_invoice->purchase_no] = $this->Common->get_purchase_item_detail(array('purchase_no' => $v_invoice->purchase_no));
                $data['order'][] = $v_invoice;
            }
        }

       // echo "<pre>";print_r($data);exit;
        //$data['purchases'] = $this->Common->getSales($start_date1,$end_date1);
        $data['start'] = $start_date;
        $data['end'] = $end_date;
        $data['items'] = $this->Common->select('item');
        $this->header();
        //print_r($data);
        $this->load->view('reports/inwards_report',$data);
        $this->footer();
	}
	
	
	
	function stockconsumption_report(){
		$start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

        $invoice = $this->Common->get_stocktrans_by_date($start_date1, $end_date1);
               //echo "<pre>";print_r($invoice);exit;
        if (!empty($invoice)) {
            $this->bps_table();
			$data['stocktrans'] = $invoice;
           // foreach ($invoice as $v_invoice) {
               // $data['invoice_details'][$v_invoice->purchase_no] = $this->Common->get_purchase_item_detail(array('purchase_no' => $v_invoice->purchase_no));
               // $data['order'][] = $v_invoice;
          //  }
        }

       // echo "<pre>";print_r($data);exit;
        //$data['purchases'] = $this->Common->getSales($start_date1,$end_date1);
        $data['start'] = $start_date;
        $data['end'] = $end_date;
        $data['items'] = $this->Common->select('item');
        $this->header();
        //print_r($data);
        $this->load->view('reports/stockconsumption_report',$data);
        $this->footer();
	}
	
	
	
	function claim_report(){
		$start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));
       // echo "<pre>";print_r($data);exit;
        //$data['purchases'] = $this->Common->getSales($start_date1,$end_date1);
        $data['start'] = $start_date1;
        $data['end'] = $end_date1; 
        $this->header();
        //print_r($data);
        $this->load->view('reports/claim_report',$data);
        $this->footer();
	}
	
	
	function claim_report_download(){
		// create file name
        $fileName = 'Claim_Report-'.date('d-m-Y').'.xlsx';  
    // load excel library
        $this->load->library('excel');
		
		
		$start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));
		
		 
             
            
 		$sql = $this->db->query("SELECT * FROM claims WHERE created_on >='".$start_date1."' AND  created_on <= '".$end_date1."'");
	 
		 
        $claim_details = $sql->result();
		 
		
        //$empInfo = $this->export->mechanicList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
		 
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Insured name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'GIC');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Location');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Make');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Model');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Date Of Creation');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Date Of Survey'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Date Of Estimate'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Date Of Assessment');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Spares Ordered Date'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Repair Start Date'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Date Of Invoice'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Estimated Amount'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Assessment Amount');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Invoice Amount'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Invoice No');    
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Insurer Liability');  
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Customer Amount'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Payment Mode'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Surveyor Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Service Provider Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Customer Mobile');
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Claim No');
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Claim ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Delivery Complete');
		
        // set Row
        $rowCount = 2;
        foreach ($claim_details as $element) {
			
			
				$getmake  = $this->db->query("SELECT make_name FROM vehicle_make WHERE make_id = '".$element->make."'")->row();
				if(!empty($getmake->make_name)){ 
				$thismake = $getmake->make_name;
				}else{
				$thismake = '';	
				}
				$getmodel  = $this->db->query("SELECT model_name FROM vehicle_model WHERE model_id = '".$element->model."'")->row();
				if(!empty($getmodel->model_name)){ 
				$thismodel = $getmodel->model_name;
		 		}else{
				$thismodel = '';	
				}
			
				$gic  = $this->db->query("SELECT * FROM gic WHERE GIC_ID = '".$element->gic."'")->row();
				
				$city  = $this->db->query("SELECT * FROM city WHERE city_id = '".$element->city."'")->row();
				$cityname = $city->cityname;
					
				$claim_survey_details  = $this->db->query("SELECT * FROM claim_survey_details WHERE claim_id = '".$element->id."'")->row();
				$claim_estimate  = $this->db->query("SELECT * FROM claim_estimate WHERE claim_id = '".$element->id."'")->row();
				$claim_gic_approval  = $this->db->query("SELECT * FROM claim_gic_approval WHERE claim_id = '".$element->id."'")->row();
			    $claim_repair  = $this->db->query("SELECT * FROM claim_repair WHERE claim_id = '".$element->id."'")->row();
			
			$claim_invoice  = $this->db->query("SELECT * FROM claim_invoice WHERE claim_id = '".$element->id."'")->row();
			
			$claim_gic_liability  = $this->db->query("SELECT * FROM claim_gic_liability WHERE claim_id = '".$element->id."'")->row();
			
			$claims_payments  = $this->db->query("SELECT * FROM claims_payments WHERE claims_id = '".$element->id."'")->row();
			
			$claim_survey_assign  = $this->db->query("SELECT * FROM claim_survey_assign WHERE claim_id = '".$element->id."'")->row();
			
			$claim_delivery = $this->db->query("SELECT * FROM claim_delivery WHERE claim_id = '".$element->id."'")->row();
			
			if(!empty($claim_survey_assign->surveyor)){ 
			$surveyor  = $this->db->query("SELECT * FROM surveyor WHERE surveyor_id = '".$claim_survey_assign->surveyor."'")->row();
			$surveyor_name = $surveyor->name;	
			}else{
			$surveyor_name = '';	 
			}
			
			$claim_customer_approval  = $this->db->query("SELECT * FROM claim_customer_approval WHERE claim_id = '".$element->id."'")->row();
			
			$claim_status_q  = $this->db->query("SELECT * FROM claim_status WHERE claim_id = '".$element->id."'")->row();
			
			
			if($element->active == 0 && $claim_status_q->stage!='-1'){ 
			$claim_status = 'Cancelled/Withdrawn';	
			}else{ 
			 $claim_status = $claim_status_q->status;
			}
				 
				 
				 
			if(!empty($claim_customer_approval->repair_type)){
			
				if($claim_customer_approval->repair_type=='Pickup'){ 
							
							 $where = array('id' => $claim_customer_approval->service_provider);
						$getgarages =$this->Common->single_row('garages', $where, 's');
								$service_provider =  $getgarages['name'];
							}else{
							
							 $where = array('mechanic_id' => $claim_customer_approval->service_provider);
						$getgarages =$this->Common->single_row('mechanic', $where, 's');
								$service_provider =  $getgarages['name'];
								 
							}
			}else{
				$service_provider = '';
			}
			
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element->name); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $gic->GIC_NAME);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $cityname);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $thismake);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $thismodel);
			
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, date('d-m-Y', strtotime($element->created_on)));
			
			if(!empty($claim_survey_details->surveyed_on)){ 
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, date('d-m-Y', strtotime($claim_survey_details->surveyed_on)));
			}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');	
			}
			
			if(!empty($claim_estimate->estimate_date)){ 
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, date('d-m-Y', strtotime($claim_estimate->estimate_date)));
			}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '');	
			}
			
			if(!empty($claim_gic_approval->approval_date)){ 
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, date('d-m-Y', strtotime($claim_gic_approval->approval_date)));
			}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '');	
			}
			 
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, '');
			 
			if(!empty($claim_repair->repair_startdate)){ 
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, date('d-m-Y', strtotime($claim_repair->repair_startdate)) );
			}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, '');	
			}
			if(!empty($claim_invoice->invoice_date)){ 
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $claim_invoice->invoice_date);
			}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, '');	
			}
			if(!empty($claim_estimate->estimate_total)){ 
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $claim_estimate->estimate_total);
			}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, '');	
			}
			
			if(!empty($claim_gic_approval->approved_amount)){ 
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $claim_gic_approval->approved_amount);
			}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, '');	
			}
			
			
			//if(!empty($claim_invoice->approved_spares) && !empty($claim_invoice->approved_labour)){ 
//            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, ($claim_invoice->approved_spares+$claim_invoice->approved_labour));
//			}else{
//			$objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, '');	
//			}
			
			
			if(!empty($claim_invoice->invoice_total)){ 
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $claim_invoice->invoice_total);
			}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, '');	
			}
			if(!empty($claim_invoice->invoice_no)){ 
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $claim_invoice->invoice_no);
			}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, '');	
			}
			if(!empty($claim_gic_liability->spares_liability)){ 
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, ($claim_gic_liability->spares_liability+$claim_gic_liability->labour_liability));
			}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, '');	
			}
			if(!empty($claim_gic_liability->customer_liability)){ 
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $claim_gic_liability->customer_liability);
			}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, '');	
			}
			if(!empty($claim_delivery->payment_mode)){ 
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $claim_delivery->payment_mode);
			}else{
			$objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, '');	
			}
			 
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $surveyor_name);
			 
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $service_provider);
			
			$objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $claim_status);
			$objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $element->mobile);
			$objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $element->claim_no);
			$objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $element->id);
			
			if(!empty($claim_delivery->delivery_date) && $claim_delivery->delivery_date!='0000-00-00'){ 
				$delivery_date = date('Y-m-d', strtotime($claim_delivery->delivery_date));
			}else{
				$delivery_date = '';
			}
			$objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $delivery_date);
			
			 
			
            $rowCount++;
        }
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('uploads/images/'.$fileName);
    // download file
        header("Content-Type: application/vnd.ms-excel");
        redirect(base_url()."uploads/images/".$fileName);  
    
	}
	
	function show_voucher(){
		$start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
        $end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));
		$vendor_id = $this->input->post('vendor_id');
		$payment_status = $this->input->post('payment_status');
		
		$query = "SELECT * FROM voucher WHERE id>0"; //$this->db->select('*', true);
        // $this->db->select('sales_detail.*', false);
        //$this->db->from('voucher');
		
		if(!empty($this->input->post('start_date'))){ 
		if ($start_date == $end_date OR empty($this->input->post('end_date'))) {
            //$this->db->where('voucher.payment_date', $start_date);
			$query .= " AND invoice_date='".$start_date."'";
        } else {
			$query .= " AND invoice_date>='".$start_date."' AND invoice_date<='".$end_date."'";
          //  $this->db->where('voucher.payment_date >=', $start_date);
           // $this->db->where('voucher.payment_date <=', $end_date);
        }
		}
		if (!empty($vendor_id)){
			$query .= " AND vendor_id='".$vendor_id."'";
			//$this->db->where('voucher.vendor_id', $vendor_id);
		}
		//$this->db->where('voucher.voucher_id =', $voucherID);
		if(!empty($payment_status)){ 
			$query .= " AND payment_status='".$payment_status."'";
			//$this->db->where('voucher.payment_status =', $payment_status);
		}
			$query .= " AND vendor_id>0";
		//$query_result = $this->db->get();
        //$vouchers = $query_result->result();
		
		$getvendorid = $this->db->query($query)->result();
        //$invoice = $this->db->query("SELECT * FROM voucher WHERE voucher_id = '".$voucherID."' AND ")->rows(); 
               //echo "<pre>";print_r($invoice);exit;
        if (!empty($getvendorid)) {
            $this->bps_table();
            $data['voucher_details'] = $getvendorid;
        }
			$data['query'] = $query;
       // echo "<pre>";print_r($data);exit;
        //$data['purchases'] = $this->Common->getSales($start_date1,$end_date1);
        $data['start'] = $this->input->post('start_date');
        $data['end'] = $this->input->post('end_date');
		$data['vouchers'] = $this->db->query("SELECT * FROM voucher")->result();
		$data['vendors'] = $this->General->fetch_records("vendor");
		
        $data['items'] = $this->Common->select('item');
        $this->header();
        //print_r($data);
        $this->load->view('reports/voucher_report',$data);
        $this->footer();
	}
	
	function voucher_report(){
		 
        $start_date1 = date('Y-m-d');
        $end_date1 = date('Y-m-d');
		 

       // echo "<pre>";print_r($data);exit;
        //$data['purchases'] = $this->Common->getSales($start_date1,$end_date1);
        $data['start'] = $start_date1;
        $data['end'] = $end_date1;
		$data['vouchers'] = $this->db->query("SELECT * FROM voucher")->result();
		$data['vendors'] = $this->General->fetch_records("vendor");
		
        $data['items'] = $this->Common->select('item');
        $this->header();
        //print_r($data);
        $this->load->view('reports/voucher_report',$data);
        $this->footer();
	}
	
		public function export_voucherlog()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

        
			
			$start_date = date('Y-m-d', strtotime($this->input->post('start_date')));
        $end_date = date('Y-m-d', strtotime($this->input->post('end_date')));
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));
		$vendor_id = $this->input->post('vendor_id');
		$payment_status = $this->input->post('payment_status');
		
		$query = "SELECT * FROM voucher WHERE id>0"; //$this->db->select('*', true);
        // $this->db->select('sales_detail.*', false);
        //$this->db->from('voucher');
		
		if(!empty($this->input->post('start_date'))){ 
		if ($start_date == $end_date OR empty($this->input->post('end_date'))) {
            //$this->db->where('voucher.payment_date', $start_date);
			$query .= " AND invoice_date='".$start_date."'";
        } else {
			$query .= " AND invoice_date>='".$start_date."' AND invoice_date<='".$end_date."'";
          //  $this->db->where('voucher.payment_date >=', $start_date);
           // $this->db->where('voucher.payment_date <=', $end_date);
        }
		}
		if (!empty($vendor_id)){
			$query .= " AND vendor_id='".$vendor_id."'";
			//$this->db->where('voucher.vendor_id', $vendor_id);
		}
		//$this->db->where('voucher.voucher_id =', $voucherID);
		if(!empty($payment_status)){ 
			$query .= " AND payment_status='".$payment_status."'";
			//$this->db->where('voucher.payment_status =', $payment_status);
		}
			$query .= " AND vendor_id>0";
		//$query_result = $this->db->get();
        //$vouchers = $query_result->result();
		
		$getvendorid = $this->db->query($query)->result();
        //$invoice = $this->db->query("SELECT * FROM voucher WHERE voucher_id = '".$voucherID."' AND ")->rows(); 
               //echo "<pre>";print_r($invoice);exit;
        if (!empty($getvendorid)) {
            $this->bps_table();
            $data['voucher_details'] = $getvendorid;
        }
			$data['query'] = $query;
			
			
 
		 $ReportFileName = 'Voucher Log-'.date('d-m-Y').'.xlsx';  
    // load excel library
        $this->load->library('excel');	
  
		
		 $BookData = $this->db->query($query);
		 
		 
		//if($BookData->num_rows > 0){
		if(!empty($BookData)){ 
     
    		
		 $bookdatas  = $BookData->result_array();
			
			
        //$empInfo = $this->export->mechanicList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
			
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Voucher Id');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Vendor Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Employee Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Location');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Voucher Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Invoice Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Taxable Value');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'GST Value');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Total Value'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Invoice No'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Payment Status'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Payment Amount'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Payment Date'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Payment Mode');
		$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Trans Ref No');	
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Comments'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Created On'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Vendor GSTIN'); 
        // set Row
          
   
     $rowCount = 2;
    //output each row of the data, format line as csv and write to file pointer
    foreach ($bookdatas as $row){
       // $status = ($row['status'] == '1')?'Active':'Inactive';
		 
			$voucher_payments  = $this->db->query("SELECT * FROM voucher_payment WHERE voucher_id='".$row['id'] ."'")->row();
			 
		
		$vendor =	$this->db->query("SELECT * FROM vendor WHERE vendor_id = '".$row['vendor_id']."'")->row();  
		
		  						if(!empty($row['vendor_name'])){
								$vendorsName = $row['vendor_name'];
								}else{ 
								$vendorsName = $vendor->vendor_name;
								} 
			
		
		$vendorsName = $vendor->vendor_name;
		
		$voucher_id=$row['id'];
		$vendor_name  = $vendorsName ;
		$employee_name  = $row['employee_name'];
		$location  = $row['location'];
		$voucher_type  = $row['voucher_type'];
		$invoice_date  = date('d-m-Y', strtotime($row['invoice_date']));
		$taxable_value  = $row['taxable_value'];
		$gst_value  = $row['gst_value'];
		$total_value  = $row['total_value'];
		$invoice_no  = $row['invoice_no'];
		
		if(!empty($voucher_payments->payment_status)){ 
		$payment_status  = $voucher_payments->payment_status;
		}else{
		$payment_status  = '';	
		}
		
		if(!empty($voucher_payments->amount)){ 
		$payment_amount  = $voucher_payments->amount;
		}else{
			$payment_amount  = '';
		}
		
		if(!empty($voucher_payments->payment_date)){ 
		$payment_date  = date('d-m-Y', strtotime($voucher_payments->payment_date));
		}else{
			$payment_date  = '';
		}
		
		if(!empty($voucher_payments->payment_mode)){ 
		$payment_mode  = $voucher_payments->payment_mode;
		}else{
			$payment_mode  = '';
		}
		
		if(!empty($voucher_payments->trans_ref_no)){ 
		$trans_ref_no  = $voucher_payments->trans_ref_no;
		}else{
			$trans_ref_no  = '';
		}
		 
		$comments  = $row['comments'];
		$created_on  = date('d-m-Y', strtotime($row['created_on']));
		
		      
		 
		
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $voucher_id);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $vendor_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $employee_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $location);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $voucher_type);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $invoice_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $taxable_value);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $gst_value);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $total_value);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $invoice_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $payment_status);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $payment_amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $payment_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $payment_mode);
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $trans_ref_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $comments);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $created_on); 
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $vendor->gstin); 
            $rowCount++;
		
		
		
	 
		
    }
    
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('uploads/images/'.$ReportFileName);
    // download file
        header("Content-Type: application/vnd.ms-excel"); 
        redirect(base_url()."uploads/images/".$ReportFileName);  
		exit(); 
}
 
		  exit(); 
        
    }
	
    // Sales Report Form
    public function sales_report()
    {
        $data['items'] = $this->Common->select('item');
        $this->header($title = 'Sales Report');
        $this->load->view('reports/sales_report',$data);
        $this->footer();

    }

    public function bps_table()
    {
       $this->Common->bps_table('sales_detail','sales_id');
    }
    // Get Sales Report Details
    public function salesReport()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

        $invoice = $this->Common->get_invoice_by_date($start_date1, $end_date1);
               //echo "<pre>";print_r($invoice);exit;
        if (!empty($invoice)) {
            $this->bps_table();
            foreach ($invoice as $v_invoice) {
                $data['invoice_details'][$v_invoice->invoice_no] = $this->Common->sales_detail(array('sales_no' => $v_invoice->sales_no));
                $data['order'][] = $v_invoice;
            }
        }

       // echo "<pre>";print_r($data);exit;
        //$data['purchases'] = $this->Common->getSales($start_date1,$end_date1);
        $data['start'] = $start_date;
        $data['end'] = $end_date;
        $data['items'] = $this->Common->select('item');
        $this->header();
        //print_r($data);
        $this->load->view('reports/sales_report',$data);
        $this->footer();
    }
	
	// Get Sales Report Details
    public function bookinglog()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

         
        $data['start'] = $start_date;
        $data['end'] = $end_date; 
        $this->header();
        //print_r($data);
        $this->load->view('reports/bookinglog',$data);
        $this->footer();
    }
	
	// Get Sales Report Details
    public function servicelog()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

         
        $data['start'] = $start_date;
        $data['end'] = $end_date; 
        $this->header();
        //print_r($data);
        $this->load->view('reports/servicelog',$data);
        $this->footer();
    }
	
	public function GetBookingTrackValue($stage, $booking_id){
		
		//$query  = $this->db->query("SELECT DATE_FORMAT(created_on, '%d-%m-%Y %H:%i:%s') AS value FROM booking_track WHERE stage='".$stage."' AND booking_id='".$booking_id."'")->row();
		
		$query  = $this->db->query("SELECT DATE_FORMAT(created_on, '%H:%i:%s') AS value FROM booking_track WHERE stage='".$stage."' AND booking_id='".$booking_id."'")->row();
		
		if(!empty($query)){
			$value = $query->value;
		}else{
			$value= '';
			
		}
		
		return $value;
		
	}
	
	 
	   
	
	public function export_servicelog()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

         
 
		 $ReportFileName = 'Service Log-'.date('d-m-Y').'.xlsx';  
    // load excel library
        $this->load->library('excel');	
  
		
		 $BookData = $this->db->query("SELECT b.booking_id, b.status, b.customer_type, b.customer_name, b.customer_channel, b.customer_mobile, b.customer_email, b.customer_address, b.customer_city, b.customer_area, b.comments, b.remark, mk.make_name, md.model_name, DATE_FORMAT(b.created_on, '%d-%m-%Y') AS booking_date, DATE_FORMAT(b.service_date, '%d-%m-%Y') AS service_date, b.time_slot, s.service_name, b.assigned_mechanic, b.complaints FROM bookings AS b INNER JOIN vehicle_make AS mk ON mk.make_id=b.vehicle_make INNER JOIN vehicle_model AS md ON md.model_id=b.vehicle_model INNER JOIN service_category AS s ON s.id=b.service_category_id WHERE b.service_date>='".$start_date1."' AND b.service_date<='".$end_date1."'");
		 
		 
		//if($BookData->num_rows > 0){
		if(!empty($BookData)){ 
     
    		
		 $bookdatas  = $BookData->result_array();
			
			
        //$empInfo = $this->export->mechanicList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
			
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Booking Id');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Customer Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Channel');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Mobile');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'City');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Area');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Make'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Model'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Booking Date'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Service Date'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Time'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Service');
		$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Addtln Spares');	
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Addtln Repairs'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Complaints'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Comments'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Mechanic'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Start Time'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Reached Time'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Inspcetion Done'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Customer Approval'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'End Work'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Invoice Value'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Amt Collected'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'Payment Mode'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'Payment Comments');
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'Invoiced Items'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'Distance Travelled'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'Customer Address');  
        $objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'Jobcard Date'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'Feedback'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'Cancel Reason/Remark'); 	
        // set Row
         
			
    //set column headers
			 
			
   
     $rowCount = 2;
    //output each row of the data, format line as csv and write to file pointer
    foreach ($bookdatas as $row){
		
			$bookingdata =	$this->Bookings->getbooking($row['booking_id']);
			$booking_id = $row['booking_id'];   
			$booking = $bookingdata['booking']; 
			$booking_details =  $bookingdata['booking_details']; 
			$estimate_details =  $bookingdata['estimate_details'];  
			$jobcard =  $bookingdata['jobcard'];  
			$jobcard_details =  $bookingdata['jobcard_details'];
			$jobcard_rejected_details =  $bookingdata['jobcard_rejected_details'];  
			$booking_payments =  $bookingdata['booking_payments']; 
			$booking_notes = $bookingdata['booking_notes'];
			$bookingtrack = $bookingdata['booking_track']; 
			$booking_service = $bookingdata['booking_service']; 		
					
		if(!empty($row['assigned_mechanic']) || $row['assigned_mechanic']!=0){ 
			$mechanic_name  = @get_service_providers(array('id'=>$row['assigned_mechanic']),'name');
			 
		}else{
			$mechanic_name  = '';
		}
		
		$addt_spares_q  = $this->db->query("SELECT item FROM jobcard_details WHERE item_type='Spare' AND status='Active'  AND  booking_id='".$row['booking_id'] ."'")->result();
		$addt_spares = "";
		foreach ($addt_spares_q as $rows) {
		if(!empty($rows)){ 
		$addt_spares .= $rows->item.', ';
		}else{
		$addt_spares .= '';
		}
		}
		 
		
		$addt_repairs_q  = $this->db->query("SELECT item FROM jobcard_details WHERE item_type='Labour' AND status='Active' AND  booking_id='".$row['booking_id'] ."'")->result();
          $addt_repairs = "";                      
		foreach ($addt_repairs_q as $rows) {
		if(!empty($rows)){ 
		$addt_repairs .= $rows->item.', ';
		}else{
		$addt_repairs .= '';
		}
		}
		
		$complain = '';
		//if(!empty($row['complaints'])){ 
		//$complaints = explode('+',$row['complaints']);
		
		$complain_q  = $this->db->query("SELECT complaints FROM jobcard_details WHERE item_type='Complaints' AND status='Active' AND  booking_id='".$row['booking_id'] ."'")->result();
			
		foreach ($complain_q as $complaint){
			 
			if(!empty($complaint)){
				$complain .= $complaint->complaints.', ';
			}else{
				$complain .= '';
			}
		}
		 
		
		 
  		 
			
		$booking_id=$row['booking_id'];
		$start_time  = @$booking_service->start_time;
		$reach_time  = @$booking_service->reached_time;
		$inspection_time  = @$booking_service->inspection_time;
		$jobcard_apporval_time  = @$this->GetBookingTrackValue('Jobcard Approved', $booking_id);
		$end_work_time  = @$booking_service->end_work_time;
		
		$total_distance_travelled   = @$booking_service->distance_travelled;
		 
		 
			$inv_val = @$booking_details->estimated_amount;
			$amt_coll = @$booking_details->actual_amount;
		 
		 
		 
			$pay_mode = @$booking_payments->payment_mode;
			$payment_comments = @$booking_payments->comments; 
		 
		  
			
		$inv_itm_q  = $this->db->query("SELECT no_of_items, created_on FROM jobcard WHERE booking_id='".$booking_id."'")->row();
		if(!empty($inv_itm_q)){
			 $inv_itm  =  $inv_itm_q->no_of_items;
			 $jobcardDate = date('d-m-Y', strtotime($inv_itm_q->created_on));
			 
		}else{
			 $inv_itm = '';
			 $jobcardDate = '';
			 
		}
		
		 
		 $jobcard_q  = $this->db->query("SELECT item FROM jobcard_details WHERE status='Active' AND booking_id='".$row['booking_id']."'")->result();
		$jobcard_itm = '';
		if(!empty($jobcard_q)){
			
			foreach ($jobcard_q as $jobcard){
			     $jobcard_itm  .= $jobcard->item.' | ';
			}
		}else{
				 $jobcard_itm .= '';
			}
		 
		
		if(empty($row['customer_type'])){
			$row['customer_type'] = '';
		}
		
		$isfeedback  = $this->db->query("SELECT * FROM feedback WHERE booking_id='".$row['booking_id'] ."'")->row();
		
			if(!empty($isfeedback->feedback_id)){
			$feedback_exist = 'Yes';	
			}else{
			$feedback_exist = 'No';	
			}
			
		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row['booking_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['status']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row['customer_type']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row['customer_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row['customer_channel']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row['customer_mobile']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row['customer_email']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row['customer_city']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row['customer_area']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row['make_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row['model_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row['booking_date']);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, @convert_date($booking_service->service_date));
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, @$booking_service->service_time);
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, @$row['service_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, @$addt_spares);
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, @$addt_repairs);
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, @$complain);
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, @$row['comments']);
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, @$mechanic_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, @$start_time);
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, @$reach_time);
            $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, @$inspection_time);
            $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, @$jobcard_apporval_time);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, @$end_work_time);
            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, @$inv_val);
            $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, @$amt_coll);
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, @$pay_mode);
            $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, @$payment_comments); 
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, @$jobcard_itm); 
            $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $rowCount, @$total_distance_travelled);
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, @$row['customer_address']);
            $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $rowCount, @$jobcardDate);
			$objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, @$feedback_exist);
			$objPHPExcel->getActiveSheet()->SetCellValue('AI' . $rowCount, @$row['remark']);
		
            $rowCount++;
		
		
		
	 
		
    }
    
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('uploads/images/'.$ReportFileName);
    // download file
        header("Content-Type: application/vnd.ms-excel"); 
        redirect(base_url()."uploads/images/".$ReportFileName);  
		exit(); 
}
 
		  exit(); 
        
    }
	
	
	
	
	public function export_bookinglog()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

         
 
		 $ReportFileName = 'Booking Log-'.date('d-m-Y').'.xlsx';  
    // load excel library
        $this->load->library('excel');	
  
		
		 $BookData = $this->db->query("SELECT b.booking_id, b.status, b.customer_type, b.customer_name, b.customer_channel, b.customer_mobile, b.customer_email, b.customer_address, b.customer_city, b.customer_area, b.comments, b.remark, mk.make_name, md.model_name, DATE_FORMAT(b.created_on, '%d-%m-%Y') AS booking_date, DATE_FORMAT(b.service_date, '%d-%m-%Y') AS service_date, b.time_slot, s.service_name, b.assigned_mechanic, b.complaints FROM bookings AS b INNER JOIN vehicle_make AS mk ON mk.make_id=b.vehicle_make INNER JOIN vehicle_model AS md ON md.model_id=b.vehicle_model INNER JOIN service_category AS s ON s.id=b.service_category_id WHERE b.created_on>='".$start_date1."' AND b.created_on<='".$end_date1."'");
		 
		 
		//if($BookData->num_rows > 0){
		if(!empty($BookData)){ 
     
    		
		 $bookdatas  = $BookData->result_array();
			
			
        //$empInfo = $this->export->mechanicList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
			
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Booking Id');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Status'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Channel');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Mobile'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'City');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Area');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Make'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Model'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Booking Date'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Service Date'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Time'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Service');  
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Customer Address'); 
        // set Row
         
			
    //set column headers
			 
			
   
     $rowCount = 2;
    //output each row of the data, format line as csv and write to file pointer
    foreach ($bookdatas as $row){
		
		 
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row['booking_id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['status']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row['customer_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row['customer_channel']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row['customer_mobile']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row['customer_city']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row['customer_area']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row['make_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row['model_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row['booking_date']);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row['service_date']);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row['time_slot']);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row['service_name']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row['customer_address']);
		
            $rowCount++;
		
		
		
	 
		
    }
    
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('uploads/images/'.$ReportFileName);
    // download file
        header("Content-Type: application/vnd.ms-excel"); 
        redirect(base_url()."uploads/images/".$ReportFileName);  
		exit(); 
}
 
		  exit(); 
        
    }
	
	
	
	
	// Get Leads
    public function leadslog()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

         
        $data['start'] = $start_date;
        $data['end'] = $end_date; 
        $this->header();
        //print_r($data);
        $this->load->view('reports/leadslog',$data);
        $this->footer();
    }
	
	
	public function export_leadslog()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

         
 
		 $ReportFileName = 'Leads Log-'.date('d-m-Y').'.xlsx';  
    // load excel library
        $this->load->library('excel');	
  
		
		 $BookData = $this->db->query("SELECT * FROM leads WHERE DATE_FORMAT(created_on, '%Y-%m-%d') >='".$start_date1."' AND DATE_FORMAT(created_on, '%Y-%m-%d') <='".$end_date1."' AND archived=0");
		 
		 
		//if($BookData->num_rows > 0){
		if(!empty($BookData)){ 
     
    		
		 $bookdatas  = $BookData->result_array();
			
			
        //$empInfo = $this->export->mechanicList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
			
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Lead Id');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Site Booking Id');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Converted'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Source');  
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Medium'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Campaign');  
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Owner');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Mobile'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Address');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Area');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Google Map');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Pincode');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Make'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Model'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Service Category'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Desired Service Date'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Desired Service Time');
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Esitmated Amount'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Specific Spares'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Specific Repairs');
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Existing Customer');
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Complaints');   
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Comments');  
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Status');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Created On');
        // set Row
         
			
    //set column headers
			 
			
   
     $rowCount = 2;
    //output each row of the data, format line as csv and write to file pointer
    foreach ($bookdatas as $row){
        
		
		 
  				$makeID = $row['make'];
				$modelID = $row['model'];
				 
				$getmake  = $this->db->query("SELECT make_name FROM vehicle_make WHERE make_id = '".$modelID."'")->row();
				if(!empty($getmake->make_name)){ 
				$thismake = $getmake->make_name;
				}else{
				$thismake = '';	
				}
				$getmodel  = $this->db->query("SELECT model_name FROM vehicle_model WHERE model_id = '".$makeID."'")->row();
				if(!empty($getmodel->model_name)){ 
				$thismodel = $getmodel->model_name;
		 		}else{
				$thismodel = '';	
				}
		
		 
			
		 
		 
		 
		 
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row['id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['site_booking_id']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row['converted']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row['source']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row['medium']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row['campaign']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row['owner']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row['mobile']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row['email']);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row['address']);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row['area']);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row['google_map']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row['pincode']);
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $thismake);
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $thismodel);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $row['service_category']);
			$objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $row['desired_service_date']); 
			$objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $row['desired_service_time']);
			$objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $row['estimated_amount']); 
			$objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $row['specific_spares']); 
			$objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $row['specific_repairs']);
			$objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $row['existing_customer']);
			$objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $row['complaints']);   
			$objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $row['comments']);  
			$objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $row['status']);   
			$objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, date('d-m-Y', strtotime($row['created_on'])));
		
            $rowCount++;
		
		
		
	 
		
    }
    
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('uploads/images/'.$ReportFileName);
    // download file
        header("Content-Type: application/vnd.ms-excel"); 
        redirect(base_url()."uploads/images/".$ReportFileName);  
		exit(); 
}
 
		  exit(); 
        
    }
	
	
	public function archivedleadslog()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

         
        $data['start'] = $start_date;
        $data['end'] = $end_date; 
        $this->header();
        //print_r($data);
        $this->load->view('reports/archivedleadslog',$data);
        $this->footer();
    }
	
	
	public function export_archivedleadslog()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

         
 
		 $ReportFileName = 'Archived Leads Log-'.date('d-m-Y').'.xlsx';  
    // load excel library
        $this->load->library('excel');	
  
		
		 $BookData = $this->db->query("SELECT * FROM leads WHERE DATE_FORMAT(created_on, '%Y-%m-%d') >='".$start_date1."' AND DATE_FORMAT(created_on, '%Y-%m-%d') <='".$end_date1."' AND archived=1");
		 
		 
		//if($BookData->num_rows > 0){
		if(!empty($BookData)){ 
     
    		
		 $bookdatas  = $BookData->result_array();
			
			
        //$empInfo = $this->export->mechanicList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
			
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Lead Id');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Site Booking Id');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Converted'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Source');  
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Medium'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Campaign');  
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Owner');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Mobile'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Address');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Area');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Google Map');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Pincode');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Make'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Model'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Service Category'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Desired Service Date'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Desired Service Time');
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Esitmated Amount'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Specific Spares'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Specific Repairs');
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Existing Customer');
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Complaints');   
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Comments');  
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Status');   
        $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Created On');
        // set Row
         
			
    //set column headers
			 
			
   
     $rowCount = 2;
    //output each row of the data, format line as csv and write to file pointer
    foreach ($bookdatas as $row){
        
		
		 
  				$makeID = $row['make'];
				$modelID = $row['model'];
				 
				$getmake  = $this->db->query("SELECT make_name FROM vehicle_make WHERE make_id = '".$modelID."'")->row();
				if(!empty($getmake->make_name)){ 
				$thismake = $getmake->make_name;
				}else{
				$thismake = '';	
				}
				$getmodel  = $this->db->query("SELECT model_name FROM vehicle_model WHERE model_id = '".$makeID."'")->row();
				if(!empty($getmodel->model_name)){ 
				$thismodel = $getmodel->model_name;
		 		}else{
				$thismodel = '';	
				}
		
		 
			
		 
		 
		 
		 
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row['id']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['site_booking_id']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row['converted']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row['source']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row['medium']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row['campaign']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row['owner']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row['mobile']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row['email']);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row['address']);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row['area']);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row['google_map']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row['pincode']);
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $thismake);
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $thismodel);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $row['service_category']);
			$objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $row['desired_service_date']); 
			$objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $row['desired_service_time']);
			$objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $row['estimated_amount']); 
			$objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $row['specific_spares']); 
			$objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $row['specific_repairs']);
			$objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $row['existing_customer']);
			$objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $row['complaints']);   
			$objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $row['comments']);  
			$objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $row['status']);   
			$objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, date('d-m-Y', strtotime($row['created_on'])));
		
            $rowCount++;
		
		
		
	 
		
    }
    
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('uploads/images/'.$ReportFileName);
    // download file
        header("Content-Type: application/vnd.ms-excel"); 
        redirect(base_url()."uploads/images/".$ReportFileName);  
		exit(); 
}
 
		  exit(); 
        
    }
	
	public function billingreport()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

         
        $data['start'] = $start_date;
        $data['end'] = $end_date; 
        $this->header();
        //print_r($data);
        $this->load->view('reports/billingreport',$data);
        $this->footer();
    }
	
	public function export_billingreport()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

         
 
		 $ReportFileName = 'Billing Export-'.date('d-m-Y').'.xlsx';  
    // load excel library
        $this->load->library('excel');	
  
		
		 $BookData = $this->db->query("SELECT b.booking_id, b.status, b.customer_type, b.customer_name, b.customer_channel, b.customer_mobile, b.customer_email, b.customer_address, b.customer_city, b.customer_area, b.comments, b.remark, mk.make_name, md.model_name, DATE_FORMAT(b.created_on, '%d-%m-%Y') AS booking_date, DATE_FORMAT(b.service_date, '%d-%m-%Y') AS service_date, b.time_slot, s.service_name, b.assigned_mechanic, b.complaints FROM bookings AS b INNER JOIN vehicle_make AS mk ON mk.make_id=b.vehicle_make INNER JOIN vehicle_model AS md ON md.model_id=b.vehicle_model INNER JOIN service_category AS s ON s.id=b.service_category_id WHERE b.status='Completed' AND b.service_date>='".$start_date1."' AND b.service_date<='".$end_date1."'");
		 
		 
		//if($BookData->num_rows > 0){
		if(!empty($BookData)){ 
     
    		
		 $bookdatas  = $BookData->result_array();
			
			
        //$empInfo = $this->export->mechanicList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
			
			



			
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Booking Id'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Channel'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'City');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Area'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Invoice Value'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Amount Collected'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Type');	
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Invoiced Line Item');  
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Item HSN'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Total Amount');  
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Invoiced Line Item Spares Cost');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Invoiced Line Item Labour Cost');
        // set Row
         
			
    //set column headers
			 
			
   
     $rowCount = 2;
    //output each row of the data, format line as csv and write to file pointer
    foreach ($bookdatas as $row){
       // $status = ($row['status'] == '1')?'Active':'Inactive';
		 
		
		$booking_id=$row['booking_id'];
		
		
		
		$inv_val_q  = $this->db->query("SELECT estimated_amount, total_amount FROM booking_payments WHERE booking_id='".$booking_id."'")->row();
		if(!empty($inv_val_q)){
			$inv_val = $inv_val_q->estimated_amount;
			$amt_coll = $inv_val_q->total_amount;
		}else{
			$inv_val = '';
			$amt_coll = '';
		}
		$pay_mode_q  = $this->db->query("SELECT payment_mode FROM booking_payments WHERE booking_id='".$booking_id."'")->row();
		if(!empty($pay_mode_q)){
			$pay_mode = $pay_mode_q->payment_mode;
			 
		}else{
			$pay_mode = '';
			 
		}
		
		
		$service_category_Q  = $this->db->query("SELECT * FROM jobcard_details WHERE status='Active' AND complaints='Service Category' AND  booking_id='".$row['booking_id'] ."'")->row();
		 
		
		if(!empty($service_category_Q)){ 
		$service_category_name = $service_category_Q->item;
		$service_category_rate = $service_category_Q->amount;
		}else{
		$service_category_name = '';
		$service_category_rate = '0';
		}
		
		
		
		///////////// SERVICE CATEGORY
		$service_category_Q  =  $this->db->query("SELECT * FROM jobcard_details WHERE status='Active' AND complaints='Service Category' AND  booking_id='".$row['booking_id'] ."'")->result();
		foreach($service_category_Q as $service_category){ 
		
			if(!empty($service_category)){ 
		
			  
				$itemhsn  =  $this->db->query("SELECT * FROM item WHERE item_name='".$service_category->item."'")->row();
				
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row['booking_id']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['customer_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row['customer_channel']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row['customer_city']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row['customer_area']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $inv_val);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $amt_coll); 
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'Service Category');	
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $service_category->item);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, @$itemhsn->hsn_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $service_category->amount); 
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $service_category->spares_rate);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $service_category->labour_rate);
		
            $rowCount++;
			
			
			} 
			
		}
		
		///////////// ADDITIONAL SPARE 
		$addt_spares_q  =  $this->db->query("SELECT * FROM jobcard_details WHERE status='Active' AND item_type='Spare' AND  booking_id='".$row['booking_id'] ."'")->result();
		foreach($addt_spares_q as $addt_spares){ 
		
			if(!empty($addt_spares)){ 
		
			 $itemhsn  =  $this->db->query("SELECT * FROM item WHERE item_name='".$addt_spares->item."'")->row();
			
				
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row['booking_id']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['customer_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row['customer_channel']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row['customer_city']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row['customer_area']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $inv_val);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $amt_coll);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'Additional Spares');	
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $addt_spares->item);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, @$itemhsn->hsn_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $addt_spares->amount); 
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $addt_spares->spares_rate);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $addt_spares->labour_rate);
		
            $rowCount++;
			
			
			} 
			
		}
		
		 
		///////////// ADDITIONAL REPAIRS 
		$addt_repairs_q  = $this->db->query("SELECT * FROM jobcard_details WHERE status='Active' AND item_type='Labour' AND  booking_id='".$row['booking_id'] ."'")->result();
		foreach($addt_repairs_q as $addt_repairs){ 
		
			if(!empty($addt_repairs)){ 
		
			 $itemhsn  =  $this->db->query("SELECT * FROM item WHERE item_name='".$addt_repairs->item."'")->row();
				
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row['booking_id']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['customer_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row['customer_channel']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row['customer_city']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row['customer_area']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $inv_val);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $amt_coll); 
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'Additional Repair');	
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $addt_repairs->item);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, @$itemhsn->hsn_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $addt_repairs->amount); 
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $addt_repairs->spares_rate);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $addt_repairs->labour_rate);
		
            $rowCount++;
			
			
			} 
			
		}
		
		
		$addt_complaints_q  = $this->db->query("SELECT * FROM jobcard_details WHERE status='Active' AND item_type='Complaints' AND  booking_id='".$row['booking_id'] ."'")->result();
		foreach($addt_complaints_q as $addt_complaints){ 
		
			if(!empty($addt_complaints)){ 
		
			 $itemhsn  =  $this->db->query("SELECT * FROM item WHERE item_name='".$addt_complaints->item."'")->row();
				
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row['booking_id']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['customer_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row['customer_channel']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row['customer_city']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row['customer_area']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $inv_val);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $amt_coll);  
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'Complaints');	
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $addt_complaints->item);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, @$itemhsn->hsn_no);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $addt_complaints->amount); 
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $addt_complaints->spares_rate);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $addt_complaints->labour_rate);
		
            $rowCount++;
			
			
			} 
			
		}
		
		  
		
	 
		
    }
    
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('uploads/images/'.$ReportFileName);
    // download file
        header("Content-Type: application/vnd.ms-excel"); 
        redirect(base_url()."uploads/images/".$ReportFileName);  
		exit(); 
}
 
		  exit(); 
        
    }
	
	public function spareslog()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

         
        $data['start'] = $start_date;
        $data['end'] = $end_date; 
        $this->header();
        //print_r($data);
        $this->load->view('reports/spareslog',$data);
        $this->footer();
    }
	
	public function export_spareslog()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

         
 
		 $ReportFileName = 'Spares Log-'.date('d-m-Y').'.xlsx';  
    // load excel library
        $this->load->library('excel');	
  
		
		 $BookData = $this->db->query("SELECT b.booking_id, b.status, b.customer_type, b.customer_name, b.customer_channel, b.customer_mobile, b.customer_email, b.customer_address, b.customer_city, b.customer_area, b.comments, b.remark, mk.make_name, md.model_name, DATE_FORMAT(b.created_on, '%d-%m-%Y') AS booking_date, DATE_FORMAT(b.service_date, '%d-%m-%Y') AS service_date, b.time_slot, s.service_name, b.assigned_mechanic, b.complaints FROM bookings AS b INNER JOIN vehicle_make AS mk ON mk.make_id=b.vehicle_make INNER JOIN vehicle_model AS md ON md.model_id=b.vehicle_model INNER JOIN service_category AS s ON s.id=b.service_category_id WHERE b.status='Completed' AND b.service_date>='".$start_date1."' AND b.service_date<='".$end_date1."'");
		 
		 
		//if($BookData->num_rows > 0){
		if(!empty($BookData)){ 
     
    		
		 $bookdatas  = $BookData->result_array();
			
			
        //$empInfo = $this->export->mechanicList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
			
			



			
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Booking Id');  
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'City');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Area'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Service Date');  
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Make');  
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Model');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Spares List');
        // set Row
         
			
    //set column headers
			 
			
   
     $rowCount = 2;
    //output each row of the data, format line as csv and write to file pointer
    foreach ($bookdatas as $row){
       // $status = ($row['status'] == '1')?'Active':'Inactive';
		 
		
		$booking_id=$row['booking_id'];
		
		
		
	 
		
		
		$spareslist_Q  = $this->db->query("SELECT * FROM jobcard_details WHERE status='Active' AND item_type!='Service Category' AND  booking_id='".$row['booking_id'] ."'")->result();
		 $spares_name = '';
		foreach($spareslist_Q as $spareslist){ 
		if(!empty($spareslist)){ 
		$spares_name .= $spareslist->item.' | '; 
		} 
		}
		
		
		 
		
			 
		
			  
				
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row['booking_id']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row['customer_city']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row['customer_area']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, date('d-m-Y', strtotime($row['service_date'])));
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row['make_name']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row['model_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $spares_name);  
		
            $rowCount++;
			
			
		 
			
		 
		
		 
		
		  
		
	 
		
    }
    
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('uploads/images/'.$ReportFileName);
    // download file
        header("Content-Type: application/vnd.ms-excel"); 
        redirect(base_url()."uploads/images/".$ReportFileName);  
		exit(); 
}
 
		  exit(); 
        
    }
	
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////// .  Complaints Log
	
	// Get Leads
    public function complaintslog()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

         
        $data['start'] = $start_date;
        $data['end'] = $end_date; 
        $this->header();
        //print_r($data);
        $this->load->view('reports/complaintslog',$data);
        $this->footer();
    }
	
	
	
	
	public function export_complaintslog()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

         
 
		 $ReportFileName = 'Complaints Log-'.date('d-m-Y').'.xlsx';  
    // load excel library
        $this->load->library('excel');	
  
		
		 $BookData = $this->db->query("SELECT * FROM customer_complaints WHERE DATE_FORMAT(created_on, '%Y-%m-%d') >='".$start_date1."' AND DATE_FORMAT(created_on, '%Y-%m-%d') <='".$end_date1."'");
		 
		 
		//if($BookData->num_rows > 0){
		if(!empty($BookData)){ 
     
    		
		 $bookdatas  = $BookData->result_array();
			
			
        //$empInfo = $this->export->mechanicList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
			
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Booking Id');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Service Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Customer Name'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Channel');  
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Mechanic'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Status');  
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'No Of Days');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Complaint Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Complaint Time'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Reason');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Created By');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Revisit');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'ReOpen');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Closure Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Closed By');  
        // set Row
         
			
    //set column headers
			 
			
   
     $rowCount = 2;
    //output each row of the data, format line as csv and write to file pointer
    foreach ($bookdatas as $row){
        
		
		 
  				$booking_id = $row['booking_id'];
				$getbooking  = $this->db->query("SELECT * FROM bookings WHERE booking_id = '".$booking_id."'")->row();
				 $service_date = date('d-m-Y', strtotime($getbooking->service_date));
				 $customer_name = $getbooking->customer_name;
				 $channel = $getbooking->customer_channel;
				 
		
		if(!empty($getbooking->assigned_mechanic) || $getbooking->assigned_mechanic!=0){ 
			$mechanic_name  = @get_service_providers(array('id'=>$getbooking->assigned_mechanic),'name');
			 
		}else{
			$mechanic_name  = '';
		}
		
				 $status = $row['status'];
				 $complaint_date = date('d-m-Y', strtotime($row['created_on']));
				 $complaint_time = date('H:i:s', strtotime($row['created_on']));
				 $complaint  = $row['complaints'];
		 			 
				$createdBy = @get_users(array('id'=>$row['created_by']),'firstname');
				 
					 
					$getallrevisit = $this->db->query("SELECT COUNT(id) AS revisited FROM customer_complaints_track WHERE action='Re-Visit' AND complaints_id = '".$row['id']."'")->row();
					if(!empty($getallrevisit->revisited) && $getallrevisit->revisited>0){
					$getfollow = $this->db->query("SELECT * FROM customer_complaints_track WHERE action='Re-Visit' AND complaints_id = '".$row['id']."' ORDER BY id DESC")->row();
						$follow_booking_id = $getfollow->follow_booking_id;
						$revisit = 'Yes';	
					}else{
						$follow_booking_id = '';
						$revisit = 'No';	
					}
		 		
				$getallreopen = $this->db->query("SELECT COUNT(id) AS reopened FROM customer_complaints_track WHERE action='Re-Open' AND complaints_id = '".$row['id']."'")->row();
					if(!empty($getallreopen->reopened) && $getallreopen->reopened>0){
					 
						$reopen = 'Yes';	
					}else{
						 
						$reopen = 'No';	
					}
				if($status == 'Close'){
					$getclosedate = $this->db->query("SELECT * FROM customer_complaints_track WHERE action='Close' AND complaints_id = '".$row['id']."' ORDER BY id DESC")->row();
					$closedate = date('d-m-Y', strtotime($getclosedate->created_on));
					
					$closeBy = @get_users(array('id'=>$getclosedate->created_by),'firstname');
				 
						
				}else{
					$closedate = '';
					$closeBy = '';	
				}
		 		
		
		
		
				if(!empty($closedate)){  
					$start_date = strtotime($complaint_date);
					$end_date = strtotime($closedate);
		 		$noofdays = ($end_date - $start_date)/60/60/24;
				}else{
					$noofdays = 0;
				}
				
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $booking_id);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $service_date); 
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $customer_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $channel);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $mechanic_name); 
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $status);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $noofdays);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $complaint_date);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $complaint_time);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $complaint);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $createdBy);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $revisit);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $reopen); 
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $closedate);
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $closeBy); 
		
            $rowCount++;
		
		
		
	 
		
    }
    
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('uploads/images/'.$ReportFileName);
    // download file
        header("Content-Type: application/vnd.ms-excel"); 
        redirect(base_url()."uploads/images/".$ReportFileName);  
		exit(); 
}
 
		  exit(); 
        
    }
	
	
	
	// Assigned Items
    public function view_spares_recon()
    {
		
		 $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

         
        $data['start'] = $start_date;
        $data['end'] = $end_date; 
		
		$city_selected = $this->input->post('city_selected');
		
		if(!empty($city_selected)){
		$data['city_selected'] =	$city_selected;
		}else{
		$data['city_selected'] = '';	
		}
		
      //  $data['bookings'] = $this->db->query("SELECT * FROM bookings WHERE status='Assigned'")->result();
        $data['customers'] = $this->Common->select('customer');
		$data['cities'] = $this->Common->select('city');
		$data['complaints'] = $this->Common->select('complaints'); 
		$data['service_categories'] = $this->db->query("SELECT  service_name FROM service_category GROUP BY service_name")->result(); 
        $this->header();
        $this->load->view('reports/view_spares_recon', $data);
        $this->footer();


    }
	
	
	public function export_spares_recon()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_date1 = date('Y-m-d', strtotime($start_date));
        $end_date1 = date('Y-m-d', strtotime($end_date));

         
 
		 $ReportFileName = 'Spares Recon Log-'.date('d-m-Y').'.xlsx';  
    // load excel library
        $this->load->library('excel');	
  
		
		 $ReconDataQ = $this->db->query("SELECT sr.* FROM spares_recon AS sr INNER JOIN bookings AS bk ON sr.booking_id=bk.booking_id WHERE DATE_FORMAT(bk.service_date, '%Y-%m-%d') >='".$start_date1."' AND DATE_FORMAT(bk.service_date, '%Y-%m-%d') <='".$end_date1."' GROUP BY sr.id");
		 
		 
		//if($BookData->num_rows > 0){
		if(!empty($ReconDataQ)){ 
     
    		
		 $ReconData  = $ReconDataQ->result_array();
			
			
        //$empInfo = $this->export->mechanicList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
			
		
			
			
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Booking Id');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Service Date');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Service Category');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Customer Name'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Channel');  
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'City'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Mechanic');   
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Make');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Model'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Invoice Value');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Amount Collected');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Spares Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Brand');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Qty');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Assigned');
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Invoiced');   
        // set Row
         
			
    //set column headers
			 
			
   
     $rowCount = 2;
    //output each row of the data, format line as csv and write to file pointer
    foreach ($ReconData as $row){
        
		
		 	
				
					
  				$booking_id = $row['booking_id'];
								$getbooking  = $this->db->query("SELECT * FROM bookings WHERE booking_id = '".$booking_id."'")->row();
				
				 $service_date = date('d-m-Y', strtotime($getbooking->service_date));
				
								$getservice_category   = $this->db->query("SELECT service_name FROM service_category WHERE id='".$getbooking->service_category_id."'")->row();
				 $service_category  = $getservice_category->service_name;
		
		
				$customer_name = $getbooking->customer_name;
		
				 $channel = $getbooking->customer_channel;
		
				$city = $getbooking->customer_city;
		
		if(!empty($getbooking->assigned_mechanic) || $getbooking->assigned_mechanic!=0){ 
			$mechanic_name  = @get_service_providers(array('id'=>$getbooking->assigned_mechanic),'name');
			 
		}else{
			$mechanic_name  = '';
		}
		
				 
		
		
				 $getmake_name   = $this->db->query("SELECT make_name FROM vehicle_make WHERE make_id='".$getbooking->vehicle_make."'")->row();
							$make_name  = $getmake_name->make_name;
		 
		 $getmodel_name   = $this->db->query("SELECT model_name FROM vehicle_model WHERE model_id='".$getbooking->vehicle_model."'")->row();
							$model_name  = $getmodel_name->model_name;
		
		
		
		       $inv_val_q  = $this->db->query("SELECT estimated_amount, total_amount FROM booking_payments WHERE booking_id='".$booking_id."'")->row();
		if(!empty($inv_val_q)){
			$inv_val = $inv_val_q->estimated_amount;
			$amt_coll = $inv_val_q->total_amount;
		}else{
			$inv_val = '';
			$amt_coll = '';
		}
		 
		
		if($row['assigned']==1){ 
					$assigned = "Yes";
					}else{
					$assigned = "No";	
					}
		
				  
				 
		 			$getjobcard_det  = $this->db->query("SELECT * FROM jobcard_details WHERE id = '".$row['jobcard_details_id']."'")->row();
				if(!empty($getjobcard_det->id)){ 
					
					if($getjobcard_det->status=='Active'){ 
					$invoiced = "Yes";
					}else{
					$invoiced = "No";	
					}
				}else{
				$invoiced = '';	
				}
					 
				 
						
			//	$booking_id,  $service_date, $service_category, $customer_name, $channel, $city, $mechanicname,  $make_name, $model_name, $inv_val, $amt_coll, Spares Name, Qty, Brand, Assigend, Invoiced	  
				
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $booking_id);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $service_date); 
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $service_category);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $customer_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $channel); 
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $city);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $mechanic_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $make_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $model_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $inv_val);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $amt_coll);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row['item']);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row['brand']); 
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row['qty']); 										 
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $assigned);
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $invoiced); 
		
            $rowCount++;
		
		
		
	 
		
    }
    
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('uploads/images/'.$ReportFileName);
    // download file
        header("Content-Type: application/vnd.ms-excel"); 
        redirect(base_url()."uploads/images/".$ReportFileName);  
		exit(); 
}
 
		  exit(); 
        
    }

}