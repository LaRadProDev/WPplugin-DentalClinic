<?php

namespace PassThisTest\Models;

use \WeDevs\ORM\Eloquent\Model as Model;

class Term extends Model  {

    protected $table = 'terms';

    protected $primaryKey = 'term_id';

    public function questions()
    {
        return $this->belongsToMany(
            Question::class,
            'wp_term_relationships',
            'term_taxonomy_id',
            'object_id'
        );
    }
}