<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Question;
use App\Models\QuestionExample;
use App\Models\Traffic;
use App\Models\User;
use App\Models\UserScore;
use App\Repositories\LanguageRepository;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        $lang = Language::with('level')->get();
        $rateLimiter = app(RateLimiter::class);
        $ip = $request->ip();
        $totalRequest = $rateLimiter->hit(
            $ip,
            30 * 60
        );
        if ($totalRequest <= 1) {
            $userId = auth('api')->user()->id;
            $traffic = new Traffic();
            $traffic->user_id = $userId;
            $traffic->ip_address = $ip;
            $traffic->save();
        }
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

    public function answerQuestion(Request $request, $level_id)
    {
        try {
            $data = [];
            $user = auth('api')->user();
            $langRepo = new LanguageRepository();
            $answer = $langRepo->checkAnswer($request, $level_id);

            $checkScore = UserScore::where('user_id', $user->id)->where('level_id', $level_id)->first();
            if (empty($checkScore)) {
                $score = new UserScore();
                $score->user_id = $user->id;
                $score->level_id = $level_id;
                $score->score = $answer['score'];
                $score->save();

                $userAuth = User::find($user->id);
                $userAuth->exp = $userAuth->exp + $answer['score'];
                $userAuth->save();
            }

            $data['score'] = $answer['score'];
            $data['upper_middle'] = $answer['score'] > 50 ? true : false;

            return response()->json([
                'code' => 200,
                'info' => 'Check answer success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::debug($e);
            return response()->json([
                'code' => 500,
                'info' => 'Answer Question Failed',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function answerQuestionExample(Request $request, $level_id)
    {
        try {
            $data = [];
            $langRepo = new LanguageRepository();
            $answer = $langRepo->checkAnswerExample($request, $level_id);

            $data['score'] = $answer['score'];

            return response()->json([
                'code' => 200,
                'info' => 'Check answer success',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::debug($e);
            return response()->json([
                'code' => 500,
                'info' => 'Answer Question Failed',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function leaderboard()
    {
        try {
            $user = auth('api')->user();
            $langRepo = new LanguageRepository();
            $dashboard = $langRepo->getLeaderboard($user->id);

            return response()->json([
                'code' => 200,
                'info' => 'Check dashboard success',
                'data' => $dashboard
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'info' => 'Get Dashboard Failed',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
