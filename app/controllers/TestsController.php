<?php

namespace App\Controllers;

use App\Core\App;
use App\Models\Test;
use App\Models\User;
use App\Models\Question;

class TestsController
{
    /**
     * Show test start page.
     */
    public function index()
    {
        $tests = Test::all();

        return view('index', compact('tests'));
    }

    public function start()
    {
        //get post parameters
        $name = $_POST['name'];
        $test_id = $_POST['test_id'];

        //Validation
        $errors = [];

        if ($name == '') {
            $errors[] = (object)[
                "message" => "Name field cannot be empty!",
                "input_name" => "name",
            ];
        }

        try {
            $test = Test::find($test_id);
        } catch (Exception $e) {
            $errors[] = (object)[
                "message" => "Invalid test selected!",
                "input_name" => "test_id",
            ];
        }

        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors;
            return redirect('');
        }

        $user = User::create([
            'name' => $name,
        ]);

        //store active user in session
        $_SESSION['user_id'] = $user->id;
        $_SESSION['test_id'] = $test_id;
        
        //redirect user to test
        return redirect('test/fill');
    }

    public function fill() 
    {
        $test_id = $_SESSION['test_id'];

        //get test instance
        $test = Test::find($test_id);

        $questions = $test->getQuestions();
        $answers = $test->getAnswers();

        return view('test', compact('test', 'questions', 'answers'));
    }
}
