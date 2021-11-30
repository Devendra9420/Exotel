<?php 
																  
							 
							$sql = $this->db->select("claims.name,
		 claims.claim_no,
		gic.GIC_NAME,
		city.cityname,
		claims.status,
		claims.created_on,
		claims.surveyed_on,
		claims.estimated_on,
		claims.repair_startdate,
		claims.repair_type,
		claims.invoice_date,
		claims.estimate_total,
		claims.approved_total,
		claims.service_provider FROM claims INNER JOIN gic on claims.gic = gic.GIC_ID INNER JOIN city on claims.city = city.city_id WHERE claims.created_on >='".$start."' AND claims.created_on <= '".$end."'")->get();
             
            
 
	 
		 
        $data[] = $sql->result();									  
							
							 $colnames = array(
    'name' => "Insure name",
    'claim_no' => "Claim No",
    'status' => "Status", 
    'created_no' => "Date Of Creation", 
    'surveyed_on' => "Date Of Survey", 
    'estimated_on' => "Date Of Estimate",
    'repair_startdate' => "Repair Start Date",
    'repair_type' => "Repair Type",
    'invoice_date' => "Date Of Invoice",
    'estimate_total' => "Estimated Amount",
    'approved_total' => "Approved Amount", 
    'service_provider' => "Service Provider",
  );

  function map_colnames($input)
  {
    global $colnames;
    return isset($colnames[$input]) ? $colnames[$input] : $input;
  }

  function cleanData(&$str)
  {
    if($str == 't') $str = 'TRUE';
    if($str == 'f') $str = 'FALSE';
    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
      $str = "'$str";
    }
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  $filename = "Claim_Report_" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv");

  $out = fopen("php://output", 'w');

  $flag = false;
  foreach($data as $row) {
    if(!$flag) {
      // display field/column names as first row
      $firstline = array_map(__NAMESPACE__ . '\map_colnames', array_keys($row));
      fputcsv($out, $firstline, ',', '"');
      $flag = true;
    }
    array_walk($row, __NAMESPACE__ . '\cleanData');
    fputcsv($out, array_values($row), ',', '"');
  }

  fclose($out);
  exit;
							?>