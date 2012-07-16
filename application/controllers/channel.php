<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Channel extends MV_Controller
{
    public function index()
    {
        $this->load->library('mongo_db');
        $channels_array = $this->mongo_db
                ->get('channels');
        $this->load->view('channel/index', array('channels' => $channels_array));
    }
    public function add()
    {
        $this->load->library('mongo_db');
        $this->mongo_db->insert('channels', array($this->encrypt->encode('channel1')));
    }
    public function ref()
    {
        $this->load->library('mongo_db');
        $channel = $this->mongo_db->get_where('channels', array('_id' => 5004176041075da375000000));
        echo $channel;
    }
    public function insert()
    {
        if ($this->input->post('channel'))
        {
            $this->load->library('mongo_db');
            $channels_array = $this->mongo_db
                    ->get_where('channels', array(
                        'name' => $this->input->post('channel')
                    ));
            $channels_count = count($channels_array);
            if (is_array($channels_array) && $channels_count == 0 ) {
                $channel = $this->mongo_db
                        ->insert('channels', array(
                            'name' => $this->input->post('channel')
                        ));

            }
            elseif ($channels_count == 1)
            {
                $channel = array_pop($channels_array);
            }
            else
            {
                HTTPStatus(500);
                $this->load->view('headers/index', array('code' => 500, 'message' => 'more than one channel with this name'));
                return;
            }
            $this->load->view('channel/get_one', array('channel' => $channel));
        }
        else
        {
            HTTPStatus(400);
            $this->load->view('headers/index', array('code' => 400, 'message' => 'missing chanel name'));
        }
    }

    public function get_one()
    {
        if ($this->input->post('channel'))
        {
            $this->load->library('mongo_db');
            $channels_array = $this->mongo_db
                    ->get_where('channels', array(
                        'name' => $this->input->post('channel')
                    ));
            $channels_count = count($channels_array);
            if (is_array($channels_array) && $channels_count == 1)
            {
                $this->load->view('channel/get_one', array('channel' => array_pop($channels_array)));
            }
            else
            {
                HTTPStatus(400);
                $this->load->view('headers/index', array('code' => 400, 'message' => 'no such channel'));
            }
        }
        else
        {
            HTTPStatus(400);
            $this->load->view('headers/index', array('code' => 400, 'message' => 'missing chanel name'));
        }
    }
}