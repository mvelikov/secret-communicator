<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Channel extends MV_Controller
{
    public function insert()
    {
        if ($this->input->post('channel'))
        {
            $this->load->library('mongo_db');
            $channels_array = $this->mongo_db
                    ->get_where('channels', array(
                        'name' => $this->input->post('channel')
                    ));
            if (is_array($channels_array) && count($channels_array) == 0 ) {
                $channel = $this->mongo_db
                        ->insert('channels', array(
                            'name' => $this->input->post('channel')
                        ));
                $this->load->view('channel/index', array('channel' => $channel));
            }
        }
        else
        {
            HTTPStatus(400);
            $this->load->view('headers/index', array('code' => 400));
        }
    }
    
    public function index()
    {
        
    }
}