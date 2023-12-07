<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Device
 *
 * @property int serial_number
 * @property string $name
 * @property float $latitude
 * @property float $longitude
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin \Eloquent
 */
class Device extends Model
{
    public $table = 'device';

    protected $primaryKey = 'serial_number';

    public function deviceLastStatus(): HasOne
    {
        return $this->hasOne(DeviceLastStatus::class, 'serial_number','serial_number');
    }

}
