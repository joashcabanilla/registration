<?php include('connection.php');
  include('dbcon.php');
  include('session.php');
  $result=mysqli_query($con, "select * from users where user_id='$session_id'")or die('Error In Session');
  $row=mysqli_fetch_array($result);
 ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="assets/dataTables.bootstrap4.min.css"/>
  <link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css"/>
  <link rel="shortcut icon" href="imgs/logo.gif">
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <script src="assets/jquery-3.5.1.min.js"></script>
  <script src="assets/bootstrap.min.js"></script>

  <title>NOVADECI Supplies Monitoring</title>
  <style type="text/css">
    .btnAdd {
      text-align: right;
      width: 83%;
      margin-bottom: 20px;
    }

    .btnAdd {
      text-align: right;
      width: 83%;
      margin-bottom: 20px;
    }
    .hover-item {
    background-color: red;
    }
    .hover-item:hover {
    background-color: orange;
    }

    #my_input[type="date"]
    {
        font-size:14px;
    }
    .dataTables_filter input {
        width: 600px !important;
    }
    .dataTables_length label,
    .dataTables_filter label{
      font-weight: 700 !important;
    }
  </style>
  <link rel="shortcut icon" href="imgs/logo.gif">
</head>
<header style="background-color:green;">
  <a href="logout.php" style="color:white;margin-right:10px;"><label class="hover-item" style="float:right;margin-right:3px;padding:5px;height:28px;margin-top:-5px;font-size:13px;">&nbsp;<i><i class="fa fa-sign-out"></i>Log out</i></label></a>

  <label style="color:white;float:right;"><i>Welcome:</i>&nbsp;&nbsp;<?php echo $row['username']; ?> &nbsp;&nbsp;</label>
</header>

<body>
  <div class="container-fluid">
    <h4 class="text-center">NOVALICHES <a href="/supplies/dashboard/index.php" style="text-decoration: none;color:black;">DEVELOPMENT</a> COOPERATIVE</h4>
    <p class="datatable design text-center d-none">SUPPLIES MONITORING</p>
    <div class="row mt-3">
      <div class="container">
       <!-- <div class="btnAdd">-->
       <!--  <a href="#!" data-id="" data-bs-toggle="modal" data-bs-target="#addMemberModal"   class="btn btn-success btn-sm" >Add</a>-->
       <!--</div>-->
       <div class="row"><center>
        <!-- <div class="col-md-2"></div> -->
        <div class="col-md-12" >
         <table id="frmMember" class="table">
          <thead>
            <th width="3%">ID</th>
            <th width="5%">PB#</th>
            <th width="5%">MemID</th>
            <th width="20%">Last Name</th>
            <th width="20%">First Name</th>
            <th width="20%">Middle Name</th>
            <th width="30%">Branch</th>
            <th width="10%">Registered Date</th>
            <!-- <th width="10%">Giveaway Received</th> -->
            <th width="10%">Calendar Received</th>
            <th width="10%">Date Received</th>
            <!-- <th width="20%">IP Address</th> -->
            <th>Options</th>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="col-md-2"></div>
    </div>
  </div>
</div>
</div>

