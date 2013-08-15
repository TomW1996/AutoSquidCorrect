<?php
	$sampleMass = $_POST['postSampleMass'];	//Store data sent from main page in variables
	$molWeight = $_POST['postMolWeight'];
	$sampleEico = $_POST['postSampleEico'];
	$blankEico = $_POST['postBlankEico'];
	$pascalValue = $_POST['postPascalValue'];
	$applyPascal = $_POST['postApplyPascal'];
	$downloadHide = $_POST['postDownloadHide'];
	$graphHide = $_POST['postGraphHide'];
	$sentFrom = $_POST['postSentFrom'];
	
	$fw = fopen('upload/saveDetails.txt', 'w');	//Create new file to write to
	fwrite($fw, $sampleMass."\n");	//Write data to file, each on a new line
	fwrite($fw, $molWeight."\n");	//Data used to refill input fields after cancellation refresh
	fwrite($fw, $sampleEico."\n");
	fwrite($fw, $blankEico."\n");
	fwrite($fw, $pascalValue."\n");
	fwrite($fw, $applyPascal."\n");
	fwrite($fw, $downloadHide);
	fclose($fw);	//Close file writer
?>