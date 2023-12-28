<?php
  include "config/db-config.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ONLINE MEMBERSHIP APPLICATION</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script>
      $(function() {
        $( "#initial_date" ).datepicker();
        $( "#final_date" ).datepicker();
      });
        $(document).ready(function(){
          $('#initial_date').on('change', function(){
            var dateThis = $(this).val();
            $('#dpicker_initial_date').text(dateThis);
          });
          $('#final_date').on('change', function(){
            var dateThis = $(this).val();
            $('#dpicker_final_date').text(dateThis);
          });
        });
    </script>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
        </div>
          <div class="row well input-daterange" style="margin-top:20px;">
            <div class="col-sm-4">
              <label class="control-label">Branch</label>
              <select class="form-control" name="branch" id="branch" style="height: 40px;" required>
								<option value="">All</option>
                <option value="Main Office">Main Office</option>
								<option value="Bagong Silang">Bagong Silang</option>
								<option value="Camarin">Camarin</option>
                <option value="Kiko">Kiko</option>
								<option value="Fairview">Fairview</option>
								<option value="Lagro">Lagro</option>\
								<option value="Muñoz">Muñoz</option>
								<option value="Tandang Sora">Tandang Sora</option>
                <option value="Bulacan">Bulacan</option>
							</select>
            </div>

            <div class="col-sm-3">
              <label class="control-label">Start date</label>
              <input class="form-control datepicker" type="text" name="initial_date" id="initial_date" placeholder="mm/dd/yyyy" style="height: 40px;"/>
            </div>
            <div class="col-sm-3">
              <label class="control-label">End date</label>
              <input class="form-control datepicker" type="text" name="final_date" id="final_date" placeholder="mm/dd/yyyy" style="height: 40px;"/>
            </div>
            <div class="col-sm-2">
              <button class="btn btn-success btn-block" type="submit" name="filter" id="filter" style="margin-top: 30px;width:70px;">
                <i class="fa fa-filter"></i> Filter
              </button>
            </div>
            <div class="col-sm-12 text-danger" id="error_log"></div>
          </div>
          <br/><p style="text-align:center">Selected Date <i>From:</i> <b><span id="dpicker_initial_date"></span></b> <i>To:</i> <b><span id="dpicker_final_date"></span></b></p><br/>
          <table id="fetch_generated" class="table table-dark table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Last name</th>
                <th>First name</th>
                <th>Middle name</th>
                <th>Contact no.</th>
                <th>Email</th>
                <th>Branch</th>
                <th>Status</th>
                <th>Application Date</th>
                <th>Recruiter's Name</th>
              </tr>
            </thead>
          </table>

        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">

      load_data(); // first load

      function load_data(initial_date, final_date, branch){
        var ajax_url = "jquery-ajax.php";

        $('#fetch_generated').DataTable({
          "order": [[ 0, "desc" ]],
          dom: 'Blfrtip',
          buttons: [
            'excel', 'pdf'//, 'print'
          ],
          "processing": true,
          "serverSide": true,
          "stateSave": true,
          "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
          "ajax" : {
            "url" : ajax_url,
            "dataType": "json",
            "type": "POST",
            "data" : {
              "action" : "fetch_users",
              "initial_date" : initial_date,
              "final_date" : final_date,
              "branch" : branch
            },
            "dataSrc": "records"
          },
          "columns": [
            { "data" : "counter" },
            { "data" : "lname" },
            { "data" : "fname" },
            { "data" : "mname" },
            { "data" : "contact_no" },
            { "data" : "email" },
            { "data" : "branch" },
            { "data" : "status" },
            { "data" : "date_posted" },
            { "data" : "recruiters_name" }
          ]
        });
      }

      $("#filter").click(function(){
        var initial_date = $("#initial_date").val();
        var final_date = $("#final_date").val();
        var branch = $("#branch").val();

        if(initial_date == '' && final_date == ''){
          $('#fetch_generated').DataTable().destroy();
          load_data("", "", branch); // filter immortalize only
        }else{
          var date1 = new Date(initial_date);
          var date2 = new Date(final_date);
          var diffTime = Math.abs(date2 - date1);
          var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

          if(initial_date == '' || final_date == ''){
              $("#error_log").html("Warning: You must select both (start and end) date.</span>");
          }else{
            if(date1 > date2){
                $("#error_log").html("Warning: End date should be greater then start date.");
            }else{
               $("#error_log").html("");
               $('#fetch_generated').DataTable().destroy();
               load_data(initial_date, final_date, branch);
            }
          }
        }
      });

      $('.input-daterange').datepicker({
        todayBtn:'linked',
        format: "mm/dd/yyyy",
        autoclose: true
      });

    </script>
  </body>
</html>
