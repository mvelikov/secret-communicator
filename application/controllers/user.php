<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MV_Controller {

    public function index()
    {
        $this->load->library('mongo_db');
        $user = $this->mongo_db
            ->get_where('users', array(
                'userHash' => $this->encrypt->sha1('mvelikov'),
                'pass' => $this->encrypt->sha1('123456mvelikov'),
            ));
        echo '<pre>';
        var_dump($user);
    }

    public function insert()
    {
        $this->load->library('mongo_db');
        $id = $this->mongo_db
                ->insert('users', array(
                    'user' => $this->encrypt->encode('mvelikov'),
                    'userHash' => $this->encrypt->sha1('mvelikov'),
                    'pass' => $this->encrypt->sha1('123456' . 'mvelikov'),
                ));
        echo $id;
    }
}