<?php

namespace App\Models;

use App\Core\App;
use Exception;

class Answer extends Record
{
    protected static $table = 'answers';

    protected static $recordable = ['user_id', 'choice_id', 'question_id'];

    public $id, $user_id, $choice_id, $question_id;

    /**
     * Get answer's related choice.
     *
     * @return Choice
     */
    public function getChoice()
    {
        return App::get('database')->selectByRelatedValue('choices', 'id', $this->choice_id);
    }
}