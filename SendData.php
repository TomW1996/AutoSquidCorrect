<?php
	$sampleMass = $_POST['varSampleMass'];
	$molWeight = $_POST['varMolWeight'];
	$sampleEico = $_POST['varSampleEico'];
	$blankEico = $_POST['varBlankEico'];
	
	$fileRead = fopen('upload/config.txt', 'r');
	$fileWrite = fopen("upload/tempConfig.txt", "w");
	$theLine = fread($fileRead);
	while theLine != ""{
		if(strpos($theLine,'Eicosane') !== false){
			if(strpos($theLine,'Sample') !== false){
				theData = theLine.explode(':');
				$fileWrite.write(theData[0].': '.$sampleEico."\n");
				$theLine = fread($fileRead);
			}	
			if(strpos($theLine,'Blank') !== false){
				theData = theLine.split(":");
				$fileWrite.write(theData[0].': '.$blankEico."\n");
				$theLine = fread($fileRead);
			}
		}		
		if(strpos($theLine,'Molecular') !== false){
			theData = theLine.split(":");
			$fileWrite.write(theData[0].': '.$sampleMass."\n");
			$theLine = fread($fileRead);
		}	
		if(strpos($theLine,'Compound') !== false){
			theData = theLine.split(":");
			$fileWrite.write(theData[0].': '.$molWeight."\n");
			$theLine = fread($fileRead);
		}
		if(strpos($theLine,'Pascal') !== false){
			theData = theLine.split(":");
			$fileWrite.write(theData[0].': '.$pascalValue."\n");
			$theLine = fread($fileRead);
		}
		else{
			fwrite($fileWrite, $theLine);
			$theLine = fread($fileRead);
		}
	}
	fclose($fileWrite);
	fclose($fileRead);
/*
	os.remove("upload/config.txt")
	$fileRead = open("upload/tempConfig.txt", "r")
	$fileWrite = open("upload/config.txt", "w")
	theLine = $fileRead.readline()
	while theLine:
		$fileWrite.write(theLine)
		theLine = $fileRead.readline()
	$fileWrite.close()
	$fileRead.close()
	os.remove("upload/tempConfig.txt")*/
?>	