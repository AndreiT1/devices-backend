<?php

namespace App\Http\API;

use App\Models\DeviceLastStatus;
use App\Services\RabbitMQService;
use Carbon\Carbon;
use Illuminate\Http\Client\Request;
use Illuminate\Routing\Controller as BaseController;

class DeviceLastStatusController extends BaseController
{
    private RabbitMQService $MQService;
    public function __construct(RabbitMQService $MQService)
    {
        $this->MQService = $MQService;
    }

    public function updateOrCreate(Request $request)
    {
        return DeviceLastStatus::updateOrCreate(
            ['serial_number' => $request->get('serial_number')],
            ['status' => (int)$request->get('status')]
        );
    }

    public function randomizeDeviceStatuses(): void
    {
        for ($i = 1; $i < 30; $i++) {
            $message = [
                "serial_number" => $i,
                "timestamp" => Carbon::now(),
                "status" => rand(0, 8)
            ];
            $this->MQService->publish(json_encode($message));
        }
    }
}
