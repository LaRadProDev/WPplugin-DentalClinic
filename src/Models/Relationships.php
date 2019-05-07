<?php

namespace PassThisTest\Models;

use \WeDevs\ORM\Eloquent\Model as Model;

class Relationships extends Model {
    protected $table = 'term_relationships';
    protected $primaryKey = 'term_taxonomy_id';
}