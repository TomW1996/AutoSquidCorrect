<html>
	<meta http-equiv="refresh" content="0; url=SQUID-Fix.php"> 
	<?php
		if(file_exists("upload/gelcapData.txt")){
			shell_exec('C:\Python33\python.exe cancelCap.py');
		}
	?>
</html>