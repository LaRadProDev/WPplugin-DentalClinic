<?php

namespace PassThisTest\Models;

use \WeDevs\ORM\Eloquent\Model as Model;

class History extends Model {
    protected $table = 'wp_ptt_quiz_history';
    protected $primaryKey = 'ID';
    protected $guarded = [ 'ID' ];
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'question_id',
        'date',
        'marked',
        'incorrect'
    ];

    public $timestamps = false;

    public function getTable() {
        return $this->table;
    }
}