<?php
require_once('config/ini.php');
?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Telerik Amazon S3 Homework</title>
	</head>
	<body>
		<?php include("layout/header.php"); ?>
		<div id="content">
		<?php
			if (!empty($_GET['page']) && trim($_GET['page']) != '' && file_exists('pages/' . $_GET['page'] . '.php')) {
				include_once('pages/' . $_GET['page'] . '.php');
			} else if (file_exists('pages/upload.php')) {
				include_once('pages/upload.php');
			} else {
				echo "<b>Error</b>";
			}
		?>
		</div>
		<br />
		<?php include("layout/footer.php"); ?>
	</body>
</html>