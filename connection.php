<?php
ini_set('display_errors', 'on');
$con  = mysqli_connect("localhost","root","","registration");
if(mysqli_connect_errno())
{
    echo 'Database Connection Error';
}
