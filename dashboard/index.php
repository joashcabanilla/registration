<?php
  include('dbcon.php');
  include('session.php');
  $result=mysqli_query($con, "select * from users where user_id='$session_id'")or die('Error In Session');
  $row=mysqli_fetch_array($result);
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>NOVADECI</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="img/logo.gif">
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/skin-green.min.css">
  <link rel="stylesheet" type="text/css" href="dist/css/dashboard_style.css">
  <style media="screen">
      div.greenTable {
      /* font-family: Georgia, serif; */
      border: 6px solid #24943A;
      background-color: #D4EED1;
      width: 100%;
      text-align: center;
      }
      .divTable.greenTable .divTableCell, .divTable.greenTable .divTableHead {
      border: 1px solid #24943A;
      padding: 3px 2px;
      }
      .divTable.greenTable .divTableBody .divTableCell {
      font-size: 13px;
      }
      .divTable.greenTable .divTableHeading {
      background: #24943A;
      background: -moz-linear-gradient(top, #5baf6b 0%, #3a9e4d 66%, #24943A 100%);
      background: -webkit-linear-gradient(top, #5baf6b 0%, #3a9e4d 66%, #24943A 100%);
      background: linear-gradient(to bottom, #5baf6b 0%, #3a9e4d 66%, #24943A 100%);
      border-bottom: 0px solid #444444;
      }
      .divTable.greenTable .divTableHeading .divTableHead {
      font-size: 19px;
      /* font-weight: bold; */
      color: #F0F0F0;
      text-align: left;
      border-left: 2px solid #24943A;
      }
      .divTable.greenTable .divTableHeading .divTableHead:first-child {
      border-left: none;
      }

      .greenTable .tableFootStyle {
      font-size: 13px;
      }
      .greenTable .tableFootStyle .links {
       text-align: right;
      }
      .greenTable .tableFootStyle .links a{
      display: inline-block;
      background: #FFFFFF;
      color: #24943A;
      padding: 2px 8px;
      border-radius: 5px;
      }
      .greenTable.outerTableFooter {
      border-top: none;
      }
      .greenTable.outerTableFooter .tableFootStyle {
      padding: 3px 5px;
      }
      /* DivTable.com */
      .divTable{ display: table; }
      .divTableRow { display: table-row; }
      .divTableHeading { display: table-header-group;}
      .divTableCell, .divTableHead { display: table-cell;}
      .divTableHeading { display: table-header-group;}
      .divTableFoot { display: table-footer-group;}
      .divTableBody { display: table-row-group;}

      .divTable.greenTable .divTableHeading2 {
      background: #24943A;
      background: -moz-linear-gradient(top, #5baf6b 0%, #3a9e4d 66%, #24943A 100%);
      background: -webkit-linear-gradient(top, #5baf6b 0%, #3a9e4d 66%, #24943A 100%);
      background: linear-gradient(to bottom, #5baf6b 0%, #3a9e4d 66%, #24943A 100%);
      border-bottom: 0px solid #444444;
      }
      .divTable.greenTable .divTableHeading2 .divTableHead {
      font-size: 19px;
      font-weight: bold;
      color: #F0F0F0;
      text-align: left;
      border-left: 2px solid #24943A;
      }
    {
      overflow-y: hidden;
      overflow-x: hidden;
    }
  </style>
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
  <div class="content-wrapper">
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="/supplies/home.php"><i class="fa fa-dashboard"></i> Supplies' monitoring</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content container-fluid">
      <div class="card ">

        <div class="card-body pr-2 pl-2">
          <body><br />
            <div class="row-fluid">
                  <section id="main">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-12">

                      <div class="dashbord lagro-content" id="inner-div">
                  			<div class="title-section">
                  				<p><b>TOTAL RECORDS</b></p>
                  			</div>
                  			<div class="icon-text-section">
                  				<div class="icon-section">
                  					<i class="fa fa-spinner" aria-hidden="true"></i>
                  				</div>
                  				<div class="text-section">
                            <a href="#">
                              <?php
                              // echo "<h2 style='color:white;'>46,190</h2>";
                                    foreach($con->query('SELECT SUM(count)
                                    FROM voters') as $row) {
                                    echo "<h1 style='color:white;'>".number_format('46190')."</h1>";
                                    }
                                  ?>
                              </a>
                  				</div>
                  				<div style="clear:both;"></div>
                  			</div>
                  			<div class="detail-section">
                  				<a href="#">
                  					<p>View Detail</p>
                  					<i class="fa fa-arrow-right" aria-hidden="true"></i>
                  				</a>
                  			</div>
                  		</div>

                      <div class="dashbord cubao-content" id="inner-div">
                  			<div class="title-section">
                  				<p>&nbsp;&nbsp;<b>MEMBERS WHO RECEIVED GIVEAWAY</b>&nbsp;&nbsp;</p>
                  			</div>
                  			<div class="icon-text-section">
                  				<div class="icon-section">
                  					<i class="fa fa-spinner" aria-hidden="true"></i>
                  				</div>
                  				<div class="text-section">
                            <a href="#">
                              <?php
                                    foreach($con->query('SELECT SUM(give_away_cnt)
                                    FROM voters where giveaway_received="YES"') as $row) {
                                    echo "<h1 style='color:white;'>".number_format($row['SUM(give_away_cnt)'])."</h1>";
                                    }
                                  ?>
                              </a>
                  				</div>
                  				<div style="clear:both;"></div>
                  			</div>
                  			<div class="detail-section">
                  				<a href="#">
                  					<p>View Detail</p>
                  					<i class="fa fa-arrow-right" aria-hidden="true"></i>
                  				</a>
                  			</div>
                  		</div>

                      <div class="" >

                      </div>
                    </div>
                  </section>
                </div>
              </div>
            </div>
          </body>
          <footer class="">
             <div style="float:right;margin-right:5px;font-size:12px;"><strong>© 2022 <a href="#">JV</a></strong> All rights reserved.</div>
          </footer>
      </div>
    </section>
</div>

<!-- <script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script> -->

</body>
</html>
