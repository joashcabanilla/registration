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
    <!-- <title><?php echo "ONLINE MEMBERSHIP APPLICATION" . date("m/d/Y") . "\n";?></title> -->
    <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap-3.3.7.min.css">
    <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="css/buttons.dataTables-1.7.1.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker-1.6.4.css" />
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script> -->
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.buttons.min.js"></script>
    <script src="js/jszip.min.js"></script>
    <script src="js/pdfmake.min.js"></script>
    <script src="js/vfs_fonts.js"></script>
    <script src="js/buttons.html5.min.js"></script>
    <script src="js/buttons.print.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/bootstrap-datepicker-1.6.4.js"></script>


    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <!-- <script src="//code.jquery.com/jquery-1.10.2.js"></script> -->
    <!-- <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> -->
    <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
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
  <?php
  $initial_date='dpicker_initial_date'; ?>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
        </div>
          <div class="row well input-daterange">

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
              <input class="form-control" type="text" name="initial_date" id="initial_date" placeholder="mm/dd/yyyy" style="height: 40px;"/>
            </div>

            <div class="col-sm-3">
              <label class="control-label">End date</label>
              <input class="form-control" type="text" name="final_date" id="final_date" placeholder="mm/dd/yyyy" style="height: 40px;"/>
            </div>

            <div class="col-sm-2">
              <button class="btn btn-success btn-block" type="submit" name="filter" id="filter" style="margin-top: 30px;width:70px;">
                <i class="fa fa-filter"></i> Filter
              </button>
            </div>
            <div class="col-sm-12 text-danger" id="error_log"></div>
          </div>
          <p style="text-align:center">Selected Date <i>From:</i> <b><span id="dpicker_initial_date"></span></b> <i>To:</i> <b><span id="dpicker_final_date"></span></b></p>

          <table id="fetch_generated" class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Last name</th>
                <th>First name</th>
                <th>Middle name</th>
                <th>Contact no.</th>
                <th>Email</th>
                <th>Status</th>
                <th>Branch</th>
                <th>Application Date</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>


    <script type="text/javascript">
      load_data(); // first load

      function load_data(initial_date, final_date, branch){
        var ajax_url = "jquery-ajax.php";

        $('#fetch_generated').DataTable({
          "order": [[ 0, "desc" ]],
          dom: 'Blfrtip',
          buttons: [
           'excel', 'pdf'
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
            { "data" : "status" },
            { "data" : "branch" },
            { "data" : "date_posted" }
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
