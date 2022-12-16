<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    protected $table = 'languages';
    protected $fillable = [
        'name',
        'description',
    ];

    function level()
    {
        return $this->hasMany(LanguageLevel::class, 'language_id', 'id');
    }
}
