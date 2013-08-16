<html>
	<meta http-equiv="refresh" content="0; url=../index.php"> <!--Return to main page after page has run-->
	<?php
		if(file_exists("../upload/gelcapData.txt")){ //Check that gelcapData.txt exists in the upload file
			unlink("../upload/gelcapData.txt");	//If true, delete the raw data files
			unlink("../upload/gelName.txt");
		}
	?>
</html>