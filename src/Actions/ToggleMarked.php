<?php

namespace PassThisTest\Actions;

use PassThisTest\Support\Ajax;
use PassThisTest\Models\History;

class ToggleMarked extends Ajax {
    protected $action = 'toggle_marked';

    protected function run() {
        $history = History::updateOrCreate(
            [
                'question_id' => $this->request['question_id'],
                'user_id' => $this->request['user_id']
            ],
            [
                
                'marked' => $this->request['marked'],
                'date' => date("Y-m-d")
            ]
        );
        $this->returnJSON(true);
    }
}