<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateLanguageRequest;
use App\Models\Language;
use App\Models\LanguageLevel;
use App\Models\Question;
use App\Repositories\LanguageRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function profile()
    {
        $user = auth('api')->user();

        return response()->json([
            'code' => 200,
            'info' => 'Get Profile Admin Successfully',
            'data' => $user
        ], 200);
    }

    public function createLanguage(CreateLanguageRequest $request)
    {
        $check = Language::where('name', $request->name)->first();
        if (!empty($check)) {
            return response()->json([
                'code' => 500,
                'info' => 'Language already exists',
            ], 500);
        }
        $langRepo = new LanguageRepository();
        $lang = $langRepo->createLanguage($request);

        if (!$lang) {
            return response()->json([
                'code' => 500,
                'info' => 'Create Language Failed',
            ], 500);
        }

        return response()->json([
            'code' => 200,
            'info' => 'Create Language Success',
            'data' => $lang
        ], 200);
    }

    public function getLanguage()
    {
        $language = Language::all();

        if (empty($language)) {
            return response()->json([
                'code' => 500,
                'info' => 'Get All Language Failed',
            ], 500);
        }

        return response()->json([
            'code' => 200,
            'info' => 'Get All Language Success',
            'data' => $language
        ], 200);
    }

    public function getLevel($language_id)
    {
        $level = LanguageLevel::where('language_id', $language_id)->get();

        if (empty($level)) {
            return response()->json([
                'code' => 500,
                'info' => 'Get All Language Failed',
            ], 500);
        }

        return response()->json([
            'code' => 200,
            'info' => 'Get All Language Success',
            'data' => $level
        ], 200);
    }

    public function createQuestion(Request $request, $level_id)
    {
        $langRepo = new LanguageRepository();
        $question = $langRepo->createQuestion($request, $level_id);

        if (!$question) {
            return response()->json([
                'code' => 500,
                'info' => 'Create Question Failed',
            ], 500);
        }

        return response()->json([
            'code' => 200,
            'info' => 'Create Question Success',
            'data' => $question
        ], 200);
    }

    public function getQuestion($level_id)
    {
        $langRepo = new LanguageRepository();
        $question = $langRepo->getQuestion($level_id);

        if (!$question) {
            return response()->json([
                'code' => 500,
                'info' => 'Get Question Failed',
            ], 500);
        }

        return response()->json([
            'code' => 200,
            'info' => 'Get Question Success',
            'data' => $question
        ], 200);
    }

    public function getQuestionItem($question_id)
    {
        $question = Question::find($question_id);

        if (empty($question)) {
            return response()->json([
                'code' => 500,
                'info' => 'Get Question Item Failed',
            ], 500);
        }

        return response()->json([
            'code' => 200,
            'info' => 'Get Question Item Success',
            'data' => $question
        ], 200);
    }

    public function updateQuestionItem(Request $request, $question_id)
    {
        $langRepo = new LanguageRepository();
        $question = $langRepo->updateQuestion($request, $question_id);

        if (empty($question)) {
            return response()->json([
                'code' => 500,
                'info' => 'Update Question Item Failed',
            ], 500);
        }

        return response()->json([
            'code' => 200,
            'info' => 'Update Question Item Success',
            'data' => $question
        ], 200);
    }

    public function deleteQuestionItem($question_id)
    {
        $langRepo = new LanguageRepository();
        $question = $langRepo->deleteQuestionItem($question_id);

        if (!$question) {
            return response()->json([
                'code' => 500,
                'info' => 'Delete Question Item Failed',
            ], 500);
        }

        return response()->json([
            'code' => 200,
            'info' => 'Delete Question Item Success',
        ], 200);
    }

    public function createQuestionExample(Request $request, $level_id)
    {
        $langRepo = new LanguageRepository();
        $question = $langRepo->createQuestionExample($request, $level_id);

        if (!$question) {
            return response()->json([
                'code' => 500,
                'info' => 'Create Question Example Failed',
            ], 500);
        }

        return response()->json([
            'code' => 200,
            'info' => 'Create Question Example Success',
            'data' => $question
        ], 200);
    }

    public function getQuestionExample($level_id)
    {
        $langRepo = new LanguageRepository();
        $question = $langRepo->getQuestionExample($level_id);

        if (!$question) {
            return response()->json([
                'code' => 500,
                'info' => 'Get Question Example Failed',
            ], 500);
        }

        return response()->json([
            'code' => 200,
            'info' => 'Get Question Example Success',
            'data' => $question
        ], 200);
    }
}
