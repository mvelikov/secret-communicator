<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Load extends CI_Controller {

    public function index()
    {
        $this->load->library('mongo_db');
        var_dump($this->mongo_db->get('users'));
        //echo $id;
        //$this->load->view('welcome_message');
    }
}