<?php

namespace PassThisTest\Models;

use \WeDevs\ORM\Eloquent\Model as Model;
use PassThisTest\Models\Term;

class Taxonomy extends Model {
    protected $table = 'term_taxonomy';
    protected $primaryKey = 'term_taxonomy_id';

    public function terms() {
        return $this->belongsTo(Term::class, 'term_id', 'term_id');
    }
}