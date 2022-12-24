<?php

namespace App\Repositories;

use App\Models\Language;
use App\Models\LanguageLevel;
use App\Models\Question;
use App\Models\QuestionExample;
use App\Repositories\RepositoryInterface;

class LanguageRepository implements RepositoryInterface
{
  public function createLanguage($request)
  {
    $lang = Language::create([
      'name' => $request->name,
      'description' => $request->description
    ]);

    $levels = ['beginner', 'intermediate', 'master'];

    foreach ($levels as $level) {
      $levelLanguage = LanguageLevel::create([
        'language_id' => $lang->id,
        'level' => $level,
      ]);
    }

    if ($lang && $levelLanguage) {
      $language = Language::find($lang->id)->with('level')->first();
      return $language;
    }
    return false;
  }

  public function createQuestion($request, $level_id)
  {
    $data = [];
    $level = LanguageLevel::find($level_id);
    foreach ($request->item as $item) {
      $questions = Question::create([
        'level_id' => $level->id,
        'question' => $item['question'],
        'option_1' => $item['option_1'],
        'option_2' => $item['option_2'],
        'option_3' => $item['option_3'],
        'option_4' => $item['option_4'],
        'option_5' => $item['option_5'],
        'answer' => $item['answer'],
      ]);
      array_push($data, $questions);
    }
    if ($data) {
      return $data;
    }
    return false;
  }

  public function createQuestionExample($request, $level_id)
  {
    $data = [];
    $level = LanguageLevel::find($level_id);
    foreach ($request->item as $item) {
      $questions = QuestionExample::create([
        'level_id' => $level->id,
        'question' => $item['question'],
        'option_1' => $item['option_1'],
        'option_2' => $item['option_2'],
        'option_3' => $item['option_3'],
        'option_4' => $item['option_4'],
        'option_5' => $item['option_5'],
        'answer' => $item['answer'],
      ]);
      array_push($data, $questions);
    }
    if ($data) {
      return $data;
    }
    return false;
  }

  public function getQuestion($level_id)
  {
    $question = Question::where('level_id', $level_id)->inRandomOrder()->get();
    if ($question) {
      return $question;
    }
    return false;
  }

  public function getQuestionExample($level_id)
  {
    $question = QuestionExample::where('level_id', $level_id)->inRandomOrder()->get();
    if ($question) {
      return $question;
    }
    return false;
  }

  public function updateQuestion($request, $question_id)
  {
    $question = Question::find($question_id);
    $question->question = $request->question;
    $question->option_1 = $request->option_1;
    $question->option_2 = $request->option_2;
    $question->option_3 = $request->option_3;
    $question->option_4 = $request->option_4;
    $question->option_5 = $request->option_5;
    $question->answer = $request->answer;
    $question->save();

    return $question;
  }

  public function deleteQuestionItem($question_id)
  {
    $question = Question::where('id', $question_id)->first();
    $check = $question->delete();
    if ($check) {
      return true;
    }
    return false;
  }
}
