<?php
include('db.php');
include('function.php');
if(isset($_POST["operation"]))
{
	if($_POST["operation"] == "Add")
	{
		$image = '';
		if($_FILES["user_image"]["name"] != '')
		{
			$image = upload_image();
		}
		$statement = $connection->prepare("
			INSERT INTO members (mem_id, fullname, branch, image)
			VALUES (:mem_id, :fullname, :branch, :image)
		");
		$result = $statement->execute(
			array(
				':mem_id'	=>	$_POST["mem_id"],
				':fullname'	=>	$_POST["fullname"],
				':branch'	=>	$_POST["branch"],
				':image'		=>	$image
			)
		);
		if(!empty($result))
		{
			echo 'Data Inserted';
		}
	}
	if($_POST["operation"] == "Edit")
	{
		$image = '';
		if($_FILES["user_image"]["name"] != '')
		{
			$image = upload_image();
		}
		else
		{
			$image = $_POST["hidden_user_image"];
		}
		$statement = $connection->prepare(
			"UPDATE members
			SET mem_id = :mem_id, fullname = :fullname, branch = :branch, image = :image, updated_count = :updated_count
			WHERE id = :id
			"
		);
		$result = $statement->execute(
			array(
				':mem_id'	=>	$_POST["mem_id"],
				':fullname'	=>	$_POST["fullname"],				
				':branch'	=>	$_POST["branch"],
				':image'		=>	$image,
				':updated_count'	=>	$_POST["updated_count"],
				':id'			=>	$_POST["user_id"]
			)
		);
		if(!empty($result))
		{
			echo 'Data Updated';
		}
	}
}

?>
