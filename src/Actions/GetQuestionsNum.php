<?php

namespace PassThisTest\Actions;

use PassThisTest\Support\Ajax;
use PassThisTest\Models\Question;

class GetQuestionsNum extends Ajax {
    protected $action = 'get_questions_num';

    protected function run() {

        $questions_num = wp_count_posts( 'question' )->publish;

        $this->returnJSON($questions_num);
    }
}