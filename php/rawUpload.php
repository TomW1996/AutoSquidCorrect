<?php
	$allowedExts = array("csv", "dat", "txt");	//Array to store acceptable extensions - upload file can only be certain file types
	$temp = explode(".", $_FILES["file"]["name"]);	//Split file name by .
	$extension = end($temp);	//Get last section - extension
	if (($_FILES["file"]["size"] > 0) && ($_FILES["file"]["size"] < 20000) && in_array($extension, $allowedExts)) //Check that file is 0-20000 bytes and has an acceptable extension
	{
		if($_FILES["file"]["error"] > 0){	//Are there any erors?
			print("Error: " . $_FILES["file"]["error"] . "<br>");	//Print errors
		}
		else
		{
			
			if(file_exists("../upload/" . $_FILES["file"]["name"]))	//Check if file already exists
			{
				print($_FILES["file"]["name"] . " already exists. ");
			}
			else	//File does not already exist
			{
				$fw = fopen("../upload/rawName.txt", "w");	//Store original name of file in text document
				fwrite($fw, $_FILES["file"]["name"]);
				fclose($fw);
				move_uploaded_file($_FILES["file"]["tmp_name"], "../upload/rawData.txt");	//Move the file to the upload folder
			}
		}
	}
	else{
		//Invalid file
	}	
?>