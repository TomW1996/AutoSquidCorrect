<?php
	$sampleMass = $_POST['postSampleMass'];
	$molWeight = $_POST['postMolWeight'];
	$sampleEico = $_POST['postSampleEico'];
	$blankEico = $_POST['postBlankEico'];
	$pascalValue = $_POST['postPascalValue'];
	$fw = fopen('upload/config.txt', 'w');
	fwrite($fw, "upload/rawData"."\n");
	fwrite($fw, "upload/gelcapData"."\n");
	fwrite($fw, "upload/eicoData"."\n");
	fwrite($fw, $sampleEico."\n");
	fwrite($fw, $blankEico."\n");
	fwrite($fw, $molWeight."\n");
	fwrite($fw, $sampleMass."\n");
	fwrite($fw, "temperature"."\n");
	fwrite($fw, "long moment"."\n");
	if($pascalValue == ""){
		fwrite($fw, "null");
	}
	else{
		fwrite($fw, $pascalValue);
	}
	fclose($fw);
?>