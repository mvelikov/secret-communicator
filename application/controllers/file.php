<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File extends MV_Controller
{
	public function index()
	{
		$this->load->library('s3');
		echo '<pre>', var_dump($this->s3), '</pre>';
	}
}