<?php
  include 'inc/header.php';
  Session::CheckSession();
  $logMsg = Session::get('logMsg');
  if (isset($logMsg)) {
    echo $logMsg;
  }
  $msg = Session::get('msg');
  if (isset($msg)) {
    echo $msg;
  }
  Session::set("msg", NULL);
  Session::set("logMsg", NULL);
?>
<?php
require_once('config/dbcon.php');
// $conn=new PDO('mysql:host=localhost; dbname=fsutility', 'root', '') or die(mysql_error());
if(isset($_POST['submit'])!=""){
  $name=$_FILES['file']['name'];
  $size=$_FILES['file']['size'];
  $type=$_FILES['file']['type'];
  $temp=$_FILES['file']['tmp_name'];  
  $fname = date("YmdHis").'_'.$name;
  $chk = $conn->query("SELECT * FROM  upload where name = '$name' ")->rowCount();
  if($chk){
    $i = 1;
    $c = 0;
	while($c == 0){
    	$i++;
    	$reversedParts = explode('.', strrev($name), 2);
    	$tname = (strrev($reversedParts[1]))."_".($i).'.'.(strrev($reversedParts[0]));
   
    	$chk2 = $conn->query("SELECT * FROM  upload where name = '$tname' ")->rowCount();
    	if($chk2 == 0){
    		$c = 1;
    		$name = $tname;
    	}
    }
}
 $move =  move_uploaded_file($temp,"upload/".$fname);
 if($move){
 	$query=$conn->query("insert into upload(name,fname)values('$name','$fname')");
	if($query){
	header("location:dashboard.php");
	}
	else{
	die(mysql_error());
	}
 }
}
?>
<link rel="stylesheet" type="text/css" href="css/dashboard_style.css">
<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css">
<!-- <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet"> -->
<style>
  iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
  }
</style>
  <div class="card ">
    <div class="card-header">
      <h4><i class="fa fa-dashboard"></i>&nbsp;Dashboard <span class="float-right">Welcome!
      <strong>
        <span class="badge badge-lg text-white" style="background-color: purple;">
          <?php
            $username = Session::get('username');
            if (isset($username)) {
              echo $username;
            }
           ?>
        </span>
      </strong></span></h4>
    </div>
    <div class="card-body pr-2 pl-2">
      <body><br />
        <div class="row-fluid">
          <div class="span12">
            <div class="container">
              <section id="main" style="margin-bottom:300px;">
                <iframe src="reports/index.php"></iframe>
              </section>
                
            </div>
          </div>
        </div>
      </body>      
  </div>
  <?php
  include 'inc/footer.php';
?>
</div>
