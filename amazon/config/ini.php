<?php
session_start();
error_reporting(0);
require_once '../amazon-s3-sdk/sdk.class.php';

define('BASE_URL', 'http://mihailvelikov.eu/amazon/');
define('MAIN_BUCKET', 'mvelikov-telerik-hw');
define('KEY', 'AKIAJ7X5A4GWGKUBVVQQ');
define('SECRET', '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');
function create_dob($date,$month,$year)
{
	$date=strtotime($date."-".$month."-".$year);
	return $date;
}
?>
