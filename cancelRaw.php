<?php
	if(file_exists("upload/rawData.txt")){
		shell_exec('C:\Python33\python.exe cancelRaw.py');
	}
	if(file_exists("upload/rawData.txt")){
		shell_exec('C:\Python33\python.exe cancelRawName.py');
	}
?>	
