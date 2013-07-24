<?php
	$sampleMass = $_POST['postSampleMass'];
	$molWeight = $_POST['postMolWeight'];
	$sampleEico = $_POST['postSampleEico'];
	$blankEico = $_POST['postBlankEico'];
	$pascalValue = $_POST['postPascalValue'];
	$applyPascal = $_POST['postApplyPascal'];
	$downloadHide = $_POST['postHidden'];
	$fw = fopen('upload/saveDetails.txt', 'w');
	fwrite($fw, $sampleMass."\n");
	fwrite($fw, $molWeight."\n");
	fwrite($fw, $sampleEico."\n");
	fwrite($fw, $blankEico."\n");
	fwrite($fw, $pascalValue."\n");
	fwrite($fw, $applyPascal."\n");
	fwrite($fw, $downloadHide);
	fclose($fw);
?>