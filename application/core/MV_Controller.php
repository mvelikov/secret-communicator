<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MV_Controller extends CI_Controller {

    protected $_user;


    public function __construct() {
        parent::__construct();

        $this->load->helper(array('mv_helper', 'url'));
/*echo '<pre>', var_dump(array(
                        'user' => $this->encrypt->encode('mvelikov'),
                        'pass' => $this->encrypt->encode($this->encrypt->sha1('123456')),
                    )), '</pre>';exit();*/
        /*if (empty($_SERVER['HTTP_X_FORWARDED_PROTO']) || $_SERVER['HTTP_X_FORWARDED_PROTO'] != 'https')
        {
            redirect($this->router->class . '/error_https');
        }
        else*/if ($this->input->post('user') && $this->input->post('pass') || 1)
        {
            $this->load->library('mongo_db');
            $users = $this->mongo_db
                    ->get_where('users', array(
                        'userHash' => $this->encrypt->sha1('mvelikov'),
                        'pass' => $this->encrypt->sha1('123456mvelikov'),
                    ));
                    /*->get_where('user', array(
                        'user' => $this->encrypt->encode($this->input->post('user')),
                        'pass' => $this->encrypt->encode($this->encrypt->sha1($this->input->post('pass')))),
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