<!DOCTYPE html>  
<html>  
  <head>
  <!--
  With thanks to:
  James 'Pro Bro' Walsh
  Morten 'Pop' Albring
  The good people of the internet
  -->
    <title>SQUID-Fix</title>
	<script src="http://code.jquery.com/jquery.js"></script> 
	<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
	<script src="js/plot.js" charset="utf-8"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" type="text/css" href="css/plot.css">
	<?php
		if(file_exists("upload/saveDetails.txt")){
			//Refresh was due to cancellation - don't delete files
		}
		else{
			//Delete files
			if(file_exists("upload/rawData.txt")){
				unlink("upload/rawData.txt");
			}
			if(file_exists("upload/rawName.txt")){
				unlink("upload/rawName.txt");
			}
			if(file_exists("upload/gelcapData.txt")){
				unlink("upload/gelcapData.txt");
			}
			if(file_exists("upload/gelName.txt")){
				unlink("upload/gelName.txt");
			}
			if(file_exists("upload/eicoData.txt")){
				unlink("upload/eicoData.txt");
			}
			if(file_exists("upload/eicoName.txt")){
				unlink("upload/eicoName.txt");
			}
			if(file_exists("upload/rawData.txt_Corrected.txt")){
				unlink("upload/rawData.txt_Corrected.txt");
			}
			if(file_exists("upload/config.txt")){
				unlink("upload/config.txt");
			}
			if(file_exists("upload/graphData.txt")){
				unlink("upload/graphData.txt");
			}
		}
	?>	
  </head>  
  <body>  
    <div class="container">
		<!--Header-->
		<div class="hero-unit">
			<div class = "row">
				<div class = "span7">
					<h1>SQUID-Fix</h1>
					<p>SQUID-Fix is a tool designed for chemistry students. It will correct your raw SQUID data
					and then use that to calculate &chi; and &chi;T. To begin, enter the appropriate data
					and drag your data files into the correct boxes. If you didn't use Eicosane, leave all related fields blank.</p>
				</div>
					<img src = "images/pro_logo.png" align = "right" width = 280>
			</div>	
		</div>
		<!--Header-->
		<!--Experimental Data Section-->
		<div class  = "row">	
			<h2>Experimental Data:</h2>
			<div class="span4">
				<form class="form-horizontal">
					<!--Pascal Correction-->
					<div class="control-group">
						<label class="control-label" for="eicoPref">Pascal Correction:</label>
						<div class = "controls">
							<select class = "span2" id = "pascalSelect"  onchange =
																				'var selected = options[selectedIndex].index;	
																				if(selected == 0){
																					document.getElementById("pascalField").style.visibility = "hidden";
																					document.getElementById("pascalMagnitude").style.visibility = "hidden";
																				}
																				else{
																					document.getElementById("pascalField").style.visibility = "visible";
																					document.getElementById("pascalMagnitude").style.visibility = "visible";
																				}'> <!--Used to display the text field when the user selects the apply option-->
								<?php	//Set the state of the dropdown after refresh, to keep page the same after cancelling an uploaded file.
									if(file_exists("upload/saveDetails.txt")){
										$fr = fopen("upload/saveDetails.txt", "r");
										for($i = 0; $i < 6; $i++){
											$data = fgets($fr);
										}
										fclose($fr);
										if($data == 0){
											echo'<option value = "0" selected>Do Not Apply</option></br><option value = "1">Apply</option>';
										}
										else if($data == 1){
											echo'<option value = "0">Do Not Apply</option></br><option value = "1" selected>Apply</option>';
										}
									}
									else{
										echo'<option value = "0" selected>Do Not Apply</option></br><option value = "1">Apply</option>';
									}									
								?>
							</select>
							<div class = "input-append">
								<input class = "input-mini" onkeypress="return isNumberKeyPascal(event)" type = "text" id = "pascalField" placeholder="Value" value = "<?php
																															if(file_exists("upload/saveDetails.txt")){
																																$fr = fopen("upload/saveDetails.txt", "r");
																																for($i = 0; $i < 5; $i++){
																																	$data = fgets($fr);
																																}
																																fclose($fr);
																																echo $data;
																															} 
																														?>"><!--Set value - retained from before refresh-->
								<span class="add-on" id = "pascalMagnitude">x10<sup>-6</sup></span>
							</div>
						</div>
					</div>	
					<!--Pascal Correction-->
				</form>
			</div>
			<div class="span4">
				<form class="form-horizontal" method = "post">
					<!--Sample Mass-->
					<div class="control-group">
						<label class="control-label" for="sampleMass">Sample Mass:</label>
						<div class="controls">
							<div class="input-append">
								<input class="span1" onkeypress="return isNumberKey(event)" id="sampleMass" name = "sampleMass" type="text" value = "<?php
																																						if(file_exists("upload/saveDetails.txt")){
																																							$fr = fopen("upload/saveDetails.txt", "r");
																																							for($i = 0; $i < 1; $i++){
																																								$data = fgets($fr);
																																							}
																																							fclose($fr);
																																							echo $data;
																																						} 
																																					?>"><!--Set value - retained from before refresh-->
								<span class="add-on">mg</span>
							</div>
						</div>
				    </div>
					<!--Sample Mass-->
					<!--Molecular Weight-->
					<div class="control-group">
						<label class="control-label" for="molWeight">Molecular Weight:</label>
						<div class="controls">
							<div class="input-append">
								<input class="span1" onkeypress="return isNumberKey(event)" id="molWeight" type="text" value = "<?php
																																	if(file_exists("upload/saveDetails.txt")){
																																		$fr = fopen("upload/saveDetails.txt", "r");
																																		for($i = 0; $i < 2; $i++){
																																			$data = fgets($fr);
																																		}
																																		fclose($fr);
																																		echo $data;
																																	} 
																																?>"><!--Set value - retained from before refresh-->
								<span class="add-on">g mol<sup>-1</sup></span>
							</div>
						</div>
				    </div>
					<!--Molecular Weight-->
				</form>	
			</div>
			<div class="span4">
				<form class="form-horizontal">
					<!--Sample Eicosane-->
					<div class="control-group">
						<label class="control-label" for="sampleEico">Mass of Eicosane - Sample:</label>
						<div class="controls">
							<div class="input-append">
								<input class="span1" onkeypress="return isNumberKey(event)" id="sampleEico" type="text" value = "<?php
																																	if(file_exists("upload/saveDetails.txt")){
																																		$fr = fopen("upload/saveDetails.txt", "r");
																																		for($i = 0; $i < 3; $i++){
																																			$data = fgets($fr);
																																		}
																																		fclose($fr);
																																		echo $data;
																																	} 
																																?>"><!--Set value - retained from before refresh-->
								<span class="add-on">mg</span>
							</div>
						</div>
				    </div>
					<!--Sample Eicosane-->
					<!--Blank Eicosane-->
					<div class="control-group">
						<label class="control-label" for="blankEico">Mass of Eicosane - Blank:</label>
						<div class="controls">
							<div class="input-append">
								<input class="span1" onkeypress="return isNumberKey(event)" id="blankEico" type="text" value = "<?php
																																	if(file_exists("upload/saveDetails.txt")){
																																		$fr = fopen("upload/saveDetails.txt", "r");
																																		for($i = 0; $i < 4; $i++){
																																			$data = fgets($fr);
																																		}
																																		fclose($fr);
																																		echo $data;
																																	} 
																																?>"><!--Set value - retained from before refresh-->
								<span class="add-on">mg</span>
							</div>
						</div>
				    </div>
					<!--Blank Eicosane-->
				</form>					
			</div>
		</div>
		<!--Experimental Data Section-->
		<!--Data Files Section-->
		<div class="row">
			<h2>Data Files:</h2>
			<!--Raw Data Drop Upload Box-->
			<div class="span4">
				<h4>Raw Data:</h4>
				<input type = "text" id = "rawName" readonly value =    "<?php 
																			if(file_exists("upload/rawName.txt") && file_exists("upload/rawData.txt")){
																				$fr = fopen("upload/rawName.txt", "r");
																				$name = fgets($fr);
																				fclose($fr);
																				echo $name;
																			} 
																		?>"><!--Fill with name of raw data file-->
			
				<form action = "cancelRaw.php" method = "post" onclick = "retainData(0);">
					<p><input type = "submit" class = "btn btn-mini btn-primary" value = "X" id = "cancelRaw"/></p>
				</form>
				<article>
					<div id="holder1">
					</div>
					<p id="upload" class="hidden"><label>Drag & drop not supported, but you can still upload via this input field:<br><input type="file"></label></p>
					<p id="filereader">File API & FileReader API not supported</p>
					<p id="formdata">XHR2's FormData is not supported</p>
					<p id="progress">XHR2's upload progress isn't supported</p>
				</article>
			</div>
			<!--Raw Data Drop Upload Box-->
			<!--Gel Cap Data Drop Upload Box-->
			<div class="span4">
				<h4>Gel Cap:</h4>
				<input type = "text" id = "gelName" readonly value =    "<?php 
																			if(file_exists("upload/gelName.txt")){
																				$fr = fopen("upload/gelName.txt", "r");
																				$name = fgets($fr);
																				fclose($fr);
																				echo $name;
																			} 
																		?>"><!--Fill with name of gel cap data file-->	
				<form action = "cancelCap.php" method = "post" onclick = "retainData(0);">
					<p><input type = "submit" class = "btn btn-mini btn-primary" value = "X" id = "cancelCap"/></p>
				</form>
				<article>
					<div id="holder2">
					</div>
					<p id="upload" class="hidden"><label>Drag & drop not supported, but you can still upload via this input field:<br><input type="file"></label></p>
				</article>
			</div>
			<!--Gel Cap Data Drop Upload Box-->
			<!--Eicosane Data Drop Upload Box-->
			<div class="span4">
				<h4>Eicosane:</h4>
				<input type = "text" id = "eicoName" readonly value = "<?php 
																			if(file_exists("upload/eicoName.txt")){
																				$fr = fopen("upload/eicoName.txt", "r");
																				$name = fgets($fr);
																				fclose($fr);
																				echo $name;
																			} 
																		?>"><!--Fill with name of eicosane data file-->	
				<form action = "cancelEico.php" method = "post" onclick = "retainData(0);">
					<p><input type = "submit" class = "btn btn-mini btn-primary" value = "X" id = "cancelEico"/></p>
				</form>
				<article>
					<div id="holder3">
					</div>
					<p id="upload" class="hidden"><label>Drag & drop not supported, but you can still upload via this input field:<br><input type="file"></label></p>
				</article>				
			</div>
			<!--Eicosane Data Drop Upload Box-->
		</div>
		<!--Data Files Section-->
		<!--Buttons-->
		<div class = "row">
			<p><center><input type = "button" class = "btn btn-large btn-primary" value = "Correct Data" onclick = 'getData();'/></center></p><!--Runs correction script when button clicked-->
		</div>	
		<div class = "row">
			<form action = "refresh.php" method = "post" onclick = "retainData(1);">
				<p><center><input id = "graphButton" type="submit" class = "btn btn-large btn-primary" value="Plot Data"></center></p>
			</form>
			<form action="Download.php" method="post" name="downloadform" onclick = "retainData(2);"/>
				<input name="download" value="rawData.txt_Corrected.txt" type = "hidden" id = "download"/>
				<p><center><input id = "downloadButton" type="submit" class = "btn btn-large btn-primary" value="Download Data"></center></p><!--Runs download script when button clicked--> 
				<!--Mort insisted on the 'symmetry' of three "... Data" buttons-->
			</form>			
		</div>	
		<!--Buttons-->
		<!--Graph-->
		<div class = "row">
			<div id="chart"></div>
		</div>
		<!--Graph-->
		<!-- Modals -->
		<!--Fill all fields-->
		<div id="fillModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 id="myModalLabel">Error</h3>
			</div>
			<div class="modal-body">
				<p>Not all fields have been filled</p>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
		<!--Fill all fields-->
		<!--Pascal-->
		<div id="pascalModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 id="myModalLabel">Error</h3>
			</div>
			<div class="modal-body">
				<p>Pascal Correction Value was entered incorrectly</p>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
		<!--Pascal-->
		<!--Eicosane - Blank-->
		<div id="blankEicoModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 id="myModalLabel">Error</h3>
			</div>
			<div class="modal-body">
				<p>Eicosane Blank Mass was entered incorrectly</p>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
		<!--Eicosane - Blank-->
		<!--Eicosane - Sample-->
		<div id="sampleEicoModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 id="myModalLabel">Error</h3>
			</div>
			<div class="modal-body">
				<p>Eicosane Sample Mass was entered incorrectly</p>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
		<!--Eicosane - Sample-->
		<!--Molecular Weight-->
		<div id="molWeightModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 id="myModalLabel">Error</h3>
			</div>
			<div class="modal-body">
				<p>Molecular Weight was entered incorrectly</p>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
		<!--Molecular Weight-->
		<!--Sample Mass-->
		<div id="sampleMassModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 id="myModalLabel">Error</h3>
			</div>
			<div class="modal-body">
				<p>Sample Mass was entered incorrectly</p>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
		<!--Sample Mass-->
		<!--No Eicosane?-->
		<div id="confirmModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 id="myModalLabel">No Eicosane Used</h3>
			</div>
			<div class="modal-body">
				<p>Continue without Eicosane data?</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" onclick = "modalResult();" data-dismiss="modal" aria-hidden="true">Yes</button>
				<button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
			</div>
		</div>
		<!--No Eicosane?-->
		<!-- Modals -->
	
		<!--CSS Styling for drag/drop boxes-->
		<style>
			#holder1 { border: 10px dashed #ccc; width: 250px; min-height: 250px; margin: 20px auto;}
			#holder1.hover { border: 10px dashed #0c0; }
			#holder1 img { display: block; margin: 10px auto; }
			#holder1 p { margin: 10px; font-size: 14px; }
			#holder2 { border: 10px dashed #ccc; width: 250px; min-height: 250px; margin: 20px auto;}
			#holder2.hover { border: 10px dashed #0c0; }
			#holder2 img { display: block; margin: 10px auto; }
			#holder2 p { margin: 10px; font-size: 14px; }
			#holder3 { border: 10px dashed #ccc; width: 250px; min-height: 250px; margin: 20px auto;}
			#holder3.hover { border: 10px dashed #0c0; }
			#holder3 img { display: block; margin: 10px auto; }
			#holder3 p { margin: 10px; font-size: 14px; }
			.fail { background: #c00; padding: 2px; color: #fff; }
			.hidden { display: none !important;}
		</style>
		
		<script>
			<?php
				if(file_exists("upload/graphData.txt")){		//Runs the graphing data script, provided the graphData.txt file exists
					echo 'd3.text("upload/graphData.txt",f_spc);
						 function f_spc(text) {
							parseSpectra(text);
						 }';
				}
			?>
		</script>
		
		<script>
			<?php
				if(file_exists("upload/rawData.txt")){
					echo 'document.getElementById("cancelRaw").style.visibility = "visible";';
				}
				else{
					echo 'document.getElementById("cancelRaw").style.visibility = "hidden";';
				}
				if(file_exists("upload/gelcapData.txt")){
					echo 'document.getElementById("cancelCap").style.visibility = "visible";';
				}
				else{
					echo 'document.getElementById("cancelCap").style.visibility = "hidden";';
				}
				if(file_exists("upload/eicoData.txt")){
					echo 'document.getElementById("cancelEico").style.visibility = "visible";';
				}
				else{
					echo 'document.getElementById("cancelEico").style.visibility = "hidden";';
				}
			?>
			<?php	//Sets pascal value visibility state after cancellation refresh
				if(file_exists("upload/saveDetails.txt")){
					$fr = fopen("upload/saveDetails.txt", "r");
					for($i = 0; $i < 6; $i++){
						$data = fgets($fr);
					}
					fclose($fr);
					if($data == 0){
						echo 'document.getElementById("pascalField").style.visibility = "hidden";';
						echo 'document.getElementById("pascalMagnitude").style.visibility = "hidden";';
					}
					else if($data == 1){
						echo 'document.getElementById("pascalField").style.visibility = "visible";';
						echo 'document.getElementById("pascalMagnitude").style.visibility = "visible";';
					}
				}
				else{
					echo 'document.getElementById("pascalField").style.visibility = "hidden";';
					echo 'document.getElementById("pascalMagnitude").style.visibility = "hidden";';
				}
			?>
			<?php
				if(file_exists("upload/saveDetails.txt")){
					echo 'console.log("1");';
					$fr = fopen("upload/saveDetails.txt", "r");
					for($i = 0; $i < 7; $i++){
						$data = fgets($fr);
					}
					fclose($fr);
					if($data == "visible"){
						echo 'console.log("2");';
						echo 'document.getElementById("downloadButton").style.visibility = "visible";';
						echo 'document.getElementById("graphButton").style.visibility = "visible";';
						echo 'document.getElementById("cancelRaw").style.visibility = "hidden";';
						echo 'document.getElementById("cancelCap").style.visibility = "hidden";';
						echo 'document.getElementById("cancelEico").style.visibility = "hidden";';
					}
					else{
						echo 'document.getElementById("downloadButton").style.visibility = "hidden";';
						echo 'document.getElementById("graphButton").style.visibility = "hidden";';
						echo 'document.getElementById("cancelRaw").style.visibility = "visible";';
						echo 'document.getElementById("cancelCap").style.visibility = "visible";';
						echo 'document.getElementById("cancelEico").style.visibility = "visible";';
					}
				}
				else{
					echo 'document.getElementById("downloadButton").style.visibility = "hidden";';
					echo 'document.getElementById("graphButton").style.visibility = "hidden";';
					echo 'document.getElementById("cancelRaw").style.visibility = "hidden";';
					echo 'document.getElementById("cancelCap").style.visibility = "hidden";';
					echo 'document.getElementById("cancelEico").style.visibility = "hidden";';
				}
			?>
		</script>
		
		<script>	
		function isNumberKey(evt)	//Checks that entered keys are acceptable on each key press - validation only numbers and .
		{
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46){	//If key isn't a number or .
				return false;	//Don't allow key true
			}
			return true;	//Key can be typed
		}
		function isNumberKeyPascal(evt)	//Checks that entered keys are acceptable on each key press - validation only numbers and . and -
		{
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46 && charCode != 45){	//If key isn't a number or . or -
				return false;	//Don't allow key true
			}
			return true;	//Key can be typed
		}
		</script>
		
		<script>
			function modalResult(){
				var sampleMass = $('#sampleMass').val();
				var molWeight = $('#molWeight').val();
				var sampleEico = $('#sampleEico').val();
				var blankEico = $('#blankEico').val();
				var applyCorrection = $('#pascalSelect').val();
				var pascalValue = $('#pascalField').val();
				var rawData = $('#rawName').val();
				var gelData = $('#gelName').val();
				var eicoData = $('#eicoName').val()
				$.post('SetUpConfig.php', {postSampleMass: sampleMass, postMolWeight: molWeight, postSampleEico: sampleEico, postBlankEico: blankEico, postApplyCorrection: applyCorrection, postPascalValue: pascalValue, postEicoData: eicoData}, function(data){}); //Run correction - no eicosane
				document.getElementById("downloadButton").style.visibility = "visible"; //Make the download button visible
				document.getElementById("graphButton").style.visibility = "visible"; //Make the download button visible
				document.getElementById("cancelRaw").style.visibility = "hidden";
				document.getElementById("cancelCap").style.visibility = "hidden";
				document.getElementById("cancelEico").style.visibility = "hidden";
			}
		
			function getData(){	//Get values from text fields to use in correction script
				var sampleMass = $('#sampleMass').val();
				var molWeight = $('#molWeight').val();
				var sampleEico = $('#sampleEico').val();
				var blankEico = $('#blankEico').val();
				var applyCorrection = $('#pascalSelect').val();
				var pascalValue = $('#pascalField').val();
				var rawData = $('#rawName').val();
				var gelData = $('#gelName').val();
				var eicoData = $('#eicoName').val()
		
				if(sampleMass === "" || molWeight === "" || sampleEico === "" || blankEico === "" || rawData === "" || gelData === "" || eicoData === "" || (applyCorrection == 1 && pascalValue === "")){ //Are all fields filled?
					if((sampleEico === "" && blankEico === "" && eicoData === "") && sampleMass != "" && molWeight != "" && (applyCorrection == 0 || (applyCorrection == 1 && pascalValue != ""))){ //If not, are all eicosane fields empty, with the rest filled?
						if(parseFloat(sampleMass)/1 == sampleMass){
							if(parseFloat(molWeight)/1 == molWeight){
								if(applyCorrection == 0 || parseFloat(pascalValue)/1 == pascalValue){
									$('#confirmModal').modal();									
								}
								else{
									$('#pascalModal').modal();
								}
							}
							else{
								$('#molWeightModal').modal();
							}
						}
						else{
							$('#sampleMassModal').modal();
						}
					}
					else{
						$('#fillModal').modal();	//Remind them to fill all fields
					}
				} 
				else{	//If all fields are filled
					if(parseFloat(sampleMass)/1 == sampleMass){
						if(parseFloat(molWeight)/1 == molWeight){
							if(parseFloat(sampleEico)/1 == sampleEico){
								if(parseFloat(blankEico)/1 == blankEico){
									if(applyCorrection == 0 || parseFloat(pascalValue)/1 == pascalValue){
										$.post('SetUpConfig.php', {postSampleMass: sampleMass, postMolWeight: molWeight, postSampleEico: sampleEico, postBlankEico: blankEico, postApplyCorrection: applyCorrection, postPascalValue: pascalValue, postEicoData: eicoData}, function(data){}); //Send information to separate PHP script
										document.getElementById("downloadButton").style.visibility = "visible";
										document.getElementById("graphButton").style.visibility = "visible";
										document.getElementById("cancelRaw").style.visibility = "hidden";
										document.getElementById("cancelCap").style.visibility = "hidden";
										document.getElementById("cancelEico").style.visibility = "hidden";										
									}
									else{
										$('#pascalModal').modal();
									}
								}
								else{
									$('#blankEicoModal').modal();
								}
							}
							else{
								$('#sampleEicoModal').modal();
							}
						}
						else{
							$('#molWeightModal').modal();
						}
					}
					else{
						$('#sampleMassModal').modal();
					}
				}
			}
			
			function retainData(sentFrom){	//Get field data and visibility states of dropdown & download button
				var sampleMass = $('#sampleMass').val();
				var molWeight = $('#molWeight').val();
				var sampleEico = $('#sampleEico').val();
				var blankEico = $('#blankEico').val();;
				var pascalValue = $('#pascalField').val();
				var applyPascal = $('#pascalSelect').val();
				var downloadHide = document.getElementById("downloadButton").style.visibility;
				var graphHide = document.getElementById("graphButton").style.visibility;
				$.post('SaveDetails.php', {postSampleMass: sampleMass, postMolWeight: molWeight, postSampleEico: sampleEico, postBlankEico: blankEico, postPascalValue: pascalValue, postApplyPascal: applyPascal, postDownloadHide: downloadHide, postGraphHide: graphHide, postSentFrom: sentFrom}, function(data){}); //Send information to separate PHP script
			}
		</script>
			
			<script>
			function fileExists(url) {	//Check to see if a file has been uploaded
				if(url){
					var req = new XMLHttpRequest();
					req.open('GET', url, false);
					req.send();
					return req.status==200;
				} else {
					return false;
				}
			}
			
			var holder1 = document.getElementById('holder1'), //Get the raw data drag/drop box
				tests = {
				  filereader: typeof FileReader != 'undefined',
				  dnd: 'draggable' in document.createElement('span'),
				  formdata: !!window.FormData,
				  progress: "upload" in new XMLHttpRequest
				}, 
				support = {
				  filereader: document.getElementById('filereader'),
				  formdata: document.getElementById('formdata'),
				  progress: document.getElementById('progress')
				},
				progress = document.getElementById('uploadprogress'),
				fileupload = document.getElementById('upload');

			"filereader formdata progress".split(' ').forEach(function (api) {
			  if (tests[api] === false) {
				support[api].className = 'fail';
			  } else {
				support[api].className = 'hidden';
			  }
			});
			
			function previewfile1(file) {
			  if (tests.filereader === true) {
				var reader = new FileReader();
				reader.onload = function (event) {
				  theImage = new Image(250,250);
				  theImage.src = "images/tick.jpg";
				  holder1.appendChild(theImage);	//Display tick picture in box
				  document.getElementById("rawName").value = file.name;	//Fill text field with name of file
				  document.getElementById("cancelRaw").style.visibility = "visible";
				};

				reader.readAsDataURL(file);	//Read in the file
			  }  else {
				console.log(file);				
			  }
			}

			function readfiles1(files) {
				debugger;
				var formData = tests.formdata ? new FormData() : null;
				for (var i = 0; i < files.length; i++) {
				  if (tests.formdata) formData.append('file', files[i]);
				  previewfile1(files[i]);
				}

				if (tests.formdata) {
				  var xhr = new XMLHttpRequest();
				  xhr.open('POST', 'rawUpload.php');	//Send the file data to the upload PHP script

				  if (tests.progress) {
					xhr.upload.onprogress = function (event) {
					  if (event.lengthComputable) {
						var complete = (event.loaded / event.total * 100 | 0);
						if(complete === 100){
						}
					  }
					}
				  } 

				  xhr.send(formData); 
				}
			}
			
			<?php
				if(file_exists("upload/rawData.txt")){ //If the raw data file is in the upload folder after refreshing, display the tick
					echo 	'theImage = new Image(250,250);
							theImage.src = "images/tick.jpg";
							holder1.appendChild(theImage);';
				}
			?>

			if (tests.dnd) { 
			  holder1.ondragover = function () { this.className = 'hover'; return false; };	//Change the colour of the box on dragover.
			  holder1.ondragend = function () { this.className = ''; return false; };
			  holder1.ondrop = function (e) {
				this.className = '';
				e.preventDefault();
				if(fileExists("upload/rawData.txt") == false){	//Only read/upload the file if there is not already a raw data file stored in the upload folder
					readfiles1(e.dataTransfer.files);
				}	
			  }
			} else {
			  fileupload.className = 'hidden';	//If there is a problem with the boxes, use a regular upload button
			  fileupload.querySelector('input').onchange = function () {
				readfiles1(this.files);
			  };
			}
			</script>
			
			<script> //Drag/drop uploader script for gel cap box
			var holder2 = document.getElementById('holder2'),
				tests = {
				  filereader: typeof FileReader != 'undefined',
				  dnd: 'draggable' in document.createElement('span'),
				  formdata: !!window.FormData,
				  progress: "upload" in new XMLHttpRequest
				}, 
				support = {
				  filereader: document.getElementById('filereader'),
				  formdata: document.getElementById('formdata'),
				  progress: document.getElementById('progress')
				},
				progress = document.getElementById('uploadprogress'),
				fileupload = document.getElementById('upload');

			"filereader formdata progress".split(' ').forEach(function (api) {
			  if (tests[api] === false) {
				support[api].className = 'fail';
			  } else {
				support[api].className = 'hidden';
			  }
			});
			
			function previewfile2(file) {
				console.log("holder2");
			  if (tests.filereader === true) {
				var reader = new FileReader();
				reader.onload = function (event) {
				  theImage = new Image(250,250);
				  theImage.src = "images/tick.jpg";
				  holder2.appendChild(theImage);
				  document.getElementById("gelName").value = file.name;
				  document.getElementById("cancelCap").style.visibility = "visible";
				};

				reader.readAsDataURL(file);
			  }  else {
				console.log(file);				
			  }
			}
			
			<?php
				if(file_exists("upload/gelcapData.txt")){ //If the gel cap data file is in the upload folder after refreshing, display the tick
					echo 	'theImage = new Image(250,250);
							theImage.src = "images/tick.jpg";
							holder2.appendChild(theImage);';
				}
			?>

			function readfiles2(files) {
				debugger;
				var formData = tests.formdata ? new FormData() : null;
				for (var i = 0; i < files.length; i++) {
				  if (tests.formdata) formData.append('file', files[i]);
				  previewfile2(files[i]);
				}

				if (tests.formdata) {
				  var xhr = new XMLHttpRequest();
				  xhr.open('POST', 'gelcapUpload.php');
				  xhr.onload = function() {
					progress.value = progress.innerHTML = 100;
				  };

				  if (tests.progress) {
					xhr.upload.onprogress = function (event) {
					  if (event.lengthComputable) {
						var complete = (event.loaded / event.total * 100 | 0);
						progress.value = progress.innerHTML = complete;
					  }
					}
				  } 

				  xhr.send(formData);
				} 
			}

			if (tests.dnd) { 
			  holder2.ondragover = function () { this.className = 'hover'; return false; };
			  holder2.ondragend = function () { this.className = ''; return false; };
			  holder2.ondrop = function (e) {
				this.className = '';
				e.preventDefault();
				if(fileExists("upload/gelcapData.txt") == false){
					readfiles2(e.dataTransfer.files);
				}
			  }
			} else {
			  fileupload.className = 'hidden';
			  fileupload.querySelector('input').onchange = function () {
				readfiles2(this.files);
			  };
			}
			</script>
			
			<script>	//Drag/drop uploader script for eicosane box
			var holder3 = document.getElementById('holder3'),
				tests = {
				  filereader: typeof FileReader != 'undefined',
				  dnd: 'draggable' in document.createElement('span'),
				  formdata: !!window.FormData,
				  progress: "upload" in new XMLHttpRequest
				}, 
				support = {
				  filereader: document.getElementById('filereader'),
				  formdata: document.getElementById('formdata'),
				  progress: document.getElementById('progress')
				},
				progress = document.getElementById('uploadprogress'),
				fileupload = document.getElementById('upload');

			"filereader formdata progress".split(' ').forEach(function (api) {
			  if (tests[api] === false) {
				support[api].className = 'fail';
			  } else {
				support[api].className = 'hidden';
			  }
			});
			
			<?php
				if(file_exists("upload/eicoData.txt")){ //If the eicosane data file is in the upload folder after refreshing, display the tick
					echo 	'theImage = new Image(250,250);
							theImage.src = "images/tick.jpg";
							holder3.appendChild(theImage);';
				}
			?>
			
			function previewfile3(file) {
				console.log("holder3");
			  if (tests.filereader === true) {
				var reader = new FileReader();
				reader.onload = function (event) {
				  theImage = new Image(250,250);
				  theImage.src = "images/tick.jpg";
				  holder3.appendChild(theImage);
				  document.getElementById("eicoName").value = file.name;
				  document.getElementById("cancelEico").style.visibility = "visible";
				};

				reader.readAsDataURL(file);
			  }  else {
				console.log(file);
				
			  }
			}

			function readfiles3(files) {
				debugger;
				var formData = tests.formdata ? new FormData() : null;
				for (var i = 0; i < files.length; i++) {
				  if (tests.formdata) formData.append('file', files[i]);
				  previewfile3(files[i]);
				}

				if (tests.formdata) {
				  var xhr = new XMLHttpRequest();
				  xhr.open('POST', 'eicoUpload.php');
				  xhr.onload = function() {
					progress.value = progress.innerHTML = 100;
				  };

				 if (tests.progress) {
					xhr.upload.onprogress = function (event) {
					  if (event.lengthComputable) {
						var complete = (event.loaded / event.total * 100 | 0);
						progress.value = progress.innerHTML = complete;
					  }
					}
				  }

				  xhr.send(formData);
				} 
			}

			if (tests.dnd) { 
			  holder3.ondragover = function () { this.className = 'hover'; return false; };
			  holder3.ondragend = function () { this.className = ''; return false; };
			  holder3.ondrop = function (e) {
				this.className = '';
				e.preventDefault();
				if(fileExists("upload/eicoData.txt") == false){
					readfiles3(e.dataTransfer.files);
				}
			  }
			} else {
			  fileupload.className = 'hidden';
			  fileupload.querySelector('input').onchange = function () {
				readfiles3(this.files);
			  };
			}
			
			
			</script>
			
			<?php
				while(1>0){										//Keep looping until file has been deleted - avoid errors
					if(file_exists("upload/saveDetails.txt")){	//Check that file exists
						unlink("upload/saveDetails.txt");		//Delete file - file used to retain values of fields stored before cancellation refresh, 
					}											//so needs to be deleted straight away to prevent values staying permanently
					else{
						break;
					}
				}
			?>

      <hr>

      <footer>
        <p>&copy; Tom Wordsworth 2013</p> <!--Displayed at the bottom of the page-->
      </footer>

    </div> <!-- /container -->


<!--	
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>
-->	


     
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>  
</html>