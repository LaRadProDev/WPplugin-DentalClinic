<?php

namespace PassThisTest\Actions;

use PassThisTest\Support\Ajax;
use PassThisTest\Models\History;
use PassThisTest\Models\Stats;

class SaveToHistory extends Ajax {
    protected $action = 'save_to_history';

    protected function run() {
        $history = History::updateOrCreate(
            [
                'question_id' => $this->request['question_id'],
                'user_id' => $this->request['user_id']
            ],
            [
                
                'incorrect' => $this->request['incorrect'] != 'false' ? $this->request['incorrect'] : NULL,
                'date' => date("Y-m-d")
            ]
        );

        $all_history = History::where('user_id', $this->request['user_id'])->get();
        $answered_questions = $all_history->filter(function($item){
            return is_null($item->incorrect) ? true : false;
        });

        $stats = Stats::updateOrCreate(
            ['user_id' => $this->request['user_id']],
            [
                'answered_questions_num' => $answered_questions->count(),
                'avg_score' => $answered_questions->count() / $all_history->count() * 100,
            ]
        );

        $this->returnJSON($stats);
    }
}