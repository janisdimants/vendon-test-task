<?php
namespace App\Controllers;

use App\Core\App;
use App\Models\Test;
use App\Models\User;
use App\Models\Result;

class ResultsController
{
  public function show()
  {
    $user_id = $_SESSION['user_id'];
    $test_id = $_SESSION['test_id'];

    if (! is_null($user_id) && ! is_null($test_id)) {
      $result = App::get('database')->selectWhere('results', [
        'user_id' => $user_id,
        'test_id' => $test_id
      ])[0];

      $user = User::find($user_id);
      $test = Test::find($test_id);
      $question_count = count($test->getQuestions());

      return view('result', compact('result', 'user', 'question_count'));
    } else {

    }
  }

  public function store()
  {
    $user_id = $_SESSION['user_id'];
  
    // Is test complete?
    $test = Test::find($_SESSION['test_id']);

    // Check if the results already saved
    $result = App::get('database')->selectWhere('results', [
      'user_id' => $user_id,
      'test_id' => $test->id
    ]);

    if (count($result) == 0) {
      // Save result
      $result = Result::create([
        'user_id' => $user_id,
        'test_id' => $test->id,
        'score' => $test->getScore(),
      ]);
    }

    // Display result
    return redirect('result/show');
  }
}