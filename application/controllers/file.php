<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File extends MV_Controller
{
	// stores sent file in S3 and returns its url
	public function index()
	{
		$config['upload_path'] = '/tmp';
		$config['max_size']	= '100000000';
		$config['allowed_types'] = '*';
		$error = '';

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('userfile') && $this->input->post('channel') && 0)
		{
			$this->load->library('s3');


			$data = $this->upload->data();
			$file = $this->s3->inputFile($data['full_path']);

			$name = $this->encrypt->sha1($data['orig_name'] . mt_rand()) . time() . $data['file_ext'];
			$res = $this->s3->putObject($file, MAIN_BUCKET, $name);

			if ($res) {
                $message = '<span class="author">' . $this->encrypt->decode($this->_user['user'])
                . '</span> said: <br /><a href="' . MAIN_BUCKET_URL . $name . '" target="_blank">' . $data['orig_name'] . '</a>';
                $this->insert_message(array(
                    'message' => $message,
                    'channel' => $this->input->post('channel'),
                ));
				HTTPStatus(200);
				$this->load->view('file/success', array('file' => $name, 'html_message' => $message));
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

}