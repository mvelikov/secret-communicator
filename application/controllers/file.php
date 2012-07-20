<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File extends CI_Controller
{
	public function index()
	{
		/*$config['max_size'] = 5000000;
		$config['upload_path'] = FCPATH . 'uploads';
		$this->load->library('upload', $config);*/
		$config['upload_path'] = './uploads/';
		$config['max_size']	= '100000000';
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('userfile'))
		{
			$this->load->library('s3');


			$data = $this->upload->data();
			$file = $this->s3->inputFile($data['full_path']);

			$name = $this->encrypt->sha1($data['orig_name'] . mt_rand()) . time() . $data['file_ext'];
			$res = $this->s3->putObject($file, MAIN_BUCKET, $name);

			echo '<pre>', var_dump(MAIN_BUCKET_URL . $name), '</pre>';
			unlink($data['full_path']);
		}
		@unlink($_FILES[$file_element_name]);
	}

	public function code()
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