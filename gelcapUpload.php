<?php
	$allowedExts = array("csv", "dat", "txt");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);
	if (($_FILES["file"]["size"] > 0) && ($_FILES["file"]["size"] < 20000) && in_array($extension, $allowedExts))
	{
		if($_FILES["file"]["error"] > 0){
			print("Error: " . $_FILES["file"]["error"] . "<br>");
		}
			else
			{
				print("Upload: " . $_FILES["file"]["name"] . "<br>");
				print("Type: " . $_FILES["file"]["type"] . "<br>");
				print("Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>");
				print("Stored in: " . $_FILES["file"]["tmp_name"] . "<br>");
			
			if(file_exists("upload/" . $_FILES["file"]["name"]))
			{
				print($_FILES["file"]["name"] . " already exists. ");
			}
			else
			{	
				$fw = fopen("upload/gelName.txt", "w");
				fwrite($fw, $_FILES["file"]["name"]);
				fclose($fw);
				move_uploaded_file($_FILES["file"]["tmp_name"], "upload/gelcapData.txt");
			}
		}
	}
	else{
		print("Invalid file");
	}	
?>