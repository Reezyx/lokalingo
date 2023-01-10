<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCriteria extends Model
{
    protected $table = 'user_criterias';
    protected $fillable = [
        'name',
        'count',
    ];
}
