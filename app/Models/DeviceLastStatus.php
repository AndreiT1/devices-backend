<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceLastStatus extends Model
{
    protected $primaryKey = 'serial_number';
    protected $fillable = ['serial_number'];
    protected $table = 'device_last_status';


}
