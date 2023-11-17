<?php

namespace App\Http\API;

use App\Models\DeviceLastStatus;
use Illuminate\Http\Client\Request;
use Illuminate\Routing\Controller as BaseController;

class DeviceLastStatusController extends BaseController
{

    public function updateOrCreate(Request $request)
    {
        return DeviceLastStatus::updateOrCreate(
            ['serial_number' => $request->get('serial_number')],
            ['status' => (int)$request->get('status')]
        );
    }
}
