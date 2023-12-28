<?php
include('db.php');
include('function.php');
if(isset($_POST["user_id"]))
{
	$output = array();
	$statement = $connection->prepare(
		"SELECT * FROM members
		WHERE id = '".$_POST["user_id"]."'
		LIMIT 1"
	);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output["mem_id"] = $row["mem_id"];
		$output["fullname"] = $row["fullname"];
		$output["branch"] = $row["branch"];
		if($row["image"] != '')
		{
			$output['user_image'] = '<img src="upload/'.$row["image"].'" class="img-thumbnail"  width="100" height="200"/><input type="hidden" name="hidden_user_image" value="'.$row["image"].'" data-action="zoom" class="pull-left" />';
		}
		else
		{
			$output['user_image'] = '<input type="hidden" name="hidden_user_image" value="" />';
		}
	}
	echo json_encode($output);
}
?>
