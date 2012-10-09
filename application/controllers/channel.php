<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Channel extends MV_Controller
{
    // returns list of all channels
    public function index()
    {
        $this->load->library('mongo_db');
        $channels_array = $this->mongo_db
                ->get('channels');
        $channels_list = array();
        if (is_array($channels_array))
        {
            foreach ($channels_array as $channel)
            {
                $channels_list[] = array(
                    'name' => $this->encrypt->decode($channel['name']),
                    '_id' => (string)$channel['_id'],
                );
            }
        }
        $this->load->view('channel/index', array('channels' => $channels_list));
    }

    // creates new channel and returns its id
    // if it name exists its Id is returned
    public function insert()
    {
        $post_channel = $this->input->post('channel');
        if ($post_channel)
        {
            $this->load->library('mongo_db');
            $channels_array = $this->mongo_db
                    ->get('channels');
            //$channels_count = count($channels_array);

            if (is_array($channels_array)) {
                foreach ($channels_array as $tmp_channel)
                {
                    if ($post_channel == $this->encrypt->decode($tmp_channel['name']))
                    {
                        $channel = $tmp_channel;
                        break;
                    }
                }
            }

            if (empty($channel))
            {
                $channel = $this->mongo_db
                        ->insert('channels', array(
                            'name' => $this->encrypt->encode($post_channel)
                        ));
            }

            $this->load->view('channel/get_one', array('channel' => $channel->{'$id'}));
        }
        else
        {
            HTTPStatus(400);
            $this->load->view('headers/index', array('code' => 400, 'message' => 'missing channel name'));
        }
    }

    // gets single channel by the name
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