<!-- adding for data table  -->
<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.css">
<div class="section-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <form method='post'>
                        <div class="row">
                            <div class="col-lg-3">
                                <label class="control-label">Start Date</label>
                                <input type="text" id="fdate" data-ad-format="" autocomplete="off" class="form-control datepicker" name="fdate">
                            </div>
                            <div class="col-lg-3">
                                <label class="control-label">End Date</label>
                                <input type="text" id="tdate" class="form-control datepicker" autocomplete="off" name="tdate">
                            </div>
                            <div class="col-lg-3">
                                <button type="button" class="btn btn-primary" id="submit_button">Submit</button>
                            </div>
                    </form>
                </div>
                <br>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="call-list">
                            <thead>
                                <tr>
                                    <th>
                                        Date
                                    </th>
                                    <th>
                                        Time
                                    </th>
                                    <th>
                                        Mobile Number
                                    </th>
                                    <th>
                                        Customer Name
                                    </th>
                                    <th>
                                        Channel
                                    </th>
                                    <th>
                                        Last Booking
                                    </th>
                                    <th>
                                        Booking Date
                                    </th>
                                    <th>
                                        Booking Status
                                    </th>
                                    <th>
                                        Purpose of Call
                                    </th>
                                    <th>
                                        Comments
                                    </th>
                                    <th>
                                        Is Archived
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
<div class="modal fade" id="EditCallLog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Call Log</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="purpose_of_call" class="col-form-label">Purpose of Call</label>
                        <div class="col-md-12">
                            <select id="purpose_of_call" class="form-control">
                                <option>Follow-up on upcoming booking</option>
                                <option>New Booking</option>
                                <option>Query on on-going booking</option>
                                <option>Complaint on past booking</option>
                                <option>Customer Enquiry</option>
                                <option>Partnership Enquiry</option>
                                <option>Sales Call</option>
                                <option>Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="message-text" class="col-form-label">Comment</label>
                            <textarea class="form-control" id="comment"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button id="send" onClick="updateCallLog()" class='btn btn-primary' data-toggle='modal' data-target='#EditCallLog'>Save</button>
            </div>
            <input type="hidden" id='call_history_id'>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script>
    $(document).ready(function() {
        $('#call-list').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ]
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

    function editCallLog(purpose_of_call, comment, id) {
        $('#purpose_of_call').val(purpose_of_call);
        $('#comment').val(comment);
        $('#call_history_id').val(id);
    }

    function updateCallLog() {
        console.log($('#send').val())
        alert("Record Updated successfully");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url("Exotel/updateCallLog") ?>?id=" + $('#call_history_id').val(),
            data: {
                purpose_of_call: $('#purpose_of_call').val(),
                comment: $('#comment').val()

            },
            dataType: 'json',
            success: function(res) {
                alert(Success)
            },
            error: function(error) {
                console.log('error 1', error);
            }
        });

    }
</script>