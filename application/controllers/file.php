<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File extends CI_Controller
{
	public function index()
	{

		$this->load->library('s3');

		$bucket = $this->s3->getBucket(MAIN_BUCKET);
		echo '<pre>', var_dump($bucket), '</pre>';
		$res = $this->s3->putObject($_FILES['uploadedfile']['name'], $bucket, $_FILES['uploadedfile']['tmp_name'], S3::ACL_PUBLIC_READ);
		echo '<pre>', var_dump($res), '</pre>';
	}
}