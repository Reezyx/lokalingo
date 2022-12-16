<?php

namespace App\Repositories;

use App\Models\Language;
use App\Models\LanguageLevel;
use App\Models\Question;
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

  public function getQuestion($level_id)
  {
    $question = Question::where('level_id', $level_id)->inRandomOrder()->get();
    if ($question) {
      return $question;
    }
    return false;
  }

  public function deleteLevel($level_id)
  {
    $question = Question::where('level_id', $level_id);
    $check = $question->delete();
    if ($check) {
      return true;
    }
    return false;
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