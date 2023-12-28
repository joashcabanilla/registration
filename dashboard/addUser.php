<?php
include 'inc/header.php';
Session::CheckSession();
$sId =  Session::get('roleid');
if ($sId === '1') { ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addUser'])) {

  $userAdd = $users->addNewUserByAdmin($_POST);
}

if (isset($userAdd)) {
  echo $userAdd;
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
          <h4><i class="fa fa-user-plus"></i>&nbsp;Add New User <span class="float-right"> <a class="btn btn-warning" onclick="history.go(-1)"><i class="fa fa-arrow-circle-left"></i>&nbsp;Back</a> </h4>
        </div>
        <div class="cad-body">



            <div style="width:300px; margin:0px auto">

            <form class="" action="" method="post">
                <div class="form-group pt-3">
                  <label for="name" style="color:gray;">Full Name</label>
                  <input type="text" name="name"  style="width:300px; margin:0px auto;font-size:18px;">
                </div>
                <div class="form-group">
                  <label for="username" style="color:gray;">Username</label>
                  <input type="text" name="username"  style="width:300px; margin:0px auto;font-size:18px;">
                </div>
                <div class="form-group">
                  <label for="email" style="color:gray;">Email</label>
                  <input type="email" name="email"  style="width:300px; margin:0px auto;font-size:18px;">
                </div>
                <div class="form-group">
                  <label for="mobile" style="color:gray;">Mobile Number</label>
                  <input type="text" name="mobile"  style="width:300px; margin:0px auto;font-size:18px;">
                </div>
                <div class="form-group">
                  <label for="branch" style="color:gray;">Branch / Satellite</label>
                  <select name="branch" id="branch" style="width:300px; margin:0px auto;font-size:18px;">
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
                  <label for="password" style="color:gray;">Password</label>
                  <input type="password" name="password" style="width:300px; margin:0px auto;font-size:18px;">
                </div>
                <div class="form-group">
                  <div class="form-group">
                    <label for="sel1" style="color:gray;">Select user Role</label>
                    <select name="roleid" id="roleid" style="width:300px; margin:0px auto;font-size:18px;">
                      <option value=""></option>
                      <option value="1">Admin</option>
                      <!-- <option value="2">Editor</option> -->
                      <option value="3">User Only</option>
                    </select>
                  </div>
                </div><br />
                <div class="form-group">
                  <button type="submit" name="addUser" class="btn btn-success" style="float:right"><i class="fa fa-save"></i>&nbsp;Register</button>
                </div><br /><br /><br />


            </form>
          </div>


        </div>
      </div>

<?php
}else{

  header('Location:userlist.php');



}
 ?>

  <?php
  include 'inc/footer.php';

  ?>
