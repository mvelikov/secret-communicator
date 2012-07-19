<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File extends CI_Controller
{
	/*public function index()
	{
		$config['max_size'] = 5000000;
		$config['upload_path'] = '/tmp';
		$this->load->library('upload', $config);
		$data = $this->upload->data();
var_dump($_FILES, $data);

		if ($this->upload->do_upload('userfile'))
		{
			$this->load->library('s3'); 
			

			$data = $this->upload->data();
			$file = $this->s3->inputFile($data['full_path']);

			$name = $this->encrypt->sha1($data['orig_name']) . time() . '.' . $data['file_ext'];
			$res = $this->s3->putObject($file, MAIN_BUCKET, $name);

			echo '<pre>', var_dump($name), '</pre>';
		}
	}*/

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