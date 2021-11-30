<!-- adding for data table  -->
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.css">
<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="row">
                    <button type="button" class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#EditCallLog">Add New Voucher</button>
                </div>

                <br>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="voucher_list">
                            <thead>
                                <tr>
                                    <th>
                                        Invoice ID
                                    </th>
                                    <th>
                                        Invoice Date
                                    </th>
                                    <th>
                                        Vender Name
                                    </th>
                                    <th>
                                        User Name
                                    </th>
                                    <th>
                                        Total Amount
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Arrival Date
                                    </th>
                                    <th>
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-xl fade" id="EditCallLog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-5">
                            <label class="form-label">Select Date</label>
                            <input type="date" name="date" id="date" class="form-control" id="validationCustom01" required>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Invoice Id</label>
                            <input type="text" name="invoiceid" class="form-control" id="invoiceid">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Vender</label>
                            <select id="vender" name="vender" class="form-control">
                                <option value="1">abc1</option>
                                <option value="2">abc2</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">User List</label>
                            <select id="user_list" name="user_list" class="form-control">
                                <option value="1">sanket</option>
                                <option value="2">Irfan</option>
                                <option value="3">devendra</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Image</label><br>
                            <img id="uploadimage" class="rounded" height="200" width="200" style="margin-left: 27%;margin-right: 27%;">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Upload Image</label>
                            <input type="file" id="uplaodimage" name="uplaodimage" class="form-control" onchange="document.getElementById('uploadimage').src = window.URL.createObjectURL(this.files[0])" aria-label="file example" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">GST</label>
                            <input type="number" name="gst" min="0" max="50000" id="gst" class="form-control floatNumberField" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">C-GST</label>
                            <input type="number" name="cgst" min="0" max="50000" class="form-control floatNumberField" id="cgst" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">S-GST</label>
                            <input type="number" name="sgst" min="0" max="50000" class="form-control floatNumberField" id="sgst" required>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">Amount (without zero)</label>
                            <input type="number" autocomplete="off" min="0" max="50000" class="form-control floatNumberField" name="totalamount" id="totalamount" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <input type="submit" id="send" onClick="updateVoucher()" class='btn btn-primary' value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script>
    $(document).ready(function() {
        $('#voucher_list').DataTable({
            // dom: 'Bfrtip',
            // buttons: [
            //     'excel'
            // ]
        });

        $(".floatNumberField").change(function() {
            $(this).val(parseFloat($(this).val()).toFixed(2));
        });
    });

    $("#submit_button").click(function() {

        $.ajax({
            type: "GET",
            url: "<?php echo base_url("Exotel/getCallHistoryLog/") ?>",
            data: {
                fdate: $('#fdate').val(),
                tdate: $('#tdate').val()

            },
            dataType: 'json',
            success: function(res) {
                $('#call-list').DataTable().destroy();
                history_detail = res.result;
                var opt = "";
                $.each(res.result, function(i, e) {
                    opt += "<tr>";
                    opt += "<td>" + e.date + "</td>";
                    opt += "<td>" + e.time + "</td>";
                    opt += "<td>" + e.call_from + "</td>";
                    opt += "<td>" + e.customer_name + "</td>";
                    opt += "<td>" + e.channel + "</td>";
                    opt += "<td>" + e.latest_booking_id + "</td>";
                    opt += "<td>" + e.latest_booking_date + "</td>";
                    opt += "<td>" + e.booking_status + "</td>";
                    opt += "<td>" + e.purpose_of_call + "</td>";
                    opt += "<td>" + e.comment + "</td>";
                    opt += "<td>" + e.is_archived + "</td>";
                    opt += "<td>" + "<button onClick=\"editCallLog('" + e.purpose_of_call + "','" + e.comment + "','" + e.id + "')\"; type='button' class='btn btn-primary' data-toggle='modal' data-target='#EditCallLog'>Edit</button>" + "</td>";
                    opt += "</tr>";
                });
                $('#call-list').find('tbody').empty().append(opt);
                $('#call-list').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'excel'
                    ]
                }).draw()
            },
            error: function(result) {
                alert('error 1');
            }
        });
    });




    function updateVoucher() {

        var formData = new FormData();
        formData.append("date", $('#date').val());
        formData.append("invoiceid", $('#invoiceid').val());
        formData.append("vendor", $('#vender').val());
        formData.append("user", $('#user_list').val());
        formData.append("upload", $('#uplaodimage').prop('files')[0]);
        formData.append("gst", $('#gst').val());
        formData.append("cgst", $('#cgst').val());
        formData.append("sgst", $('#sgst').val());
        formData.append("finalamt", $('#totalamount').val());



        $.ajax({
            type: "POST",
            url: "<?php echo base_url("Voucher/add"); ?>",
            contentType: false,
            cache: false,
            processData: false,
            data: formData,
            dataType: "JSON",

            log: function(log) {
                console.log(log);
            },
            success: function(res) {
                alert("Data Saved Successfully");
                console.log(res);
                console.log(res.statusCode);
                console.log(res.message);
                var dataResult = JSON.stringify(res);
                if (dataResult.statusCode == 200) {
                    alert(dataResult.message)
                } else {

                }
            },
            // error: function(res) {
            //     var dataResult = JSON.stringify(res);
            //     alert(dataResult);
            //     alert("Data Saved Un-Successfully");
            //     console.log('error 1', error);
            // }
        });

    }
</script>