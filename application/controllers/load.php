<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Load extends CI_Controller {
    // inserting and testing users
    public function index()
    {
        $this->load->library('mongo_db');
        $users = $this->mongo_db->get('users');
        foreach ($users as $user)
        {
            echo '<pre>id ', var_dump($user['_id']), '</pre>';
        	echo '<pre>user ', var_dump($this->encrypt->decode($user['user'])), '</pre>';
        	echo '<pre>pass ', var_dump($user['pass'], $user['userHash']), '</pre>';
        }

        //echo $id;
        //$this->load->view('welcome_message');
    }

    public function insert()
    {
        $this->load->library('mongo_db');
        $id = $this->mongo_db
                ->insert('users', array(
                    'user' => $this->encrypt->encode('test'),
                    'pass' => $this->encrypt->sha1('test') . $this->encrypt->sha1('test'),
                ));
        echo $id;
    }
}