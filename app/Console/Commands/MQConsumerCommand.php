<?php

namespace App\Console\Commands;

use App\Events\StatusNotification;
use App\Models\DeviceLastStatus;
use App\Services\RabbitMQService;
use Illuminate\Console\Command;
use PhpAmqpLib\Message\AMQPMessage;

class MQConsumerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mq:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume the mq queue';

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle(): void
    {
        $mqService = new RabbitMQService();
        $callback = function (AMQPMessage $message) {
            $body = json_decode($message->getBody(),true);
            $deviceStatus = DeviceLastStatus::find($body['serial_number']);
            if ($deviceStatus){
                $deviceStatus->status = (int)$body['status'];
                $deviceStatus->save();
                StatusNotification::dispatch(json_encode($deviceStatus));
            }
        };
        $mqService->consume($callback);
    }
}
