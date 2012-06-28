<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MV_Controller {

    public function index() 
    {
        $this->load->library('mongo_db');
        $user = $this->mongo_db
            ->get_where('users', array(
                'user' => 'mvelikov',
                'pass' => '7c4a8d09ca3762af61e59520943dc26494f8941b'
            ));
        echo '<pre>';
        var_dump($user );
    }
    
    public function insert() 
    {
        $this->load->library('mongo_db');
        $id = $this->mongo_db
                ->insert('users', array(
                    'user' => 'mvelikov',
                    'pass' => '7c4a8d09ca3762af61e59520943dc26494f8941b'
                ));
        echo $id;
    }
}