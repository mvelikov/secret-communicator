<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File extends MV_Controller
{
	public function index()
	{
        HTTPStatus(200);
		/*$config['max_size'] = 5000000;
		$config['upload_path'] = FCPATH . 'uploads';
		$this->load->library('upload', $config);*/
		$config['upload_path'] = '/tmp';
		$config['max_size']	= '100000000';
		$config['allowed_types'] = '*';
		$error = '';

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('userfile'))
		{
			$this->load->library('s3');


			$data = $this->upload->data();
			$file = $this->s3->inputFile($data['full_path']);

			$name = $this->encrypt->sha1($data['orig_name'] . mt_rand()) . time() . $data['file_ext'];
			$res = $this->s3->putObject($file, MAIN_BUCKET, $name);

			//echo '<pre>', var_dump(MAIN_BUCKET_URL . $name), '</pre>';
			if ($res) {
				
				$this->load->view('file/success', array('file' => $name));
			} else {
				$error = 'File not uploaded';
			}
			unlink($data['full_path']);
		} else {
			$error = 'File not submitted';
		}

		if ($error != '') {
			$this->load->view('file/error', array('error' => $error));
		}
		@unlink($_FILES['userfile']);
	}

	public function alt()
	{
		echo '<pre>', var_dump($_FILES), '</pre>';
		$error = '';
		if ( ! empty($_FILES['userfile']['tmp_name']) && file_exists($_FILES['userfile']['tmp_name'])
			&& ! empty($_FILES['userfile']['name']) && $_FILES['userfile']['name'] != '')
		{
			$this->load->library('s3');

			$file = $this->s3->inputFile($_FILES['userfile']['tmp_name']);
			$ext = explode('.', $_FILES['userfile']['name']);
			$name = $this->encrypt->sha1($_FILES['userfile']['name'] . mt_rand()) . time() . '.' . end($ext);
			$res = $this->s3->putObject($file, MAIN_BUCKET, $name);

			if ($res) {
				$this->load->view('file/success', array('file' => $name));
			} else {
				$error = 'File not uploaded';
			}

		} else {
			$error = 'File not submitted';
		}
		if ($error != '') {
			$this->load->view('file/error', array('error' => $error));
		}
		@unlink($_FILES['userfile']);
	}

}