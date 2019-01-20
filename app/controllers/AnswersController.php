<?php

namespace App\Controllers;

use App\Core\App;
use App\Models\Answer;
use App\Models\Choice;

class AnswersController
{
    public function save() {
        //validate that the choice exists in the database
        $post_data = json_decode(file_get_contents("php://input"), true);
        
        $choice_id = $post_data['choice_id'];
        $user_id = $_SESSION['user_id'];

        $choice = Choice::find($choice_id);

        $data = [
            "user_id" => $user_id,
            "question_id" => $choice->question_id,
        ];

        $answer = App::get('database')->selectWhere('answers', $data);
        
        if (count($answer) > 0) {
            // Update existing answer
            $answer = Answer::instantiate($answer[0]);

            $answer->choice_id = $choice_id;

            $answer->save();
        } else {
            // Save new answer
            $data['choice_id'] = $choice_id;
            $answer = Answer::create($data);
        }
    }
}
