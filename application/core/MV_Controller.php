<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MV_Controller extends CI_Controller {

    protected $_user;


    public function __construct() {
        parent::__construct();

        $this->load->helper(array('mv_helper', 'url'));
        $pass = $this->input->get_post('pass');
        echo '<pre>', var_dump($pass), '</pre>';exit;
/*echo '<pre>', var_dump(array(
                        'user' => $this->encrypt->encode('mvelikov'),
                        'pass' => $this->encrypt->encode($this->encrypt->sha1('123456')),
                    )), '</pre>';exit();*/
        /*if (empty($_SERVER['HTTP_X_FORWARDED_PROTO']) || $_SERVER['HTTP_X_FORWARDED_PROTO'] != 'https')
        {
            redirect($this->router->class . '/error_https');
        }
        else*/if ($pass)
        {
            $this->load->library('mongo_db');
            $users = $this->mongo_db
                    ->get_where('users', array(
                        'pass' => $pass,
                    ));
                    /*->get_where('users', array(
                        'user' => $this->encrypt->encode($this->input->post('user')),
                        'pass' => $this->encrypt->sha1($this->input->post('pass')) . $this->encrypt->sha1($this->input->post('user')),
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

    public function insert_message($data)
    {
        if ( ! empty($data['message']) && trim($data['message']) != ''
                && ! empty($data['channel']) && trim($data['channel']) != '')
        {
            $this->load->library('mongo_db');
            $message = $this->mongo_db
                    ->insert('messages', array(
                        'user' => $this->_user['user'],
                        'message' => $this->encrypt->encode($data['message']),
                        'channel' => new MongoID($data['channel']),//5004176041075da375000000
                        //'channel' => $this->mongo_db->create_dbref('channels', $this->mongo_db->get)
                        'time' => time(),
                    ));
            return $message;
        }
        return FALSE;
    }
}