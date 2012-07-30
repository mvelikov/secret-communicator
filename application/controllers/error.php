<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('mv_helper', 'url'));
	}
	public function error_https()
    {
        HTTPStatus(501);
        $this->load->view('headers/index', array(
            'code' => 501,
            'message' => 'Use HTTPS connection!',
        ));
    }

    public function error_auth()
    {
        HTTPStatus(401);
        $this->load->view('headers/index', array('code' => 401, 'message' => 'Invalid user'));
    }
}