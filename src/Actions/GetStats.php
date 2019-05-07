<?php

namespace PassThisTest\Actions;

use PassThisTest\Support\Ajax;
use PassThisTest\Models\Stats;
use PassThisTest\Models\History;

class GetStats extends Ajax {
    protected $action = 'get_stats';

    protected function run() {

        $stats = Stats::where('user_id', $this->request['user_id'])->first();
        $history = History::where('user_id', $this->request['user_id'])->get();
        
        $all_stats = Stats::orderBy('avg_score', 'desc')->pluck('avg_score', 'user_id');
        $user_ids = $all_stats->keys();
        $position = array_search($this->request['user_id'], $user_ids->toArray()) + 1;
        $rank = (100 * ($position - 0.5)) / $user_ids->count();

        $stats['rank'] = round($rank);
        $stats['attempted_questions_num'] = $history->count();

        $this->returnJSON($stats);
    }
}