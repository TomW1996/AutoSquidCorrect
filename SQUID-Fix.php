<!DOCTYPE html>  
<html>  
  <head>  
    <title>SQUID-Fix</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <!-- Bootstrap -->  
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">  
  </head>  
  <body>  
    <div class="container">
		<!-- Main hero unit for a primary marketing message or call to action -->
		<div class="hero-unit">
			<div class = "row">
				<div class = "span7">
					<h1>SQUID-Fix</h1>
					<p>SQUID-Fix is a powerful tool designed for chemistry students. Using real SQUID data, it will correct your raw data 
					and produce graphs as well as a downloadable file with all the calculated results.</p>
				</div>
					<img src = "images/squidpic.jpg" align = "right" width = 240>
			</div>	
		</div>		
		<div class = "row">
			<h2>Preferences:</h2>	
			<form class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="gelcapPref">Gel Cap Data:</label>
					<div class = "controls">
						<select>
							<option>Use own</option>
							<option>Use ours</option>
						</select>
					</div>
				</div>	
			</form>
			<form class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="eicoPref">Eicosane Data:</label>
					<div class = "controls">
						<select>
							<option>Use own</option>
							<option>None used</option>
							<option>Use ours</option>
						</select>
					</div>
				</div>	
			</form>
			<form class="form-horizontal">
				<div class="control-group">
					<label class="control-label" for="eicoPref">Approximate Pascal Correction:</label>
					<div class = "controls">
						<select onchange =
								'var selected = options[selectedIndex].index;
								console.log(selected);
								if(selected == 1){
									document.getElementById("pascalField").style.visibility = "hidden";
								}
								else{
									document.getElementById("pascalField").style.visibility = "visible";
								}
							'>
							<option>Apply</option>
							<option>Don't Apply</option>							
						</select>
						<input id = "pascalField" placeholder="Constant Value">
					</div>
				</div>	
			</form>
		</div>
		<div class="row">
			<h2>Data Files:</h2>
			<div class="span4">
				<h4>Raw Data:</h4>
				<article>
					<div id="holder1">
					</div>
					<p id="upload" class="hidden"><label>Drag & drop not supported, but you can still upload via this input field:<br><input type="file"></label></p>
					<p id="filereader">File API & FileReader API not supported</p>
					<p id="formdata">XHR2's FormData is not supported</p>
					<p id="progress">XHR2's upload progress isn't supported</p>
				</article>	
			</div>
			<div class="span4">
				<h4>Gel Cap:</h4>
				<article>
					<div id="holder2">
					</div>
					<p id="upload" class="hidden"><label>Drag & drop not supported, but you can still upload via this input field:<br><input type="file"></label></p>
				</article>
				<form class="form-horizontal">
					<div class="control-group">
						<label class="control-label" for="molWeight">Sample Mass:</label>
						<div class="controls">
							<div class="input-append">
								<input class="span1" id="appendedInput" type="text">
								<span class="add-on">mg</span>
							</div>
						</div>
				    </div>
				</form>
				<form class="form-horizontal">
					<div class="control-group">
						<label class="control-label" for="molWeight">Molecular Weight:</label>
						<div class="controls">
							<div class="input-append">
								<input class="span1" id="appendedInput" type="text">
								<span class="add-on">g mol<sup>-1</sup></span>
							</div>
						</div>
				    </div>
				</form>	
			</div>
			<div class="span4">
				<h4>Eicosane:</h4>
				<article>
					<div id="holder3">
					</div>
					<p id="upload" class="hidden"><label>Drag & drop not supported, but you can still upload via this input field:<br><input type="file"></label></p>
				</article>
				<form class="form-horizontal">
					<div class="control-group">
						<label class="control-label" for="sampleEico">Mass of Eicosane - Sample:</label>
						<div class="controls">
							<div class="input-append">
								<input class="span1" id="appendedInput" type="text">
								<span class="add-on">mg</span>
							</div>
						</div>
				    </div>
				</form>
				<form class="form-horizontal">
					<div class="control-group">
						<label class="control-label" for="blankEico">Mass of Eicosane - Blank:</label>
						<div class="controls">
							<div class="input-append">
								<input class="span1" id="appendedInput" type="text">
								<span class="add-on">mg</span>
							</div>
						</div>
				    </div>
				</form>					
			</div>
		</div>
		<div class = "row">
			<form action = "runPythonCorrection.php" method = "post">
				<p><center><input type = "submit" class = "btn btn-large btn-primary" value = "Correct Data"/></center></p>
			</form>
		</div>
		<div class = "row">
			<center>Draw a graph<center>
		</div>

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
			var holder1 = document.getElementById('holder1'),
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
				acceptedTypes = {
				  'image/png': true,
				  'image/jpeg': true,
				  'image/gif': true
				},
				progress = document.getElementById('uploadprogress'),
				fileupload = document.getElementById('upload');

			"filereader formdata progress".split(' ').forEach(function (api) {
			  if (tests[api] === false) {
				support[api].className = 'fail';
			  } else {
				// FFS. I could have done el.hidden = true, but IE doesn't support
				// hidden, so I tried to create a polyfill that would extend the
				// Element.prototype, but then IE10 doesn't even give me access
				// to the Element object. Brilliant.
				support[api].className = 'hidden';
			  }
			});

			function previewfile1(file) {
				console.log("holder1");
			  if (tests.filereader === true && acceptedTypes[file.type] === true) {
				var reader = new FileReader();
				reader.onload = function (event) {
				  var image = new Image();
				  image.src = event.target.result;
				  image.width = 250; // a fake resize
				  holder1.appendChild(image);
				};

				reader.readAsDataURL(file);
			  }  else {
				holder1.innerHTML += '<p>Uploaded ' + 'rawData_' + file.name + ' ' + (file.size ? (file.size/1024|0) + 'K' : '');
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

				// now post a new XHR request
				if (tests.formdata) {
				  var xhr = new XMLHttpRequest();
				  xhr.open('POST', 'rawUpload.php');

				  if (tests.progress) {
					xhr.upload.onprogress = function (event) {
					  if (event.lengthComputable) {
						var complete = (event.loaded / event.total * 100 | 0);
					  }
					}
				  } 

				  xhr.send(formData); 
				}
			}

			if (tests.dnd) { 
			  holder1.ondragover = function () { this.className = 'hover'; return false; };
			  holder1.ondragend = function () { this.className = ''; return false; };
			  holder1.ondrop = function (e) {
				this.className = '';
				e.preventDefault();
				readfiles1(e.dataTransfer.files);
			  }
			} else {
			  fileupload.className = 'hidden';
			  fileupload.querySelector('input').onchange = function () {
				readfiles1(this.files);
			  };
			}
			</script>
			
			<script>
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
				acceptedTypes = {
				  'image/png': true,
				  'image/jpeg': true,
				  'image/gif': true
				},
				progress = document.getElementById('uploadprogress'),
				fileupload = document.getElementById('upload');

			"filereader formdata progress".split(' ').forEach(function (api) {
			  if (tests[api] === false) {
				support[api].className = 'fail';
			  } else {
				// FFS. I could have done el.hidden = true, but IE doesn't support
				// hidden, so I tried to create a polyfill that would extend the
				// Element.prototype, but then IE10 doesn't even give me access
				// to the Element object. Brilliant.
				support[api].className = 'hidden';
			  }
			});

			function previewfile2(file) {
				console.log("holder2");
			  if (tests.filereader === true && acceptedTypes[file.type] === true) {
				var reader = new FileReader();
				reader.onload = function (event) {
				  var image = new Image();
				  image.src = event.target.result;
				  image.width = 250; // a fake resize
				  holder2.appendChild(image);
				};

				reader.readAsDataURL(file);
			  }  else {
				holder2.innerHTML += '<p>Uploaded ' + 'blankData_' + file.name + ' ' + (file.size ? (file.size/1024|0) + 'K' : '');
				console.log(file);
			  }
			}

			function readfiles2(files) {
				debugger;
				var formData = tests.formdata ? new FormData() : null;
				for (var i = 0; i < files.length; i++) {
				  if (tests.formdata) formData.append('file', files[i]);
				  previewfile2(files[i]);
				}

				// now post a new XHR request
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
				readfiles2(e.dataTransfer.files);
			  }
			} else {
			  fileupload.className = 'hidden';
			  fileupload.querySelector('input').onchange = function () {
				readfiles2(this.files);
			  };
			}
			
			
			</script>
			
			<script>
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
				acceptedTypes = {
				  'image/png': true,
				  'image/jpeg': true,
				  'image/gif': true
				},
				progress = document.getElementById('uploadprogress'),
				fileupload = document.getElementById('upload');

			"filereader formdata progress".split(' ').forEach(function (api) {
			  if (tests[api] === false) {
				support[api].className = 'fail';
			  } else {
				// FFS. I could have done el.hidden = true, but IE doesn't support
				// hidden, so I tried to create a polyfill that would extend the
				// Element.prototype, but then IE10 doesn't even give me access
				// to the Element object. Brilliant.
				support[api].className = 'hidden';
			  }
			});

			function previewfile3(file) {
				console.log("holder3");
			  if (tests.filereader === true && acceptedTypes[file.type] === true) {
				var reader = new FileReader();
				reader.onload = function (event) {
				  var image = new Image();
				  image.src = event.target.result;
				  image.width = 250; // a fake resize
				  holder3.appendChild(image);
				};

				reader.readAsDataURL(file);
			  }  else {
				holder3.innerHTML += '<p>Uploaded ' + 'eicoData_' + file.name + ' ' + (file.size ? (file.size/1024|0) + 'K' : '');
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

				// now post a new XHR request
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
				readfiles3(e.dataTransfer.files);
			  }
			} else {
			  fileupload.className = 'hidden';
			  fileupload.querySelector('input').onchange = function () {
				readfiles3(this.files);
			  };
			}
			
			
			</script>

      <hr>

      <footer>
        <p>&copy; Tom Wordsworth 2013</p>
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

    <script src="http://code.jquery.com/jquery.js"></script>  
    <script src="bootstrap/js/bootstrap.min.js"></script>  
  </body>  
</html>