<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'user_devices';
    protected $fillable = [
        'device',
        'area',
    ];
}
