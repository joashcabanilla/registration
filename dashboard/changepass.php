<?php
include 'inc/header.php';
Session::CheckSession();
 ?>
 <?php

 if (isset($_GET['id'])) {
   $userid = (int)$_GET['id'];

 }



 if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['changepass'])) {
    $changePass = $users->changePasswordBysingelUserId($userid, $_POST);
 }



 if (isset( $changePass)) {
   echo  $changePass;
 }
  ?>

  <style>
  input {
    outline: 0;
    border-width: 0 0 2px;
    border-color: green
  }
  input:focus {
    border-color: purple
  }
  select {
    outline: 0;
    border-width: 0 0 2px;
    border-width: 0 0 2px;
    border-color: green
  }
  select:focus {
    border-color: purple
  }
  </style>

 <div class="card ">
   <div class="card-header">
          <h3><i class="fa fa-key"></i>&nbsp;Change your password <span class="float-right"> <a class="btn btn-warning" onclick="history.go(-1)"><i class="fa fa-arrow-circle-left"></i>&nbsp;Back</a> </h3>
        </div>
        <div class="card-body">



          <div style="width:300px; margin:0px auto">

          <form class="" action="" method="POST">
              <div class="form-group">
                <label for="old_password" style="color:gray;">Old Password</label>
                <input type="password" name="old_password"  style="width:300px; margin:0px auto;font-size:18px;">
              </div>
              <div class="form-group">
                <label for="new_password" style="color:gray;">New Password</label>
                <input type="password" name="new_password"  style="width:300px; margin:0px auto;font-size:18px;">
              </div>


              <div class="form-group">
                <button style="float:right" type="submit" name="changepass" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Save</button>
              </div>


          </form>
        </div>


      </div>
    </div>


  <?php
  include 'inc/footer.php';

  ?>
