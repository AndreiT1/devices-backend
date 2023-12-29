<?php

namespace App\Http\API;

use App\Constants\DeviceConstants;
use App\Models\Device;
use App\Models\DeviceLastStatus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class DeviceController extends BaseController
{
 public function __construct()
 {
 }

    public function index()
    {

        $data = Device::with('deviceLastStatus:status,serial_number')->get();
        return response()->json($data,200);
    }


    public function get($id)
    {
        $device = Device::findOrFail($id);
        return response()->json($device, 200);
    }

    /**
     * @throws \Throwable
     */
    public function create(Request $request)
    {
        $request->validate([
            'serialNumber' => 'required|integer|unique:device,serial_number',
            'deviceName' => 'required|string',
            'lat' => 'required|numeric',
            'long' => 'required|numeric'
        ]);
        try {
            DB::beginTransaction();
            $device = new Device();
            $device->serial_number = (int)$request->get('serialNumber');
            $device->name = $request->get('deviceName');
            $device->latitude = floatval($request->get('lat'));
            $device->longitude = floatval($request->get('long'));
            $device->saveOrFail();
            $deviceLastStatus = new DeviceLastStatus();
            $deviceLastStatus->serial_number = $device->serial_number;
            $deviceLastStatus->status = DeviceConstants::UNKNOWN;
            $deviceLastStatus->saveOrFail();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json($device,201);
    }

    public function update(Request $request)
    {
        $request->validate([
            'serialNumber' => 'required|integer',
        ]);
        $device = Device::where('serial_number', '=', $request->get('serial_number'))->first();
        if($request->has('name')) {
            $device->name = $request->get('name');
            $device->save();
        }
        return response()->json($device, 200);
    }

    public function destroy($id)
    {
        try {
            $device = Device::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json('Model not found ', 404);
        }

        $device->delete();
        return response()->json('No content', 204);
    }
}
