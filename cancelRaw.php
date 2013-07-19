<html>
	<meta http-equiv="refresh" content="0; url=SQUID-Fix.php"> 
	<?php
		if(file_exists("upload/rawData.txt")){
			shell_exec('C:\Python33\python.exe cancelRaw.py');
		}
		if(file_exists("upload/rawData.txt")){
			shell_exec('C:\Python33\python.exe cancelRawName.py');
		}
	?>	
</html>