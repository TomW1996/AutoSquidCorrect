<?php	
	if(file_exists("upload/rawName.txt")){	//Check that file exists
		$fr = fopen("upload/rawName.txt", "r");	//Open the file to read
		$name = fgets($fr);	//Read the first line and store as $name - this is the original file name
		fclose($fr);	//Close file reader
		$parts = explode('.', $name);	//Split $name between .
		$name = $parts[0].'_Corrected.txt'; //Append '_Corrected.txt' to the first part of $name
		$file = $_POST['download'];	//Get location of download file
		header('Content-type: text/plain');	//Set type
		header('Content-Disposition: attachment; filename='.$name.'');	//Set name
		readfile('upload/'.$file);	//Download the file
	}
?>






