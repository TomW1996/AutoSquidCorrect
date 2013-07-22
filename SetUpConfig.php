<?php
	$sampleMass = $_POST['postSampleMass'];
	$molWeight = $_POST['postMolWeight'];
	$sampleEico = $_POST['postSampleEico'];
	$blankEico = $_POST['postBlankEico'];
	$pascalValue = $_POST['postPascalValue'];
	$eicoData = $_POST['postEicoData'];
	$fw = fopen('upload/config.txt', 'w');
	fwrite($fw, "Raw Data File: upload/rawData.txt"."\n");
	fwrite($fw, "Gel Cap Data File: upload/gelcapData.txt"."\n");
	if($eicoData != ""){
		fwrite($fw, "Eicosane Data File: upload/eicoData.txt"."\n");	
	}
	else{
		fwrite($fw, "Eicosane Data File: null"."\n");
	}
	if($sampleEico != ""){
		fwrite($fw, "Eicosane - Sample Mass: ".$sampleEico."\n");
	}
	else{
		fwrite($fw, "Eicosane - Sample Mass: 0"."\n");
	}
	if($blankEico != ""){
		fwrite($fw, "Eicosane - Blank Mass: ".$blankEico."\n");
	}
	else{
		fwrite($fw, "Eicosane - Blank Mass: 0"."\n");
	}
	fwrite($fw, "Molecular Weight : ".$molWeight."\n");
	fwrite($fw, "Sample Mass: ".$sampleMass."\n");
	fwrite($fw, "Data Set X: temperature"."\n");
	fwrite($fw, "Data Set Y: long moment"."\n");
	if($pascalValue == ""){
		fwrite($fw, "Pascal Correction Value: null");
	}
	else{
		fwrite($fw, "Pascal Correction Value: ".$pascalValue);
	}
	fclose($fw);
	shell_exec('C:\Python33\python.exe SQUID-Fix.py');
?>