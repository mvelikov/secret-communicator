<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo json_encode(array(
	'code' => 200,
	'message' => $html_message,
	'file' => $file,
	'success' => TRUE,
	'failed' => FALSE,
));