<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GarageWorks Booking Confirmation</title>
  
    <style type="text/css">
      a { text-decoration: none; outline: none; }
      @media (max-width: 649px) {
        .o_col-full { max-width: 100% !important; }
        .o_col-half { max-width: 50% !important; }
        .o_hide-lg { display: inline-block !important; font-size: inherit !important; max-height: none !important; line-height: inherit !important; overflow: visible !important; width: auto !important; visibility: visible !important; }
        .o_hide-xs, .o_hide-xs.o_col_i { display: none !important; font-size: 0 !important; max-height: 0 !important; width: 0 !important; line-height: 0 !important; overflow: hidden !important; visibility: hidden !important; height: 0 !important; }
        .o_xs-center { text-align: center !important; }
        .o_xs-left { text-align: left !important; }
        .o_xs-right { text-align: left !important; }
        table.o_xs-left { margin-left: 0 !important; margin-right: auto !important; float: none !important; }
        table.o_xs-right { margin-left: auto !important; margin-right: 0 !important; float: none !important; }
        table.o_xs-center { margin-left: auto !important; margin-right: auto !important; float: none !important; }
        h1.o_heading { font-size: 32px !important; line-height: 41px !important; }
        h2.o_heading { font-size: 26px !important; line-height: 37px !important; }
        h3.o_heading { font-size: 20px !important; line-height: 30px !important; }
        .o_xs-py-md { padding-top: 24px !important; padding-bottom: 24px !important; }
        .o_xs-pt-xs { padding-top: 8px !important; }
        .o_xs-pb-xs { padding-bottom: 8px !important; }
      }
      @media screen {
        @font-face {
          font-family: 'Roboto';
          font-style: normal;
          font-weight: 400;
          src: local("Roboto"), local("Roboto-Regular"), url(https://fonts.gstatic.com/s/roboto/v18/KFOmCnqEu92Fr1Mu7GxKOzY.woff2) format("woff2");
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF; }
        @font-face {
          font-family: 'Roboto';
          font-style: normal;
          font-weight: 400;
          src: local("Roboto"), local("Roboto-Regular"), url(https://fonts.gstatic.com/s/roboto/v18/KFOmCnqEu92Fr1Mu4mxK.woff2) format("woff2");
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; }
        @font-face {
          font-family: 'Roboto';
          font-style: normal;
          font-weight: 700;
          src: local("Roboto Bold"), local("Roboto-Bold"), url(https://fonts.gstatic.com/s/roboto/v18/KFOlCnqEu92Fr1MmWUlfChc4EsA.woff2) format("woff2");
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF; }
        @font-face {
          font-family: 'Roboto';
          font-style: normal;
          font-weight: 700;
          src: local("Roboto Bold"), local("Roboto-Bold"), url(https://fonts.gstatic.com/s/roboto/v18/KFOlCnqEu92Fr1MmWUlfBBc4.woff2) format("woff2");
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD; }
        .o_sans, .o_heading { font-family: "Roboto", sans-serif !important; }
        .o_heading, strong, b { font-weight: 700 !important; }
        a[x-apple-data-detectors] { color: inherit !important; text-decoration: none !important; }
      }
		
		
		 



 
.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 1rem;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #eceeef;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #eceeef;
}

.table tbody + tbody {
  border-top: 2px solid #eceeef;
}

.table .table {
  background-color: #fff;
}

.table-sm th,
.table-sm td {
  padding: 0.3rem;
}

.table-bordered {
  border: 1px solid #eceeef;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #eceeef;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}

.table-hover tbody tr:hover {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-active,
.table-active > th,
.table-active > td {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-hover .table-active:hover {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-hover .table-active:hover > td,
.table-hover .table-active:hover > th {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-success,
.table-success > th,
.table-success > td {
  background-color: #dff0d8;
}

.table-hover .table-success:hover {
  background-color: #d0e9c6;
}

.table-hover .table-success:hover > td,
.table-hover .table-success:hover > th {
  background-color: #d0e9c6;
}

.table-info,
.table-info > th,
.table-info > td {
  background-color: #d9edf7;
}

.table-hover .table-info:hover {
  background-color: #c4e3f3;
}

.table-hover .table-info:hover > td,
.table-hover .table-info:hover > th {
  background-color: #c4e3f3;
}

.table-warning,
.table-warning > th,
.table-warning > td {
  background-color: #fcf8e3;
}

.table-hover .table-warning:hover {
  background-color: #faf2cc;
}

.table-hover .table-warning:hover > td,
.table-hover .table-warning:hover > th {
  background-color: #faf2cc;
}

.table-danger,
.table-danger > th,
.table-danger > td {
  background-color: #f2dede;
}

.table-hover .table-danger:hover {
  background-color: #ebcccc;
}

.table-hover .table-danger:hover > td,
.table-hover .table-danger:hover > th {
  background-color: #ebcccc;
}

.thead-inverse th {
  color: #fff;
  background-color: #292b2c;
}

.thead-default th {
  color: #464a4c;
  background-color: #eceeef;
}

.table-inverse {
  color: #fff;
  background-color: #292b2c;
}

.table-inverse th,
.table-inverse td,
.table-inverse thead th {
  border-color: #fff;
}

.table-inverse.table-bordered {
  border: 0;
}

.table-responsive {
  display: block;
  width: 100%;
  overflow-x: auto;
  -ms-overflow-style: -ms-autohiding-scrollbar;
}

.table-responsive.table-bordered {
  border: 0;
}

.list-group {
   
  padding-left: 0;  
  margin-bottom: 20px;
}

 

.list-group-item {
  position: relative;
  display: block;
  padding: 10px 15px;
   
  margin-bottom: -1px;
  background-color: #fff;
  border: 1px solid #ddd;
 
}	
		
.list-group-item-info {
    color: #31708f;
    background-color: #d9edf7;
}
		
    </style>
    <!--[if mso]>
    <style>
      table { border-collapse: collapse; }
      .o_col { float: left; }
    </style>
    <xml>
      <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
  </head>
  <body class="o_body o_bg-light" style="width: 100%;margin: 0px;padding: 0px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background-color: #dbe5ea;">
    <!-- preview-text -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
      <tbody>
        <tr>
          <td class="o_hide" align="center" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">Email Summary (Hidden)</td>
        </tr>
      </tbody>
    </table>
    <!-- header-button -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
      <tbody>
        <tr>
          <td class="o_bg-light o_px-xs o_pt-lg o_xs-pt-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;padding-top: 32px;">
            <!--[if mso]><table width="800" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
            <table class="o_block-lg" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">
              <tbody>
                <tr>
                  <td class="o_re o_bg-dark o_px o_pb-md o_br-t" align="center" style="font-size: 0;vertical-align: top;background-color: #242b3d;border-radius: 4px 4px 0px 0px;padding-left: 16px;padding-right: 16px;">
                    <p style="margin: auto;"><a class="o_text-white" href="https://garageworks.in/" style="text-decoration: none;outline: none;color: #ffffff;"><img src="<?= base_url() ?>assets/images/emailer/logo.png" width="136" height="36" alt="GarageWorks" style="display: block;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a></p>
                  </td>
                </tr>
              </tbody>
            </table>
            <!--[if mso]></td></tr></table><![endif]-->
          </td>
        </tr>
      </tbody>
    </table>
    <!-- hero-icon-outline -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
      <tbody>
        <tr>
          <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
            <!--[if mso]><table width="800" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
            <table class="o_block-lg" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">
              <tbody>
                <tr>
                  <td class="o_bg-ultra_light o_px-md o_py-xl o_xs-py-md" align="center" style="background-color: #ebf5fa;padding-left: 24px;padding-right: 24px;padding-top: 64px;padding-bottom: 64px;">
                    <!--[if mso]><table width="584" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td align="center"><![endif]-->
                    <div class="o_col-6s o_center o_sans o_text-md o_text-light" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 19px;line-height: 28px;max-width: 584px;color: #82899a;text-align: center;">
                      <table class="o_center" cellspacing="0" cellpadding="0" border="0" role="presentation" style="text-align: center;margin-left: auto;margin-right: auto;">
                        <tbody>
                          <tr>
                            <td class="o_sans o_text o_text-secondary o_b-primary o_px o_py o_br-max" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;border: 2px solid #126de5;border-radius: 96px;padding-left: 16px;padding-right: 16px;padding-top: 16px;padding-bottom: 16px;">
                              <img src="<?= base_url() ?>assets/images/emailer/25.png" width="48" height="48" alt="" style="max-width: 48px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;">
                            </td>
                          </tr>
                          <tr>
                            <td style="font-size: 24px; line-height: 24px; height: 24px;">&nbsp; </td>
                          </tr>
                        </tbody>
                      </table>
                      <h2 class="o_heading o_text-dark o_mb-xxs" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 30px;line-height: 39px;">New Booking Confirmation</h2>
                      
                    </div>
                    <!--[if mso]></td></tr></table><![endif]-->
                  </td>
                </tr>
              </tbody>
            </table>
            <!--[if mso]></td></tr></table><![endif]-->
          </td>
        </tr>
      </tbody>
    </table>
    <!-- spacer -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
      <tbody>
        <tr>
          <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
            <!--[if mso]><table width="800" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
            <table class="o_block-lg" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">
              <tbody>
                <tr>
                  <td class="o_bg-white" style="font-size: 24px;line-height: 24px;height: 24px;background-color: #ffffff;">&nbsp; </td>
                </tr>
              </tbody>
            </table>
            <!--[if mso]></td></tr></table><![endif]-->
          </td>
        </tr>
      </tbody>
    </table>
    <!-- order-intro -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
      <tbody>
        <tr>
          <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
            <!--[if mso]><table width="800" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
            <table class="o_block-lg" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">
              <tbody>
                <tr>
                  <td class="o_bg-white o_px-md o_py" align="center" style="background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
                    <!--[if mso]><table width="584" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td align="center"><![endif]-->
                    <div class="o_col-6s o_sans o_text o_text-secondary o_center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;max-width: 584px;color: #424651;text-align: center;">
                      <h4 class="o_heading o_text-dark o_mb-xs" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 8px;color: #242b3d;font-size: 18px;line-height: 23px;">Hello, <?php echo $customer_name; ?></h4>
                      <p class="o_mb-md" style="margin-top: 0px;margin-bottom: 24px;">Your service has been booked with GarageWorks. Please refer to the details below:</p>
                      <table align="center" cellspacing="0" cellpadding="0" border="0" role="presentation">
                        <tbody>
                          <tr>
                            <td width="300" class="o_btn o_bg-success o_br o_heading o_text" align="center" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;mso-padding-alt: 12px 24px;background-color: #0ec06e;border-radius: 4px;">
                              <a class="o_text-white" href="" style="text-decoration: none;outline: none;color: #ffffff;display: block;padding: 12px 24px;mso-text-raise: 3px;">Order Id: <?php echo $booking_id; ?></a>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <div style="font-size: 28px; line-height: 28px; height: 28px;">&nbsp; </div>
                      <!-- <h4 class="o_heading o_text-dark o_mb-xxs" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 18px;line-height: 23px;">Order Id: -</h4> -->
                      <p class="o_text-xs o_text-light" style="font-size: 14px;line-height: 21px;color: #82899a;margin-top: 0px;margin-bottom: 0px;">Placed on <?php echo $created_date; ?></p>
                    </div>
                    <!--[if mso]></td></tr></table><![endif]-->
                  </td>
                </tr>
              </tbody>
            </table>
            <!--[if mso]></td></tr></table><![endif]-->
          </td>
        </tr>
      </tbody>
    </table>

    
    <!-- order-details -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
      <tbody>
        <tr>
          <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
            <!--[if mso]><table width="800" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
            <table class="o_block-lg" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">
              <tbody>
                <tr>
                  <td class="o_re o_bg-white o_px o_pb-md" align="center" style="font-size: 0;vertical-align: top;background-color: #ffffff;padding-left: 16px;padding-right: 16px;padding-bottom: 24px;">
                    <!--[if mso]><table cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td width="300" align="center" valign="top" style="padding: 0px 8px;"><![endif]-->
                    <div class="o_col o_col-3 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 300px;">
                      <div style="font-size: 24px; line-height: 24px; height: 24px;">&nbsp; </div>
                      <div class="o_px-xs" style="padding-left: 8px;padding-right: 8px;">
                        <table width="100%" role="presentation" cellspacing="0" cellpadding="0" border="0">
                          <tbody>
                            <tr>
								
								 
								<td class="o_bg-ultra_light o_br o_px o_py o_sans o_text-xs o_text-secondary" align="left" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;background-color: #ebf5fa;color: #424651;border-radius: 4px;padding-left: 16px;padding-right: 16px;padding-top: 16px;padding-bottom: 16px;">
                                <p class="o_mb-xs" style="margin-top: 0px;margin-bottom: 8px;"><strong>Customer Details</strong></p>
                                <p class="o_mb-md" style="margin-top: 0px;margin-bottom: 24px;"><?php echo $customer_name; ?> <br>
                                  Phone: <?php echo $customer_phone; ?><br />
									Alternate No: <?php echo $customer_alternate_no; ?><br />
									Address: <?php echo $customer_address; ?><br />
									</p>
       							<p class="o_mb-xs" style="margin-top: 0px;margin-bottom: 8px;"><strong>Date & Time</strong></p>
                                <p class="o_mb-md" style="margin-top: 0px;margin-bottom: 24px;"><?php echo $service_date; ?> <br>
                                  <?php echo $service_time; ?></p>
									
									
                                <!--<p class="o_mb-xs" style="margin-top: 0px;margin-bottom: 8px;"><strong>Additional Complaints</strong></p>
                                <p style="margin-top: 0px;margin-bottom: 0px;">{Comments}</p>-->
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <!--[if mso]></td><td width="300" align="center" valign="top" style="padding: 0px 8px;"><![endif]-->
                    <div class="o_col o_col-3 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 300px;">
                      <div style="font-size: 24px; line-height: 24px; height: 24px;">&nbsp; </div>
                      <div class="o_px-xs" style="padding-left: 8px;padding-right: 8px;">
                        <table width="100%" role="presentation" cellspacing="0" cellpadding="0" border="0">
                          <tbody>
                            <tr>
                             
                              <td class="o_bg-ultra_light o_br o_px o_py o_sans o_text-xs o_text-secondary" align="left" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;background-color: #ebf5fa;color: #424651;border-radius: 4px;padding-left: 16px;padding-right: 16px;padding-top: 16px;padding-bottom: 16px;">
                                <p class="o_mb-xs" style="margin-top: 0px;margin-bottom: 8px;"><strong>Vehicle Details</strong></p>
                                <p class="o_mb-md" style="margin-top: 0px;margin-bottom: 24px;">Brand: <?php echo $make; ?><br>
                                  Modal: <?php echo $model; ?> 
                                 </p>
                                <p class="o_mb-xs" style="margin-top: 0px;margin-bottom: 8px;"><strong>Service Type</strong></p>
                                <p style="margin-top: 0px;margin-bottom: 0px;"><?php echo $service_category; ?></p>
								  
								 <p class="o_mb-xs" style="margin-top: 0px;margin-bottom: 8px;"><strong>Specific Requirements</strong></p>
                                <p style="margin-top: 0px;margin-bottom: 0px;">Complaints: <?php echo $complaints; ?><br/>
								  Specific Spares:  <?php echo $specific_spares; ?><br/>
								  Specific Repairs:  <?php echo $specific_repairs; ?> 
								  </p>
								  
								  <p class="o_mb-xs" style="margin-top: 0px;margin-bottom: 8px;"><strong>Comments</strong></p>
                                <p class="o_mb-md" style="margin-top: 0px;margin-bottom: 24px;"><?php echo $comments; ?></p>
								  
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    
                    <!--[if mso]></td></tr></table><![endif]-->
                  </td>
                </tr>
              </tbody>
            </table>
            <!--[if mso]></td></tr></table><![endif]-->
          </td>
        </tr>
        
      </tbody>
    </table>
    
    <!-- order-summary -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
      <tbody>
        <tr>
          
          <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
            <!--[if mso]><table width="800" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
            <table class="o_block-lg" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">
              <tbody>
                <tr>
                  <td class="o_bg-white o_sans o_text-xs o_text-light o_px-md o_pt-xs" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;background-color: #ffffff;color: #82899a;padding-left: 24px;padding-right: 24px;padding-top: 8px;">
                    <p style="margin-top: 0px;margin-bottom: 0px;"><strong>Estimated Value:</strong> We will share the estimated jobcard along with cost once our mechanic inspects your vehicle.</p>
                    <table cellspacing="0" cellpadding="0" border="0" role="presentation">
                      <tbody>
                        <tr>
                          <td width="584" class="o_re o_bb-light" style="font-size: 8px;line-height: 8px;height: 8px;vertical-align: top;border-bottom: 1px solid #d3dce0;">&nbsp; </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
            <!--[if mso]></td></tr></table><![endif]-->
          </td>
        </tr>
      </tbody>
    </table>
    <!-- product -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
      <tbody>
        <tr>
          <td class="o_bg-light o_px-xs" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
            
            <!--[if mso]><table width="800" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
            <table class="o_block-lg  table-responsive table-bordered" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">
              <tbody>
                <tr>
                  <td class="o_re o_bg-white o_px o_pt"  style="font-size: 14;vertical-align: top;background-color: #ffffff;padding-left: 16px;padding-right: 16px;padding-top: 16px;">
                      <h4 class="o_heading o_text-dark o_mb-xxs list-group-item list-group-item-info" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 18px;line-height: 23px;">Terms & Conditions:</h4>
                      <a class="list-group-item list-group-item" style="text-align:justify;">1. Mechanic will be assigned a day prior to your service request. You will receive a confirmation email & SMS</a>
                      <a class="list-group-item list-group-item" style="text-align:justify;">2. Services will be delivered as per the Terms & Conditions. To learn more, click here.</a>
                      <a class="list-group-item list-group-item" style="text-align:justify;">3. Our mechanic comes equipped with spares & consumables as per information provided by you. Please ensure you have reported all and any kind of additional work or complaint which you wish the technician to address. If not, please connect with us @ 8806174754 to report the complaints.</a>
                      <a class="list-group-item list-group-item" style="text-align:justify;">4. The booking advance of &#8377; 100 paid by you (if any) is non-refundable if in case you cancel the appointment, delay more than 30 minutes, change the address of the service, refuse to avail the service</a>
                      <a class="list-group-item list-group-item" style="text-align:justify;">5. If you are availing service through coupons please ensure, you have understood the terms & conditions. All terms & conditions mentioned strictly apply.</a>
                      <a class="list-group-item list-group-item" style="text-align:justify;">6. Our team is not allowed to accept bargain requests. All prices are fixed and payable as communicated.</a>
                      <a class="list-group-item list-group-item" style="text-align:justify;">7. Any advances if paid, will be adjusted in the final invoice value</a>
                      <a class="list-group-item list-group-item" style="text-align:justify;">8. We offer our customers multiple payment options via Credit Card, PayTM, UPI </a>
                   
                    <!--[if mso]></td></tr></table><![endif]-->
                  </td>
                </tr>
              </tbody>
            </table>
            <!--[if mso]></td></tr></table><![endif]-->
          </td>
        </tr>
      </tbody>
      
    </table>
  
     <!-- product -->
     <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
      <tbody>
        <tr>
          <td class="o_bg-light o_px-xs" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
            
            <!--[if mso]><table width="800" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
            <table class="o_block-lg" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">
              <tbody>
                <tr>
                  <td class="o_re o_bg-white o_px o_pt"  style="font-size: 14;vertical-align: top;background-color: #ffffff;padding-left: 16px;padding-right: 16px;padding-top: 16px;">
                      <h5 class="o_heading o_text-dark o_mb-xxs list-group-item list-group-item-info" style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 4px;color: #242b3d;font-size: 14px;line-height: 23px;text-align:center;">For any other queries, please feel to contact us at hello@garageworks.in or 8806174754.
                        <br>Team GarageWorks</h5>
                    
                   
                    <!--[if mso]></td></tr></table><![endif]-->
                  </td>
                </tr>
              </tbody>
            </table>
            <!--[if mso]></td></tr></table><![endif]-->
          </td>
        </tr>
      </tbody>
      
    </table>
    <!-- footer-3cols -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
      <tbody>
        <tr>
          <td class="o_bg-light o_px-xs o_pb-lg o_xs-pb-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;padding-bottom: 32px;">
            <!--[if mso]><table width="800" cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td><![endif]-->
            <table class="o_block-lg" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">
              <tbody>
                <tr>
                  <td class="o_re o_bg-dark o_px o_pb-lg" align="center" style="font-size: 0;vertical-align: top;background-color: #242b3d;padding-left: 16px;padding-right: 16px;padding-bottom: 32px;">
                    <!--[if mso]><table cellspacing="0" cellpadding="0" border="0" role="presentation"><tbody><tr><td width="200" align="center" valign="top" style="padding:0px 8px;"><![endif]-->
                    <div class="o_col o_col-2 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 200px;">
                      <div style="font-size: 32px; line-height: 32px; height: 32px;">&nbsp; </div>
                      <div class="o_px-xs o_sans o_text-xs o_center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;text-align: center;padding-left: 8px;padding-right: 8px;">
                        <p style="margin-top: 0px;margin-bottom: 0px;"><a class="o_text-dark_light" href="https://garageworks.in/" style="text-decoration: none;outline: none;color: #a0a3ab;"><strong style="color: #a0a3ab;">Help Center</strong></a></p>
                      </div>
                    </div>
                    <!--[if mso]></td><td width="200" align="center" valign="top" style="padding:0px 8px;"><![endif]-->
                    <div class="o_col o_col-2 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 200px;">
                      <div style="font-size: 24px; line-height: 24px; height: 24px;">&nbsp; </div>
                      <div class="o_px-xs o_sans o_text-xs o_center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;text-align: center;padding-left: 8px;padding-right: 8px;">
                        <p style="margin-top: 0px;margin-bottom: 0px;">
                          <a class="o_text-dark_light" href="https://www.facebook.com/garageworks33/?ref=bookmarks" style="text-decoration: none;outline: none;color: #a0a3ab;"><img src="<?= base_url() ?>assets/images/emailer/facebook-light.png" width="36" height="36" alt="fb" style="max-width: 36px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a><span> &nbsp;</span>
                          <a class="o_text-dark_light" href="https://twitter.com/GarageWorks33?s=08" style="text-decoration: none;outline: none;color: #a0a3ab;"><img src="<?= base_url() ?>assets/images/emailer/twitter-light.png" width="36" height="36" alt="tw" style="max-width: 36px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a><span> &nbsp;</span>
                          <a class="o_text-dark_light" href="https://www.instagram.com/garageworks_/" style="text-decoration: none;outline: none;color: #a0a3ab;"><img src="<?= base_url() ?>assets/images/emailer/instagram-light.png" width="36" height="36" alt="ig" style="max-width: 36px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a><span> &nbsp;</span>
                          <!-- <a class="o_text-dark_light" href="" style="text-decoration: none;outline: none;color: #a0a3ab;"><img src=" assets/images/emailer/snapchat-light.png" width="36" height="36" alt="sc" style="max-width: 36px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a> -->
                        </p>
                      </div>
                    </div>
                    <!--[if mso]></td><td width="200" align="center" valign="top" style="padding:0px 8px;"><![endif]-->
                    <div class="o_col o_col-2 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 200px;">
                      <div style="font-size: 32px; line-height: 32px; height: 32px;">&nbsp; </div>
                      <div class="o_px-xs o_sans o_text-xs o_center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;text-align: center;padding-left: 8px;padding-right: 8px;">
                        <p style="margin-top: 0px;margin-bottom: 0px;"><a class="o_text-dark_light" href="https://garageworks.in/contact.html" style="text-decoration: none;outline: none;color: #a0a3ab;"><strong style="color: #a0a3ab;">Contact Us</strong></a></p>
                      </div>
                    </div>
                    <!--[if mso]></td></tr></table><![endif]-->
                  </td>
                </tr>
                <tr>
                  <td class="o_bg-dark o_px-md o_pb-lg o_br-b o_sans o_text-xs o_text-dark_light" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;background-color: #242b3d;color: #a0a3ab;border-radius: 0px 0px 4px 4px;padding-left: 24px;padding-right: 24px;padding-bottom: 32px;">
                   
                    <p class="o_mb-xs" style="margin-top: 0px;margin-bottom: 8px;">&copy; Copyright <?php echo date('Y'); ?><br>
                      Wakadewadi, Shivajinagar, Pune, Maharashtra 411003
                    </p>
                    
                  </td>
                </tr>
              </tbody>
            </table>
            <!--[if mso]></td></tr></table><![endif]-->
            <div class="o_hide-xs" style="font-size: 64px; line-height: 64px; height: 64px;">&nbsp; </div>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>
