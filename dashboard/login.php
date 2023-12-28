<?php
  include 'inc/header2.php';
  Session::CheckLogin();
?>
<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
     $userLog = $users->userLoginAuthotication($_POST);
  }
  if (isset($userLog)) {
    echo $userLog;
  }
  $logout = Session::get('logout');
  if (isset($logout)) {
    echo $logout;
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
</style>
  <div class="card">
    <!-- <div class="card-header">
      <h4 class='text-center'>User login</h4>
    </div> -->
    <div class="card-body">
        <div style="width:300px; margin:0px auto">
        <form class="" action="" method="post">
            <div class="form-group">
              <label for="email" style="color:gray;">Email</label>
              <input type="email" name="email" style="width:300px; margin:0px auto;font-size:18px;">
            </div>
            <div class="form-group">
              <label for="password" style="color:gray;">Password</label>
              <input type="password" name="password" style="width:300px; margin:0px auto;font-size:18px;">
            </div>
            <div class="form-group" style="float:right">
              <button type="submit" class="btn btn-success" name="login"><i class="fa fa-sign-in"></i>&nbsp;Login</button>
            </div>

            <!-- <div class="form-group" style="float:right">             
                  Don't have an account!
                  <a href="register.php">Register here</a>              
            </div> -->
        </form>
      </div>
    </div>
  </div>
  <?php
  include 'inc/footer.php';

  ?>
