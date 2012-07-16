<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends MV_Controller
{
    public function insert()
    {
        $message = $this->input->post('message');
        $channel = $this->input->post('channel');

        if (($message && $message != '')
                && ($channel && $channel != ''))
        {
            $this->load->library('mongo_db');
            $message = $this->mongo_db
                    ->insert('messages', array(
                        'user' => $this->_user['user'],
                        'message' => $this->encrypt->encode($message),
                        'channel' => $this->encrypt->encode($channel),
                        'time' => time(),
                    ));

            if ( ! empty($message->{'$id'}))
            {
                HTTPStatus(200);
                $this->load->view('message/index', array(
                    'code' => 200,
                    'message' => 'Message successfully inserted',
                    'success' => TRUE,
                    'failed' => FALSE,
                ));
            }
            else
            {
                HTTPStatus(200);
                $this->load->view('message/index', array(
                    'code' => 200,
                    'message' => 'Message not inserted',
                    'success' => FALSE,
                    'failed' => TRUE,
                ));
            }
        }
        else
        {
            HTTPStatus(400);
            $this->load->view('headers/index', array(
                'code' => 400,
                'message' => 'Channel or message not provided',
            ));
        }
    }

    public function get_many()
    {
        $channel = $this->input->post('channel');
        $number = $this->input->post('number');

        if ($channel && $channel != ''
            && $number && $number > 0)
        {
            $this->load->library('mongo_db');
            $messages = $this->mongo_db
                    ->order_by(array('time' => 'DESC'))
                    ->get_where('messages', array(
                        'channel' => $channel,
                    ));
            if (is_array($messages))
            {
                HTTPStatus(200);
                $this->load->view('message/index', array(
                    'code' => 200,
                    'message' => 'List of requested messages',
                    'success' => TRUE,
                    'failed' => FALSE,
                ));
            }
            else
            {
                HTTPStatus(200);
                $this->load->view('message/index', array(
                    'code' => 200,
                    'message' => 'Error loading messages',
                    'success' => FALSE,
                    'failed' => TRUE,
                ));
            }
        }
        else
        {
            HTTPStatus(400);
            $this->load->view('headers/index', array(
                'code' => 400,
                'message' => 'Channel or number of messages not provided',
            ));
        }
    }
}