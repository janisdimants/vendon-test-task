<?php

namespace App\Models;

use App\Core\App;
use Exception;
use App\Models\Record;

class Test extends Record
{
    public static $table = 'tests';

    public static $recordable = [
        'name'
    ];

    /**
     * Get all test's related questions.
     *
     * @return void
     */
    public function getQuestions()
    {
        $records = App::get('database')->selectByRelatedValue('questions', 'test_id', $this->id);
        $questions = [];
        foreach($records as $record)
        {
            $questions[] = Question::instantiate($record);
        }
        return $questions;
    }

    public function getAnswers()
    {
        // Get user ID
        $user_id = $_SESSION['user_id'];

        // Get all user answers
        $answers = App::get('database')->selectWhere('answers', [
            'user_id' => $user_id,
        ]);

        return $answers;
    }

    public function isComplete()
    {
        $answers = $this->getAnswers();
        $questions = $this->getQuestions();

        return (count($questions) == count($answers));
    }

    public function getScore()
    {
        $answers = $this->getAnswers();
        $score = 0;
        
        foreach ($answers as $answer) {
            $choice = Choice::find($answer->choice_id);

            if ($choice->correct) {
                $score++;
            }
        }

        return $score;
    }
}