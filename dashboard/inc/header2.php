<?php
$filepath = realpath(dirname(__FILE__));
include_once $filepath."/../lib/Session.php";
Session::init();



spl_autoload_register(function($classes){

  include 'classes/'.$classes.".php";

});


$users = new Users();

?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>NOVADECI >>MEMBERSHIP</title>
    <link rel="icon" href="assets/icon/favicon.ico">
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
    <!-- <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="assets/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/style.css">


    <style>
    body {
      background-color:gray;
    }
</style>
  </head>
  <body>


<?php


if (isset($_GET['action']) && $_GET['action'] == 'logout') {
  Session::destroy();
}



 ?>


    <div class="container" style="width:365px; margin:0px auto">
      <br />
      <nav class="navbar navbar-expand-md navbar-dark bg-success">
        <a class="navbar-brand" href="index.php">
          <img src="assets/img/membership.png" />
        </a>
        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button> -->

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav ml-auto">

          <?php if (Session::get('id') == TRUE) { ?>
            <?php if (Session::get('roleid') == '1') { ?>

              <li class="nav-item">
                  <a class="nav-link" href="userlist.php"><i class="fa fa-users"></i>&nbsp;User lists </span></a>
              </li>
              <li class="nav-item
              <?php
                  $path = $_SERVER['SCRIPT_FILENAME'];
                  $current = basename($path, '.php');
                  if ($current == 'addUser') {
                    echo " active ";
                  }
               ?>">

                <a class="nav-link" href="addUser.php"><i class="fa fa-user-plus"></i>&nbsp;Add user </span></a>
              </li>
            <?php  } ?>

            <li class="nav-item
              <?php
        				$path = $_SERVER['SCRIPT_FILENAME'];
        				$current = basename($path, '.php');
        				if ($current == 'profile') {
        					echo "active ";
        				}
        			 ?>
              ">
              <a class="nav-link" href="profile.php?id=<?php echo Session::get("id"); ?>"><i class="fa fa-user-circle"></i>&nbsp;Profile <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?action=logout"><i class="fa fa-sign-out"></i>&nbsp;Logout</a>
            </li>
          <?php }else{ ?>

              <!-- <li class="nav-item
              <?php
                $path = $_SERVER['SCRIPT_FILENAME'];
                $current = basename($path, '.php');
                if ($current == 'register') {
                  echo " active ";
                }
              ?>">
                <a class="nav-link" href="register.php"><i class="fa fa-user-plus"></i>&nbsp;Register</a>
              </li>

              <li class="nav-item
                <?php
          				$path = $_SERVER['SCRIPT_FILENAME'];
          				$current = basename($path, '.php');
          				if ($current == 'login') {
          					echo " active ";
          				}
          			?>">
                <a class="nav-link" href="login.php"><i class="fa fa-sign-in mr-2"></i>&nbsp;Login</a>
              </li> -->

          <?php } ?>
          </ul>
        </div>
      </nav>
