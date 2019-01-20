<?php

namespace App\Models;

use App\Core\App;
use Exception;

class Choice extends Record
{
    protected static $table = 'choices';

    protected static $recordable = ['question_id', 'text', 'correct'];

    public $id, $question_id, $text, $correct;

    /**
     * Get choice's related test.
     *
     * @return void
     */
    public function getQuestion()
    {
        return App::get('database')->selectByRelatedValue('questions', 'id', $this->question_id);
    }
}