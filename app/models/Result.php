<?php

namespace App\Models;

use App\Core\App;
use Exception;

class Result extends Record
{
    protected static $table = 'results';

    protected static $recordable = ['user_id', 'test_id', 'score'];

    public $id, $user_id, $test_id, $score;

    /**
     * Get result's related test.
     *
     * @return Test
     */
    public function getTest()
    {
        return App::get('database')->selectByRelatedValue('tests', 'id', $this->test_id);
    }
}