<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    public function index()
    {
        $this->load->helper(array('mv_helper'));
        $user = $this->input->post('user');
        $pass = $this->input->post('pass');
        if ($user && $pass)
        {
            $this->load->library('mongo_db');
            $users = $this->mongo_db
                ->get_where('users', array(
                    'pass' => $this->encrypt->sha1($pass) . $this->encrypt->sha1($user),
                ));

            if (is_array($users) && count($users) == 1)
            {
                $this->_user = array_pop($users);
                HTTPStatus(200);
                $this->load->view('user/index', array(
                    'code' => 200,
                    'success' => TRUE,
                    'failed' => FALSE,
                    'message' => 'Login successfull',
                ));
            }
            else
            {
                HTTPStatus(200);
                $this->load->view('user/index', array(
                    'code' => 200,
                    'success' => FALSE,
                    'failed' => TRUE,
                    'message' => 'Login failed',
                ));
            }
        }
    }
}