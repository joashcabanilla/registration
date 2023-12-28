<?php
include 'inc/header.php';
Session::CheckSession();

 ?>

<?php

if (isset($_GET['id'])) {
  $userid = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['id']);

}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
  $updateUser = $users->updateUserByIdInfo($userid, $_POST);

}
if (isset($updateUser)) {
  echo $updateUser;
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
    <h4><i class="fa fa-id-card-o"></i>&nbsp;User Profile <span class="float-right"> <a href="dashboard.php" class="btn btn-warning"><i class="fa fa-home"></i></a> </h4>
   </div>
        <div class="card-body">

    <?php
    $getUinfo = $users->getUserInfoById($userid);
    if ($getUinfo) {
     ?>
          <div style="width:300px; margin:0px auto">

          <form class="" action="" method="POST">
              <div class="form-group">
                <label for="pbno" style="color:gray;font-style:italic;">PB# / Member ID</label>
                <input type="text" name="pbno" value="<?php echo $getUinfo->pbno; ?>" style="width:300px; margin:0px auto;font-size:18px;">
              </div>
              <div class="form-group">
                <label for="name" style="color:gray;font-style:italic;">Name</label>
                <input type="text" name="name" value="<?php echo $getUinfo->name; ?>" style="width:300px; margin:0px auto;font-size:18px;">
              </div>
              <div class="form-group">
                <label for="mobile" style="color:gray;font-style:italic;">Mobile Number</label>
                <input type="text" id="mobile" name="mobile" value="<?php echo $getUinfo->mobile; ?>" style="width:300px; margin:0px auto;font-size:18px;">
              </div>
              <div class="form-group">
                <!-- <label for="branch" style="color:gray;font-style:italic;">Branch / Satellite</label>
                <input type="text" id="branch" name="branch" value="<?php echo $getUinfo->branch; ?>" style="width:300px; margin:0px auto;font-size:18px;"> -->
                <label for="branch" style="color:gray;">Branch / Satellite</label>
                <select name="branch" style="width:300px; margin:0px auto;font-size:18px;">
                  <option value=""><?php echo $getUinfo->branch; ?></option>
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
                <label for="username" style="color:gray;font-style:italic;">Username</label>
                <input type="text" name="username" value="<?php echo $getUinfo->username; ?>" style="width:300px; margin:0px auto;font-size:18px;">
              </div>
              <div class="form-group">
                <label for="email" style="color:gray;font-style:italic;">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $getUinfo->email; ?>" style="width:300px; margin:0px auto;font-size:18px;">
              </div>


              <?php if (Session::get("roleid") == '1') { ?>

              <div class="form-group
              <?php if (Session::get("roleid") == '1' && Session::get("id") == $getUinfo->id) {
                echo "d-none";
              } ?>
              ">
                <div class="form-group">
                  <label for="sel1" style="color:gray;font-style:italic;">Select user Role</label>
                  <select name="roleid" id="roleid" style="width:300px; margin:0px auto;font-size:18px;">

                  <?php

                if($getUinfo->roleid == '1'){?>
                  <option value="1" selected='selected'>Admin</option>
                  <!-- <option value="2">Editor</option> -->
                  <option value="3">User only</option>
                <?php }elseif($getUinfo->roleid == '2'){?>
                  <option value="1">Admin</option>
                  <!-- <option value="2" selected='selected'>Editor</option> -->
                  <option value="3">User only</option>
                <?php }elseif($getUinfo->roleid == '3'){?>
                  <option value="1">Admin</option>
                  <!-- <option value="2">Editor</option> -->
                  <option value="3" selected='selected'>User only</option>


                <?php } ?>


                  </select>
                </div>
              </div>

          <?php }else{?>
            <input type="hidden" name="roleid" value="<?php echo $getUinfo->roleid; ?>">
          <?php } ?>

              <?php if (Session::get("id") == $getUinfo->id) {?>
              <br />
              <div class="form-group">
                <button type="submit" name="update" class="btn btn-success" style="margin-right:17px"><i class="fa fa-save"></i>&nbsp;Update</button>
                <a class="btn btn-danger" href="changepass.php?id=<?php echo $getUinfo->id;?>"><i class="fa fa-key"></i>&nbsp;Change password</a>
              </div>
            <?php } elseif(Session::get("roleid") == '1') {?>


              <div class="form-group">
                <button type="submit" name="update" class="btn btn-success" style="margin-right:17px"><i class="fa fa-save"></i>&nbsp;Update</button>
                <a class="btn btn-danger" href="changepass.php?id=<?php echo $getUinfo->id;?>"><i class="fa fa-key"></i>&nbsp;Change password</a>
              </div>
            <?php } elseif(Session::get("roleid") == '2') {?>


              <div class="form-group">
                <button type="submit" name="update" class="btn btn-success">Update</button>

              </div>

              <?php   }else{ ?>
                  <div class="form-group">

                    <a class="btn btn-success" href="userlist.php">Ok</a>
                  </div>
                <?php } ?>


          </form>
        </div>

      <?php }else{

        header('Location:userlist.php');
      } ?>



      </div>
    </div>


  <?php
  include 'inc/footer.php';

  ?>
