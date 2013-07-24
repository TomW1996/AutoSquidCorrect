<?php
	$sampleMass = $_POST['postSampleMass'];	//Get data sent from main page and store in variables
	$molWeight = $_POST['postMolWeight'];
	$sampleEico = $_POST['postSampleEico'];
	$blankEico = $_POST['postBlankEico'];
	$pascalValue = $_POST['postPascalValue'];
	$eicoData = $_POST['postEicoData'];
	$applyCorrection = $_POST['postApplyCorrection'];
	
	$fw = fopen('upload/config.txt', 'w');	//Create a new file to write to
	fwrite($fw, "Raw Data File: upload/rawData.txt"."\n");	//Write config file to be used by python correction script, use values sent from main page, taken from input fields
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
	if($applyCorrection == 0){
		fwrite($fw, "Pascal Correction Value: null");
	}
	else{
		fwrite($fw, "Pascal Correction Value: ".$pascalValue);
	}
	fclose($fw);	//Close file writer

	shell_exec('C:\Python33\python.exe SQUID-Fix.py');	//Run python correction script
?>