<html>
	<head>
		<title>"SQUID-Fix"</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
	<body>
		<div id = "container">
			<div id = "body">
				<div id = "content">
					<form action="upload_file.php" method="post"enctype="multipart/form-data">
						<label for="file">Filename:</label>
						<input type="file" name="file" id="file"><br>
						<input type="submit" name="submit" value="Submit">
					</form>
					<form action="runPythonCorrection.php" method="post">
						<input type="submit" name="correctData" value="Correct Data"/>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
