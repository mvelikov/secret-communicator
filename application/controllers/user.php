<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MV_Controller {

    public function index()
    {
        $this->load->library('mongo_db');
        $user = $this->mongo_db
            ->get_where('users', array(
                'user' => $this->encrypt->encode('mvelikov'),
                'pass' => $this->encrypt->encode($this->encrypt->sha1('123456')),
            ));
        echo '<pre>';
        var_dump($this->encrypt->encode('mvelikov'),  $this->encrypt->encode($this->encrypt->sha1('123456')));
    }

    public function insert()
    {
        $this->load->library('mongo_db');
        $id = $this->mongo_db
                ->insert('users', array(
                    'user' => $this->encrypt->encode('mvelikov'),
                    'pass' => $this->encrypt->encode($this->encrypt->sha1('123456')),
                ));
        echo $id;
    }
}