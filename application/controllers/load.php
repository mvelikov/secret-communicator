<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Load extends CI_Controller {

    public function index()
    {
        $this->load->library('mongo_db');
        $id = $this->mongo_db->insert('users', array('user1' => '123456'));
        var_dump($this->mongo_db->get('users'));
        //echo $id;
        //$this->load->view('welcome_message');
    }
}