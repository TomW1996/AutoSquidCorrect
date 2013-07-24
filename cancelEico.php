<html>
	<meta http-equiv="refresh" content="0; url=SQUID-Fix.php"> <!--Return to main page after page has run-->
	<?php
		if(file_exists("upload/eicoData.txt")){ //Check that eicoData.txt exists in the upload file
			unlink("upload/eicoData.txt");	//If true, delete the eicosane data files
			unlink("upload/eicoName.txt");
		}
	?>
</html>