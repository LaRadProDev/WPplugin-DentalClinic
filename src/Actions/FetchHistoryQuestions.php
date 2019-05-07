<?php

namespace PassThisTest\Actions;

use PassThisTest\Support\Ajax;
use PassThisTest\Models\History;
use PassThisTest\Models\Question;

class FetchHistoryQuestions extends Ajax {
    protected $action = 'fetch_history_questions';

    protected function run() {
        $history = History::where('user_id', $this->request['user_id'])->get();
        $questions_ids = $history->map(function($item){
            return $item->question_id;
        });
        $questions = Question::whereIn('ID', $questions_ids)->with('terms')->get();

        $questions_with_user_answers = $questions->map(function($item, $index) use ($history) {

            foreach ($history as $el) {
                if ((int) $el['question_id'] == $item->ID) {
                    $item->date = $el->date;
                    $item->incorrect = $el->incorrect;
                    $item->marked = $el->marked;
                }
            }
            
            return $item;
        });

        $this->returnJSON($questions_with_user_answers);
    }
}