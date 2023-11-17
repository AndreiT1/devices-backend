<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class RabbitMQService
{
    protected $connection;
    protected $channel;
    protected $exchange = 'ex_device_status';
    protected $queue = 'q_device_status';
    protected $routingKey = 'status';

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            env('MQ_HOST'),
            env('MQ_PORT'),
            env('MQ_USER'),
            env('MQ_PASS'),
            env('MQ_VHOST')
        );

        $this->channel = $this->connection->channel();

        $this->channel->exchange_declare($this->exchange, 'direct', false, true, true);
        $this->channel->queue_declare($this->queue, false, true, false, true);
        $this->channel->queue_bind($this->queue, $this->exchange, $this->routingKey);
    }

    public function publish($message): void
    {
        $msg = new AMQPMessage($message);
        $this->channel->basic_publish($msg, $this->exchange, $this->routingKey);
    }

    public function consume($callback): void
    {
        $this->channel->basic_consume($this->queue, '', false, false, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }
    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

}
