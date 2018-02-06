<?php
	session_start();
	if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
		echo $_SESSION['message'];
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>test</title>
</head>
<body>

	<form method="post" enctype="multipart/form-data" action="http://ngpictures.pe.hu/uploader.php">
		<input type="file" name="thumbs">
		<input type="submit" name="submit">
	</form>
</body>
</html>