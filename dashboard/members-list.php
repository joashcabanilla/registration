<?php
  include('dbcon.php');
  include_once('db.php');
  include('session.php');
  $result=mysqli_query($con, "select * from users where user_id='$session_id'")or die('Error In Session');
  $row=mysqli_fetch_array($result);
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>NOVADECI - Member's Specimen Signature</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../dist/css/skins/skin-green.min.css">
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->

	<!-- <link rel="stylesheet" href="./assets/css/bootstrap.min.css" /> -->
	<!-- <link rel="stylesheet" href="./assets/font-awesome/4.5.0/css/font-awesome.min.css" /> -->
	<!-- <link rel="stylesheet" href="./assets/css/fonts.googleapis.com.css" /><!-- text fonts -->
	<!-- <link rel="stylesheet" href="./assets/css/custom.css" /> -->


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" media="all">
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->



  <style media="screen">
  .header {
    padding: 2px;
    /* border-radius: 50% 50% 0% 0%; */
    text-align: center;
    background: #00a65a;
    color: white;
    font-size: 24px;
    /* margin-top:10px; */
  }
  </style>
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">
  <?php include('inc/header.php');?>
  <?php include('inc/sidebar.php');?>

  <div class="content-wrapper">
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="../dashboard/index.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Reports</li>
      </ol>
    </section>

    <section class="content container-fluid">
      <div class="container">
        <div class="container box">
    			<h4 align="center"><b>ESPECIMEN SIGNATURE VERIFIER</b></h4>

    			<div class="table-responsive">
    				<div style="float:right;">
    					<button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-success fa fa-plus-circle" title="Addnew"></button>
    				</div>
    				<br /><br />
    				<table id="example" class="table table-bordered table-striped">
    					<thead>
    						<tr >
    							<th width="2%" height="2%" style="text-align:center">Signature</th>
    							<th width="5%">MemID/PBno</th>
    							<th width="20%">Last Name</th>
    							<th width="20%">First Name</th>
    							<th width="20%">Middle Name</th>
    							<th width="45%">Branch</th>
    							<th width="1%"></th>
    							<th width="1%"></th>
    						</tr>
    					</thead>
    				</table>
    			 </div>
    	  </div>
       </div>
    </section>
  </div>

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

  					<label>First Name</label>
  					<input type="text" name="fname" id="fname" class="form-control" />

  					<label>Last Name</label>
  					<input type="text" name="lname" id="lname" class="form-control" />

  					<label>Middle Name</label>
  					<input type="text" name="mname" id="mname" class="form-control" />

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
  					<input type="file" name="user_image" id="user_image" />
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

  <script src="js/zoom.js"></script>

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
  		var lastName = $('#lname').val();
  		var firstName = $('#fname').val();
  		var middleName = $('#mname').val();
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
  		if(memid != '' && lastName != '' && firstName != '' && middleName != '' && branch != '' )
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
  				$('#lname').val(data.lname);
  				$('#fname').val(data.fname);
  				$('#mname').val(data.mname);
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




  <?php include('inc/footer.php');?>
</div>

  <script src="./assets/js/jquery-2.2.4.min.js"></script>
	<script type="text/javascript" src="./assets/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="./assets/js/jquery.dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" src="./assets/js/dataTables.select.min.js"></script>
	<!-- <script type="text/javascript" src="./assets/js/select2.min.js"></script> -->
	<script type="text/javascript" src="./assets/js/moment.min.js"></script>
	<!-- <script type="text/javascript" src="./assets/js/daterangepicker.js"></script> -->

	<script>
	   tableName =
			$('#dynamic-table').DataTable( {
				"ordering": false,
				"processing": true,
				"serverSide": true,
				"stateSave": true,
				"ajax":{
					url :"ajax_query.php",
					type: "post",
					error: function(){}
				},
				"lengthMenu": [ 10, 25, 50, 75, 100,1000 ],
				 'columnDefs': [{
				 'targets': 0,
				 'searchable': false,
				 'orderable': false,
				 'className': 'center',
			  }
			  ],
			  'order': [[1, 'asc']],
				select: true,
				select: {
					style: 'multi',
					selector: 'td:first-child',
					info: false
				},
				"fnInitComplete": function(oSettings, json) {
				 // Load Compmplete Functions
				},
				"drawCallback": function( settings ) {
					// Callback Draw Functions
				}
			} );
			// Select2 for branch Select Box
			$('#filter_branch').select2({placeholder: "Select branch...", allowClear: true, width:'resolve',theme: "bootstrap"});
			// branch Selection and DrawCallBack
			$('#filter_branch').change(function(){
				var branID = $(this).val();
				// alert(branID);
				tableName.column(0).search(branID).draw();
			});
			// Date Filter
				$('input[name=date-range-picker]').daterangepicker({
					 autoUpdateInput: false,
					"opens": "right",
					"drops": "down",
					"showDropdowns": true,
					'applyClass' : 'btn-sm btn-success',
					'cancelClass' : 'btn-sm btn-default'
				});
				$('input[name="date-range-picker"]').on('apply.daterangepicker', function(ev, picker) {
				  $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));

				  tableName.column(1).search(picker.startDate.format('MM/DD/YYYY')+"@"+picker.endDate.format('MM/DD/YYYY')).draw();
			  });
				$('input[name="date-range-picker"]').on('cancel.daterangepicker', function(ev, picker) {
					  $(this).val('');
					  tableName.column(1).search('').draw();
				  });
				$('#reload').click(function (e) {
					  $(this).val('');
						 tableName.column(1).search('').draw();
				 });
	</script>

<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>

</body>
</html>
