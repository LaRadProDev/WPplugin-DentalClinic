<?php

namespace PassThisTest\Actions;

use PassThisTest\Support\Ajax;
use PassThisTest\Models\Question;

class FetchQuestions extends Ajax {
    protected $action = 'fetch_questions';

    protected function run() {

        $type = $this->request['questions_type'];

        switch ($type) {
            case 'incorrect':
                $this->returnJSON(Question::whereHas('terms', function($q) {
                    $q->whereIn('slug', $this->request['terms']);
                })->whereHas('histories', function($q) {
                    $q->where('incorrect', '!=', NULL)->where('user_id', get_current_user_id());
                })->with('terms')->take($this->request['questions_num'])->orderByRaw('RAND()')->get());

                break;
            
            case 'new':
                $this->returnJSON(Question::whereHas('terms', function($q) {
                    $q->whereIn('slug', $this->request['terms']);
                })->whereNotIn('ID', function($q) {
                    $q->select('question_id')->from('wp_ptt_quiz_history')->where('user_id', get_current_user_id());
                })->with('terms')->take($this->request['questions_num'])->orderByRaw('RAND()')->get());

                break;

            case 'all':
                $this->returnJSON(Question::whereHas('terms', function($q) {
                    $q->whereIn('slug', $this->request['terms']);
                })->with('terms')->take($this->request['questions_num'])->orderByRaw('RAND()')->get());
                
                break;
        }
    }
}