<?php
	$sampleMass = $_POST['postSampleMass'];
	$molWeight = $_POST['postMolWeight'];
	$sampleEico = $_POST['postSampleEico'];
	$blankEico = $_POST['postBlankEico'];
	$pascalValue = $_POST['postPascalValue'];
	$fw = fopen('upload/test.txt', 'w');
	fwrite($fw, $sampleMass."\n");
	fwrite($fw, $molWeight."\n");
	fwrite($fw, $sampleEico."\n");
	if($pascalValue != ""){
		fwrite($fw, $blankEico."\n");
		fwrite($fw, $pascalValue);
	}
	else{
		fwrite($fw, $blankEico);
	}
	fclose($fw);
?>