<?php

namespace PassThisTest\Models;

use \WeDevs\ORM\Eloquent\Model as Model;

class Stats extends Model {
    protected $table = 'wp_ptt_stats';
    protected $primaryKey = 'ID';
    protected $guarded = [ 'ID' ];
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'avg_score',
        'rank',
        'answered_questions_num'
    ];

    public $timestamps = false;

    public function getTable() {
        return $this->table;
    }
}