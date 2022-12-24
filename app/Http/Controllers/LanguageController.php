<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Question;
use App\Models\QuestionExample;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        $lang = Language::with('level')->get();
        return response()->json([
            'code' => 200,
            'info' => 'Get all language succesfull',
            'data' => $lang
        ]);
    }

    public function getQuestion($level_id)
    {
        $questions = Question::where('level_id', $level_id)->inRandomOrder()->limit(10)->get();
        return response()->json([
            'code' => 200,
            'info' => 'Get all questions succes',
            'data' => $questions
        ]);
    }

    public function exampleQuestion($level_id)
    {
        $question =  QuestionExample::where('level_id', $level_id)->inRandomOrder()->limit(2)->get();
        return response()->json([
            'code' => 200,
            'info' => 'Get all example questions succes',
            'data' => $question
        ]);
    }
}
