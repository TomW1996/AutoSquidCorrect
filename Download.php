<?php	
	if(file_exists("upload/rawName.txt")){
		$fr = fopen("upload/rawName.txt", "r");
		$name = fgets($fr);
		fclose($fr);
		$parts = explode('.', $name);
		$name = $parts[0].'_Corrected.txt';
		$file = $_POST['file_name'];
		header('Content-type: text/plain');
		header('Content-Disposition: attachment; filename='.$name.'');
		readfile('upload/'.$file);
	}
?>