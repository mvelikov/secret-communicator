<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MV_Controller {

    public function index()
    {
        $this->load->library('mongo_db');
        $user = $this->mongo_db
            ->get_where('users', array(
                'pass' => $this->encrypt->sha1('123456') . $this->encrypt->sha1('mvelikov'),
            ));
        echo '<pre>';
        var_dump($user);
        echo $this->encrypt->decode($user[0]['user']);
    }
}