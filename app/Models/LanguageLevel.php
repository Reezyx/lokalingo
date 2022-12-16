<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageLevel extends Model
{
    protected $table = 'language_levels';
    protected $fillable = [
        'language_id',
        'level',
    ];
}
