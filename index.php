<?php session_start(); ?>
<?php include('dbcon.php'); ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="shortcut icon" href="imgs/logo.gif">
</head>
<body>
<div class="form-wrapper" style="height:300px;">

  <form action="#" method="post">
    <img src="img/1.png" alt="" style="width:260px;">

    <div class="form-item">
		<input type="text" name="user" required="required" placeholder="Username" autofocus required></input>
    </div>

    <div class="form-item">
		<input type="password" name="pass" required="required" placeholder="Password" required></input>
    </div>

    <div class="button-panel">
		<input type="submit" class="button" title="Log In" name="login" value="Login"></input>
    </div>
  </form>
  <?php
	if (isset($_POST['login']))
		{
			$username = mysqli_real_escape_string($con, $_POST['user']);
			$password = mysqli_real_escape_string($con, $_POST['pass']);

			$query 		= mysqli_query($con, "SELECT * FROM users WHERE  password='$password' and username='$username'");
			$row		= mysqli_fetch_array($query);
			$num_row 	= mysqli_num_rows($query);

			if ($num_row > 0)
				{
					$_SESSION['user_id']=$row['user_id'];
					header('location:home.php');

				}
			else
				{
					echo 'Invalid Username and Password Combination';
				}
		}
  ?>
  <!--<div class="reminder">-->
    <!-- <p>Not a member? <a href="#">Sign up now</a></p>
    <p><a href="#">Forgot password?</a></p> -->
  <!--</div>-->

</div>

</body>
</html>
