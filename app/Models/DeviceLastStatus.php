<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceLastStatus extends Model
{
    protected $primaryKey = 'serial_number';
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    protected $fillable = ['serial_number'];
    protected $table = 'device_last_status';


}
