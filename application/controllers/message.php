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
            $message = $this->insert_message(array(
                'message' => $message,
                'channel' => $channel,
            ));

            if (is_object($message) && ! empty($message->{'$id'}))
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

    public function get($page = 1, $skip = 0)
    {
        $this->load->library('mongo_db');
        $messages = $this->mongo_db
                ->order_by(array('time' => 'DESC'))
                //->limit($number)
                ->offset($skip)
                ->get_where('messages', array(
                    'channel' => new MongoID($channel),
                ));

        $count = count($messages);
        //echo '<pre>', var_dump($messages), '</pre>';
    }

    public function get_many()
    {
        $channel = $this->input->post('channel');
        $number = $this->input->post('number');
        $page = $this->input->post('page');
        $skip = $this->input->post('skip');
        var_dump($skip);
        if ( ! $page OR $page <= 0)
        {
            $page = 1;
        }
        if ( ! $skip) {
            $skip = ((int)$page - 1) * MESSAGES_PER_PAGE;
        }
var_dump($skip);
        if ($channel && $channel != ''
            && $number && $number > 0)
        {
            $this->load->library('mongo_db');
            $messages = $this->mongo_db
                    ->order_by(array('time' => 'DESC'))
                    //->limit($number)
                    //->offset($skip)
                    ->get_where('messages', array(
                        'channel' => new MongoID($channel),
                    ));

            $count = count($messages);

            $messages = array_slice($messages, $skip, MESSAGES_PER_PAGE);

            if (is_array($messages))
            {
                $messages_list = array();
                foreach ($messages as $key => $message) {
                    $message['user'] = $this->encrypt->decode($message['user']);
                    $message['message'] = $this->encrypt->decode($message['message']);
                    $messages_list[] = $message;
                }
                HTTPStatus(200);
                $this->load->view('message/list', array('data' => array(
                    'code' => 200,
                    'message' => 'List of requested messages',
                    'success' => TRUE,
                    'failed' => FALSE,
                    'list' => $messages_list,
                    'count' => $count,
                    'page' => $page,
                    'per_page' => MESSAGES_PER_PAGE,
                )));
            }
            else
            {
                HTTPStatus(200);
                $this->load->view('message/list', array('data' => array(
                    'code' => 200,
                    'message' => 'Error loading messages',
                    'success' => FALSE,
                    'failed' => TRUE,
                    'list' => array(),
                    'count' => FALSE,
                )));
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