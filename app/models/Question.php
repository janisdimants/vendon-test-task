<?php

namespace App\Models;

use App\Core\App;
use Exception;
use App\Models\Choice;

class Question extends Record
{
    protected static $table = 'questions';

    protected static $recordable = [
      'test_id',
      'text'
    ];


    /**
     * Get test that the question belongs to
     *
     * @return void
     */
    public function getTest()
    {
        return App::get('database')->selectByRelatedValue('tests', 'id', $this->test_id);
    }

    /**
     * Get list of choices for this question
     *
     * @return array
     */
    public function getChoices()
    {
        $records = App::get('database')->selectByRelatedValue('choices', 'question_id', $this->id);
        $choices = [];
        foreach($records as $record)
        {
            $choices[] = Choice::instantiate($record);
        }
        return $choices;
    }

}