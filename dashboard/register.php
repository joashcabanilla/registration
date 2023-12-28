<?php
include 'inc/header.php';
Session::CheckLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
  $register = $users->userRegistration($_POST);
}
if (isset($register)) {
  echo $register;
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
          <h3 class='text-center'>Registration</h3>
        </div>
        <div class="cad-body">
            <div style="width:300px; margin:0px auto">

            <form class="" action="" method="post">
              <div class="form-group pt-3" style="float:right">
                <label for="note" style="color:red;font-style:italic">Note: All fields are mandatory.</label>
              </div><br /><br />           
                
                <div class="form-group">
                  <label for="pbno" style="color:gray;">PB# / Member ID</label>
                  <input type="text" name="pbno"  style="width:300px; margin:0px auto;font-size:18px;">
                </div>
                <div class="form-group">
                  <label for="name" style="color:gray;">Full Name</label>
                  <input type="text" name="name"  style="width:300px; margin:0px auto;font-size:18px;">
                </div>
                <div class="form-group">
                  <label for="mobile" style="color:gray;">Mobile Number</label>
                  <input type="text" name="mobile"  style="width:300px; margin:0px auto;font-size:18px;">
                </div>
                <div class="form-group">
                  <label for="branch" style="color:gray;">Branch / Satellite</label>
                  <select name="branch" style="width:300px; margin:0px auto;font-size:18px;">
                    <option value=""></option>
                    <optgroup label="Caloocan City Branch/Satellite">
                      <option value="Bagong Silang">Bagong Silang</option>
                      <option value="Camarin">Camarin</option>
                      <option value="Kiko">Kiko</option>
                    </optgroup>
                    <optgroup label="Quezon City Branch/Satellite">
                      <option value="Fairview">Fairview</option>
                      <option value="Lagro">Lagro</option>
                      <option value="Muñoz">Muñoz</option>
                      <option value="Main Office">Main Office</option>
                      <option value="Tandang Sora">Tandang Sora</option>
                    </optgroup>
                    <optgroup label="Bulacan City Satellite">
                      <option value="Bulacan">Bulacan</option>
                    </optgroup>
                  </select>
                </div>
                <div class="form-group">
                  <label for="username" style="color:gray;">User Name</label>
                  <input type="text" name="username" style="width:300px; margin:0px auto;font-size:18px;">
                </div>
                <div class="form-group">
                  <label for="email" style="color:gray;">Email</label>
                  <input type="email" name="email" style="width:300px; margin:0px auto;font-size:18px;">
                </div>
                <div class="form-group">
                  <label for="password" style="color:gray;">Password</label>
                  <input type="password" name="password" style="width:300px; margin:0px auto;font-size:18px;">
                  <input type="hidden" name="roleid" value="3" class="form-control">
                </div>
                <div class="form-group pt-3">
                  <label style="color:#3a87ad; font-size:14px;">Select your Image</label>
                  <input type="file" name="image">
                </div>
                <div class="form-group">
                  <button style="float:right;" type="submit" name="register" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Register</button>
                </div><br /><br /><br />
            </form>
          </div>
        </div>
      </div>
  <?php
  include 'inc/footer.php';

  ?>
