<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MV_Controller extends CI_Controller {

    protected $_user;


    public function __construct() {
        parent::__construct();

        $this->load->helper(array('mv_helper', 'url'));

        if (empty($_SERVER['HTTP_X_FORWARDED_PROTO']) || $_SERVER['HTTP_X_FORWARDED_PROTO'] != 'https')
        {
            redirect($this->router->class . '/error_https');
        }
        elseif ($this->input->post('user') && $this->input->post('pass') || 1)
        {
            $this->load->library('mongo_db');
            $users = $this->mongo_db
                    ->get_where('users', array(
                        'user' => 'mvelikov',
                        'pass' => '7c4a8d09ca3762af61e59520943dc26494f8941b'
                    ));
                    /*->get_where('user', array(
                        'user' => $this->input->post('user'),
                        'pass' => sha1($this->input->post('pass')),
                    ));*/
            if (!is_array($users) || count($users) == 0)
            {
                redirect($this->router->class . '/error_auth');
            }
            else
            {
                $this->_user = array_pop($users);
            }
        }
        else
        {
            redirect($this->router->class . '/error_auth');
        }
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