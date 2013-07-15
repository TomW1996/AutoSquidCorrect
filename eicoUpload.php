<?php
	if ($_FILES["file"]["error"] > 0)
	{
		print("Error: " . $_FILES["file"]["error"] . "<br>");
	}
	else
	{
		print("Upload: " . $_FILES["file"]["name"] . "<br>");
		print("Type: " . $_FILES["file"]["type"] . "<br>");
		print("Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>");
		print("Stored in: " . $_FILES["file"]["tmp_name"] . "<br>");
	}

	if(file_exists("upload/" . $_FILES["file"]["name"]))
	{
		print($_FILES["file"]["name"] . " already exists. ");
	}
	else
	{
		move_uploaded_file($_FILES["file"]["tmp_name"], "upload/eicoData.txt");
	}			
?>