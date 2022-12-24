<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionExample extends Model
{
    protected $table = 'example_questions';
    protected $fillable = [
        'level_id',
        'question',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'option_5',
        'answer'
    ];
}
