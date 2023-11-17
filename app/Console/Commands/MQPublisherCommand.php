<?php

namespace App\Console\Commands;

use App\Events\StatusNotification;
use App\Services\RabbitMQService;
use Illuminate\Console\Command;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;

class MQPublisherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:m-q-publisher-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mqService = new RabbitMQService();
        // status messages update simulation
        for($i = 1 ; $i < 30; $i++ ) {
            $message = [
                "serial_number" => $i,
                "timestamp" => "2022-08-09T12:20:43",
                "status" => rand(0,8)
            ];
            $mqService->publish(json_encode($message));
        }

    }
}

