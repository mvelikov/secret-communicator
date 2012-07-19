<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File extends CI_Controller
{
	public function index()
	{
		if ( ! empty($_FILES['uploadedfile']['tmp_name']) && file_exists($_FILES['uploadedfile']['tmp_name']) 
			&& ! empty($_FILES['uploadedfile']['name']) && $_FILES['uploadedfile']['name'] != '')
		{
			$this->load->library('s3');

			$file = $this->s3->inputFile($_FILES['uploadedfile']['tmp_name']);
			$ext = explode('.', $_FILES['uploadedfile']['name']);
			$name = $this->encrypt->sha1($_FILES['uploadedfile']['name']) . time() . '.' . end($ext);
			$res = $this->s3->putObject($file, MAIN_BUCKET, $name);

			echo '<pre>', var_dump($name), '</pre>';
		}
	}
}