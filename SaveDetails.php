<?php
	$sampleMass = $_POST['postSampleMass'];
	$molWeight = $_POST['postMolWeight'];
	$sampleEico = $_POST['postSampleEico'];
	$blankEico = $_POST['postBlankEico'];
	$applyCorrection = $_POST['postApplyCorrection'];
	$pascalValue = $_POST['postPascalValue'];
	$fw = fopen('upload/saveDetails.txt', 'w');
	fwrite($fw, $sampleMass."\n");
	fwrite($fw, $molWeight."\n");
	fwrite($fw, $sampleEico."\n");
	fwrite($fw, $blankEico."\n");	
	fwrite($fw, $applyCorrection."\n");
	fwrite($fw, $pascalValue);
	fclose($fw);
?>