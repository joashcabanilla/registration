<?php
  include('../dbcon.php');
  include('../session.php');
  $result=mysqli_query($con, "select * from users where user_id='$session_id'")or die('Error In Session');
  $row=mysqli_fetch_array($result);
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>NOVADECI - Member's Specimen Signature Verifier</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="/img/logo.gif">

  <script src="js/jquery-2.2.0.min.js"></script>
  <!-- <link rel="stylesheet" href="css/bootstrap-3.3.6.min.css" type="text/css" media="all"> -->
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../dist/css/skins/skin-green.min.css">
  <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/zoom.css">
  <script src="js/jquery.dataTables.min.js"></script>

  <link rel="stylesheet" href="css/thumbnailviewer.css" type="text/css" />
  <script src="js/thumbnailviewer.js" type="text/javascript"></script>
  <style media="screen">
  /* .header {
    padding: 2px;
    text-align: center;
    background: #00a65a;
    color: white;
    font-size: 24px;
  } */
		/* body
		{
			margin:0;
			padding:0;
			background-color:#f1f1f1;
		} */



     .center {
      display: block;
      margin-left: auto;
      margin-right: auto;
      /* width: 50%; */
    }
  </style>




</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
  <?php include('../inc/header.php');?>
  <?php include('../inc/sidebar.php');?>

  <div class="content-wrapper">
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="../dashboard/index.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">List of Members</li>
      </ol>
    </section><br />

    <section class="content container-fluid">
      <div class="container">
	       <div id="layout" class="boxed-layout" >
    			<!-- <div class="row">
    				<div class="col-sm-12 col-md-12">
    					<div class="header" id="title"> </div>
    				</div>
    			</div> -->

    			<!-- <div class="col-xs-12 col-sm-12 col-md-12"> -->
    		     <!-- <div class="clearfix">
               <div class="pull-right tableTools-container"></div>
             </div> -->
      			<!-- <div> -->
							<!--  -->
							<div class="container box">
								<h4 align="center"><b>SPECIMEN SIGNATURE VERIFIER</b></h4>

								<div class="table-responsive">
									<div style="float:right;">
										<button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-success fa fa-plus-circle" title="Addnew"></button>
									</div>
									<br /><br />
									<table id="example" class="table table-bordered table-striped">
										<thead>
											<tr >
												<th width="2%">SpecimenCard</th>
												<th width="5%">MemID/PBno</th>
												<th width="30%">Full Name</th>
												<th width="45%">Branch</th>
												<th width="1%"></th>
												<th width="1%"></th>
											</tr>
										</thead>
									</table>
								</div>
							</div>


						</body>
					</html>

					<div id="userModal" class="modal fade">
						<div class="modal-dialog">
							<form method="post" id="user_form" enctype="multipart/form-data">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">AddNew</h4>
									</div>
									<div class="modal-body">
										<label>MemID/PBno.</label>
										<input type="text" name="mem_id" id="mem_id" class="form-control" />

										<label>Full Name</label>
										<input type="text" name="fullname" id="fullname" class="form-control" />

										<label>Select Branch</label>
										<select name="branch" id="branch" class="form-control">
											<option value=""></option>
											<option value="BSILANG OFFICE">BSILANG OFFICE</option>
											<option value="BULACAN OFFICE">BULACAN OFFICE</option>
											<option value="CAMARIN OFFICE">CAMARIN OFFICE</option>
											<option value="FAIRVIEW OFFICE">FAIRVIEW OFFICE</option>
											<option value="KIKO OFFICE">KIKO OFFICE</option>
											<option value="LAGRO OFFICE">LAGRO OFFICE</option>\
											<option value="MUÑOZ OFFICE">MUÑOZ OFFICE</option>
											<option value="MAIN OFFICE">MAIN OFFICE</option>
											<option value="TSORA OFFICE">TSORA OFFICE</option>
										</select>
										<label>Select Image</label>
										<input type="file" name="user_image" id="user_image"/>
										<span id="user_uploaded_image"></span>
										<input type="hidden" name="updated_count" value="1"/>
									</div>
									<div class="modal-footer">
										<input type="hidden" name="user_id" id="user_id" />
										<input type="hidden" name="operation" id="operation" />
										<input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>
								<br />
							</form>
						</div>
					</div>
					<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
						<!-- <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script> -->



							<!--  -->
      			<!-- </div> -->
      		<!-- </div> -->
    	</div>
    </div>
    <div id="viewModal" class="modal fade">
      <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">AddNew</h4>
            </div>
            <div class="modal-body">
              <label>MemID/PBno.</label>
              <input type="text" name="mem_id" id="mem_id" class="form-control" />

              <label>Full Name</label>
              <input type="text" name="fullname" id="fullname" class="form-control" />

              <label>Select Branch</label>
              <select name="branch" id="branch" class="form-control">
                <option value=""></option>
                <option value="BSILANG OFFICE">BSILANG OFFICE</option>
                <option value="BULACAN OFFICE">BULACAN OFFICE</option>
                <option value="CAMARIN OFFICE">CAMARIN OFFICE</option>
                <option value="FAIRVIEW OFFICE">FAIRVIEW OFFICE</option>
                <option value="KIKO OFFICE">KIKO OFFICE</option>
                <option value="LAGRO OFFICE">LAGRO OFFICE</option>\
                <option value="MUÑOZ OFFICE">MUÑOZ OFFICE</option>
                <option value="MAIN OFFICE">MAIN OFFICE</option>
                <option value="TSORA OFFICE">TSORA OFFICE</option>
              </select>
              <label>Select Image</label>
              <input type="file" name="user_image" id="user_image"/>
              <span id="user_uploaded_image"></span>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="user_id" id="user_id" />
              <input type="hidden" name="operation" id="operation" />
              <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <br />
        </form>
      </div>
    </div>


    </section>
  </div>
  <?php include('../inc/footer.php');?>
