<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
HTTPStatus(500);
echo json_encode(array(
	'code' => 500,
	'message' => $error,
	'success' => FALSE,
	'failed' => TRUE,
));