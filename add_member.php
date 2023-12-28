<?php
include('connection.php');
$voters_id = $_POST['voters_id'];
$memid = $_POST['memid'];
$pbno = $_POST['pbno'];
$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$bday = $_POST['bday'];
$membershipdate = $_POST['membershipdate'];
$status = $_POST['status'];
$branch = $_POST['branch'];
$password = $_POST['password'];
$isregistered = "0";
$count = "1";
$sql = "INSERT INTO `voters` (`voters_id`,`memid`,`pbno`,`lastname`,`firstname`,`middlename`,`bday`,`membershipdate`,`status`,`branch`,`password`,`isregistered`,`count`) values ('$voters_id', '$memid', '$pbno', '$lastname', '$firstname', '$middlename', '$bday', '$membershipdate', '$status', '$branch', '$password', '$isregistered', '$count')";
$query= mysqli_query($con,$sql);
$lastId = mysqli_insert_id($con);
if($query ==true)
{
    $data = array(
        'status'=>'true',
    );
    echo json_encode($data);
}
else
{
     $data = array(
        'status'=>'false',
    );

    echo json_encode($data);
}
?>