</div>

  <script type="text/javascript" language="javascript" >
  $(document).ready(function(){
    $('#add_button').click(function(){
      $('#user_form')[0].reset();
      $('.modal-title').text("AddNew Member's Specimen Signature");
      $('#action').val("Add");
      $('#operation').val("Add");
      $('#user_uploaded_image').html('');
    });

    var dataTable = $('#example').DataTable({
      "processing":true,
      "serverSide":true,
      "sScrollY": false,
      "sScrollX": false,
      "order":[],
      "ajax":{
        url:"fetch.php",
        type:"POST"
      },
      "columnDefs":[
        {
          "targets":[0, 3, 4],
          "orderable":false,
        },
      ],

    });

    $(document).on('submit', '#user_form', function(event){
      event.preventDefault();
      var memid = $('#mem_id').val();
      var fullName = $('#fullname').val();
      var branch = $('#branch').val();
      var extension = $('#user_image').val().split('.').pop().toLowerCase();
      if(extension != '')
      {
        if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
        {
          alert("Invalid Image File");
          $('#user_image').val('');
          return false;
        }
      }
      if(memid != '' && fullName != '' && branch != '' )
      {
        $.ajax({
          url:"insert.php",
          method:'POST',
          data:new FormData(this),
          contentType:false,
          processData:false,
          success:function(data)
          {
            alert(data);
            $('#user_form')[0].reset();
            $('#userModal').modal('hide');
            dataTable.ajax.reload();
          }
        });
      }
      else
      {
        alert("All Fields are Required");
      }
    });

    $(document).on('click', '.update', function(){
      var user_id = $(this).attr("id");
      $.ajax({
        url:"fetch_single.php",
        method:"POST",
        data:{user_id:user_id},
        dataType:"json",
        success:function(data)
        {
          $('#userModal').modal('show');
          $('#mem_id').val(data.mem_id);
          $('#fullname').val(data.fullname);
          $('#branch').val(data.branch);
          $('.modal-title').text("Edit Member's Data");
          $('#user_id').val(user_id);
          $('#user_uploaded_image').html(data.user_image);
          $('#action').val("Update");
          $('#operation').val("Edit");
        }
      })
    });

    $(document).on('click', '.delete', function(){
      var user_id = $(this).attr("id");
      if(confirm("Are you sure you want to delete this?"))
      {
        $.ajax({
          url:"delete.php",
          method:"POST",
          data:{user_id:user_id},
          success:function(data)
          {
            alert(data);
            dataTable.ajax.reload();
          }
        });
      }
      else
      {
        return false;
      }
    });
  });
  </script>

<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>

</body>
</html>
