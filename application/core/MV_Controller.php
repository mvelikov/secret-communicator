<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MV_Controller extends CI_Controller {
    
     protected $_user;


     public function __construct() {
        parent::__construct();

        if ($this->input->post('user') && $this->input->post('pass') || 1) 
        {
            $this->load->library('mongo_db');
            $users = $this->mongo_db
                    ->get_where('users', array(
                        'user' => 'mvelikov',
                        'pass' => '7c4a8d09ca3762af61e59520943dc26494f8941b'
                    ));
                    /*->get_where('user', array(
                        'user' => $this->input->post('user'),
                        'pass' => $this->input->post('pass')
                    ));*/
            if (!is_array($users) || count($users) == 0) 
            {
                $error = 401;
            }
            else
            {
                $this->_user = array_pop($users);
            }
        } 
        else
        {
            $error = 401;   
        }
        
        if (!empty($error) && $error = 401)
        {
            header('HTTP/1.1 401 Unauthorized');
            $this->load->view('headers/h401');
            return;
        }
        
    }
}