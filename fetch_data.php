<?php include('connection.php');

$output= array();
$sql = "SELECT * FROM voters ";
$totalQuery = mysqli_query($con,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE CONCAT( lastname,  ' ', firstname,  ' ', middlename ) like '%".$search_value."%'";
  $sql .= " OR voters_id like '%".$search_value."%'";
  $sql .= " OR memid like '%".$search_value."%'";
  $sql .= " OR pbno like '%".$search_value."%'";
  $sql .= " OR pbnum like '%".$search_value."%'";
	//
	// $sql .= " OR stat like '%".$search_value."%'";
}
if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$column_name." ".$order."";
}
else
{
	$sql .= " ORDER BY id asc";
}
if($_POST['length'] != -1)
{
	$start = $_POST['start'];
	$length = $_POST['length'];
	$sql .= " LIMIT  ".$start.", ".$length;
}

$query = mysqli_query($con,$sql);
$count_rows = mysqli_num_rows($query);
$data = array();
while($row = mysqli_fetch_assoc($query))
{
	$sub_array = array();
	$sub_array[] = $row['id'];
	$sub_array[] = $row['pbno'];
	$sub_array[] = $row['memid'];
	$sub_array[] = $row['lastname'];
	$sub_array[] = $row['firstname'];
	$sub_array[] = $row['middlename'];
	$sub_array[] = $row['branch'];
	$sub_array[] = $row['regs_date'];
	// $sub_array[] = $row['giveaway_received'];
	// $sub_array[] = $row['date_received'];
	$sub_array[] = $row['calendar_received'];
	$sub_array[] = $row['calendar_date_received'];
	// $sub_array[] = $row['comp_name'];

	// $sub_array[] = '<a href="javascript:void();" data-id="'.$row['id'].'"  class="btn btn-info btn-sm editbtn" >Edit</a>  <a href="javascript:void();" data-id="'.$row['id'].'"  class="btn btn-danger btn-sm deleteBtn" >Delete</a>';
	$sub_array[] = '<a data-id="'.$row['id'].'" class="btn btn-success btn-sm editbtn" >Update</a>';
	$data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=>   $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
