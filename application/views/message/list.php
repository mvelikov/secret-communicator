<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo json_encode(array(
    'code' => $code,
    'message' => $message,
    'success' => $success,
    'failed' => $failed,
    'list' => $list,
));