<script type="text/javascript" src="assets/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="assets/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="assets/datatables.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#frmMember').DataTable({
        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
          $(nRow).attr('id', aData[0]);
        },
        'serverSide':'true',
        'processing':'true',
        'paging':'true',
        'order':[],
        'ajax': {
          'url':'fetch_data.php',
          'type':'post',
        },
        "columnDefs": [{
          'target':[10],
          'orderable' :false,
        }]
      });
      $(".dataTables_filter").find("input").focus();

      $('#updateModal').on('hidden.bs.modal', function () {
        $(".dataTables_filter").find("input").focus();
      });
    } );
    $(document).on('submit','#addMember',function(e){
      e.preventDefault();
      var voters_id= $('#addvoters_idField').val();
      var memid= $('#addmemidField').val();
      var pbno= $('#addpbnoField').val();
      var lastname= $('#addlastnameField').val();
      var firstname= $('#addfirstnameField').val();
      var middlename= $('#addmiddlenameField').val();
      var bday= $('#addbdayField').val();
      var membershipdate= $('#addmembershipdateField').val();
      var status= $('#addstatusField').val();
      var branch= $('#addbranchField').val();
      var password= $('#addpasswordField').val();
      var isregistered= $('#addisregisteredField').val();
      var count= $('#addcountField').val();
        if(voters_id != '' && memid != '' && pbno != '' && lastname != '' && firstname != '' && middlename != '' && bday != '' && membershipdate != '' && status != '' && branch != '' && isregistered != '' && password != '' && count != '')
      // if(voters_id != '' && memid != '' && pbno != '' && lastname != '' && firstname != '' && middlename != '' && bday != '' && membershipdate != '' && status != '' && branch != '' && password != '' && count != '')
      {
       $.ajax({
         url:"add_member.php",
         type:"post",
         data:{voters_id:voters_id,memid:memid,pbno:pbno,lastname:lastname,firstname:firstname,middlename:middlename,bday:bday,membershipdate:membershipdate,status:status,branch:branch,isregistered:isregistered,password:password,count:count},
         // data:{voters_id:voters_id,memid:memid,pbno:pbno,lastname:lastname,firstname:firstname,middlename:middlename,bday:bday,membershipdate:membershipdate,status:status,branch:branch},
         success:function(data)
         {
           var json = JSON.parse(data);
           var status = json.status;
           if(status=='true')
           {
            mytable =$('#frmMember').DataTable();
            mytable.draw();
            $('#addMemberModal').modal('hide');
          }
          else
          {
            alert('failed');
          }
        }
      });
     }
     else {
      alert('Fill all the required fields');
    }
  });

    $(document).on('submit','#updateMember',function(e){
      e.preventDefault();
       // var tr = $(this).closest('tr');
       var voters_id= $('#voters_idField').val();
       var memid= $('#memidField').val();
       var lastname= $('#lastnameField').val();
       var firstname= $('#firstnameField').val();
       var middlename= $('#middlenameField').val();
       var branch= $('#branchField').val();
       var regs_date= $('#regs_dateField').val();
       var giveaway_received= $('#giveaway_receivedField').val();
       var date_received= $('#date_receivedField').val();
       var comp_name= $('#comp_nameField').val();
       var calendar_received = $("#calendar_receivedField").val();
       var calendar_date_received = $("#calendar_date_receivedField").val();

       var trid= $('#trid').val();
       var id= $('#id').val();
      //  if(voters_id != '' && memid != '' && lastname != '' && firstname != '' && middlename != '' && branch != '' && regs_date != '' && giveaway_received != '' && date_received != '' && comp_name != '')
      if(lastname != '' && firstname != '' && middlename != '' && branch != '' && calendar_received != '' && calendar_date_received != '' && comp_name != '')
       // if(voters_id != '' )
       {
         $.ajax({
           url:"update_member.php",
           type:"post",
           data:{voters_id:voters_id,memid:memid,lastname:lastname,firstname:firstname,middlename:middlename,branch:branch,regs_date:regs_date,giveaway_received:giveaway_received,date_received:date_received,comp_name:comp_name,id:id, calendar_received:calendar_received, calendar_date_received: calendar_date_received, action: "calendar"},
           success:function(data)
           {
             var json = JSON.parse(data);
             var status = json.status;
             if(status=='true')
             {
              table =$('#frmMember').DataTable();
              // var button =   '<td><a href="javascript:void();" data-id="' +id + '" class="btn btn-info btn-sm editbtn">Edit</a>  <a href="#!"  data-id="' +id + '"  class="btn btn-danger btn-sm deleteBtn">Delete</a></td>';
              var button =   '<td><a href="javascript:void();" data-id="' +id + '" class="btn btn-success btn-sm editbtn">Update</a></td>';
              var row = table.row("[id='"+trid+"']");

              // row.row("[id='" + trid + "']").data([id,voters_id,memid,lastname,firstname,middlename,branch,regs_date,giveaway_received,date_received,comp_name,button]);
              row.row("[id='" + trid + "']").data([id,voters_id,memid,lastname,firstname,middlename,branch,regs_date,calendar_received,calendar_date_received,button]);
              $('#updateModal').modal('hide');
              $(".dataTables_filter").find("input").focus();
            }
            else
            {
              alert('failed');
            }
          }
        });
       }
       else {
        alert('Fill all the required fields');
      }
    });
    $('#frmMember').on('click','.editbtn ',function(event){
      event.preventDefault();
      var table = $('#frmMember').DataTable();
      var trid = $(this).closest('tr').attr('id');
     // console.log(selectedRow);
     var id = $(this).data('id');
     $('#updateModal').modal('show');

     $.ajax({
      url:"get_single_data.php",
      data:{id:id},
      type:'post',
      success:function(data)
      {
       var json = JSON.parse(data);
       $('#voters_idField').val(json.voters_id);
       $('#memidField').val(json.memid);
       $('#lastnameField').val(json.lastname);
       $('#firstnameField').val(json.firstname);
       $('#middlenameField').val(json.middlename);
       $('#branchField').val(json.branch);
       $('#regs_dateField').val(json.regs_date);
       $('#giveaway_receivedField').val(json.giveaway_received);
       $('#date_receivedField').val(json.date_received);
       $('#calendar_receivedField').val(json.calendar_received);
       $('#calendar_date_receivedField').val(json.calendar_date_received);
       $('#comp_nameField').val(json.comp_name);
       $('#id').val(id);
       $('#trid').val(trid);
     }
   })
   });
    $(document).on('click','.deleteBtn',function(event){
       var table = $('#frmMember').DataTable();
      event.preventDefault();
      var id = $(this).data('id');
      if(confirm("Are you sure want to delete this record ? "))
      {
      $.ajax({
        url:"delete_member.php",
        data:{id:id},
        type:"post",
        success:function(data)
        {
          var json = JSON.parse(data);
          status = json.status;
          if(status=='success')
          {

             $("#"+id).closest('tr').remove();
          }
          else
          {
            alert('Failed');
            return;
          }
        }
      });
      }
      else
      {
        return null;
      }
    })
 </script>
 <script>
     var current = null;
     function showresponddiv(messagedivid){
     var id = messagedivid.replace("message-", "respond-"),
         div = document.getElementById(id);
     if(current && current != div) {
         current.style.display =  'none';
     }
     if (div.style.display=="none"){
         div.style.display="inline";
         current = div;
     }
     else {
         div.style.display="none";
         }
     }
 </script>

 <!-- update Modal -->
 <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel"><div id="message-1" onclick="showresponddiv(this.id)">Update</div></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="updateMember" >
          <input type="hidden" name="id" id="id" value="">
          <input type="hidden" name="trid" id="trid" value="">

            <div id="respond-1" style="display:none;">
                <input type="text" class="form-control" id="voters_idField" name="voters_id" >
                <input type="text" class="form-control" id="memidField" name="memid" >
            </div>

          <div class="mb-3 row">
            <label for="lastnameField" class="col-md-3 form-label">Last Name</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="lastnameField" name="lastname" readonly>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="firstnameField" class="col-md-3 form-label">First Name</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="firstnameField" name="firstname" readonly>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="middlenameField" class="col-md-3 form-label">Middle Name</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="middlenameField" name="middlename" readonly>
            </div>
          </div>
          <!-- <div class="mb-3 row"> -->
            <!-- <label for="branchField" class="col-md-3 form-label">Branch</label> -->
            <!-- <div class="col-md-9"> -->
              <input type="text" class="form-control" id="branchField" name="branch" hidden>
            <!-- </div> -->
          <!-- </div> -->
          <div class="mb-3 row">
            <!-- <label for="regs_dateField" class="col-md-3 form-label">Registered Date</label> -->
            <div class="col-md-9">
              <input type="date" class="form-control" id="regs_dateField" name="regs_date" hidden>
            </div>
          </div>
          <!-- <div class="mb-3 row">
            <label for="giveaway_receivedField" class="col-md-3 form-label">Giveaway Received</label>
            <div class="col-md-9">
              <select class="form-control" id="giveaway_receivedField" name="giveaway_received" style="font-size:24px;">
                <option value="---"></option>
                <option value="YES">YES</option>
                <option value="NO">NO</option>
              </select>
            </div>
          </div> -->
          <div class="mb-3 row">
            <label for="calendar_receivedField" class="col-md-3 form-label">Calendar Received</label>
            <div class="col-md-9">
              <select class="form-control" id="calendar_receivedField" name="calendar_received" style="font-size:24px;">
                <option value="---"></option>
                <option value="YES">YES</option>
                <option value="NO">NO</option>
              </select>
            </div>
          </div>
          <!-- <div class="mb-3 row">
            <label for="date_receivedField" class="col-md-3 form-label">Date Recieved</label>
            <div class="col-md-9">
              <input type="date" class="form-control" id="date_receivedField" name="date_received" style="font-size:24px;">
            </div>
          </div> -->
          <div class="mb-3 row">
            <label for="calendar_date_receivedField" class="col-md-3 form-label">Calendar Date Recieved</label>
            <div class="col-md-9">
              <input type="date" class="form-control" id="calendar_date_receivedField" name="calendar_date_received" style="font-size:24px;">
            </div>
          </div>
          <div class="mb-3 row">
            <div class="col-md-9">
              <input type="text" class="form-control" id="comp_nameField" name="comp_name" hidden>
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>


  <!-- Add member Modal -->
  <div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateModalLabel">Add User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addMember" action="add_member.php">
            <div class="mb-3 row">
              <label for="addvoters_idField" class="col-md-3 form-label">voters_id</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="addvoters_idField" name="voters_id">
              </div>
            </div>
             <div class="mb-3 row">
              <label for="addmemidField" class="col-md-3 form-label">memid</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="addmemidField" name="memid">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="addpbnoField" class="col-md-3 form-label">pbno</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="addpbnoField" name="pbno" >
              </div>
            </div>
            <div class="mb-3 row">
              <label for="addlastnameField" class="col-md-3 form-label">lastname</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="addlastnameField" name="lastname" >
              </div>
            </div>
            <div class="mb-3 row">
              <label for="addfirstnameField" class="col-md-3 form-label">firstname</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="addfirstnameField" name="firstname" >
              </div>
            </div>
            <div class="mb-3 row">
              <label for="addmiddlenameField" class="col-md-3 form-label">middlename</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="addmiddlenameField" name="middlename" >
              </div>
            </div>
            <div class="mb-3 row">
              <label for="addbdayField" class="col-md-3 form-label">bday</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="addbdayField" name="bday" >
              </div>
            </div>
            <div class="mb-3 row">
              <label for="addmembershipdateField" class="col-md-3 form-label">membershipdate</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="addmembershipdateField" name="membershipdate" >
              </div>
            </div>
            <div class="mb-3 row">
              <label for="addstatusField" class="col-md-3 form-label">status</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="addstatusField" name="status" >
              </div>
            </div>
            <div class="mb-3 row">
              <label for="addbranchField" class="col-md-3 form-label">branch</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="addbranchField" name="branch" >
              </div>
            </div>
           <div class="mb-3 row">
              <!-- <label for="addpasswordField" class="col-md-3 form-label">password</label> -->
              <div class="col-md-9">
                <input type="hidden" class="form-control" id="addpasswordField" name="password" value="$2y$10$iKKBAxFfVtkqf/a3fMnMeObXvuwv73fsijdst/bsX5JrxM8CQrlgG">
              </div>
            </div>
            <!-- <div class="mb-3 row">
              <label for="addcountField" class="col-md-3 form-label">count</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="addcountField" name="count" value="1">
              </div>
            </div> -->

            <div class="text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</div>

<footer><div style="float:right;margin-right:5px;font-size:12px;"><strong>© 2022 <a href="#" data-id="" data-bs-toggle="modal" data-bs-target="#addMemberModal" >JV</a></strong> All rights reserved.</div></footer>
</body>
</html>
<script type="text/javascript">
  //var table = $('#frmMember').DataTable();
</script>
