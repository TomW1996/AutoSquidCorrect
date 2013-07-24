<html>
	<meta http-equiv="refresh" content="0; url=SQUID-Fix.php"> <!--Return to main page after page has run-->
	<?php
		if(file_exists("upload/rawData.txt")){ //Check that rawData.txt exists in the upload file
			unlink("upload/rawData.txt");	//If true, delete the raw data files
			unlink("upload/rawName.txt");
		}
	?>	
</html>